<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Units;
use App\Models\UserCart;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserOrder;
use App\Models\Transaction;

use App\Helpers\GetCommonHelper;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use League\Flysystem\Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailOrderPlaced;

class ProcessingWebController extends Controller
{
    use FileTrait, CommonTrait, ValidationTrait;
    public $platform = 'web';

    public function showCheckout(Request $request)
    {
        try {
            $banner = Banner::where('for', config('constants.bannerFor')['checkout'])->first();
            if (sizeof(GetCommonHelper::getCartData()) > 0) {
                if ($request->isMethod('post')) {
                    $values = $request->only('payMode');
                    $payMode = $values['payMode'];
                } else {
                    $payMode = '';
                }

                $data = array(
                    'bannerPic' => $this->picUrl($banner->image, 'bannerPic', $this->platform),
                    'payMode' => $payMode,
                    'productByShort' => collect(GetCommonHelper::getCartData())
                        ->groupBy('payMode')
                        ->map(function ($item) {
                            return array_merge($item->toArray());
                        }),
                    'product' => GetCommonHelper::getCartData(),
                    'userAddress' => UserAddress::where([
                        ['userId', Auth::user()->id],
                        ['isDefault', '1']
                    ])->first(),
                );

                return view('web.processing.checkout', ['data' => $data]);
            } else {
                return redirect()->route('web.show.home');
            }
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function saveOrder(Request $request)
    {
        try {
            $values = $request->only('payMode');
            $productId = $product = array();
            $totalPayment = 0;
            $cartProduct = collect(GetCommonHelper::getCartData())
                ->groupBy('payMode')
                ->map(function ($item) {
                    return array_merge($item->toArray());
                });

            DB::beginTransaction();

            $user = User::where('id', Auth::user()->id)->first();

            if ($values['payMode'] == config('constants.payMode')['cod']) {
                if (isset($cartProduct['COD'])) {
                    foreach ($cartProduct['COD'] as $temp) {
                        array_push($productId, decrypt($temp['id']));
                        array_push($product, $temp);
                        $totalPayment += ($temp['priceAfterGst'] * $temp['quantity']);
                    }
                } else {
                    return redirect()->back()->with('error', 'There some item need to play via online, please delete those item from card which does not have COD alliable');
                }
            } else {
                dd(GetCommonHelper::getCartData());
            }

            $userAddress = UserAddress::where([
                ['userId', Auth::user()->id],
                ['isDefault', '1']
            ])->first();
            $address = [
                'address' => $userAddress->address,
                'landmark' => $userAddress->landmark,
                'city' => $userAddress->city,
                'state' => $userAddress->state,
                'country' => $userAddress->country,
                'pinCode' => $userAddress->pinCode,
                'contactNumber' => $userAddress->contactNumber,
            ];

            $userOrder = new UserOrder();
            $userOrder->userId = Auth::user()->id;
            $userOrder->uniqueId = $this->generateCode('ORDER', 6, UserOrder::class, 'uniqueId');
            $userOrder->payMode = $values['payMode'];
            $userOrder->productId = json_encode($productId);
            $userOrder->product = json_encode($product);
            $userOrder->deliveredAddress = json_encode($address);
            $userOrder->userAddressId = $userAddress->id;
            $userOrder->status = config('constants.status')['placed'];

            if ($userOrder->save()) {
                if (UserCart::where([
                    ['userId', Auth::user()->id],
                    ['status', config('constants.status')['1']],
                ])->update(['status' => config('constants.status')['0']])) {

                    $transaction = new Transaction();
                    $transaction->uniqueId = $this->generateCode('TRUN', 6, Transaction::class, 'uniqueId');
                    $transaction->userId = Auth::user()->id;
                    $transaction->userOrderId = $userOrder->id;
                    $transaction->status = config('constants.transactionStatus')['pending'];
                    $transaction->payMode = $values['payMode'];
                    $transaction->amount = $totalPayment;
                    if ($transaction->save()) {
                        DB::commit();
                        $data = array(
                            'otp' => 'Order Placed',
                            'msg' => "Your order placed successfully"
                        );
                        Mail::to($user->email)->send(new MailOrderPlaced($data));
                        return redirect()->route('web.show.dashboard')->with('success', 'Order placed successfully successfully');
                    } else {
                        DB::rollback();
                        return redirect()->back()->with('error', __('messages.serverErrMsg'));
                    }
                } else {
                    DB::rollback();
                    return redirect()->back()->with('error', __('messages.serverErrMsg'));
                }
            } else {
                DB::rollback();
                return redirect()->back()->with('error', __('messages.serverErrMsg'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', __('messages.serverErrMsg'));
        }
    }

    public function addToCart(Request $request)
    {
        $values = $request->only('id', 'userId', 'quantity');
        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', __('messages.serverErrMsg'));
        }

        try {
            $validator = $this->isValid($request->all(), 'addToCart', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $userCart = UserCart::where([
                    ['productId', $id],
                    ['userId', Auth::user()->id],
                    ['status', config('constants.status')['1']],
                ])->first();

                if ($userCart) {
                    $userCart->quantity = ($values['quantity'] + $userCart->quantity);

                    if ($userCart->update()) {
                        return redirect()->back()->with('success', 'Update in card successfully');
                    } else {
                        return redirect()->back()->with('error', __('messages.serverErrMsg'));
                    }
                } else {
                    $userCart = new UserCart();

                    $userCart->userId = Auth::user()->id;
                    $userCart->uniqueId = $this->generateCode('CART', 6, UserCart::class, 'uniqueId');
                    $userCart->productId = $id;
                    $userCart->status = config('constants.status')['1'];
                    $userCart->quantity = $values['quantity'];

                    if ($userCart->save()) {
                        return redirect()->back()->with('success', 'Added in card successfully');
                    } else {
                        return redirect()->back()->with('error', __('messages.serverErrMsg'));
                    }
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('messages.serverErrMsg'));
        }
    }

    public function deleteToCart($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', __('messages.serverErrMsg'));
        }

        try {
            $result = $this->deleteItem($id, UserCart::class, '');
            if ($result === true) {
                return redirect()->back()->with('success', 'Added in card successfully');
            } else {
                return redirect()->back()->with('error', __('messages.serverErrMsg'));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('messages.serverErrMsg'));
        }
    }
}

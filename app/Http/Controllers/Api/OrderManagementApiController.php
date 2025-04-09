<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;
use App\Traits\RazorpayTrait;
use App\Traits\DishTrait;
use App\Traits\NotificationTrait;

use App\Models\UserAddress;
use App\Models\User;
use App\Models\Transduction;
use App\Models\AddToCart;
use App\Models\Orders;
use App\Models\FoodCuration\Dish;

use Carbon\Carbon;
use Exception;

use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use App\Notifications\NotifyUser;

class OrderManagementApiController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait, RazorpayTrait, DishTrait, NotificationTrait;
    public $platform = 'app';


    /*------- ( Order ) -------*/
    public function genarateOrderForDis($amount, $payMode)
    {
        try {
            $auth = Auth::user();
            $data = array();

            if (Str::upper($payMode) == config('constants.payMode')['razorpay']) {
                $responce = $this->createOrder([
                    'amount' => $amount
                ]);
                $razoppayOrderId = $responce->id;
                $payMode = config('constants.payMode')['razorpay'];
                $tranType = 'NA';
            } else if (Str::upper($payMode) == config('constants.payMode')['cod']) {
                $payMode = config('constants.payMode')['cod'];
                $razoppayOrderId = 'NA';
                $tranType = 'NA';
            } else {
                if ($amount > $auth->wallet) {
                    return response()->json(['status' => 0, 'msg' => 'Sorry, you dont have enoufgh ballance in you wallet to continute', 'payload' => (object)[]], config('constants.ok'));
                } else {
                    $payMode = config('constants.payMode')['wallet'];
                    $tranType = config('constants.tranType')['withdraw'];
                    $razoppayOrderId = 'NA';
                }
            }

            $transduction = new Transduction();
            $transduction->userId = $auth->id;
            $transduction->tranNumber = $this->generateCode('', 10, Transduction::class, 'tranNumber');
            $transduction->amount = $amount;
            $transduction->payMode = $payMode;
            $transduction->tranType = $tranType;
            $transduction->payStatus = config('constants.payStatus')['initiate'];
            $transduction->razoppayOrderId = $razoppayOrderId;

            if ($transduction->save()) {
                $data = array(
                    'id' => $transduction->id,
                    'orderId' => $razoppayOrderId,
                    'amount' => $amount
                );
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => ['data' => $data]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object) []], config('constants.serverErr'));
        }
    }

    public function saveOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            $auth = Auth::user();
            $values = $request->only('transductionId', 'paymentId', 'orderId', 'pinCode', 'address', 'restaurantId');
            Config::set([
                'constants.models.dish' => Dish::class,
            ]);

            if (!$this->isValid($request->all(), 'saveOrder', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            } else {

                if ($values['transductionId'] > 0) {
                    $transduction = Transduction::where('id', $values['transductionId'])->first();
                } else {
                    $transduction = Transduction::where('razoppayOrderId', $values['orderId'])->first();
                }

                if ($transduction->payStatus == config('constants.payStatus')['paid']) {
                    return response()->json(['status' => 0, 'msg' => 'This transiction is already done', 'payload' => (object)[]], config('constants.ok'));
                } else {

                    $getDishList = $this->getDishList([
                        'addToCart' => AddToCart::where([
                            ['userId', $auth->id],
                            ['status', config('constants.status')['pending']]
                        ])->get(),
                        'models' => Config::get('constants.models'),
                    ]);

                    $orders = new Orders();
                    $orders->userId = $auth->id;
                    $orders->addToCartId = json_encode($getDishList['addToCartId']);
                    $orders->dishes = json_encode($getDishList);
                    $orders->amount = round($getDishList['amount']);
                    $orders->pinCode = $values['pinCode'];
                    $orders->address = $values['address'];
                    $orders->restaurantId = $values['restaurantId'];
                    $orders->status = Config::get('constants.status.placed');
                    $orders->orderNumber = $this->generateCode('', 10, Orders::class, 'orderNumber');

                    if ($values['transductionId'] > 0) {
                        if ($transduction->payMode != config('constants.payMode')['cod']) {
                            $user = User::where('id', $auth->id)->first();
                            $user->wallet = $user->wallet - $transduction->amount;
                            if ($user->update()) {
                                goto a;
                            } else {
                                DB::rollback();
                                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
                            }
                        }
                    } else {
                        $responce = $this->checkPaymentStatus(['paymentId' => $values['paymentId']]);
                        if (Str::upper($responce->status) == config('constants.payStatus')['captured']) {
                            goto a;
                        } else {
                            return response()->json(['status' => 0, 'msg' => 'Sorry payment is not done', 'payload' => (object)[]], config('constants.ok'));
                        }
                    }

                    a:
                    if ($orders->save()) {

                        $transduction->razoppayPaymentId = $values['paymentId'];
                        if ($transduction->payMode != config('constants.payMode')['cod']) {
                            $transduction->payStatus = config('constants.payStatus')['paid'];
                        }
                        $transduction->ordersId = $orders->id;

                        if ($transduction->update()) {

                            if (AddToCart::whereIn('id', $getDishList['addToCartId'])->update(['status' => Config::get('constants.status.removed')])) {
                                DB::commit();
                                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
                            } else {
                                DB::rollback();
                                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
                            }
                        } else {
                            DB::rollback();
                            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
                        }
                    } else {
                        DB::rollback();
                        return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function getOrder()
    {
        try {
            $auth = Auth::user();
            $data = $dishList = array();

            if ($auth->userType == config('constants.userType')['customers']) {
                $orders = Orders::where('userId', $auth->id)->orderBy('id', 'desc')->get();
            } else {
                $orders = Orders::where([
                    ['deliveryBoyId', $auth->id],
                    ['status', config('constants.status')['dispatched']]
                ])->orderBy('id', 'desc')->get();
            }

            foreach ($orders as $tempOne) {
                $dishes = json_decode($tempOne->dishes);

                foreach ($dishes->dishList as $tempTwo) {
                    $dish = Dish::where('id', $tempTwo->dishId)->first();
                    $dishList[] = array(
                        "name" => $tempTwo->name,
                        "description" => $tempTwo->description,
                        "singleDishPrice" => $tempTwo->singleDishPrice,
                        "price" => $tempTwo->price,
                        "singleDishDiscount" => $tempTwo->singleDishDiscount,
                        "discount" => $tempTwo->discount,
                        "discountPrice" => $tempTwo->discountPrice,
                        "finalPrice" => $tempTwo->finalPrice,
                        "quantity" => $tempTwo->quantity,
                        "image" => $this->picUrl($dish->image, 'dishPic', $this->platform),
                    );
                }

                $transduction = Transduction::where('ordersId', $tempOne->id)->first();
                $user = User::where('id', $tempOne->userId)->first();
                $data[] = array(
                    'id' => $tempOne->id,
                    'orderNumber' => $tempOne->orderNumber,
                    'name' => $user->name,
                    'isdCode' => $user->isdCode,
                    'phone' => $user->phone,
                    'address' => $tempOne->address,
                    'pinCode' => $tempOne->pinCode,
                    'status' => $tempOne->status,
                    'transduction' => $transduction,
                    'dishes' => $dishList,
                    'totalMarkedPrice' => $dishes->totalMarkedPrice,
                    'totalDiscountPrice' => $dishes->totalDiscountPrice,
                    'delivaryCharge' => 0,
                    'date' => date('d-m-Y h:i A', strtotime($tempOne->created_at)),
                );

                $dishList = array();
            }

            if (!empty($data)) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => ['data' => $data]], config('constants.ok'));
            } else {
                return response()->json(['status' => 1, 'msg' => __('messages.noDataFound'), 'payload' => ['data' => $data]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object) []], config('constants.serverErr'));
        }
    }

    public function statusOrder($id, $status)
    {
        DB::beginTransaction();
        // try {
        $status = Str::upper($status);
        $title = $msg = '';

        $orders = Orders::where('id', $id)->first();
        $transduction = Transduction::where('ordersId', $orders->id)->first();

        if ($status == config('constants.status')['canceled']) {
            if ($orders->status == config('constants.status')['placed'] || $orders->status == config('constants.status')['accepted']) {
                if ($transduction->payMode == config('constants.payMode')['wallet']) {
                    $transduction->payStatus = config('constants.payStatus')['refund'];
                    $transduction->update();

                    $user = User::where('id', $orders->userId)->first();
                    $user->wallet = $user->wallet + $transduction->amount;
                    $user->update();
                }
                $orders->status = $status;
                $title = 'Canceled Order';
                $msg = __('messages.canceledOrderNoti');
            } else {
                return response()->json(['status' => 0, 'msg' => 'Oops! You cant canceled this order now.', 'payload' => (object)[]], config('constants.ok'));
            }
        }

        if ($status == config('constants.status')['delivered']) {
            $orders->status = $status;
            if ($transduction->payMode == config('constants.payMode')['cod']) {
                $transduction->payStatus = config('constants.payStatus')['paid'];
                $transduction->update();
            }
            $title = 'Delivered Order';
            $msg = __('messages.deliveredOrderNoti');
        }


        if ($orders->update()) {

            $user = User::find($orders->userId);
            $notifyDetails = array(
                "title" => $title,
                "msg" => $msg,
                'date' => date('d-m-Y h:i A', strtotime(Carbon::now())),
                'userId' => $user->userId,
                'deviceToken' => $user->deviceToken,
                'deviceType' => $user->deviceType,
            );
            User::find($user->id)->notify(new NotifyUser($notifyDetails));
            $this->sendNotification($notifyDetails);

            DB::commit();
            return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
        } else {
            DB::rollBack();
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
        }
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object) []], config('constants.serverErr'));
        // }
    }
}

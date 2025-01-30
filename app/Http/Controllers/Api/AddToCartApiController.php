<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\FavoriteDish;
use App\Models\AddToCart;
use App\Models\FoodCuration\Dish;

use Carbon\Carbon;
use Exception;

use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddToCartApiController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'app';


    /*------- ( Add To Cart ) -------*/
    public function saveAddToCart(Request $request)
    {
        try {
            $values = $request->only('dishId');

            if (!$this->isValid($request->all(), 'saveAddToCart', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            }

            $auth = Auth::user();
            $addToCart = AddToCart::where([
                ['userId', $auth->id],
                ['dishId', $values['dishId']],
                ['status', config('constants.status')['pending']],
            ])->first();
            if ($addToCart == null) {
                $addToCart = new AddToCart();
                $addToCart->dishId = $values['dishId'];
                $addToCart->userId = $auth->id;
                $addToCart->status = config('constants.status')['pending'];
                if ($addToCart->save()) {
                    return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
                }
            } else {
                return response()->json(['status' => 0, 'msg' => 'This dish is already added to your cart', 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function updateAddToCart(Request $request)
    {
        try {
            $values = $request->only('id', 'quantity');

            if (!$this->isValid($request->all(), 'updateAddToCart', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            }

            $addToCart = AddToCart::where('id', $values['id'])->first();
            $addToCart->quantity = $values['quantity'];
            if ($addToCart->update()) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function statusAddToCart(Request $request)
    {
        try {
            $values = $request->only('id', 'status');

            if (!$this->isValid($request->all(), 'statusAddToCart', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            }

            $addToCart = AddToCart::where('id', $values['id'])->first();
            $addToCart->status = Str::upper($values['status']);
            if ($addToCart->update()) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function getAddToCart($type)
    {
        try {
            $auth = Auth::user();
            $data = array();
            $discountPrice = $totalMarkedPrice = $totalDiscountPrice = 0;

            $addToCart = AddToCart::where([
                ['userId', $auth->id],
                ['status', Str::upper($type)]
            ])->get();

            foreach ($addToCart as $temp) {
                $dish = Dish::where('id', $temp->dishId)->first();
                $discountPrice = (($dish->price * $dish->discount) / 100) * $temp->quantity;
                $totalMarkedPrice += $dish->price * $temp->quantity;
                $totalDiscountPrice += $discountPrice;
                $data[] = array(
                    'id' => $temp->id,
                    'dishId' => $dish->id,
                    'categoryId' => $dish->categoryId,
                    'subCategoryId' => $dish->subCategoryId,
                    'name' => $dish->name,
                    'description' => ($dish->description == null) ? 'NA' : $dish->description,
                    'price' => $dish->price * $temp->quantity,
                    'discount' => $dish->discount,
                    'discountPrice' => $discountPrice,
                    'finalPrice' => round(($dish->price * $temp->quantity) - $discountPrice),
                    'quantity' => $temp->quantity,
                    'image' => $this->picUrl($dish->image, 'dishPic', $this->platform),
                );
            }
            if (!empty($data)) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => ['data' => $data, 'totalMarkedPrice' => round($totalMarkedPrice), 'totalDiscountPrice' => round($totalDiscountPrice)]], config('constants.ok'));
            } else {
                return response()->json(['status' => 1, 'msg' => __('messages.noDataFound'), 'payload' => ['data' => $data]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object) []], config('constants.serverErr'));
        }
    }

    public function deleteAddToCart($id)
    {
        try {
            $addToCart = AddToCart::where('id', $id)->first();

            if ($addToCart->delete()) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 1, 'msg' => __('messages.noDataFound'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object) []], config('constants.serverErr'));
        }
    }
}

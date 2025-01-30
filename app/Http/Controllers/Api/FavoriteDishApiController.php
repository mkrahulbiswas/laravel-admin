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

class FavoriteDishApiController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'app';


    /*------- ( Favorite Dish ) -------*/
    public function saveFavoriteDish($id)
    {
        try {
            $auth = Auth::user();

            $favoriteDish = FavoriteDish::where([
                ['userId', $auth->id],
                ['dishId', $id],
            ])->first();

            if ($favoriteDish == null) {
                $favoriteDish = new FavoriteDish();
                $favoriteDish->userId = $auth->id;
                $favoriteDish->dishId = $id;
                if ($favoriteDish->save()) {
                    return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), "payload" => (object)[]], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
                }
            } else {
                if ($favoriteDish->delete()) {
                    return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), "payload" => (object)[]], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function getFavoriteDish()
    {
        try {
            $auth = Auth::user();
            $data = array();
            $discountPrice = 0;
            $favoriteDish = FavoriteDish::where('userId', $auth->id)->get();

            foreach ($favoriteDish as $temp) {
                $dish = Dish::where('id', $temp->dishId)->first();
                $discountPrice = ($dish->price * $dish->discount) / 100;
                $data[] = array(
                    'id' => $dish->id,
                    'categoryId' => $dish->categoryId,
                    'subCategoryId' => $dish->subCategoryId,
                    'name' => $dish->name,
                    'description' => ($dish->description == null) ? 'NA' : $dish->description,
                    'price' => $dish->price,
                    'discount' => $dish->discount,
                    'discountPrice' => $discountPrice,
                    'finalPrice' => $dish->price - $discountPrice,
                    'image' => $this->picUrl($dish->image, 'dishPic', $this->platform),
                    'isFavoriteDish' => ($favoriteDish == null) ? 0 : 1,
                );
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
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\FoodCuration\Category;
use App\Models\FoodCuration\SubCategory;
use App\Models\FoodCuration\Dish;
use App\Models\FavoriteDish;

use Carbon\Carbon;
use Exception;

use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FoodCurationApiController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'app';


    /*------- ( Category ) -------*/
    public function getCategory()
    {
        try {
            $data = array();
            $category = Category::where('status', config('constants.status')['1'])->orderBy('id', 'desc')->get();
            foreach ($category as $temp) {
                $data[] = array(
                    'id' => $temp->id,
                    'name' => $temp->name,
                    'image' => $this->picUrl($temp->image, 'categoryPic', $this->platform),
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

    public function getSubCategory($id)
    {
        try {
            $data = array();
            if ($id == 0) {
                $subCategory = SubCategory::where('status', config('constants.status')['1'])->orderBy('id', 'desc')->get();
            } else {
                $subCategory = SubCategory::where([
                    ['status', config('constants.status')['1']],
                    ['categoryId', $id]
                ])->orderBy('id', 'desc')->get();
            }
            foreach ($subCategory as $temp) {
                $data[] = array(
                    'id' => $temp->id,
                    'categoryId' => $temp->categoryId,
                    'name' => $temp->name,
                    'image' => $this->picUrl($temp->image, 'subCategoryPic', $this->platform),
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

    public function getDish($id, $type)
    {
        try {
            $data = array();
            $auth = Auth::user();
            $type = Str::upper($type);
            $discountPrice = 0;

            if ($type == config('constants.dishType')['trending']) {
                $dish = Dish::where([
                    ['status', config('constants.status')['1']],
                    ['trending', config('constants.status')['1']]
                ])->orderBy('id', 'desc')->get();
            } else if ($type == config('constants.dishType')['recommendation']) {
                $dish = Dish::where([
                    ['status', config('constants.status')['1']],
                    ['recommendation', config('constants.status')['1']]
                ])->orderBy('id', 'desc')->get();
            } else {
                $dish = Dish::where([
                    ['status', config('constants.status')['1']],
                    ['subCategoryId', $id]
                ])->orderBy('id', 'desc')->get();
            }

            foreach ($dish as $temp) {
                $favoriteDish = FavoriteDish::where([
                    ['userId', $auth->id],
                    ['dishId', $temp->id]
                ])->first();
                $discountPrice = ($temp->price * $temp->discount) / 100;
                $data[] = array(
                    'id' => $temp->id,
                    'categoryId' => $temp->categoryId,
                    'subCategoryId' => $temp->subCategoryId,
                    'name' => $temp->name,
                    'description' => ($temp->description == null) ? 'NA' : $temp->description,
                    'price' => $temp->price,
                    'discount' => $temp->discount,
                    'discountPrice' => $discountPrice,
                    'finalPrice' => round($temp->price - $discountPrice),
                    'image' => $this->picUrl($temp->image, 'dishPic', $this->platform),
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

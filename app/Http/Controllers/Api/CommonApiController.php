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

use App\Models\UserAddress;
use App\Models\User;
use App\Models\Transduction;

use App\Models\FoodCuration\Dish;
use Carbon\Carbon;
use Exception;

use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommonApiController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait, RazorpayTrait;
    public $platform = 'app';


    /*------- ( Razor Pay ) -------*/
    public function getRazorpayKey()
    {
        try {
            $data = array(
                'key' => env('RAZORPAY_KEY'),
                'secret' => env('RAZORPAY_SECRET')
            );

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

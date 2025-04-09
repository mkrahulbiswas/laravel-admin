<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\Restaurant;

use Carbon\Carbon;
use Exception;

use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ManageRestaurantApiController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'app';


    /*------- ( My Restaurant ) -------*/
    public function getMyRestaurant()
    {
        try {
            $data = array();
            $category = Restaurant::where('status', config('constants.status')['1'])->orderBy('id', 'desc')->get();
            foreach ($category as $temp) {
                $data[] = array(
                    'id' => $temp->id,
                    'name' => $temp->name,
                    'address' => $temp->address,
                    'pinCode' => $temp->pinCode,
                    'latitude' => $temp->latitude,
                    'longitude' => $temp->longitude,
                    'description' => $temp->description,
                    'image' => $this->picUrl($temp->image, 'myRestaurantPic', $this->platform),
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

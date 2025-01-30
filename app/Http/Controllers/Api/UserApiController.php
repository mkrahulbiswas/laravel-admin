<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\UserAddress;
use App\Models\AddToCart;
use App\Models\Transduction;

use App\Models\FoodCuration\Dish;
use Carbon\Carbon;
use Exception;

use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserApiController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'app';


    /*------- ( User Address ) -------*/
    public function saveUserAddress(Request $request)
    {
        try {
            $values = $request->only('address', 'pinCode', 'longitude', 'latitude');

            if (!$this->isValid($request->all(), 'saveUserAddress', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            }

            $auth = Auth::user();
            if (UserAddress::where([
                ['userId', $auth->id],
                ['address', $values['address']],
                ['pinCode', $values['pinCode']]
            ])->first() != null) {
                return response()->json(['status' => 0, 'msg' => 'This address is already saved', 'payload' => (object)[]], config('constants.ok'));
            } else {
                $userAddress = new UserAddress();
                $userAddress->address = $values['address'];
                $userAddress->pinCode = $values['pinCode'];
                $userAddress->longitude = $values['longitude'];
                $userAddress->latitude = $values['latitude'];
                $userAddress->userId = $auth->id;
                if ($userAddress->save()) {
                    return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function updateUserAddress(Request $request)
    {
        try {
            $values = $request->only('id', 'address', 'pinCode', 'longitude', 'latitude');

            if (!$this->isValid($request->all(), 'saveUserAddress', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            }

            $auth = Auth::user();
            if (UserAddress::where([
                ['id', '<>', $values['id']],
                ['userId', $auth->id],
                ['address', $values['address']],
                ['pinCode', $values['pinCode']]
            ])->first() != null) {
                return response()->json(['status' => 0, 'msg' => 'This address is already saved', 'payload' => (object)[]], config('constants.ok'));
            } else {
                $userAddress = UserAddress::where('id', $values['id'])->first();
                $userAddress->address = $values['address'];
                $userAddress->pinCode = $values['pinCode'];
                $userAddress->longitude = $values['longitude'];
                $userAddress->latitude = $values['latitude'];
                if ($userAddress->update()) {
                    return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
                }
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

    public function getUserAddress()
    {
        try {
            $auth = Auth::user();
            $data = array();

            $userAddress = UserAddress::where('userId', $auth->id)->get();

            foreach ($userAddress as $temp) {
                $data[] = array(
                    'id' => $temp->id,
                    'address' => $temp->address,
                    'pinCode' => $temp->pinCode,
                    'isDefault' => $temp->isDefault,
                );
            }

            if (!empty($data)) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => ['data' => $data]], config('constants.ok'));
            } else {
                return response()->json(['status' => 1, 'msg' => __('messages.noDataFound'), 'payload' => (object)['data' => $data]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object) []], config('constants.serverErr'));
        }
    }

    public function deleteUserAddress($id)
    {
        try {
            $userAddress = UserAddress::where('id', $id)->first();

            if ($userAddress->delete()) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 1, 'msg' => __('messages.noDataFound'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object) []], config('constants.serverErr'));
        }
    }

    public function defaultUserAddress($id)
    {
        try {
            $auth = Auth::user();
            if (UserAddress::where('userId', $auth->id)->update(['isDefault' => config('constants.status')['0']])) {
                $userAddress = UserAddress::where('id', $id)->first();
                $userAddress->isDefault = config('constants.status')['1'];
                if ($userAddress->update()) {
                    return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
                } else {
                    return response()->json(['status' => 1, 'msg' => __('messages.noDataFound'), 'payload' => (object)[]], config('constants.ok'));
                }
            } else {
                return response()->json(['status' => 1, 'msg' => __('messages.noDataFound'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object) []], config('constants.serverErr'));
        }
    }
}

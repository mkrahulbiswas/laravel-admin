<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\CommonTrait;

use Exception;
use Illuminate\Support\Facades\Config;

class CommonApiController extends Controller
{
    use CommonTrait;
    public $platform = 'app';


    public function getDeviceType()
    {
        try {
            return response()->json(['status' => 1, 'type' => "warning", 'title' => "Device type", 'msg' => __('messages.successMsg'), 'payload' => ['data' => Config::get('constants.deviceType')]], Config::get('constants.errorCode.ok'));
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Device type", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }
}

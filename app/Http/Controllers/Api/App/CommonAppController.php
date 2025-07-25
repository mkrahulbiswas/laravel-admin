<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;

use App\Models\VersionControl;

use App\Traits\CommonTrait;

use Exception;
use Illuminate\Support\Facades\Config;

class CommonAppController extends Controller
{
    use CommonTrait;
    public $platform = 'app';


    public function getAppVersion()
    {
        try {
            $versionControl = VersionControl::first();
            $data = array(
                'appVersion' => $versionControl->appVersion,
            );
            return response()->json(['status' => 1, 'type' => "error", 'title' => "Current version",  'msg' => __('messages.successMsg'), 'payload' => ['data' => $data]], Config::get('constants.errorCode.ok'));
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Current version",  'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }
}

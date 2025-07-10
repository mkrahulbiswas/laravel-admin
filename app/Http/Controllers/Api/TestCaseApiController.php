<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Traits\CommonTrait;
use app\Traits\FileTrait;
use app\Traits\ValidationTrait;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TestCaseApiController extends Controller
{
    use CommonTrait, FileTrait, ValidationTrait;
    public $platform = 'app';

    public function uploadFileTest(Request $request)
    {
        $file = $request->file('file');
        // $user = User::find(Auth::user()->id);
        if ($file) {
            $uploadFile = $this->uploadFile([
                'file' => ['current' => $file, 'previous' => ''],
                // 'file' => ['current' => $file, 'previous' => $user->image],
                'platform' => $this->platform,
                'storage' => Config::get('constants.storage')['testFile']
            ]);
            // if ($uploadFile['type'] == false) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Profile pic", 'msg' => $uploadFile['msg']], Config::get('constants.errorCode.ok'));
            // } else {
            //     $user->image = $uploadFile['name'];
            // }
        }
        // if ($user->update()) {
        //     $getFile = FileTrait::getFile([
        //         'fileName' => $user->image,
        //         'storage' => Config::get('constants.storage')['appUsers']
        //     ])['public']['fullPath']['asset'];
        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Profile pic", 'payload' => [], 'msg' => __('messages.changeMsg', ['type' => 'Profile pic'])['success']], Config::get('constants.errorCode.ok'));
        // } else {
        //     return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Profile pic", 'msg' => __('messages.changeMsg', ['type' => 'Profile pic'])['failed']], Config::get('constants.errorCode.ok'));
        // }
    }
}

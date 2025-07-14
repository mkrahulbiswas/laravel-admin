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
        if ($file) {
            $uploadFile = $this->uploadFile([
                'file' => ['current' => $file, 'previous' => ''],
                'platform' => $this->platform,
                'storage' => Config::get('constants.storage')['testFile']
            ]);
        }
        $getFile = FileTrait::getFile([
            'fileName' => $uploadFile['name'],
            'storage' => Config::get('constants.storage')['testFile']
        ])['s3']['fullPath']['url'];
        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Profile pic", 'payload' => ['image' => $getFile], 'msg' => __('messages.changeMsg', ['type' => 'Profile pic'])['success']], Config::get('constants.errorCode.ok'));
    }
}

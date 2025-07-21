<?php

namespace App\Http\Controllers\Api\App\PropertyRelated;

use App\Http\Controllers\Controller;

use App\Models\PropertyRelated\ManagePost\MpBasicDetails;
use App\Models\PropertyRelated\ManagePost\MpMain;

use App\Traits\CommonTrait;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CreatePostWebController extends Controller
{
    use CommonTrait;
    public $platform = 'web';


    public function initiatePostDb()
    {
        try {
            DB::beginTransaction();
            $auth = Auth::user();
            if (
                MpMain::where([
                    ['userId', $auth->getAuthIdentifier()],
                    ['status', Config::get('constants.status.pending')],
                ])->exists()
            ) {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Initiate Post", 'msg' => __('messages.createMsg.post')['alreadyExists'], 'payload' => (object) []], Config::get('constants.errorCode.ok'));
            } else {
                $mpMain = new MpMain();
                $mpMain->userId = $auth->getAuthIdentifier();
                $mpMain->uniqueId = $this->generateYourChoice([
                    [
                        'preString' => 'MPP',
                        'length' => 6,
                        'model' => MpMain::class,
                        'field' => '',
                        'type' => Config::get('constants.generateType.uniqueId')
                    ]
                ])[Config::get('constants.generateType.uniqueId')]['result'];
                $mpMain->status = Config::get('constants.status.pending');
                if ($mpMain->save()) {
                    $mpBasicDetails = new MpBasicDetails();
                    $mpBasicDetails->mpMainId = $mpMain->getKey();
                    if ($mpBasicDetails->save()) {
                        DB::commit();
                        return response()->json(['status' => 1, 'type' => "success", 'title' => "Initiate Post", 'msg' => __('messages.createMsg.post')['success'], 'payload' => (object) []], Config::get('constants.errorCode.ok'));
                    } else {
                        DB::rollBack();
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Initiate Post", 'msg' => __('messages.createMsg.post')['failed'], 'payload' => (object) []], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    DB::rollBack();
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Initiate Post", 'msg' => __('messages.createMsg.post')['failed'], 'payload' => (object) []], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Initiate Post", 'msg' => __('messages.serverErrMsg'), 'payload' => (object) []], Config::get('constants.errorCode.server'));
        }
    }
}

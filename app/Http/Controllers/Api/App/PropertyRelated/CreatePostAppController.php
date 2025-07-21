<?php

namespace App\Http\Controllers\Api\App\PropertyRelated;

use App\Http\Controllers\Controller;

use App\Helpers\PropertyRelated\ManagePost\GetPropertyPostHelper;

use App\Models\PropertyRelated\ManagePost\MpBasicDetails;
use App\Models\PropertyRelated\ManagePost\MpMain;
use App\Models\PropertyRelated\ManagePost\MpPropertyLocated;

use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CreatePostAppController extends Controller
{
    use CommonTrait, ValidationTrait;
    public $platform = 'app';

    public function initiatePostDb()
    {
        try {
            DB::beginTransaction();
            $auth = Auth::user();
            $mpMain = MpMain::where([
                ['userId', $auth->getAuthIdentifier()],
                ['status', Config::get('constants.status.pending')],
            ]);
            if ($mpMain->exists()) {
                $mpMain = $mpMain->first();
                $getPropertyPostHelper = GetPropertyPostHelper::getDetail([
                    [
                        'getDetail' => [
                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                            'for' => Config::get('constants.typeCheck.propertyRelated.managePost.propertyPost.type'),
                        ],
                        'otherDataPasses' => [
                            'id' => encrypt($mpMain->id),
                        ],
                    ],
                ])[Config::get('constants.typeCheck.propertyRelated.managePost.propertyPost.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Initiate Post", 'msg' => __('messages.createMsg.post')['alreadyExists'], 'payload' => ['data' => $getPropertyPostHelper]], Config::get('constants.errorCode.ok'));
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
                        $getPropertyPostHelper = GetPropertyPostHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                    'for' => Config::get('constants.typeCheck.propertyRelated.managePost.propertyPost.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($mpMain->getKey())
                                ],
                            ],
                        ])[Config::get('constants.typeCheck.propertyRelated.managePost.propertyPost.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
                        return response()->json(['status' => 1, 'type' => "success", 'title' => "Initiate Post", 'msg' => __('messages.createMsg.post')['success'], 'payload' => ['data' => $getPropertyPostHelper]], Config::get('constants.errorCode.ok'));
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

    public function updateBasicDetails(Request $request)
    {
        $values = $request->only('id', 'mpMainId', 'assignCategoryId', 'assignBroadId', 'propertyTypeId', 'mainCategoryId', 'subCategoryId', 'nestedCategoryId');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateBasicDetails', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], Config::get('constants.errorCode.validation'));
            } else {
                $mpBasicDetails = MpBasicDetails::where([
                    ['id', $id],
                    ['mpMainId', decrypt($values['mpMainId'])],
                ])->first();
                $mpBasicDetails->assignCategoryId = decrypt($values['assignCategoryId']);
                $mpBasicDetails->assignBroadId = decrypt($values['assignBroadId']);
                $mpBasicDetails->propertyTypeId = decrypt($values['propertyTypeId']);
                $mpBasicDetails->mainCategoryId = decrypt($values['mainCategoryId']);
                $mpBasicDetails->subCategoryId = ($values['subCategoryId'] == null) ? null : decrypt($values['subCategoryId']);
                $mpBasicDetails->nestedCategoryId = ($values['nestedCategoryId'] == null) ? null : decrypt($values['nestedCategoryId']);
                if ($mpBasicDetails->update()) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Basic Details", 'msg' => __('messages.updateMsg.success', ['type' => 'basic details']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Basic Details", 'msg' => __('messages.updateMsg.failed', ['type' => 'basic details']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Basic Details", 'msg' => __('messages.serverErrMsg'), 'payload' => (object) []], Config::get('constants.errorCode.server'));
        }
    }

    public function updatePropertyLocated(Request $request)
    {
        $values = $request->only('id', 'mpMainId', 'city', 'locality', 'subLocality', 'address');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updatePropertyLocated', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], Config::get('constants.errorCode.validation'));
            } else {
                $mpPropertyLocated = MpPropertyLocated::where([
                    ['id', $id],
                    ['mpMainId', decrypt($values['mpMainId'])],
                ])->first();
                if ($mpPropertyLocated == null) {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Property Located", 'msg' => __('messages.createMsg.post.noInstance'), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
                } else {
                    $mpPropertyLocated->city = $values['city'];
                    $mpPropertyLocated->locality = $values['locality'];
                    $mpPropertyLocated->subLocality = ($values['subLocality'] == '') ? 'NA' : $values['subLocality'];
                    $mpPropertyLocated->address = $values['address'];
                    if ($mpPropertyLocated->update()) {
                        return response()->json(['status' => 1, 'type' => "success", 'title' => "Property Located", 'msg' => __('messages.updateMsg.success', ['type' => 'property located']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Property Located", 'msg' => __('messages.updateMsg.failed', ['type' => 'property located']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Property Located", 'msg' => __('messages.serverErrMsg'), 'payload' => (object) []], Config::get('constants.errorCode.server'));
        }
    }
}

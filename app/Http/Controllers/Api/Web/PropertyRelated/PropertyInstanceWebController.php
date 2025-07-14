<?php

namespace App\Http\Controllers\Api\Web\PropertyRelated;

use App\Http\Controllers\Controller;

use App\Helpers\PropertyRelated\GetPropertyTypeHelper;
use App\Helpers\PropertyRelated\GetManageBroadHelper;

use App\Traits\CommonTrait;

use Exception;
use Illuminate\Support\Facades\Config;

class PropertyInstanceWebController extends Controller
{
    use CommonTrait;
    public $platform = 'web';

    public function getPropertyType()
    {
        try {
            $getList = GetPropertyTypeHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyType.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status.active'),
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyType.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $data = [
                'all' => $getList,
                'default' => collect($getList)->where('default', Config::get('constants.status.yes'))->first(),
            ];
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Property Type", 'msg' => __('messages.dataFoundMsg.failed', ['type' => 'property type']), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Property Type", 'msg' => __('messages.dataFoundMsg.success', ['type' => 'property type']), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Property Type", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }

    public function getBroadType()
    {
        try {
            $getList = GetManageBroadHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status.active'),
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $data = [
                'all' => $getList,
            ];
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Broad Type", 'msg' => __('messages.dataFoundMsg.failed', ['type' => 'broad type']), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Broad Type", 'msg' => __('messages.dataFoundMsg.success', ['type' => 'broad type']), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Broad Type", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }

    public function getAssignBroad($propertyTypeId)
    {
        try {
            $getList = GetManageBroadHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status.active'),
                            'propertyTypeId' => $propertyTypeId,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $data = [
                'all' => $getList,
                'default' => collect($getList)->where('default', Config::get('constants.status.yes'))->values()->all(),
            ];
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Assign Broad", 'msg' => __('messages.dataFoundMsg.failed', ['type' => 'assign broad']), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Assign Broad", 'msg' => __('messages.dataFoundMsg.success', ['type' => 'assign broad']), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Assign Broad", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }
}

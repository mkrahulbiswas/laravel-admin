<?php

namespace App\Http\Controllers\Api\App\PropertyRelated;

use App\Http\Controllers\Controller;

use App\Helpers\PropertyRelated\PropertyInstance\GetPropertyTypeHelper;

use App\Traits\CommonTrait;

use Exception;
use Illuminate\Support\Facades\Config;

class CreatePostWebController extends Controller
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
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyType.type'),
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
            ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyType.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $data = [
                'all' => $getList,
                'default' => collect($getList)->where('default', Config::get('constants.status.yes'))->values()->all(),
            ];
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Property Type", 'msg' => __('messages.dataFoundMsg.failed', ['type' => 'property type']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Property Type", 'msg' => __('messages.dataFoundMsg.success', ['type' => 'property type']), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Property Type", 'msg' => __('messages.serverErrMsg'), 'payload' => (object) []], Config::get('constants.errorCode.server'));
        }
    }
}

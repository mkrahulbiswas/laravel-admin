<?php

namespace App\Http\Controllers\Api\Web\PropertyRelated;

use App\Http\Controllers\Controller;

use App\Helpers\PropertyRelated\PropertyInstance\GetPropertyTypeHelper;
use App\Helpers\PropertyRelated\PropertyInstance\GetManageBroadHelper;
use App\Helpers\PropertyRelated\PropertyInstance\GetPropertyCategoryHelper;

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
                'default' => collect($getList)->where('default', Config::get('constants.status.yes'))->first(),
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

    public function getBroadType()
    {
        try {
            $getList = GetManageBroadHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.manageBroad.broadType.type'),
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
            ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.manageBroad.broadType.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $data = [
                'all' => $getList,
            ];
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Broad Type", 'msg' => __('messages.dataFoundMsg.failed', ['type' => 'broad type']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Broad Type", 'msg' => __('messages.dataFoundMsg.success', ['type' => 'broad type']), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Broad Type", 'msg' => __('messages.serverErrMsg'), 'payload' => (object) []], Config::get('constants.errorCode.server'));
        }
    }

    public function getAssignBroad($propertyTypeId)
    {
        try {
            $getList = GetManageBroadHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.manageBroad.assignBroad.type'),
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
            ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.manageBroad.assignBroad.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $data = [
                'all' => $getList,
                'default' => collect($getList)->where('default', Config::get('constants.status.yes'))->values()->all(),
            ];
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Assign Broad", 'msg' => __('messages.dataFoundMsg.failed', ['type' => 'assign broad']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Assign Broad", 'msg' => __('messages.dataFoundMsg.success', ['type' => 'assign broad']), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Assign Broad", 'msg' => __('messages.serverErrMsg'), 'payload' => (object) []], Config::get('constants.errorCode.server'));
        }
    }

    public function getMainCategory()
    {
        try {
            $getList = GetPropertyCategoryHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.manageCategory.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status.active'),
                            'type' => Config::get('constants.status.category.main'),
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.manageCategory.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $data = [
                'all' => $getList,
            ];
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Main Category", 'msg' => __('messages.dataFoundMsg.failed', ['type' => 'main category']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Main Category", 'msg' => __('messages.dataFoundMsg.success', ['type' => 'main category']), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Main Category", 'msg' => __('messages.serverErrMsg'), 'payload' => (object) []], Config::get('constants.errorCode.server'));
        }
    }

    public function getSubCategory($mainCategoryId)
    {
        try {
            $getList = GetPropertyCategoryHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.manageCategory.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status.active'),
                            'type' => Config::get('constants.status.category.sub'),
                            'mainCategoryId' => $mainCategoryId,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.manageCategory.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $data = [
                'all' => $getList,
            ];
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Sub Category", 'msg' => __('messages.dataFoundMsg.failed', ['type' => 'sub category']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Sub Category", 'msg' => __('messages.dataFoundMsg.success', ['type' => 'sub category']), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Sub Category", 'msg' => __('messages.serverErrMsg'), 'payload' => (object) []], Config::get('constants.errorCode.server'));
        }
    }

    public function getNestedCategory($mainCategoryId, $subCategoryId)
    {
        try {
            $getList = GetPropertyCategoryHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.manageCategory.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status.active'),
                            'type' => Config::get('constants.status.category.nested'),
                            'mainCategoryId' => $mainCategoryId,
                            'subCategoryId' => $subCategoryId,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.manageCategory.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $data = [
                'all' => $getList,
            ];
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Nested Category", 'msg' => __('messages.dataFoundMsg.failed', ['type' => 'nested category']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Nested Category", 'msg' => __('messages.dataFoundMsg.success', ['type' => 'nested category']), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Nested Category", 'msg' => __('messages.serverErrMsg'), 'payload' => (object) []], Config::get('constants.errorCode.server'));
        }
    }

    public function getAllCategory()
    {
        try {
            $getList = GetPropertyCategoryHelper::getCompleteList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.manageCategory.type'),
                    ],
                    'otherDataPasses' => [],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.manageCategory.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $data = [
                'all' => $getList,
            ];
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "All Category", 'msg' => __('messages.dataFoundMsg.failed', ['type' => 'all category']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "All Category", 'msg' => __('messages.dataFoundMsg.success', ['type' => 'all category']), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "All Category", 'msg' => __('messages.serverErrMsg'), 'payload' => (object) []], Config::get('constants.errorCode.server'));
        }
    }

    public function getAssignCategory($propertyTypeId, $broadTypeId)
    {
        try {
            $getList = GetPropertyCategoryHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.assignCategory.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status.active'),
                            'propertyTypeId' => $propertyTypeId,
                            'broadTypeId' => $broadTypeId,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.assignCategory.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $data = [
                'all' => $getList,
                'default' => collect($getList)->where('default', Config::get('constants.status.yes'))->values()->all(),
            ];
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Assign Category", 'msg' => __('messages.dataFoundMsg.failed', ['type' => 'assign category']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Assign Category", 'msg' => __('messages.dataFoundMsg.success', ['type' => 'assign category']), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Assign Category", 'msg' => __('messages.serverErrMsg'), 'payload' => (object) []], Config::get('constants.errorCode.server'));
        }
    }

    public function getAssignBroadCategory($propertyTypeId)
    {
        try {
            $getListAssignCategory = GetPropertyCategoryHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.assignCategory.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status.active'),
                            'propertyTypeId' => $propertyTypeId
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.assignCategory.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $getListAssignBroad = GetManageBroadHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.manageBroad.assignBroad.type'),
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
            ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.manageBroad.assignBroad.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];
            $data = [
                'assignCategory' => [
                    'all' => $getListAssignCategory,
                    'default' => collect($getListAssignCategory)->where('default', Config::get('constants.status.yes'))->values()->all(),
                ],
                'assignBroad' => [
                    'all' => $getListAssignBroad,
                    'default' => collect($getListAssignBroad)->where('default', Config::get('constants.status.yes'))->values()->all(),
                ]
            ];
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Assign Category", 'msg' => __('messages.dataFoundMsg.failed', ['type' => 'assign category']), 'payload' => (object) []], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Assign Category", 'msg' => __('messages.dataFoundMsg.success', ['type' => 'assign category']), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Assign Category", 'msg' => __('messages.serverErrMsg'), 'payload' => (object) []], Config::get('constants.errorCode.server'));
        }
    }
}

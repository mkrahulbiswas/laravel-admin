<?php

namespace App\Helpers\PropertyRelated;

use App\Traits\CommonTrait;

use App\Models\PropertyRelated\PropertyCategory\MainCategory;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class GetPropertyCategoryHelper
{
    use CommonTrait;
    public $platform = 'backend';


    public static function getList($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                if (Config::get('constants.typeCheck.propertyRelated.propertyCategory.mainCategory.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.iyf'), $tempOne['getList']['type'])) {
                        $mainCategory = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                        }

                        if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                            if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                                $id = $tempOne['otherDataPasses']['orderBy']['id'];
                                if (!empty($id)) {
                                    $orderByRaw = "`id` " . $id;
                                }
                            }
                        }

                        foreach (MainCategory::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $mainCategory[] = [
                                'id' => encrypt($tempTwo->id),
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.iyf')] = [
                            'list' => $mainCategory
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                        $mainCategory = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'default')) {
                                $default = $tempOne['otherDataPasses']['filterData']['default'];
                                if (!empty($default)) {
                                    $whereRaw .= " and `default` = '" . $default . "'";
                                }
                            }
                        }

                        if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                            if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                                $id = $tempOne['otherDataPasses']['orderBy']['id'];
                                if (!empty($id)) {
                                    $orderByRaw = "`id` " . $id;
                                }
                            }
                        }

                        foreach (MainCategory::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $mainCategory[] = GetPropertyCategoryHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyCategory.mainCategory.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.propertyRelated.propertyCategory.mainCategory.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                            'list' => $mainCategory
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.propertyCategory.mainCategory.type')] = $data;
                }

                if (Config::get('constants.typeCheck.propertyRelated.propertyCategory.assignCategory.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                        $assignBroad = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'default')) {
                                $default = $tempOne['otherDataPasses']['filterData']['default'];
                                if (!empty($default)) {
                                    $whereRaw .= " and `default` = '" . $default . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'propertyType')) {
                                $propertyType = $tempOne['otherDataPasses']['filterData']['propertyType'];
                                if (!empty($propertyType)) {
                                    $whereRaw .= " and `propertyTypeId` = " .  decrypt($propertyType);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'broadType')) {
                                $broadType = $tempOne['otherDataPasses']['filterData']['broadType'];
                                if (!empty($broadType)) {
                                    $whereRaw .= " and `broadTypeId` = " .  decrypt($broadType);
                                }
                            }
                        }

                        if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                            if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                                $id = $tempOne['otherDataPasses']['orderBy']['id'];
                                if (!empty($id)) {
                                    $orderByRaw = "`id` " . $id;
                                }
                            }
                        }

                        foreach (AssignBroad::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $assignBroad[] = GetPropertyCategoryHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyCategory.assignCategory.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.propertyRelated.propertyCategory.assignCategory.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.dyf')] = [
                            'list' => $assignBroad
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.propertyCategory.assignCategory.type')] = $data;
                }
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getDetail($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                [
                    'otherDataPasses' => $otherDataPasses,
                    'getDetail' => [
                        'type' => $type,
                        'for' => $for,
                    ]
                ] = $tempOne;

                if (Config::get('constants.typeCheck.propertyRelated.propertyCategory.mainCategory.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $mainCategory = MainCategory::where('id', decrypt($otherDataPasses['id']))->first();
                        $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                            'id' => encrypt($mainCategory->id),
                            'name' => $mainCategory->name,
                            'about' =>  $mainCategory->about,
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $mainCategory->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                    'value' => $mainCategory->status
                                ],
                            ]),
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.propertyCategory.mainCategory.type')] = $data;
                }

                if (Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $assignBroad = AssignBroad::where('id', decrypt($otherDataPasses['id']))->first();
                        $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                            'id' => encrypt($assignBroad->id),
                            'about' => $assignBroad->about,
                            'propertyType' => GetPropertyTypeHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyType.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($assignBroad->propertyTypeId)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.propertyRelated.propertyType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            'broadType' => GetPropertyCategoryHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyCategory.mainCategory.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($assignBroad->broadTypeId)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.propertyRelated.propertyCategory.mainCategory.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $assignBroad->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                    'value' => $assignBroad->status
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.default'),
                                    'value' => $assignBroad->default
                                ],
                            ]),
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

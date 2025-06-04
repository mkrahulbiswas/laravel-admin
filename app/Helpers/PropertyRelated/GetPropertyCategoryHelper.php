<?php

namespace App\Helpers\PropertyRelated;

use App\Traits\CommonTrait;

use App\Models\PropertyRelated\PropertyCategory\AssignCategory;
use App\Models\PropertyRelated\PropertyCategory\ManageCategory;

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
                if (Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.iyf'), $tempOne['getList']['type'])) {
                        $manageCategory = array();
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
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'type')) {
                                $type = $tempOne['otherDataPasses']['filterData']['type'];
                                if (!empty($type)) {
                                    $whereRaw .= " and `type` = '" . $type . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainCategoryId')) {
                                $mainCategoryId = $tempOne['otherDataPasses']['filterData']['mainCategoryId'];
                                if (!empty($mainCategoryId)) {
                                    $whereRaw .= " and `mainCategoryId` = " . decrypt($mainCategoryId);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'subCategoryId')) {
                                $subCategoryId = $tempOne['otherDataPasses']['filterData']['subCategoryId'];
                                if (!empty($subCategoryId)) {
                                    $whereRaw .= " and `subCategoryId` = " . decrypt($subCategoryId);
                                } else {
                                    $whereRaw .= " and `subCategoryId` is null";
                                }
                            }
                        }

                        foreach (ManageCategory::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $manageCategory[] = [
                                'id' => encrypt($tempTwo->id),
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.iyf')] = [
                            'list' => $manageCategory
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                        $manageCategory = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'type')) {
                                $type = $tempOne['otherDataPasses']['filterData']['type'];
                                if (!empty($type)) {
                                    $whereRaw .= " and `type` = '" . $type . "'";
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

                        foreach (ManageCategory::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $manageCategory[] = GetPropertyCategoryHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                            'list' => $manageCategory
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                        $manageCategory = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'type')) {
                                $type = $tempOne['otherDataPasses']['filterData']['type'];
                                if (!empty($type)) {
                                    $whereRaw .= " and `type` = '" . $type . "'";
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

                        foreach (ManageCategory::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $manageCategory[] = GetPropertyCategoryHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.dyf')] = [
                            'list' => $manageCategory
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type')] = $data;
                }

                if (Config::get('constants.typeCheck.propertyRelated.propertyCategory.assignCategory.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                        $assignCategory = array();
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
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainCategory')) {
                                $mainCategory = $tempOne['otherDataPasses']['filterData']['mainCategory'];
                                if (!empty($mainCategory)) {
                                    $whereRaw .= " and `mainCategoryId` = " .  decrypt($mainCategory);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'propertyType')) {
                                $propertyType = $tempOne['otherDataPasses']['filterData']['propertyType'];
                                if (!empty($propertyType)) {
                                    $whereRaw .= " and `propertyTypeId` = " .  decrypt($propertyType);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'assignBroad')) {
                                $assignBroad = $tempOne['otherDataPasses']['filterData']['assignBroad'];
                                if (!empty($assignBroad)) {
                                    $whereRaw .= " and `assignBroadId` = " .  decrypt($assignBroad);
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

                        foreach (AssignCategory::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $assignCategory[] = GetPropertyCategoryHelper::getDetail([
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
                            'list' => $assignCategory
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

                if (Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $manageCategory = ManageCategory::where('id', decrypt($otherDataPasses['id']))->first();
                        if ($manageCategory != null) {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                                'id' => encrypt($manageCategory->id),
                                'name' => $manageCategory->name,
                                'about' =>  $manageCategory->about,
                                'type' =>  $manageCategory->type,
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $manageCategory->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                        'value' => $manageCategory->status
                                    ],
                                ]),
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [];
                        }
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $manageCategory = ManageCategory::where('id', decrypt($otherDataPasses['id']))->first();
                        if ($manageCategory != null) {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                                'id' => encrypt($manageCategory->id),
                                'name' => $manageCategory->name,
                                'about' =>  $manageCategory->about,
                                'type' =>  $manageCategory->type,
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $manageCategory->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                        'value' => $manageCategory->status
                                    ],
                                ]),
                            ];
                            if ($manageCategory->mainCategoryId != null) {
                                $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail']['mainCategory'] = GetPropertyCategoryHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($manageCategory->mainCategoryId)
                                        ]
                                    ],
                                ])[Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                            }
                            if ($manageCategory->subCategoryId != null) {
                                $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail']['subCategory'] = GetPropertyCategoryHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($manageCategory->subCategoryId)
                                        ]
                                    ],
                                ])[Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                            }
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type')] = $data;
                }

                if (Config::get('constants.typeCheck.propertyRelated.propertyCategory.assignCategory.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $assignCategory = AssignCategory::where('id', decrypt($otherDataPasses['id']))->first();
                        if ($assignCategory != null) {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                                'id' => encrypt($assignCategory->id),
                                'about' => $assignCategory->about,
                                'assignBroad' => GetManageBroadHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                            'for' => Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($assignCategory->assignBroadId)
                                        ]
                                    ],
                                ])[Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'],
                                'manageCategory' => GetPropertyCategoryHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($assignCategory->mainCategoryId)
                                        ]
                                    ],
                                ])[Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $assignCategory->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                        'value' => $assignCategory->status
                                    ],
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.default'),
                                        'value' => $assignCategory->default
                                    ],
                                ]),
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [];
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
}

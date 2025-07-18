<?php

namespace App\Helpers\PropertyRelated;

use App\Traits\CommonTrait;

use App\Models\PropertyInstance\PropertyRelated\ManageBroad\AssignBroad;
use App\Models\PropertyInstance\PropertyRelated\ManageBroad\BroadType;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class GetManageBroadHelper
{
    use CommonTrait;
    public $platform = 'backend';


    public static function getList($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                if (Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.iyf'), $tempOne['getList']['type'])) {
                        $broadType = array();
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

                        foreach (BroadType::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $broadType[] = [
                                'id' => encrypt($tempTwo->id),
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.iyf')] = [
                            'list' => $broadType
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                        $broadType = array();
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

                        foreach (BroadType::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $broadType[] = GetManageBroadHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                            'list' => $broadType
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type')] = $data;
                }

                if (Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.iyf'), $tempOne['getList']['type'])) {
                        $broadType = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'propertyTypeId')) {
                                $propertyTypeId = $tempOne['otherDataPasses']['filterData']['propertyTypeId'];
                                if (!empty($propertyTypeId)) {
                                    $whereRaw .= " and `propertyTypeId` = " .  decrypt($propertyTypeId);
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
                            $broadType[] = [
                                'id' => encrypt($tempTwo->id),
                                'broadTypeId' => encrypt($tempTwo->broadTypeId),
                                'propertyTypeId' => encrypt($tempTwo->propertyTypeId),
                                'name' => BroadType::where('id', $tempTwo->broadTypeId)->value('name'),
                                'default' => $tempTwo->default,
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.iyf')] = [
                            'list' => $broadType
                        ];
                    }

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
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'propertyTypeId')) {
                                $propertyTypeId = $tempOne['otherDataPasses']['filterData']['propertyTypeId'];
                                if (!empty($propertyTypeId)) {
                                    $whereRaw .= " and `propertyTypeId` = " .  decrypt($propertyTypeId);
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
                            $assignBroad[] = GetManageBroadHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                        'for' => Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
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

                    $finalData[Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type')] = $data;
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

                if (Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $broadType = BroadType::where('id', decrypt($otherDataPasses['id']))->first();
                        if ($broadType != null) {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                                'id' => encrypt($broadType->id),
                                'name' => $broadType->name,
                                'about' =>  $broadType->about,
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $broadType->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                        'value' => $broadType->status
                                    ],
                                ]),
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type')] = $data;
                }

                if (Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $assignBroad = AssignBroad::where('id', decrypt($otherDataPasses['id']))->first();
                        if ($assignBroad != null) {
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
                                'broadType' => GetManageBroadHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($assignBroad->broadTypeId)
                                        ]
                                    ],
                                ])[Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
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
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [];
                        }
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

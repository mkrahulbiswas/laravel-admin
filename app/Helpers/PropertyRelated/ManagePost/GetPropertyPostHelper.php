<?php

namespace App\Helpers\PropertyRelated\ManagePost;

use App\Helpers\PropertyRelated\PropertyInstance\GetManageBroadHelper;
use App\Helpers\PropertyRelated\PropertyInstance\GetPropertyCategoryHelper;
use App\Helpers\PropertyRelated\PropertyInstance\GetPropertyTypeHelper;
use App\Traits\CommonTrait;

use App\Helpers\UsersRelated\ManageUsers\ManageUsersHelper;
use App\Models\PropertyRelated\ManagePost\MpBasicDetails;
use App\Models\PropertyRelated\ManagePost\MpMain;
use App\Models\PropertyRelated\ManagePost\MpPropertyLocated;
use App\Models\PropertyRelated\PropertyInstance\ManageBroad\BroadType;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class GetPropertyPostHelper
{
    use CommonTrait;
    public $platform = 'backend';


    public static function getList($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                if (Config::get('constants.typeCheck.propertyRelated.propertyInstance.manageBroad.broadType.type') == $tempOne['getList']['for']) {
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
                            $broadType[] = self::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.manageBroad.broadType.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.manageBroad.broadType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
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

                    $finalData[Config::get('constants.typeCheck.propertyRelated.propertyInstance.manageBroad.broadType.type')] = $data;
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

                if (Config::get('constants.typeCheck.propertyRelated.managePost.propertyPost.type') == $for) {
                    $data = array();
                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $mpMain = MpMain::where('id', decrypt($otherDataPasses['id']))->first();
                        $mpBasicDetails = MpBasicDetails::where('mpMainId', $mpMain->id)->first();
                        $mpPropertyLocated = MpPropertyLocated::where('mpMainId', $mpMain->id)->first();
                        if ($mpMain != null) {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                                'id' => encrypt($mpMain->id),
                                // 'user' => ManageUsersHelper::getDetail([
                                //     [
                                //         'getDetail' => [
                                //             'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                //             'for' => Config::get('constants.typeCheck.usersRelated.manageUsers.appUsers.type'),
                                //         ],
                                //         'otherDataPasses' => [
                                //             'id' => encrypt($mpMain->userId)
                                //         ],
                                //     ],
                                // ])[Config::get('constants.typeCheck.usersRelated.manageUsers.appUsers.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                                'mpBasicDetails' => [
                                    'id' => encrypt($mpBasicDetails->id),
                                    'assignCategory' => GetPropertyCategoryHelper::getDetail([
                                        [
                                            'getDetail' => [
                                                'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                                'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.assignCategory.type'),
                                            ],
                                            'otherDataPasses' => [
                                                'id' => encrypt($mpBasicDetails->assignCategoryId)
                                            ],
                                        ],
                                    ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyCategory.assignCategory.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'],
                                    'assignBroad' => GetManageBroadHelper::getDetail([
                                        [
                                            'getDetail' => [
                                                'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                                'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.manageBroad.assignBroad.type'),
                                            ],
                                            'otherDataPasses' => [
                                                'id' => encrypt($mpBasicDetails->assignBroadId)
                                            ],
                                        ],
                                    ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.manageBroad.assignBroad.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'],
                                    'propertyType' => GetPropertyTypeHelper::getDetail([
                                        [
                                            'getDetail' => [
                                                'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                                'for' => Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyType.type'),
                                            ],
                                            'otherDataPasses' => [
                                                'id' => encrypt($mpBasicDetails->propertyTypeId)
                                            ],
                                        ],
                                    ])[Config::get('constants.typeCheck.propertyRelated.propertyInstance.propertyType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                                ],
                                'mpPropertyLocated' => [
                                    'id' => encrypt($mpPropertyLocated->id),
                                    'city' => $mpPropertyLocated->city,
                                    'locality' => $mpPropertyLocated->locality,
                                    'subLocality' => $mpPropertyLocated->subLocality,
                                    'address' => $mpPropertyLocated->address,
                                ],
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $mpMain->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                        'value' => $mpMain->status
                                    ],
                                ]),
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.managePost.propertyPost.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

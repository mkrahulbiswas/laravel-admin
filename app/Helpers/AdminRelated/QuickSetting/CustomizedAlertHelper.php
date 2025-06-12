<?php

namespace App\Helpers\AdminRelated\QuickSetting;

use App\Traits\CommonTrait;

use App\Models\AdminRelated\QuickSetting\CustomizedAlert\AlertType;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class CustomizedAlertHelper
{
    use CommonTrait;
    public $platform = 'backend';


    public static function getList($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                if (Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.inf'), $tempOne['getList']['type'])) {
                        $alertType = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        foreach (AlertType::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $alertType[] = [
                                'id' => encrypt($tempTwo->id),
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.inf')] = [
                            'list' => $alertType
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.bnf'), $tempOne['getList']['type'])) {
                        $alertType = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        foreach (AlertType::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $alertType[] = CustomizedAlertHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.bnf')] = [
                            'list' => $alertType
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type')] = $data;
                }

                if (Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type') == $tempOne['getList']['for']) {
                    $data = array();

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
                            $broadType[] = CustomizedAlertHelper::getDetail([
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

                    $finalData[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type')] = $data;
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

                if (Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $alertType = AlertType::where('id', decrypt($otherDataPasses['id']))->first();
                        if ($alertType != null) {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                                'id' => encrypt($alertType->id),
                                'name' => $alertType->name,
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $alertType->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                        'value' => $alertType->status
                                    ],
                                ]),
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

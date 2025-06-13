<?php

namespace App\Helpers\AdminRelated\QuickSetting;

use App\Traits\CommonTrait;

use App\Models\AdminRelated\QuickSetting\CustomizedAlert\AlertFor;
use App\Models\AdminRelated\QuickSetting\CustomizedAlert\AlertTemplate;
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

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.iyf'), $tempOne['getList']['type'])) {
                        $alertFor = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'alertTypeId')) {
                                $alertTypeId = $tempOne['otherDataPasses']['filterData']['alertTypeId'];
                                if (!empty($alertTypeId)) {
                                    $whereRaw .= " and `alertTypeId` = " . decrypt($alertTypeId);
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

                        foreach (AlertFor::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $alertFor[] = [
                                'id' => encrypt($tempTwo->id),
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.iyf')] = [
                            'list' => $alertFor
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                        $alertFor = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'alertTypeId')) {
                                $alertTypeId = $tempOne['otherDataPasses']['filterData']['alertTypeId'];
                                if (!empty($alertTypeId)) {
                                    $whereRaw .= " and `alertTypeId` = " . decrypt($alertTypeId);
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

                        foreach (AlertFor::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $alertFor[] = CustomizedAlertHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.dyf')] = [
                            'list' => $alertFor
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type')] = $data;
                }
                if (Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertTemplate.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.iyf'), $tempOne['getList']['type'])) {
                        $alertFor = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'alertTypeId')) {
                                $alertTypeId = $tempOne['otherDataPasses']['filterData']['alertTypeId'];
                                if (!empty($alertTypeId)) {
                                    $whereRaw .= " and `alertTypeId` = " . decrypt($alertTypeId);
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

                        foreach (AlertFor::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $alertFor[] = [
                                'id' => encrypt($tempTwo->id),
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.iyf')] = [
                            'list' => $alertFor
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                        $alertTemplate = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'alertTypeId')) {
                                $alertTypeId = $tempOne['otherDataPasses']['filterData']['alertTypeId'];
                                if (!empty($alertTypeId)) {
                                    $whereRaw .= " and `alertTypeId` = " . decrypt($alertTypeId);
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

                        foreach (AlertTemplate::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $alertTemplate[] = CustomizedAlertHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertTemplate.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertTemplate.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.dyf')] = [
                            'list' => $alertTemplate
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertTemplate.type')] = $data;
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

                if (Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $alertFor = AlertFor::where('id', decrypt($otherDataPasses['id']))->first();
                        if ($alertFor != null) {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                                'id' => encrypt($alertFor->id),
                                'name' => $alertFor->name,
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $alertFor->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                        'value' => $alertFor->status
                                    ],
                                ]),
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [];
                        }
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $alertFor = AlertFor::where('id', decrypt($otherDataPasses['id']))->first();
                        if ($alertFor != null) {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                                'id' => encrypt($alertFor->id),
                                'name' => $alertFor->name,
                                'alertType' => CustomizedAlertHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($alertFor->alertTypeId)
                                        ]
                                    ],
                                ])[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $alertFor->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                        'value' => $alertFor->status
                                    ],
                                ]),
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type')] = $data;
                }

                if (Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertTemplate.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $alertTemplate = AlertTemplate::where('id', decrypt($otherDataPasses['id']))->first();
                        if ($alertTemplate != null) {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                                'id' => encrypt($alertTemplate->id),
                                'heading' => $alertTemplate->heading,
                                'content' => $alertTemplate->content,
                                'alertType' => CustomizedAlertHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($alertTemplate->alertTypeId)
                                        ]
                                    ],
                                ])[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                                'alertFor' => CustomizedAlertHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($alertTemplate->alertForId)
                                        ]
                                    ],
                                ])[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $alertTemplate->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.default'),
                                        'value' => $alertTemplate->default
                                    ],
                                ]),
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertTemplate.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

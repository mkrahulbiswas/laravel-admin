<?php

namespace App\Helpers\PropertyRelated;

use App\Traits\CommonTrait;

use App\Models\PropertyRelated\PropertyAttributes;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class GetPropertyAttributesHelper
{
    use CommonTrait;
    public $platform = 'backend';


    public static function getList($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                if (Config::get('constants.typeCheck.propertyRelated.propertyAttributes.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                        $propertyAttributes = array();
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

                        foreach (PropertyAttributes::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $propertyAttributes[] = GetPropertyAttributesHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyAttributes.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.propertyRelated.propertyAttributes.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                            'list' => $propertyAttributes
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.propertyAttributes.type')] = $data;
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

                if (Config::get('constants.typeCheck.propertyRelated.propertyAttributes.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $propertyAttributes = PropertyAttributes::where('id', decrypt($otherDataPasses['id']))->first();
                        $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                            'id' => encrypt($propertyAttributes->id),
                            'name' => $propertyAttributes->name,
                            'about' =>  $propertyAttributes->about,
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $propertyAttributes->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                    'value' => $propertyAttributes->status
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.default'),
                                    'value' => $propertyAttributes->default
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.type'),
                                    'value' => $propertyAttributes->type
                                ]
                            ]),
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.propertyAttributes.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

<?php

namespace App\Helpers\PropertyRelated;

use App\Traits\CommonTrait;

use App\Models\PropertyRelated\PropertyTypes;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class GetPropertyTypesHelper
{
    use CommonTrait;
    public $platform = 'backend';


    public static function getList($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                if (Config::get('constants.typeCheck.propertyRelated.propertyTypes.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                        $propertyTypes = array();
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

                        foreach (PropertyTypes::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $propertyTypes[] = GetPropertyTypesHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyTypes.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.propertyRelated.propertyTypes.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                            'list' => $propertyTypes
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.propertyTypes.type')] = $data;
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

                if (Config::get('constants.typeCheck.propertyRelated.propertyTypes.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $propertyTypes = PropertyTypes::where('id', decrypt($otherDataPasses['id']))->first();
                        $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                            'id' => encrypt($propertyTypes->id),
                            'name' => $propertyTypes->name,
                            'about' =>  $propertyTypes->about,
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $propertyTypes->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                    'value' => $propertyTypes->status
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.default'),
                                    'value' => $propertyTypes->default
                                ]
                            ]),
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.propertyRelated.propertyTypes.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

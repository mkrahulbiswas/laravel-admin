<?php

namespace App\Helpers\ManagePanel;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use App\Models\ManagePanel\QuickSettings\Logo;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class GetQuickSettingsHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';


    public static function getList($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                if (Config::get('constants.typeCheck.quickSettings.logo.type') == $tempOne['getList']['for']) {
                    $data = array();
                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.inf'), $tempOne['getList']['type'])) {
                        $logo = array();
                        foreach (Logo::get() as $tempTwo) {
                            $logo[] = [
                                'id' => encrypt($tempTwo->id),
                                'uniqueId' => $tempTwo->uniqueId,
                                'bigLogo' => FileTrait::getFile([
                                    'fileName' => $tempTwo->bigLogo,
                                    'storage' => Config::get('constants.storage')['bigLogo']
                                ])['public']['fullPath']['asset'],
                                'smallLogo' => FileTrait::getFile([
                                    'fileName' => $tempTwo->smallLogo,
                                    'storage' => Config::get('constants.storage')['smallLogo']
                                ])['public']['fullPath']['asset'],
                                'favicon' => FileTrait::getFile([
                                    'fileName' => $tempTwo->favicon,
                                    'storage' => Config::get('constants.storage')['favicon']
                                ])['public']['fullPath']['asset'],
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.default'),
                                        'value' => $tempTwo->default
                                    ],
                                ]),
                            ];
                        }
                        $data[Config::get('constants.typeCheck.helperCommon.get.inf')] = [
                            'list' => $logo
                        ];
                    }
                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.bnf'), $tempOne['getList']['type'])) {
                        $logo = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";
                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        }
                        if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                            if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                                $id = $tempOne['otherDataPasses']['orderBy']['id'];
                                if (!empty($id)) {
                                    $orderByRaw = "`id` " . $id;
                                }
                            }
                        }
                        foreach (Logo::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $logo[] = GetQuickSettingsHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.quickSettings.logo.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.quickSettings.logo.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                        }
                        $data[Config::get('constants.typeCheck.helperCommon.get.bnf')] = [
                            'list' => $logo
                        ];
                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.bnf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }
                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.bnf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }
                    $finalData[Config::get('constants.typeCheck.quickSettings.logo.type')] = $data;
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

                if (Config::get('constants.typeCheck.quickSettings.logo.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $logo = Logo::where('id', decrypt($otherDataPasses['id']))->first();
                        $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                            'id' => encrypt($logo->id),
                            'default' =>  $logo->default,
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $logo->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => 'default',
                                    'value' => $logo->default
                                ],
                            ]),
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.quickSettings.logo.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

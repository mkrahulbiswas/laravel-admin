<?php

namespace App\Helpers\ManagePanel\ManageAccess;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use App\Models\ManagePanel\ManageAccess\Permission;
use App\Models\ManagePanel\ManageAccess\RoleMain;
use App\Models\ManagePanel\ManageAccess\RoleSub;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class GetDetailHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';

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

                if (Config::get('constants.typeCheck.manageAccess.roleMain.type') == $for) {
                    $hasRoleSub = RoleSub::where('roleMainId', decrypt($otherDataPasses['id']))->count();
                    $permission = Permission::where('roleMainId', decrypt($otherDataPasses['id']))->count();
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $roleMain = RoleMain::where('id', decrypt($otherDataPasses['id']))->first();
                        $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                            'id' => encrypt($roleMain->id),
                            'name' => $roleMain->name,
                            'status' =>  $roleMain->status,
                            'description' =>  'lol',
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $roleMain->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => 'status',
                                    'value' => $roleMain->status
                                ],
                                [
                                    'type' => 'hasChild',
                                    'value' => $hasRoleSub
                                ],
                                [
                                    'type' => 'hasPermission',
                                    'value' => $permission
                                ]
                            ]),
                            'extraData' => [
                                'hasRoleSub' => $hasRoleSub,
                                'roleSubRoute' => route('admin.show.roleSub'),
                                'hasPermission' => $permission,
                            ]
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.manageAccess.roleMain.type')] = $data;
                }

                if (Config::get('constants.typeCheck.manageAccess.roleSub.type') == $for) {
                    $permission = Permission::where('roleSubId', decrypt($otherDataPasses['id']))->count();
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $roleSub = RoleSub::where('id', decrypt($otherDataPasses['id']))->first();
                        $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                            'id' => encrypt($roleSub->id),
                            'name' => $roleSub->name,
                            'status' =>  $roleSub->status,
                            'description' =>  $roleSub->description,
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $roleSub->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => 'status',
                                    'value' => $roleSub->status
                                ]
                            ]),
                            'extraData' => [
                                'hasPermission' => $permission,
                            ],
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $roleSub = RoleSub::where('id', decrypt($otherDataPasses['id']))->first();
                        $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                            'id' => encrypt($roleSub->id),
                            'name' => $roleSub->name,
                            'status' =>  $roleSub->status,
                            'description' =>  $roleSub->description,
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $roleSub->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => 'status',
                                    'value' => $roleSub->status
                                ]
                            ]),
                            'extraData' => [
                                'hasPermission' => $permission,
                            ],
                            Config::get('constants.typeCheck.manageAccess.roleMain.type') => GetDetailHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.manageAccess.roleMain.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($roleSub->roleMainId),
                                    ]
                                ]
                            ])[Config::get('constants.typeCheck.manageAccess.roleMain.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail']
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.manageAccess.roleSub.type')] = $data;
                }

                if (Config::get('constants.typeCheck.manageAccess.permission.type') == $for) {
                    $data = array();
                    $whereRaw = "`created_at` is not null";

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'id')) {
                                $id = $tempOne['otherDataPasses']['filterData']['id'];
                                if (!empty($id)) {
                                    $whereRaw .= " and `id` = " . decrypt($id);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navTypeId')) {
                                $navTypeId = $tempOne['otherDataPasses']['filterData']['navTypeId'];
                                if (!empty($navTypeId)) {
                                    $whereRaw .= " and `navTypeId` = " . decrypt($navTypeId);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navMainId')) {
                                $navMainId = $tempOne['otherDataPasses']['filterData']['navMainId'];
                                if (!empty($navMainId)) {
                                    $whereRaw .= " and `navMainId` = " . decrypt($navMainId);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navSubId')) {
                                $navSubId = $tempOne['otherDataPasses']['filterData']['navSubId'];
                                if (!empty($navSubId)) {
                                    $whereRaw .= " and `navSubId` = " . decrypt($navSubId);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navNestedId')) {
                                $navNestedId = $tempOne['otherDataPasses']['filterData']['navNestedId'];
                                if (!empty($navNestedId)) {
                                    $whereRaw .= " and `navNestedId` = " . decrypt($navNestedId);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'roleSubId')) {
                                $roleSubId = $tempOne['otherDataPasses']['filterData']['roleSubId'];
                                if (!empty($roleSubId)) {
                                    $whereRaw .= " and `roleSubId` = " . decrypt($roleSubId);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'roleMainId')) {
                                $roleMainId = $tempOne['otherDataPasses']['filterData']['roleMainId'];
                                if (!empty($roleMainId)) {
                                    $whereRaw .= " and `roleMainId` = " . decrypt($roleMainId);
                                }
                            }
                        }
                        $permission = Permission::whereRaw($whereRaw)->first();
                        if ($permission != null) {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                                'id' => encrypt($permission->id),
                                'uniqueId' => $permission->uniqueId,
                                'privilege' => json_decode($permission->privilege, true),
                                'permission' => $permission,
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = null;
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.manageAccess.permission.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

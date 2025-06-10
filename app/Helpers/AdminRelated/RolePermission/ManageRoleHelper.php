<?php

namespace App\Helpers\AdminRelated\RolePermission;

use App\Models\AdminRelated\RolePermission\ManageRole\MainRole;
use App\Models\AdminRelated\RolePermission\ManageRole\SubRole;
use App\Models\ManagePanel\ManageAccess\Permission;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ManageRoleHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';

    public static function getList($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                if (Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                        $mainRole = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'uniqueId') && (Auth::guard('admin')->user()->uniqueId != Config::get('constants.superAdminCheck')['admin'])) {
                                $uniqueId = $tempOne['otherDataPasses']['filterData']['uniqueId'];
                                if (!empty($uniqueId)) {
                                    $whereRaw .= " and `uniqueId` != '" . $uniqueId . "'";
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

                        foreach (MainRole::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $mainRole[] = ManageRoleHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                            'list' => $mainRole
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.ryf'), $tempOne['getList']['type'])) {
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'uniqueId') && (Auth::guard('admin')->user()->uniqueId != Config::get('constants.superAdminCheck')['admin'])) {
                                $uniqueId = $tempOne['otherDataPasses']['filterData']['uniqueId'];
                                if (!empty($uniqueId)) {
                                    $whereRaw .= " and `uniqueId` != '" . $uniqueId . "'";
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

                        $data[Config::get('constants.typeCheck.helperCommon.get.ryf')] = [
                            'list' => MainRole::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get()
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.ryf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.ryf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')] = $data;
                }

                if (Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                        $subRole = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainRoleId')) {
                                $mainRoleId = $tempOne['otherDataPasses']['filterData']['mainRoleId'];
                                if (!empty($mainRoleId)) {
                                    $whereRaw .= " and `mainRoleId` = " . decrypt($mainRoleId);
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

                        foreach (SubRole::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $subRole[] = ManageRoleHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                            'list' => $subRole
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                        $subRole = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainRoleId')) {
                                $mainRoleId = $tempOne['otherDataPasses']['filterData']['mainRoleId'];
                                if (!empty($mainRoleId)) {
                                    $whereRaw .= " and `mainRoleId` = " . decrypt($mainRoleId);
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

                        foreach (SubRole::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $subRole[] = ManageRoleHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.dyf')] = [
                            'list' => $subRole
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.ryf'), $tempOne['getList']['type'])) {
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainRoleId')) {
                                $mainRoleId = $tempOne['otherDataPasses']['filterData']['mainRoleId'];
                                if (!empty($mainRoleId)) {
                                    $whereRaw .= " and `mainRoleId` = '" . $mainRoleId . "'";
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

                        $data[Config::get('constants.typeCheck.helperCommon.get.ryf')] = [
                            'list' => SubRole::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get()
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.ryf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.ryf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')] = $data;
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

                if (Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type') == $for) {
                    $hasSubRole = SubRole::where('mainRoleId', decrypt($otherDataPasses['id']))->count();
                    $permission = Permission::where('mainRoleId', decrypt($otherDataPasses['id']))->count();
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $mainRole = MainRole::where('id', decrypt($otherDataPasses['id']))->first();
                        $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                            'id' => encrypt($mainRole->id),
                            'name' => $mainRole->name,
                            'status' =>  $mainRole->status,
                            'description' =>  'lol',
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $mainRole->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => 'status',
                                    'value' => $mainRole->status
                                ],
                                [
                                    'type' => 'hasChild',
                                    'value' => $hasSubRole
                                ],
                                [
                                    'type' => 'hasPermission',
                                    'value' => $permission
                                ]
                            ]),
                            'extraData' => [
                                'hasSubRole' => $hasSubRole,
                                'subRoleRoute' => route('admin.show.subRole'),
                                'hasPermission' => $permission,
                            ]
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')] = $data;
                }

                if (Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type') == $for) {
                    $permission = Permission::where('subRoleId', decrypt($otherDataPasses['id']))->count();
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $subRole = SubRole::where('id', decrypt($otherDataPasses['id']))->first();
                        $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                            'id' => encrypt($subRole->id),
                            'name' => $subRole->name,
                            'status' =>  $subRole->status,
                            'description' =>  $subRole->description,
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $subRole->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => 'status',
                                    'value' => $subRole->status
                                ]
                            ]),
                            'extraData' => [
                                'hasPermission' => $permission,
                            ],
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $subRole = SubRole::where('id', decrypt($otherDataPasses['id']))->first();
                        $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                            'id' => encrypt($subRole->id),
                            'name' => $subRole->name,
                            'status' =>  $subRole->status,
                            'description' =>  $subRole->description,
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $subRole->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => 'status',
                                    'value' => $subRole->status
                                ]
                            ]),
                            'extraData' => [
                                'hasPermission' => $permission,
                            ],
                            Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type') => ManageRoleHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($subRole->mainRoleId),
                                    ]
                                ]
                            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail']
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')] = $data;
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
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainNavId')) {
                                $mainNavId = $tempOne['otherDataPasses']['filterData']['mainNavId'];
                                if (!empty($mainNavId)) {
                                    $whereRaw .= " and `mainNavId` = " . decrypt($mainNavId);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'subNavId')) {
                                $subNavId = $tempOne['otherDataPasses']['filterData']['subNavId'];
                                if (!empty($subNavId)) {
                                    $whereRaw .= " and `subNavId` = " . decrypt($subNavId);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'nestedNavId')) {
                                $nestedNavId = $tempOne['otherDataPasses']['filterData']['nestedNavId'];
                                if (!empty($nestedNavId)) {
                                    $whereRaw .= " and `nestedNavId` = " . decrypt($nestedNavId);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'subRoleId')) {
                                $subRoleId = $tempOne['otherDataPasses']['filterData']['subRoleId'];
                                if (!empty($subRoleId)) {
                                    $whereRaw .= " and `subRoleId` = " . decrypt($subRoleId);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainRoleId')) {
                                $mainRoleId = $tempOne['otherDataPasses']['filterData']['mainRoleId'];
                                if (!empty($mainRoleId)) {
                                    $whereRaw .= " and `mainRoleId` = " . decrypt($mainRoleId);
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

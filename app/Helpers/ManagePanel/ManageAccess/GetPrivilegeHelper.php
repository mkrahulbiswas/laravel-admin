<?php

namespace App\Helpers\ManagePanel\ManageAccess;

use App\Helpers\ManagePanel\GetManageNavHelper;
use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use App\Models\ManagePanel\ManageAccess\Permission;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class GetPrivilegeHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';

    public static function getPrivilege($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                [
                    'type' => $type,
                    'otherDataPasses' => $otherDataPasses
                ] = $tempOne;

                if (in_array(Config::get('constants.typeCheck.helperCommon.privilege.np'), $type)) {
                    $roleMain = $roleSub = array();

                    $getNav = GetManageNavHelper::getNav([
                        [
                            'type' => [Config::get('constants.typeCheck.helperCommon.nav.np')],
                            'otherDataPasses' => [
                                'filterData' => [
                                    'status' => Config::get('constants.status')['active']
                                ],
                                'orderBy' => [
                                    'position' => 'asc'
                                ]
                            ],
                        ]
                    ])[Config::get('constants.typeCheck.helperCommon.nav.np')];

                    $getRoleMain = GetListHelper::getList([
                        [
                            'getList' => [
                                'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                                'for' => Config::get('constants.typeCheck.manageAccess.roleMain.type'),
                            ],
                            'otherDataPasses' => [
                                'filterData' => [
                                    'status' => Config::get('constants.status')['active']
                                ]
                            ],
                        ],
                    ])[Config::get('constants.typeCheck.manageAccess.roleMain.type')]['rawYesFilter']['list'];

                    foreach ($getRoleMain as $tempTwo) {
                        $getRoleSub = GetListHelper::getList([
                            [
                                'getList' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                                    'for' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                                ],
                                'otherDataPasses' => [
                                    'filterData' => [
                                        'roleMainId' => $tempTwo->id,
                                        'status' => Config::get('constants.status')['active'],
                                    ]
                                ],
                            ],
                        ])[Config::get('constants.typeCheck.manageAccess.roleSub.type')]['rawYesFilter']['list'];
                        if ($tempTwo) {
                            foreach ($getRoleSub as $tempThree) {
                                $roleSub[] = [
                                    'id' => encrypt($tempThree->id),
                                    'name' => $tempThree->name,
                                    'status' =>  $tempThree->status,
                                    'description' =>  $tempThree->description,
                                    'nav' => $getNav
                                ];
                            }
                        }
                        $roleMain[] = [
                            'id' => encrypt($tempOne->id),
                            'name' => $tempOne->name,
                            'status' =>  $tempOne->status,
                            'description' =>  $tempOne->description,
                            'roleSub' => $roleSub,
                            'nav' => $getNav
                        ];
                        $roleSub = array();
                    }

                    $finalData[Config::get('constants.typeCheck.helperCommon.privilege.np')] = $roleMain;
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.privilege.gp'), $type)) {
                    $privilege = [];
                    $url = explode("/", url()->current());
                    $auth = Auth::guard('admin')->user();
                    if ($auth->uniqueId == Config::get('constants.superAdminCheck')['admin']) {
                        $privilege = CommonTrait::getNavAccessList([
                            [
                                'checkFirst' => [
                                    'type' => Config::get('constants.typeCheck.helperCommon.access.al')
                                ],
                                'otherDataPasses' => []
                            ]
                        ])[Config::get('constants.typeCheck.helperCommon.access.al')]['privilege'];
                    } else {
                        $permission = Permission::where(function ($query) use ($auth) {
                            if ($auth->roleSubId == null) {
                                return $query->where('roleMainId', $auth->roleMainId)->where('roleSubId', null);
                            } else {
                                return $query->where('roleMainId', $auth->roleMainId)->where('roleSubId', $auth->roleSubId);
                            }
                        })->get();
                        // dd($permission);
                        foreach ($permission as $tempTwo) {
                            if ($tempTwo->navTypeId != null && $tempTwo->navMainId != null && $tempTwo->navSubId != null && $tempTwo->navNestedId != null) {
                                $getDetail = GetManageNavHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.rnd')],
                                            'for' => Config::get('constants.typeCheck.manageNav.navNested.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($tempTwo->navNestedId)
                                        ],
                                    ]
                                ])[Config::get('constants.typeCheck.manageNav.navNested.type')][Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'];
                            } else if ($tempTwo->navTypeId != null && $tempTwo->navMainId != null && $tempTwo->navSubId != null && $tempTwo->navNestedId == null) {
                                $getDetail = GetManageNavHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.rnd')],
                                            'for' => Config::get('constants.typeCheck.manageNav.navSub.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($tempTwo->navSubId)
                                        ],
                                    ]
                                ])[Config::get('constants.typeCheck.manageNav.navSub.type')][Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'];
                            } else if ($tempTwo->navTypeId != null && $tempTwo->navMainId != null && $tempTwo->navSubId == null && $tempTwo->navNestedId == null) {
                                $getDetail = GetManageNavHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.rnd')],
                                            'for' => Config::get('constants.typeCheck.manageNav.navMain.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($tempTwo->navMainId)
                                        ],
                                    ]
                                ])[Config::get('constants.typeCheck.manageNav.navMain.type')][Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'];
                            } else {
                                $getDetail = GetManageNavHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.rnd')],
                                            'for' => Config::get('constants.typeCheck.manageNav.navType.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($tempTwo->navTypeId)
                                        ],
                                    ]
                                ])[Config::get('constants.typeCheck.manageNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'];
                            }
                            if (in_array($getDetail['lastSegment'], $url)) {
                                $privilege = json_decode($tempTwo->privilege, true);
                                goto a;
                            }
                        }
                        a:
                        // dd($privilege);
                        if ($privilege == []) {
                            $privilege = CommonTrait::getNavAccessList([
                                [
                                    'checkFirst' => [
                                        'type' => Config::get('constants.typeCheck.helperCommon.access.an')
                                    ],
                                    'otherDataPasses' => []
                                ]
                            ])[Config::get('constants.typeCheck.helperCommon.access.an')]['privilege'];
                        }
                    }
                    $finalData[Config::get('constants.typeCheck.helperCommon.privilege.gp')] = $privilege;
                }
                return $finalData;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}

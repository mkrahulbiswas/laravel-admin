<?php

namespace App\Helpers\AdminRelated\RolePermission;

use App\Helpers\AdminRelated\NavigationAccess\ManageSideNavHelper;

use App\Models\AdminRelated\RolePermission\ManagePermission\Permission;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ManagePermissionHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';

    public static function setPermission($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                DB::beginTransaction();

                [
                    'otherDataPasses' => $otherDataPasses,
                    'checkFirst' => $checkFirst
                ] = $tempOne;

                if (Config::get('constants.typeCheck.helperCommon.privilege.sp') == $checkFirst['for']) {

                    if (in_array(Config::get('constants.typeCheck.helperCommon.set.pfn'), $checkFirst['type'])) {
                        if ($otherDataPasses['for'] == Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')) {
                            $forType = Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type');
                            $targetTypeField = 'mainNavId';
                        } else if ($otherDataPasses['for'] == Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')) {
                            $forType = Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type');
                            $targetTypeField = 'subNavId';
                        } else if ($otherDataPasses['for'] == Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')) {
                            $forType = Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type');
                            $targetTypeField = 'nestedNavId';
                        } else {
                            $forType =  Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type');
                            $targetTypeField = 'navTypeId';
                        }

                        $getDetail = ManageSideNavHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                    'for' => $otherDataPasses['for'],
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($otherDataPasses['id'])
                                ],
                            ],
                        ])[$otherDataPasses['for']][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];

                        $mainRole = ManageRoleHelper::getList([
                            [
                                'getList' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                                    'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                                ],
                                'otherDataPasses' => [
                                    'filterData' => [
                                        'status' => Config::get('constants.status')['active']
                                    ]
                                ],
                            ],
                        ]);

                        $result = CommonTrait::deleteItem([
                            [
                                'model' => Permission::class,
                                'picUrl' => [],
                                'filter' => [['search' => decrypt($getDetail['id']), 'field' => $targetTypeField]],
                            ]
                        ]);

                        if ($result == true) {
                            foreach ($mainRole[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'] as $tempTwo) {
                                if ($tempTwo['extraData']['hasSubRole'] <= 0) {
                                    $permission = new Permission();
                                    if ($otherDataPasses['for'] == Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')) {
                                        $permission->mainNavId = decrypt($getDetail['id']);
                                    }
                                    if ($otherDataPasses['for'] == Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')) {
                                        $permission->subNavId = decrypt($getDetail['id']);
                                        $permission->mainNavId = decrypt($getDetail['mainNav']['id']);
                                    }
                                    if ($otherDataPasses['for'] == Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')) {
                                        $permission->nestedNavId = decrypt($getDetail['id']);
                                        $permission->subNavId = decrypt($getDetail['subNav']['id']);
                                        $permission->mainNavId = decrypt($getDetail['mainNav']['id']);
                                    }
                                    $permission->navTypeId = decrypt($getDetail['navType']['id']);
                                    $permission->mainRoleId = decrypt($tempTwo['id']);
                                    $permission->privilege = json_encode($otherDataPasses['getNavAccessList']['privilege']);
                                    $permission->uniqueId = CommonTrait::generateCode(['preString' => 'PER', 'length' => 6, 'model' => Permission::class, 'field' => '']);
                                    if ($permission->save()) {
                                        $response = true;
                                    } else {
                                        $response = false;
                                        goto a;
                                    }
                                } else {
                                    $subRole = ManageRoleHelper::getList([
                                        [
                                            'getList' => [
                                                'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                                                'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                                            ],
                                            'otherDataPasses' => [
                                                'filterData' => [
                                                    'status' => Config::get('constants.status')['active'],
                                                    'mainRoleId' => $tempTwo['id']
                                                ]
                                            ],
                                        ]
                                    ]);
                                    foreach ($subRole[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'] as $tempThree) {
                                        $permission = new Permission();
                                        if ($otherDataPasses['for'] == Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')) {
                                            $permission->mainNavId = decrypt($getDetail['id']);
                                        }
                                        if ($otherDataPasses['for'] == Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')) {
                                            $permission->subNavId = decrypt($getDetail['id']);
                                            $permission->mainNavId = decrypt($getDetail['mainNav']['id']);
                                        }
                                        if ($otherDataPasses['for'] == Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')) {
                                            $permission->nestedNavId = decrypt($getDetail['id']);
                                            $permission->subNavId = decrypt($getDetail['subNav']['id']);
                                            $permission->mainNavId = decrypt($getDetail['mainNav']['id']);
                                        }
                                        $permission->navTypeId = decrypt($getDetail['navType']['id']);
                                        $permission->mainRoleId = decrypt($tempTwo['id']);
                                        $permission->subRoleId = decrypt($tempThree['id']);
                                        $permission->privilege = json_encode($otherDataPasses['getNavAccessList']['privilege']);
                                        $permission->uniqueId = CommonTrait::generateCode(['preString' => 'PER', 'length' => 6, 'model' => Permission::class, 'field' => '']);
                                        if ($permission->save()) {
                                            $response = true;
                                        } else {
                                            $response = false;
                                            goto a;
                                        }
                                    }
                                }
                            }
                        } else {
                            $response = false;
                            goto a;
                        }

                        a:
                        if ($response) {
                            DB::commit();
                            return true;
                        } else {
                            DB::rollBack();
                            return false;
                        }
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.set.pfr'), $checkFirst['type'])) {
                        $getNav = ManageSideNavHelper::getNav([
                            [
                                'type' => [Config::get('constants.typeCheck.helperCommon.nav.np')],
                                'otherDataPasses' => [
                                    'filterData' => ['status' => Config::get('constants.status')['active']],
                                    'orderBy' => ['position' => 'asc']
                                ],
                            ]
                        ])[Config::get('constants.typeCheck.helperCommon.nav.np')];
                        foreach ($getNav as $tempTwo) {
                            foreach ($tempTwo['mainNav'] as $tempThree) {
                                if ($tempThree['extraData']['hasSubNav'] > 0) {
                                    foreach ($tempThree['subNav'] as $tempFour) {
                                        if ($tempFour['extraData']['hasNestedNav'] > 0) {
                                            foreach ($tempFour['nestedNav'] as $tempFive) {
                                                $getNavAccessList = CommonTrait::getNavAccessList([
                                                    [
                                                        'checkFirst' => [
                                                            'type' => Config::get('constants.typeCheck.helperCommon.access.frs')
                                                        ],
                                                        'otherDataPasses' => [
                                                            'access' => $tempFive['access']
                                                        ]
                                                    ]
                                                ])[Config::get('constants.typeCheck.helperCommon.access.frs')]['privilege'];
                                                $permission = new Permission();
                                                $permission->navTypeId = decrypt($tempTwo['id']);
                                                $permission->mainNavId = decrypt($tempThree['id']);
                                                $permission->subNavId = decrypt($tempFour['id']);
                                                $permission->nestedNavId = decrypt($tempFive['id']);
                                                $permission->mainRoleId = $otherDataPasses['mainRoleId'];
                                                $permission->subRoleId = isset($otherDataPasses['subRoleId']) ? $otherDataPasses['subRoleId'] : null;
                                                $permission->privilege = json_encode($getNavAccessList);
                                                $permission->uniqueId = CommonTrait::generateCode(['preString' => 'PER', 'length' => 6, 'model' => Permission::class, 'field' => '']);
                                                if ($permission->save()) {
                                                    $response = true;
                                                } else {
                                                    $response = false;
                                                    goto check;
                                                }
                                            }
                                        } else {
                                            $getNavAccessList = CommonTrait::getNavAccessList([
                                                [
                                                    'checkFirst' => [
                                                        'type' => Config::get('constants.typeCheck.helperCommon.access.frs')
                                                    ],
                                                    'otherDataPasses' => [
                                                        'access' => $tempFour['access']
                                                    ]
                                                ]
                                            ])[Config::get('constants.typeCheck.helperCommon.access.frs')]['privilege'];
                                            $permission = new Permission();
                                            $permission->navTypeId = decrypt($tempTwo['id']);
                                            $permission->mainNavId = decrypt($tempThree['id']);
                                            $permission->subNavId = decrypt($tempFour['id']);
                                            $permission->mainRoleId = $otherDataPasses['mainRoleId'];
                                            $permission->subRoleId = isset($otherDataPasses['subRoleId']) ? $otherDataPasses['subRoleId'] : null;
                                            $permission->privilege = json_encode($getNavAccessList);
                                            $permission->uniqueId = CommonTrait::generateCode(['preString' => 'PER', 'length' => 6, 'model' => Permission::class, 'field' => '']);
                                            if ($permission->save()) {
                                                $response = true;
                                            } else {
                                                $response = false;
                                                goto check;
                                            }
                                        }
                                    }
                                } else {
                                    $getNavAccessList = CommonTrait::getNavAccessList([
                                        [
                                            'checkFirst' => [
                                                'type' => Config::get('constants.typeCheck.helperCommon.access.frs')
                                            ],
                                            'otherDataPasses' => [
                                                'access' => $tempThree['access']
                                            ]
                                        ]
                                    ])[Config::get('constants.typeCheck.helperCommon.access.frs')]['privilege'];
                                    $permission = new Permission();
                                    $permission->navTypeId = decrypt($tempTwo['id']);
                                    $permission->mainNavId = decrypt($tempThree['id']);
                                    $permission->mainRoleId = $otherDataPasses['mainRoleId'];
                                    $permission->subRoleId = isset($otherDataPasses['subRoleId']) ? $otherDataPasses['subRoleId'] : null;
                                    $permission->privilege = json_encode($getNavAccessList);
                                    $permission->uniqueId = CommonTrait::generateCode(['preString' => 'PER', 'length' => 6, 'model' => Permission::class, 'field' => '']);
                                    if ($permission->save()) {
                                        $response = true;
                                    } else {
                                        $response = false;
                                        goto check;
                                    }
                                }
                            }
                        }

                        check:
                        if ($response) {
                            DB::commit();
                            return true;
                        } else {
                            DB::rollBack();
                            return false;
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.helperCommon.detail.nd')] = [];
                }
            }
            return $finalData;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

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
                    $mainRole = $subRole = array();

                    $getNav = ManageSideNavHelper::getNav([
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

                    $getMainRole = ManageRoleHelper::getList([
                        [
                            'getList' => [
                                'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                                'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                            ],
                            'otherDataPasses' => [
                                'filterData' => [
                                    'status' => Config::get('constants.status')['active']
                                ]
                            ],
                        ],
                    ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')]['rawYesFilter']['list'];

                    foreach ($getMainRole as $tempTwo) {
                        $getSubRole = ManageRoleHelper::getList([
                            [
                                'getList' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                                    'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                                ],
                                'otherDataPasses' => [
                                    'filterData' => [
                                        'mainRoleId' => $tempTwo->id,
                                        'status' => Config::get('constants.status')['active'],
                                    ]
                                ],
                            ],
                        ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')]['rawYesFilter']['list'];
                        if ($tempTwo) {
                            foreach ($getSubRole as $tempThree) {
                                $subRole[] = [
                                    'id' => encrypt($tempThree->id),
                                    'name' => $tempThree->name,
                                    'status' =>  $tempThree->status,
                                    'description' =>  $tempThree->description,
                                    'nav' => $getNav
                                ];
                            }
                        }
                        $mainRole[] = [
                            'id' => encrypt($tempOne->id),
                            'name' => $tempOne->name,
                            'status' =>  $tempOne->status,
                            'description' =>  $tempOne->description,
                            'subRole' => $subRole,
                            'nav' => $getNav
                        ];
                        $subRole = array();
                    }

                    $finalData[Config::get('constants.typeCheck.helperCommon.privilege.np')] = $mainRole;
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.privilege.gp'), $type)) {
                    $privilege = [];
                    $url = explode("/", url()->current());
                    $auth = Auth::guard('admin')->user();
                    if ($auth->uniqueId == Config::get('constants.superAdminCheck')['admin']) {
                        $privilege = CommonTrait::getNavAccessList([
                            [
                                'checkFirst' => [
                                    'type' => Config::get('constants.typeCheck.helperCommon.access.ay')
                                ],
                                'otherDataPasses' => []
                            ]
                        ])[Config::get('constants.typeCheck.helperCommon.access.ay')]['privilege'];
                    } else {
                        $permission = Permission::where(function ($query) use ($auth) {
                            if ($auth->subRoleId == null) {
                                return $query->where('mainRoleId', $auth->mainRoleId)->where('subRoleId', null);
                            } else {
                                return $query->where('mainRoleId', $auth->mainRoleId)->where('subRoleId', $auth->subRoleId);
                            }
                        })->get();
                        // dd($permission);
                        foreach ($permission as $tempTwo) {
                            if ($tempTwo->navTypeId != null && $tempTwo->mainNavId != null && $tempTwo->subNavId != null && $tempTwo->nestedNavId != null) {
                                $getDetail = ManageSideNavHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.rnd')],
                                            'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($tempTwo->nestedNavId)
                                        ],
                                    ]
                                ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')][Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'];
                            } else if ($tempTwo->navTypeId != null && $tempTwo->mainNavId != null && $tempTwo->subNavId != null && $tempTwo->nestedNavId == null) {
                                $getDetail = ManageSideNavHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.rnd')],
                                            'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($tempTwo->subNavId)
                                        ],
                                    ]
                                ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')][Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'];
                            } else if ($tempTwo->navTypeId != null && $tempTwo->mainNavId != null && $tempTwo->subNavId == null && $tempTwo->nestedNavId == null) {
                                $getDetail = ManageSideNavHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.rnd')],
                                            'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($tempTwo->mainNavId)
                                        ],
                                    ]
                                ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'];
                            } else {
                                $getDetail = ManageSideNavHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.rnd')],
                                            'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($tempTwo->navTypeId)
                                        ],
                                    ]
                                ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'];
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

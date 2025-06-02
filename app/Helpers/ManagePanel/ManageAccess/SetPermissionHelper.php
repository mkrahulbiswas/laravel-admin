<?php

namespace App\Helpers\ManagePanel\ManageAccess;

use App\Helpers\ManagePanel\GetManageNavHelper;
use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use App\Models\ManagePanel\ManageAccess\Permission;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SetPermissionHelper
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
                        if ($otherDataPasses['for'] == Config::get('constants.typeCheck.manageNav.navMain.type')) {
                            $forType = Config::get('constants.typeCheck.manageNav.navMain.type');
                            $targetTypeField = 'navMainId';
                        } else if ($otherDataPasses['for'] == Config::get('constants.typeCheck.manageNav.navSub.type')) {
                            $forType = Config::get('constants.typeCheck.manageNav.navSub.type');
                            $targetTypeField = 'navSubId';
                        } else if ($otherDataPasses['for'] == Config::get('constants.typeCheck.manageNav.navNested.type')) {
                            $forType = Config::get('constants.typeCheck.manageNav.navNested.type');
                            $targetTypeField = 'navNestedId';
                        } else {
                            $forType =  Config::get('constants.typeCheck.manageNav.navType.type');
                            $targetTypeField = 'navTypeId';
                        }

                        $getDetail = GetDetailHelper::getDetail([
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

                        $roleMain = GetListHelper::getList([
                            [
                                'getList' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                                    'for' => Config::get('constants.typeCheck.manageAccess.roleMain.type'),
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
                            foreach ($roleMain[Config::get('constants.typeCheck.manageAccess.roleMain.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'] as $tempTwo) {
                                if ($tempTwo['extraData']['hasRoleSub'] <= 0) {
                                    $permission = new Permission();
                                    if ($otherDataPasses['for'] == Config::get('constants.typeCheck.manageNav.navMain.type')) {
                                        $permission->navMainId = decrypt($getDetail['id']);
                                    }
                                    if ($otherDataPasses['for'] == Config::get('constants.typeCheck.manageNav.navSub.type')) {
                                        $permission->navSubId = decrypt($getDetail['id']);
                                        $permission->navMainId = decrypt($getDetail['navMain']['id']);
                                    }
                                    if ($otherDataPasses['for'] == Config::get('constants.typeCheck.manageNav.navNested.type')) {
                                        $permission->navNestedId = decrypt($getDetail['id']);
                                        $permission->navSubId = decrypt($getDetail['navSub']['id']);
                                        $permission->navMainId = decrypt($getDetail['navMain']['id']);
                                    }
                                    $permission->navTypeId = decrypt($getDetail['navType']['id']);
                                    $permission->roleMainId = decrypt($tempTwo['id']);
                                    $permission->privilege = json_encode($otherDataPasses['getNavAccessList']['privilege']);
                                    $permission->uniqueId = CommonTrait::generateCode(['preString' => 'PER', 'length' => 6, 'model' => Permission::class, 'field' => '']);
                                    if ($permission->save()) {
                                        $response = true;
                                    } else {
                                        $response = false;
                                        goto a;
                                    }
                                } else {
                                    $roleSub = GetListHelper::getList([
                                        [
                                            'getList' => [
                                                'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                                                'for' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                                            ],
                                            'otherDataPasses' => [
                                                'filterData' => [
                                                    'status' => Config::get('constants.status')['active'],
                                                    'roleMainId' => $tempTwo['id']
                                                ]
                                            ],
                                        ]
                                    ]);
                                    foreach ($roleSub[Config::get('constants.typeCheck.manageAccess.roleSub.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'] as $tempThree) {
                                        $permission = new Permission();
                                        if ($otherDataPasses['for'] == Config::get('constants.typeCheck.manageNav.navMain.type')) {
                                            $permission->navMainId = decrypt($getDetail['id']);
                                        }
                                        if ($otherDataPasses['for'] == Config::get('constants.typeCheck.manageNav.navSub.type')) {
                                            $permission->navSubId = decrypt($getDetail['id']);
                                            $permission->navMainId = decrypt($getDetail['navMain']['id']);
                                        }
                                        if ($otherDataPasses['for'] == Config::get('constants.typeCheck.manageNav.navNested.type')) {
                                            $permission->navNestedId = decrypt($getDetail['id']);
                                            $permission->navSubId = decrypt($getDetail['navSub']['id']);
                                            $permission->navMainId = decrypt($getDetail['navMain']['id']);
                                        }
                                        $permission->navTypeId = decrypt($getDetail['navType']['id']);
                                        $permission->roleMainId = decrypt($tempTwo['id']);
                                        $permission->roleSubId = decrypt($tempThree['id']);
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
                        $getNav = GetManageNavHelper::getNav([
                            [
                                'type' => [Config::get('constants.typeCheck.helperCommon.nav.np')],
                                'otherDataPasses' => [
                                    'filterData' => ['status' => Config::get('constants.status')['active']],
                                    'orderBy' => ['position' => 'asc']
                                ],
                            ]
                        ])[Config::get('constants.typeCheck.helperCommon.nav.np')];
                        foreach ($getNav as $tempTwo) {
                            foreach ($tempTwo['navMain'] as $tempThree) {
                                if ($tempThree['extraData']['hasNavSub'] > 0) {
                                    foreach ($tempThree['navSub'] as $tempFour) {
                                        if ($tempFour['extraData']['hasNavNested'] > 0) {
                                            foreach ($tempFour['navNested'] as $tempFive) {
                                                $getNavAccessList = CommonTrait::getNavAccessList([
                                                    [
                                                        'checkFirst' => [
                                                            'type' => Config::get('constants.typeCheck.helperCommon.access.bm.frs')
                                                        ],
                                                        'otherDataPasses' => [
                                                            'access' => $tempFive['access']
                                                        ]
                                                    ]
                                                ])[Config::get('constants.typeCheck.helperCommon.access.bm.frs')]['privilege'];
                                                $permission = new Permission();
                                                $permission->navTypeId = decrypt($tempTwo['id']);
                                                $permission->navMainId = decrypt($tempThree['id']);
                                                $permission->navSubId = decrypt($tempFour['id']);
                                                $permission->navNestedId = decrypt($tempFive['id']);
                                                $permission->roleMainId = $otherDataPasses['roleMainId'];
                                                $permission->roleSubId = isset($otherDataPasses['roleSubId']) ? $otherDataPasses['roleSubId'] : null;
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
                                                        'type' => Config::get('constants.typeCheck.helperCommon.access.bm.frs')
                                                    ],
                                                    'otherDataPasses' => [
                                                        'access' => $tempFour['access']
                                                    ]
                                                ]
                                            ])[Config::get('constants.typeCheck.helperCommon.access.bm.frs')]['privilege'];
                                            $permission = new Permission();
                                            $permission->navTypeId = decrypt($tempTwo['id']);
                                            $permission->navMainId = decrypt($tempThree['id']);
                                            $permission->navSubId = decrypt($tempFour['id']);
                                            $permission->roleMainId = $otherDataPasses['roleMainId'];
                                            $permission->roleSubId = isset($otherDataPasses['roleSubId']) ? $otherDataPasses['roleSubId'] : null;
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
                                                'type' => Config::get('constants.typeCheck.helperCommon.access.bm.frs')
                                            ],
                                            'otherDataPasses' => [
                                                'access' => $tempThree['access']
                                            ]
                                        ]
                                    ])[Config::get('constants.typeCheck.helperCommon.access.bm.frs')]['privilege'];
                                    $permission = new Permission();
                                    $permission->navTypeId = decrypt($tempTwo['id']);
                                    $permission->navMainId = decrypt($tempThree['id']);
                                    $permission->roleMainId = $otherDataPasses['roleMainId'];
                                    $permission->roleSubId = isset($otherDataPasses['roleSubId']) ? $otherDataPasses['roleSubId'] : null;
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
}

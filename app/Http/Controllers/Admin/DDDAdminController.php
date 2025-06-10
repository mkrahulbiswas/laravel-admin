<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Helpers\ManagePanel\GetManageAccessHelper;
use App\Helpers\ManagePanel\GetManageNavHelper;
use App\Helpers\PropertyRelated\GetManageBroadHelper;
use App\Helpers\PropertyRelated\GetPropertyCategoryHelper;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use Exception;
use Illuminate\Support\Facades\Config;

class DDDAdminController extends Controller
{
    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


    /*------ ( Get Nav Main ) -------*/
    public function getNavMain($navTypeId)
    {
        try {
            $navMain = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageNav.navMain.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'navTypeId' => $navTypeId,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ]);

            $data = [
                'navMain' => $navMain[Config::get('constants.typeCheck.manageNav.navMain.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list']
            ];

            if ($data) {
                return Response()->Json(['status' => 1, 'msg' => 'Nav main is found.', 'data' => $data], Config::get('constants.errorCode.ok'));
            } else {
                return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    /*------ ( Get Nav Sub ) -------*/
    public function getNavSub($navMainId)
    {
        try {
            $navSub = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageNav.navSub.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'navMainId' => $navMainId,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ]);

            $data = [
                'navSub' => $navSub[Config::get('constants.typeCheck.manageNav.navSub.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list']
            ];

            if ($data) {
                return Response()->Json(['status' => 1, 'msg' => 'Nav sub is found.', 'data' => $data], Config::get('constants.errorCode.ok'));
            } else {
                return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    /*------ ( Get Sub Role ) -------*/
    public function getRoleSub($mainRoleId)
    {
        try {
            $navSub = GetManageAccessHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'mainRoleId' => $mainRoleId,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ]);

            $data = [
                'roleSub' => $navSub[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list']
            ];

            if ($data) {
                return Response()->Json(['status' => 1, 'msg' => 'Sub role is found.', 'data' => $data], Config::get('constants.errorCode.ok'));
            } else {
                return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    /*------ ( Property Category ) -------*/
    public function getAssignBroad($propertyTypeId)
    {
        try {
            $assignBroad = GetManageBroadHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'propertyTypeId' => $propertyTypeId,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            if ($assignBroad == []) {
                return Response()->Json(['status' => 2, 'msg' => __('messages.serverErrMsg'), 'redirectTo' => route('admin.show.assignBroad'), 'data' => (object)[]], Config::get('constants.errorCode.ok'));
            } else {
                $data = [
                    'assignBroad' => $assignBroad
                ];
                if ($data) {
                    return Response()->Json(['status' => 1, 'msg' => 'Sub role is found.', 'data' => $data], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'data' => (object)[]], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function getMainCategory($mainCategoryId)
    {
        try {
            $mainCategory = GetPropertyCategoryHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status.active'),
                            'mainCategoryId' => $mainCategoryId,
                            'subCategoryId' => null,
                        ],
                        'orderBy' => ['id' => 'desc'],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];

            $data = [
                'mainCategory' => $mainCategory
            ];
            if ($data) {
                return Response()->Json(['status' => 1, 'msg' => 'Sub role is found.', 'data' => $data], Config::get('constants.errorCode.ok'));
            } else {
                return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'data' => (object)[]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }
}

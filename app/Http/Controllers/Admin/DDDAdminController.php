<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Helpers\AdminRelated\RolePermission\ManageRoleHelper;
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


    /*------ ( Get Main Nav ) -------*/
    public function getNavMain($navTypeId)
    {
        try {
            $mainNav = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
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
                'mainNav' => $mainNav[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list']
            ];

            if ($data) {
                return Response()->Json(['status' => 1, 'msg' => 'Main nav is found.', 'data' => $data], Config::get('constants.errorCode.ok'));
            } else {
                return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    /*------ ( Get Sub Nav ) -------*/
    public function getNavSub($mainNavId)
    {
        try {
            $subNav = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'mainNavId' => $mainNavId,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ]);

            $data = [
                'navSub' => $subNav[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list']
            ];

            if ($data) {
                return Response()->Json(['status' => 1, 'msg' => 'Sub nav is found.', 'data' => $data], Config::get('constants.errorCode.ok'));
            } else {
                return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    /*------ ( Get Sub Role ) -------*/
    public function getSubRole($mainRoleId)
    {
        try {
            $subNav = ManageRoleHelper::getList([
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
                'subRole' => $subNav[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list']
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

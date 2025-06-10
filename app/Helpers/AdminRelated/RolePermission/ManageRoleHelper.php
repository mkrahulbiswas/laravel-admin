<?php

namespace App\Helpers\AdminRelated\RolePermission;

use App\Models\AdminRelated\RolePermission\ManageRole\MainRole;
use App\Models\AdminRelated\RolePermission\ManageRole\SubRole;
use App\Models\ManagePanel\ManageAccess\Permission;

use App\Helpers\ManagePanel\GetManageNavHelper;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ManageRoleHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';

    public static function getList($params, $platform = '')
    {
        // try {
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
        // } catch (Exception $e) {
        //     return false;
        // }
    }

    public static function getDetail($params, $platform = '')
    {
        // try {
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
        // } catch (Exception $e) {
        //     return false;
        // }
    }

    public static function setPermission($params, $platform = '')
    {
        // try {
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

                    $getDetail = GetManageNavHelper::getDetail([
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
                                                        'type' => Config::get('constants.typeCheck.helperCommon.access.frs')
                                                    ],
                                                    'otherDataPasses' => [
                                                        'access' => $tempFive['access']
                                                    ]
                                                ]
                                            ])[Config::get('constants.typeCheck.helperCommon.access.frs')]['privilege'];
                                            $permission = new Permission();
                                            $permission->navTypeId = decrypt($tempTwo['id']);
                                            $permission->navMainId = decrypt($tempThree['id']);
                                            $permission->navSubId = decrypt($tempFour['id']);
                                            $permission->navNestedId = decrypt($tempFive['id']);
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
                                        $permission->navMainId = decrypt($tempThree['id']);
                                        $permission->navSubId = decrypt($tempFour['id']);
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
                                $permission->navMainId = decrypt($tempThree['id']);
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
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return false;
        // }
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

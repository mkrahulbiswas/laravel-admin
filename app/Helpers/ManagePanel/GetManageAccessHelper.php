<?php

namespace App\Helpers\ManagePanel;

use App\Models\AdminRelated\RolePermission\ManageRole\MainRole;
use App\Models\AdminRelated\RolePermission\ManageRole\SubRole;
use App\Models\ManagePanel\ManageAccess\Permission;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class GetManageAccessHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';


    public static function getList($params, $platform = '')
    {
        // try {
        $finalData = array();
        foreach ($params as $tempOne) {
            if (Config::get('constants.typeCheck.manageAccess.roleMain.type') == $tempOne['getList']['for']) {
                $data = array();

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                    $roleMain = array();
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
                        $roleMain[] = GetManageAccessHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'for' => Config::get('constants.typeCheck.manageAccess.roleMain.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($tempTwo->id)
                                ]
                            ],
                        ])[Config::get('constants.typeCheck.manageAccess.roleMain.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                        'list' => $roleMain
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

                $finalData[Config::get('constants.typeCheck.manageAccess.roleMain.type')] = $data;
            }

            if (Config::get('constants.typeCheck.manageAccess.roleSub.type') == $tempOne['getList']['for']) {
                $data = array();

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                    $roleSub = array();
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'roleMainId')) {
                            $roleMainId = $tempOne['otherDataPasses']['filterData']['roleMainId'];
                            if (!empty($roleMainId)) {
                                $whereRaw .= " and `roleMainId` = " . decrypt($roleMainId);
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
                        $roleSub[] = GetManageAccessHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'for' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($tempTwo->id)
                                ]
                            ],
                        ])[Config::get('constants.typeCheck.manageAccess.roleSub.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                        'list' => $roleSub
                    ];

                    if (isset($tempOne['otherDataPasses']['filterData'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                    }

                    if (isset($tempOne['otherDataPasses']['orderBy'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                    }
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                    $roleSub = array();
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'roleMainId')) {
                            $roleMainId = $tempOne['otherDataPasses']['filterData']['roleMainId'];
                            if (!empty($roleMainId)) {
                                $whereRaw .= " and `roleMainId` = " . decrypt($roleMainId);
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
                        $roleSub[] = GetManageAccessHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                    'for' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($tempTwo->id)
                                ]
                            ],
                        ])[Config::get('constants.typeCheck.manageAccess.roleSub.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.dyf')] = [
                        'list' => $roleSub
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
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'roleMainId')) {
                            $roleMainId = $tempOne['otherDataPasses']['filterData']['roleMainId'];
                            if (!empty($roleMainId)) {
                                $whereRaw .= " and `roleMainId` = '" . $roleMainId . "'";
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

                $finalData[Config::get('constants.typeCheck.manageAccess.roleSub.type')] = $data;
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

            if (Config::get('constants.typeCheck.manageAccess.roleMain.type') == $for) {
                $hasRoleSub = SubRole::where('roleMainId', decrypt($otherDataPasses['id']))->count();
                $permission = Permission::where('roleMainId', decrypt($otherDataPasses['id']))->count();
                $data = array();

                if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                    $roleMain = MainRole::where('id', decrypt($otherDataPasses['id']))->first();
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
                            'roleSubRoute' => route('admin.show.subRole'),
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
                    $roleSub = SubRole::where('id', decrypt($otherDataPasses['id']))->first();
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
                    $roleSub = SubRole::where('id', decrypt($otherDataPasses['id']))->first();
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
                        Config::get('constants.typeCheck.manageAccess.roleMain.type') => GetManageAccessHelper::getDetail([
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

                    $roleMain = GetManageAccessHelper::getList([
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
                                $roleSub = GetManageAccessHelper::getList([
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

                    $getRoleMain = GetManageAccessHelper::getList([
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
                        $getRoleSub = GetManageAccessHelper::getList([
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
                                    'type' => Config::get('constants.typeCheck.helperCommon.access.ay')
                                ],
                                'otherDataPasses' => []
                            ]
                        ])[Config::get('constants.typeCheck.helperCommon.access.ay')]['privilege'];
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

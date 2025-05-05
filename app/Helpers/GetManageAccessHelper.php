<?php

namespace App\Helpers;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use App\Models\ManagePanel\ManageAccess\Permission;
use App\Models\ManagePanel\ManageAccess\RoleMain;
use App\Models\ManagePanel\ManageAccess\RoleSub;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class GetManageAccessHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';


    public static function getList($params, $platform = '')
    {
        try {
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
                        }

                        if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                            if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                                $id = $tempOne['otherDataPasses']['orderBy']['id'];
                                if (!empty($id)) {
                                    $orderByRaw = "`id` " . $id;
                                }
                            }
                        }

                        foreach (RoleMain::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
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
                            'list' => RoleMain::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get()
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

                        foreach (RoleSub::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
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

                        foreach (RoleSub::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
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
                            'list' => RoleSub::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get()
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
                    'otherDataPasses' => [
                        'id' => $id,
                    ],
                    'getDetail' => [
                        'type' => $type,
                        'for' => $for,
                    ]
                ] = $tempOne;

                if (Config::get('constants.typeCheck.manageAccess.roleMain.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $roleMain = RoleMain::where('id', decrypt($id))->first();
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
                                ]
                            ]),
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.manageAccess.roleMain.type')] = $data;
                }

                if (Config::get('constants.typeCheck.manageAccess.roleSub.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $roleSub = RoleSub::where('id', decrypt($id))->first();
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
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $roleSub = RoleSub::where('id', decrypt($id))->first();
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
                            Config::get('constants.typeCheck.manageAccess.roleMain.type') => GetManageAccessHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.manageAccess.roleMain.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($roleSub->roleMainId)
                                    ]
                                ]
                            ])[Config::get('constants.typeCheck.manageAccess.roleMain.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail']
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.manageAccess.roleSub.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function setPrivilege($params, $platform = '')
    {
        try {
            DB::beginTransaction();
            $finalData = array();

            [
                'otherDataPasses' => [
                    'getNavAccessList' => $getNavAccessList,
                    'id' => $id,
                ],
                'type' => $type
            ] = $params;

            if (in_array(Config::get('constants.typeCheck.manageNav.navMain.type'), $type)) {
                $getDetail = GetManageNavHelper::getDetail([
                    [
                        'getDetail' => [
                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                            'for' => Config::get('constants.typeCheck.manageNav.navMain.type'),
                        ],
                        'otherDataPasses' => [
                            'id' => encrypt($id)
                        ],
                    ],
                ])[Config::get('constants.typeCheck.manageNav.navMain.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
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
                        'filter' => [
                            ['search' => decrypt($getDetail['id']), 'field' => 'navMainId'],
                            ['search' => null, 'field' => 'navSubId'],
                            ['search' => null, 'field' => 'navNestedId'],
                        ],
                    ],
                ]);
                if ($result === true) {
                    foreach ($roleMain[Config::get('constants.typeCheck.manageAccess.roleMain.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'] as $tempOne) {
                        $permission = new Permission();
                        $permission->navTypeId = decrypt($getDetail['navType']['id']);
                        $permission->navMainId = decrypt($getDetail['id']);
                        $permission->roleMainId = decrypt($tempOne['id']);
                        $permission->privilege = json_encode($getNavAccessList['privilege']);
                        if ($permission->save()) {
                            $roleSub = GetManageAccessHelper::getList([
                                [
                                    'getList' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                                        'for' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'filterData' => [
                                            'status' => Config::get('constants.status')['active'],
                                            'roleMainId' => $tempOne['id']
                                        ]
                                    ],
                                ]
                            ]);
                            foreach ($roleSub[Config::get('constants.typeCheck.manageAccess.roleSub.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'] as $tempTwo) {
                                $permission = new Permission();
                                $permission->navTypeId = decrypt($getDetail['navType']['id']);
                                $permission->navMainId = decrypt($getDetail['id']);
                                $permission->roleMainId = decrypt($tempOne['id']);
                                $permission->roleSubId = decrypt($tempTwo['id']);
                                $permission->privilege = json_encode($getNavAccessList['privilege']);
                                if ($permission->save()) {
                                    $response = true;
                                } else {
                                    DB::rollBack();
                                    $response = false;
                                }
                            }
                        } else {
                            DB::rollBack();
                            $response = false;
                        }
                    }
                } else {
                    $response = false;
                }

                if ($response) {
                    DB::commit();
                    return true;
                } else {
                    return false;
                }

                $finalData[Config::get('constants.typeCheck.helperCommon.detail.nd')] = [];
            }

            if (in_array(Config::get('constants.typeCheck.manageNav.navSub.type'), $type)) {
                $getDetail = GetManageNavHelper::getDetail([
                    [
                        'getDetail' => [
                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                            'for' => Config::get('constants.typeCheck.manageNav.navSub.type'),
                        ],
                        'otherDataPasses' => [
                            'id' => encrypt($id)
                        ],
                    ],
                ])[Config::get('constants.typeCheck.manageNav.navSub.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
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
                        'filter' => [
                            ['search' => decrypt($getDetail['id']), 'field' => 'navSubId'],
                            ['search' => null, 'field' => 'navNestedId'],
                        ],
                    ]
                ]);
                if ($result === true) {
                    foreach ($roleMain[Config::get('constants.typeCheck.manageAccess.roleMain.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'] as $tempOne) {
                        $permission = new Permission();
                        $permission->navTypeId = decrypt($getDetail['navType']['id']);
                        $permission->navMainId = decrypt($getDetail['navMain']['id']);
                        $permission->navSubId = decrypt($getDetail['id']);
                        $permission->roleMainId = decrypt($tempOne['id']);
                        $permission->privilege = json_encode($getNavAccessList['privilege']);
                        if ($permission->save()) {
                            $roleSub = GetManageAccessHelper::getList([
                                [
                                    'getList' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                                        'for' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'filterData' => [
                                            'status' => Config::get('constants.status')['active'],
                                            'roleMainId' => $tempOne['id']
                                        ]
                                    ],
                                ]
                            ]);
                            foreach ($roleSub[Config::get('constants.typeCheck.manageAccess.roleSub.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'] as $tempTwo) {
                                $permission = new Permission();
                                $permission->navTypeId = decrypt($getDetail['navType']['id']);
                                $permission->navMainId = decrypt($getDetail['navMain']['id']);
                                $permission->navSubId = decrypt($getDetail['id']);
                                $permission->roleMainId = decrypt($tempOne['id']);
                                $permission->roleSubId = decrypt($tempTwo['id']);
                                $permission->privilege = json_encode($getNavAccessList['privilege']);
                                if ($permission->save()) {
                                    $response = true;
                                } else {
                                    DB::rollBack();
                                    $response = false;
                                }
                            }
                        } else {
                            DB::rollBack();
                            $response = false;
                        }
                    }
                } else {
                    $response = false;
                }

                if ($response) {
                    DB::commit();
                    return true;
                } else {
                    return false;
                }

                $finalData[Config::get('constants.typeCheck.helperCommon.detail.nd')] = [];
            }

            if (in_array(Config::get('constants.typeCheck.manageNav.navNested.type'), $type)) {
                $getDetail = GetManageNavHelper::getDetail([
                    [
                        'getDetail' => [
                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                            'for' => Config::get('constants.typeCheck.manageNav.navNested.type'),
                        ],
                        'otherDataPasses' => [
                            'id' => encrypt($id)
                        ],
                    ],
                ])[Config::get('constants.typeCheck.manageNav.navNested.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];
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
                        'filter' => [['search' => decrypt($getDetail['id']), 'field' => 'navNestedId']],
                    ]
                ]);
                if ($result === true) {
                    foreach ($roleMain[Config::get('constants.typeCheck.manageAccess.roleMain.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'] as $tempOne) {
                        $permission = new Permission();
                        $permission->navTypeId = decrypt($getDetail['navType']['id']);
                        $permission->navMainId = decrypt($getDetail['navMain']['id']);
                        $permission->navSubId = decrypt($getDetail['navSub']['id']);
                        $permission->navNestedId = decrypt($getDetail['id']);
                        $permission->roleMainId = decrypt($tempOne['id']);
                        $permission->privilege = json_encode($getNavAccessList['privilege']);
                        if ($permission->save()) {
                            $roleSub = GetManageAccessHelper::getList([
                                [
                                    'getList' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                                        'for' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'filterData' => [
                                            'status' => Config::get('constants.status')['active'],
                                            'roleMainId' => $tempOne['id']
                                        ]
                                    ],
                                ]
                            ]);
                            foreach ($roleSub[Config::get('constants.typeCheck.manageAccess.roleSub.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'] as $tempTwo) {
                                $permission = new Permission();
                                $permission->navTypeId = decrypt($getDetail['navType']['id']);
                                $permission->navMainId = decrypt($getDetail['navMain']['id']);
                                $permission->navSubId = decrypt($getDetail['navSub']['id']);
                                $permission->navNestedId = decrypt($getDetail['id']);
                                $permission->roleMainId = decrypt($tempOne['id']);
                                $permission->roleSubId = decrypt($tempTwo['id']);
                                $permission->privilege = json_encode($getNavAccessList['privilege']);
                                if ($permission->save()) {
                                    $response = true;
                                } else {
                                    DB::rollBack();
                                    $response = false;
                                }
                            }
                        } else {
                            DB::rollBack();
                            $response = false;
                        }
                    }
                } else {
                    $response = false;
                }

                if ($response) {
                    DB::commit();
                    return true;
                } else {
                    return false;
                }

                $finalData[Config::get('constants.typeCheck.helperCommon.detail.nd')] = [];
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getPrivilege($params, $platform = '')
    {
        // try {
        DB::beginTransaction();
        $finalData = $roleMain = $roleSub = array();

        // [
        //     'otherDataPasses' => [
        //         'getNavAccessList' => $getNavAccessList,
        //         'id' => $id,
        //     ],
        //     'type' => $type
        // ] = $params;

        foreach (
            GetManageAccessHelper::getList([
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
            ])[Config::get('constants.typeCheck.manageAccess.roleMain.type')]['rawYesFilter']['list'] as $tempOne
        ) {
            foreach (
                GetManageAccessHelper::getList([
                    [
                        'getList' => [
                            'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                            'for' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                        ],
                        'otherDataPasses' => [
                            'filterData' => [
                                'roleMainId' => $tempOne->id,
                                'status' => Config::get('constants.status')['active'],
                            ]
                        ],
                    ],
                ])[Config::get('constants.typeCheck.manageAccess.roleSub.type')]['rawYesFilter']['list'] as $tempTwo
            ) {
                $roleSub[] = [
                    'id' => encrypt($tempTwo->id),
                    'name' => $tempTwo->name,
                    'status' =>  $tempTwo->status,
                    'description' =>  $tempTwo->description,
                    'nav' => GetManageNavHelper::getNav([
                        [
                            'type' => [Config::get('constants.typeCheck.helperCommon.nav.sn')],
                            'otherDataPasses' => [
                                'filterData' => [
                                    'status' => Config::get('constants.status')['active']
                                ],
                                'orderBy' => [
                                    'position' => 'asc'
                                ]
                            ],
                        ]
                    ])[Config::get('constants.typeCheck.helperCommon.nav.sn')]
                ];
            }
            $roleMain[] = [
                'id' => encrypt($tempOne->id),
                'name' => $tempOne->name,
                'status' =>  $tempOne->status,
                'description' =>  $tempOne->description,
                'roleSub' => $roleSub,
                'nav' => GetManageNavHelper::getNav([
                    [
                        'type' => [Config::get('constants.typeCheck.helperCommon.nav.sn')],
                        'otherDataPasses' => [
                            'filterData' => [
                                'status' => Config::get('constants.status')['active']
                            ],
                            'orderBy' => [
                                'position' => 'asc'
                            ]
                        ],
                    ]
                ])[Config::get('constants.typeCheck.helperCommon.nav.sn')]
            ];
            $roleSub = array();
        }

        // dd($roleMain);

        return $finalData;
        // } catch (Exception $e) {
        //     return false;
        // }
    }
}

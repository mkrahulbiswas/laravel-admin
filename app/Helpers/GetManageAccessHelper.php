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

class GetManageAccessHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';


    public static function getList($params, $platform = '')
    {
        try {
            $finalData = array();

            if (in_array(Config::get('constants.typeCheck.manageAccess.roleMain.type'), $params['type'])) {
                $roleMain = array();

                $whereRaw = "`created_at` is not null";
                $orderByRaw = "`id` DESC";
                if (Arr::exists($params['otherDataPasses'], 'filterData')) {
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'status')) {
                        $status = $params['otherDataPasses']['filterData']['status'];
                        if (!empty($status)) {
                            $whereRaw .= " and `status` = '" . $status . "'";
                        }
                    }
                }

                if (Arr::exists($params['otherDataPasses'], 'orderBy')) {
                    if (Arr::exists($params['otherDataPasses']['orderBy'], 'position')) {
                        $position = $params['otherDataPasses']['orderBy']['position'];
                        if (!empty($position)) {
                            $orderByRaw = "`position` " . $position;
                        }
                    }
                }

                foreach (RoleMain::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $temp) {
                    $roleMain[] = GetManageAccessHelper::getRoleMainDetail([
                        'type' => ['basic'],
                        'otherDataPasses' => [
                            'id' => $temp->id
                        ]
                    ])['basic']['roleSubDetail'];
                }

                $data = [
                    'roleMain' => $roleMain
                ];

                if (isset($params['otherDataPasses']['filterData'])) {
                    $data['filterData'] = $params['otherDataPasses']['filterData'];
                }

                if (isset($params['otherDataPasses']['orderBy'])) {
                    $data['orderBy'] = $params['otherDataPasses']['orderBy'];
                }

                $finalData['roleMain'] = $data;
            }

            if (in_array(Config::get('constants.typeCheck.manageAccess.roleSub.type'), $params['type'])) {
                $roleSub = array();

                $whereRaw = "`created_at` is not null";
                $orderByRaw = "`id` DESC";
                if (Arr::exists($params['otherDataPasses'], 'filterData')) {
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'status')) {
                        $status = $params['otherDataPasses']['filterData']['status'];
                        if (!empty($status)) {
                            $whereRaw .= " and `status` = '" . $status . "'";
                        }
                    }
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'roleMainId')) {
                        $roleMainId = $params['otherDataPasses']['filterData']['roleMainId'];
                        if (!empty($roleMainId)) {
                            $whereRaw .= " and `roleMainId` = " . decrypt($roleMainId);
                        }
                    }
                }

                if (Arr::exists($params['otherDataPasses'], 'orderBy')) {
                    if (Arr::exists($params['otherDataPasses']['orderBy'], 'position')) {
                        $position = $params['otherDataPasses']['orderBy']['position'];
                        if (!empty($position)) {
                            $orderByRaw = "`position` " . $position;
                        }
                    }
                }

                foreach (RoleSub::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $temp) {
                    $roleSub[] = GetManageAccessHelper::getRoleSubDetail([
                        'type' => ['basic'],
                        'otherDataPasses' => [
                            'id' => $temp->id
                        ]
                    ])['basic']['roleSubDetail'];
                }

                $data = [
                    'roleSub' => $roleSub
                ];

                if (isset($params['otherDataPasses']['filterData'])) {
                    $data['filterData'] = $params['otherDataPasses']['filterData'];
                }

                if (isset($params['otherDataPasses']['orderBy'])) {
                    $data['orderBy'] = $params['otherDataPasses']['orderBy'];
                }

                $finalData['roleSub'] = $data;
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getRoleMainDetail($params, $platform = '')
    {
        try {
            $finalData = array();

            if (in_array('basic', $params['type'])) {
                $roleMain = RoleMain::where('id', $params['otherDataPasses']['id'])->first();
                $data = [
                    'roleSubDetail' => [
                        'id' => encrypt($roleMain->id),
                        'uniqueId' => $roleMain->uniqueId,
                        'name' => $roleMain->name,
                        'status' =>  $roleMain->status,
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $roleMain->uniqueId]),
                        'customizeInText' => CommonTrait::customizeInText([
                            [
                                'type' => 'status',
                                'value' => $roleMain->status
                            ]
                        ]),
                    ]
                ];

                $finalData['basic'] = $data;
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getRoleSubDetail($params, $platform = '')
    {
        try {
            $finalData = array();

            if (in_array('basic', $params['type'])) {
                $roleSub = RoleSub::where('id', $params['otherDataPasses']['id'])->first();
                $data = [
                    'roleSubDetail' => [
                        'id' => encrypt($roleSub->id),
                        'uniqueId' => $roleSub->uniqueId,
                        'name' => $roleSub->name,
                        'status' =>  $roleSub->status,
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $roleSub->uniqueId]),
                        'customizeInText' => CommonTrait::customizeInText([
                            [
                                'type' => 'status',
                                'value' => $roleSub->status
                            ]
                        ]),
                    ]
                ];

                $finalData['basic'] = $data;
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function setPrivilege($params, $platform = '')
    {
        try {
            $finalData = array();

            if (in_array(Config::get('constants.typeCheck.manageNav.navMain.type'), $params['type'])) {
                $getNavMainDetail = GetManageNavHelper::getNavMainDetail([
                    'type' => ['withDepended'],
                    'otherDataPasses' => [
                        'id' => $params['otherDataPasses']['id']
                    ]
                ])['withDepended']['navMainDetail'];
                $roleMain = GetManageAccessHelper::getList([
                    'type' => ['roleMain'],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active']
                        ]
                    ],
                ]);
                dd($roleMain);
                Permission::where('navMainId', $navMain->id)->delete();
                foreach ($roleMain['roleMain']['roleMain'] as $tempOne) {
                    $permission = new Permission();
                    $permission->navTypeId = $navMain->navTypeId;
                    $permission->navMainId = $navMain->id;
                    $permission->roleMainId = decrypt($tempOne['id']);
                    $permission->privilege = json_encode($getNavAccessList['privilege']);
                    if ($permission->save()) {
                        $roleSub = GetManageAccessHelper::getList([
                            'type' => ['roleSub'],
                            'otherDataPasses' => [
                                'filterData' => [
                                    'status' => Config::get('constants.status')['active'],
                                    'roleMainId' => $tempOne['id']
                                ]
                            ],
                        ]);
                        foreach ($roleSub['roleSub']['roleSub'] as $tempTwo) {
                            $permission = new Permission();
                            $permission->navTypeId = $navMain->navTypeId;
                            $permission->navMainId = $navMain->id;
                            $permission->roleMainId = decrypt($tempOne['id']);
                            $permission->roleSubId = decrypt($tempTwo['id']);
                            $permission->privilege = json_encode($getNavAccessList['privilege']);
                            if ($permission->save()) {
                            } else {
                            }
                        }
                    } else {
                    }
                }

                $finalData['basic'] = [];
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

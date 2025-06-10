<?php

namespace App\Helpers\ManageUsers;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use App\Models\ManageUsers\AdminUsers;
use App\Models\ManageUsers\UsersInfo;

use App\Helpers\ManagePanel\GetManageAccessHelper;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class GetManageUsersHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';


    public static function getList($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                if (Config::get('constants.typeCheck.manageUsers.adminUsers.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                        $adminUsers = array();
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

                        foreach (AdminUsers::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $adminUsers[] = GetManageUsersHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.manageUsers.adminUsers.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.manageUsers.adminUsers.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                            'list' => $adminUsers
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.manageUsers.adminUsers.type')] = $data;
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

                if (Config::get('constants.typeCheck.manageUsers.adminUsers.type') == $for) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $adminUsers = AdminUsers::where('id', decrypt($otherDataPasses['id']))->first();
                        if ($adminUsers != null) {
                            $usersInfo = UsersInfo::where([
                                ['userId', $adminUsers->id],
                                ['userType', Config::get('constants.userType.admin')]
                            ])->first();
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                                'id' => encrypt($adminUsers->id),
                                'name' => $adminUsers->name,
                                'status' =>  $adminUsers->status,
                                'getFile' => FileTrait::getFile([
                                    'fileName' => $adminUsers->image,
                                    'storage' => Config::get('constants.storage')['adminUsers']
                                ]),
                                'roleMainId' =>  $adminUsers->roleMainId,
                                'roleSubId' =>  $adminUsers->roleSubId,
                                'email' =>  $adminUsers->email,
                                'phone' =>  $adminUsers->phone,
                                'pinCode' =>  $usersInfo->pinCode,
                                'state' =>  $usersInfo->state,
                                'country' =>  $usersInfo->country,
                                'address' =>  $usersInfo->address,
                                'about' =>  $usersInfo->about,
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $adminUsers->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => 'status',
                                        'value' => $adminUsers->status
                                    ]
                                ]),
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [];
                        }
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $adminUsers = AdminUsers::where('id', decrypt($otherDataPasses['id']))->first();
                        if ($adminUsers != null) {
                            $usersInfo = UsersInfo::where([
                                ['userId', $adminUsers->id],
                                ['userType', Config::get('constants.userType.admin')]
                            ])->first();
                            $roleMain = GetManageAccessHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($adminUsers->roleMainId)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                            if ($adminUsers->roleSubId != null) {
                                $roleSub = GetManageAccessHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($adminUsers->roleSubId)
                                        ]
                                    ],
                                ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                            } else {
                                $roleSub = [];
                            }
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                                'id' => encrypt($adminUsers->id),
                                'name' => $adminUsers->name,
                                'status' =>  $adminUsers->status,
                                'getFile' => FileTrait::getFile([
                                    'fileName' => $adminUsers->image,
                                    'storage' => Config::get('constants.storage')['adminUsers']
                                ]),
                                'roleMain' =>  $roleMain,
                                'roleSub' =>  $roleSub,
                                'email' =>  $adminUsers->email,
                                'phone' =>  $adminUsers->phone,
                                'pinCode' =>  $usersInfo->pinCode,
                                'state' =>  $usersInfo->state,
                                'country' =>  $usersInfo->country,
                                'address' =>  $usersInfo->address,
                                'about' =>  $usersInfo->about,
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $adminUsers->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => 'status',
                                        'value' => $adminUsers->status
                                    ]
                                ]),
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.manageUsers.adminUsers.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

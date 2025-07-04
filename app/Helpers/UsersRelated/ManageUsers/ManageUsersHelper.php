<?php

namespace App\Helpers\UsersRelated\ManageUsers;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use App\Helpers\AdminRelated\RolePermission\ManageRoleHelper;

use App\Models\User;
use App\Models\UsersRelated\UsersInfo;
use App\Models\UsersRelated\ManageUsers\AdminUsers;

use DevSarfo\LaraPhone\Models\PhoneNumber;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ManageUsersHelper
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
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainRoleId')) {
                                $mainRoleId = $tempOne['otherDataPasses']['filterData']['mainRoleId'];
                                if (!empty($mainRoleId)) {
                                    $whereRaw .= " and `mainRoleId` = " . decrypt($mainRoleId);
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'subRoleId')) {
                                $subRoleId = $tempOne['otherDataPasses']['filterData']['subRoleId'];
                                if (!empty($subRoleId)) {
                                    $whereRaw .= " and `subRoleId` = " . decrypt($subRoleId);
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
                            $adminUsers[] = ManageUsersHelper::getDetail([
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

                if (Config::get('constants.typeCheck.manageUsers.appUsers.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                        $appUsers = array();
                        $whereRaw = "`created_at` is not null";
                        $orderByRaw = "`id` DESC";

                        if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                                $status = $tempOne['otherDataPasses']['filterData']['status'];
                                if (!empty($status)) {
                                    $whereRaw .= " and `status` = '" . $status . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'userType')) {
                                $userType = $tempOne['otherDataPasses']['filterData']['userType'];
                                if (!empty($userType)) {
                                    $whereRaw .= " and `userType` = '" . $userType . "'";
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

                        foreach (User::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $appUsers[] = ManageUsersHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.manageUsers.appUsers.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.manageUsers.appUsers.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                            'list' => $appUsers
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.manageUsers.appUsers.type')] = $data;
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
                    $adminUsers = AdminUsers::where('id', decrypt($otherDataPasses['id']))->first();
                    $phone = new PhoneNumber('+' . $adminUsers->dialCode . $adminUsers->phone);

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        if ($adminUsers != null) {
                            $usersInfo = UsersInfo::where([
                                ['userId', $adminUsers->id],
                                ['userType', Config::get('constants.userType.admin')]
                            ])->first();
                            $mainRole = ManageRoleHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($adminUsers->mainRoleId)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                            if ($adminUsers->subRoleId != null) {
                                $subRole = ManageRoleHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($adminUsers->subRoleId)
                                        ]
                                    ],
                                ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                            } else {
                                $subRole = [];
                            }
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                                'id' => encrypt($adminUsers->id),
                                'name' => $adminUsers->name,
                                'status' =>  $adminUsers->status,
                                'getFile' => FileTrait::getFile([
                                    'fileName' => $adminUsers->image,
                                    'storage' => Config::get('constants.storage')['adminUsers']
                                ]),
                                'mainRole' => $mainRole,
                                'subRole' => $subRole,
                                'email' =>  $adminUsers->email,
                                'phone' =>  $adminUsers->phone,
                                'formattedPhone' =>  $phone->formatInternational(),
                                'dialCode' =>  $adminUsers->dialCode,
                                'pinCode' =>  $usersInfo->pinCode,
                                'state' =>  $usersInfo->state,
                                'country' =>  $usersInfo->country,
                                'address' =>  $usersInfo->address,
                                'about' =>  $usersInfo->about,
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $adminUsers->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                        'value' => $adminUsers->status
                                    ]
                                ]),
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [];
                        }
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        if ($adminUsers != null) {
                            $usersInfo = UsersInfo::where([
                                ['userId', $adminUsers->id],
                                ['userType', Config::get('constants.userType.admin')]
                            ])->first();
                            $mainRole = ManageRoleHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($adminUsers->mainRoleId)
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                            if ($adminUsers->subRoleId != null) {
                                $subRole = ManageRoleHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($adminUsers->subRoleId)
                                        ]
                                    ],
                                ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                            } else {
                                $subRole = [];
                            }
                            $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                                'id' => encrypt($adminUsers->id),
                                'name' => $adminUsers->name,
                                'status' =>  $adminUsers->status,
                                'getFile' => FileTrait::getFile([
                                    'fileName' => $adminUsers->image,
                                    'storage' => Config::get('constants.storage')['adminUsers']
                                ]),
                                'mainRole' =>  $mainRole,
                                'subRole' =>  $subRole,
                                'email' =>  $adminUsers->email,
                                'dialCode' =>  $adminUsers->dialCode,
                                'phone' =>  $adminUsers->phone,
                                'formattedPhone' =>  $phone->formatInternational(),
                                'pinCode' =>  $usersInfo->pinCode,
                                'state' =>  $usersInfo->state,
                                'country' =>  $usersInfo->country,
                                'address' =>  $usersInfo->address,
                                'about' =>  $usersInfo->about,
                                'date' =>  date('d-m-Y', strtotime($adminUsers->created_at)),
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $adminUsers->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.status'),
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

                if (Config::get('constants.typeCheck.manageUsers.appUsers.type') == $for) {
                    $data = array();
                    $user = User::where('id', decrypt($otherDataPasses['id']))->first();
                    $phone = new PhoneNumber('+' . $user->dialCode . $user->phone);

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        if ($user != null) {
                            $usersInfo = UsersInfo::where([
                                ['userId', $user->id],
                                ['userType', $user->userType]
                            ])->first();

                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                                'id' => encrypt($user->id),
                                'name' => $user->name,
                                'status' =>  $user->status,
                                'getFile' => FileTrait::getFile([
                                    'fileName' => $user->image,
                                    'storage' => Config::get('constants.storage')['appUsers']
                                ]),
                                'email' =>  $user->email,
                                'dialCode' =>  $user->dialCode,
                                'phone' =>  $user->phone,
                                'date' =>  $user->created_at->format('d-m-Y'),
                                'formattedPhone' =>  $phone->formatInternational(),
                                'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $user->uniqueId]),
                                'customizeInText' => CommonTrait::customizeInText([
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                        'value' => $user->status
                                    ],
                                    [
                                        'type' => Config::get('constants.typeCheck.customizeInText.userType'),
                                        'value' => $user->userType
                                    ]
                                ]),
                            ];
                        } else {
                            $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [];
                        }
                    }

                    $finalData[Config::get('constants.typeCheck.manageUsers.appUsers.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

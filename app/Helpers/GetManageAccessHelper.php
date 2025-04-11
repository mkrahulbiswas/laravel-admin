<?php

namespace App\Helpers;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use App\Models\ManagePanel\ManageAccess\RoleMain;
use App\Models\ManagePanel\ManageAccess\RoleSub;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

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
                    $roleSub[] = GetManageAccessHelper::getRoleMainDetail([
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
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $roleMain->uniqueId]),
                        'status' => CommonTrait::customizeInText(['type' => 'status', 'value' => $roleMain->status]),
                    ]
                ];

                $finalData['basic'] = $data;
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getNavSubDetail($params, $platform = '')
    {
        try {
            $finalData = array();

            if (in_array('basic', $params['type'])) {
                $roleSub = RoleSub::where('id', $params['otherDataPasses']['id'])->first();
                $data = [
                    'navMainDetail' => [
                        'id' => encrypt($roleSub->id),
                        'uniqueId' => $roleSub->uniqueId,
                        'name' => $roleSub->name,
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $roleSub->uniqueId]),
                        'status' => CommonTrait::customizeInText(['type' => 'status', 'value' => $roleSub->status]),
                    ]
                ];

                $finalData['basic'] = $data;
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

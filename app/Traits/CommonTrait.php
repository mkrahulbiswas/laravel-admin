<?php

namespace app\Traits;

use App\Helpers\AdminRelated\RolePermission\ManageRoleHelper;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;
use DateTimeZone;
use DateTime;

trait CommonTrait
{
    public static function changeStatus($params)
    {
        try {
            DB::beginTransaction();
            if ($params['type'] == Config::get('constants.action.status.smsf')) {
                $field = ($params['targetField'] == null) ? 'status' : $params['targetField'][0];
                $data = app($params['targetModel'])::where('id', $params['targetId'])->first();
                if ($data->$field == config('constants.status')['inactive']) {
                    $data->$field = config('constants.status')['active'];
                    if ($data->update()) {
                        DB::commit();
                        return true;
                    } else {
                        DB::rollBack();
                        return false;
                    }
                } else {
                    $data->$field = config('constants.status')['inactive'];
                    if ($data->update()) {
                        DB::commit();
                        return true;
                    } else {
                        DB::rollBack();
                        return false;
                    }
                }
            } elseif ($params['type'] == Config::get('constants.action.status.smmf')) {
            } elseif ($params['type'] == Config::get('constants.action.status.mmsf')) {
            } else {
                // foreach ($field as $temp) {
                //     if (app($model)::where($temp, '1')->update([$temp => '0'])) {
                //         $responce = app($model)::where('id', $id)->update([$temp => '1']);
                //     } else {
                //         return false;
                //     }
                // }

                // if ($responce) {
                //     return true;
                // } else {
                //     return false;
                // }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function setDefault($params)
    {
        try {
            DB::beginTransaction();
            foreach ($params as $tempOne) {
                [
                    'targetId' => $targetId,
                    'model' => $model,
                    'field' => $field,
                    'filter' => $filter,
                    'type' => $type,
                ] = $tempOne;
                $field = ($field == null) ? 'default' : $field[0];
                $data = app($model)::where('id', $targetId)->first();
                if ($type == Config::get('constants.action.default.smyon')) {
                    $whereRaw = "`created_at` is not null";
                    if (!empty($filter)) {
                        foreach ($filter as $tempTwo) {
                            $key = ($tempTwo['key'] == '') ? 'id' : $tempTwo['key'];
                            if (gettype($tempTwo['value']) == 'integer') {
                                $whereRaw .= " and `" . $key . "` = " . $tempTwo['value'];
                            }
                            if (gettype($tempTwo['value']) == 'string') {
                                $whereRaw .= " and `" . $key . "` = '" . $tempTwo['value'] . "'";
                            }
                            if (gettype($tempTwo['value']) == 'NULL') {
                                $whereRaw .= " and `" . $key . "` is null";
                            }
                        }
                    }
                    app($model)::whereRaw($whereRaw)->update([$field => config('constants.status')['no']]);
                }
                if ($data->$field == config('constants.status')['no']) {
                    $data->$field = config('constants.status')['yes'];
                    if ($data->update()) {
                        DB::commit();
                        return true;
                    } else {
                        DB::rollBack();
                        return false;
                    }
                } else {
                    $data->$field = config('constants.status')['no'];
                    if ($data->update()) {
                        DB::commit();
                        return true;
                    } else {
                        DB::rollBack();
                        return false;
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function deleteItem($params)
    {
        try {
            DB::beginTransaction();
            foreach ($params as $tempOne) {
                [
                    'model' => $model,
                    'picUrl' => $picUrl,
                    'filter' => $filter,
                ] = $tempOne;
                $whereRaw = "`created_at` is not null";
                if (!empty($filter)) {
                    foreach ($filter as $tempTwo) {
                        $field = ($tempTwo['field'] == '') ? 'id' : $tempTwo['field'];
                        if (gettype($tempTwo['search']) == 'integer') {
                            $whereRaw .= " and `" . $field . "` = " . $tempTwo['search'];
                        }
                        if (gettype($tempTwo['search']) == 'string') {
                            $whereRaw .= " and `" . $field . "` = '" . $tempTwo['search'] . "'";
                        }
                        if (gettype($tempTwo['search']) == 'NULL') {
                            $whereRaw .= " and `" . $field . "` is null";
                        }
                    }
                }
                $data = app($model)::whereRaw($whereRaw)->get();
                if ($data->count() > 0) {
                    foreach ($data->toArray() as $tempTwo) {
                        if (sizeof($picUrl) > 0) {
                            foreach ($picUrl as $tempThree) {
                                $field = ($tempThree['field'] == '') ? 'image' : $tempThree['field'];
                                $fileName = ($tempTwo[$field] == '' || $tempTwo[$field] == 'NA') ? 'NA' : $tempTwo[$field];
                                if ($fileName != 'NA') {
                                    foreach ($tempThree['storage']['for'] as $tempFour) {
                                        if (Storage::disk($tempFour)->exists($tempThree['storage']['path'] . $fileName)) {
                                            if (Storage::disk($tempFour)->delete($tempThree['storage']['path'] . $fileName)) {
                                                $response = true;
                                            } else {
                                                $response = false;
                                                goto resp;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if (app($model)::where('id', $tempTwo['id'])->delete()) {
                            $response = true;
                        } else {
                            $response = false;
                            goto resp;
                        }
                    }
                } else {
                    $response = true;
                }
            }
            resp:
            if ($response == true) {
                DB::commit();
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function dynamicHtmlPurse($params)
    {
        // try {
        $return = array();
        foreach ($params as $tempOne) {
            if ($tempOne['type'] == 'dtMultiData') {
                $appendHtml = '';

                foreach ($tempOne['data'] as $tempTwo) {
                    if ($tempTwo['type'] == Config::get('constants.typeCheck.customizeInText.status')) {
                        $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataStatus"><label>Status:</label>' . $tempTwo['custom'] . '</div>';
                    }

                    if ($tempTwo['type'] == Config::get('constants.typeCheck.customizeInText.default')) {
                        $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataDefault"><label>Default:</label>' . $tempTwo['custom'] . '</div>';
                    }

                    if ($tempTwo['type'] == Config::get('constants.typeCheck.customizeInText.access')) {
                        $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataAccess"><label>Access:</label>' . $tempTwo['custom'] . '</div>';
                    }

                    if ($tempTwo['type'] == Config::get('constants.typeCheck.customizeInText.hasChild')) {
                        $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataAccess"><label>Child:</label>' . $tempTwo['custom'] . '</div>';
                    }

                    if ($tempTwo['type'] == Config::get('constants.typeCheck.customizeInText.hasPermission')) {
                        $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataAccess"><label>Permission:</label>' . $tempTwo['custom'] . '</div>';
                    }

                    if ($tempTwo['type'] == Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type')) {
                        $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataAccess"><label>Alert Name:</label>' . $tempTwo['value']['name'] . '</div>';
                        $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataAccess"><label>Unique Id:</label>' . $tempTwo['value']['uniqueId'] . '</div>';
                    }

                    if ($tempTwo['type'] == Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type')) {
                        $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataAccess"><label>Alert Name:</label>' . $tempTwo['value']['name'] . '</div>';
                        $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataAccess"><label>Unique Id:</label>' . $tempTwo['value']['uniqueId'] . '</div>';
                    }
                }

                $html = '<div class="dtMultiData"><div class="dtMultiDataContent">' . $appendHtml . '</div></div>';

                $return['dtMultiData'] = [
                    'custom' => $html,
                    'raw' => $tempOne['data']
                ];
            }

            if ($tempOne['type'] == 'dtAction') {
                $primaryAction = $secondaryAction = '';

                foreach ($tempOne['data']['primary'] as $tempTwo) {
                    if (Str::contains($tempTwo, 'data-type="status"')) {
                        $primaryAction .= '<div class="tdActionButtonCommon tdActionButtonStatus">' . $tempTwo . '</div>';
                    }
                    if (Str::contains($tempTwo, 'data-type="edit"')) {
                        $primaryAction .= '<div class="tdActionButtonCommon tdActionButtonEdit">' . $tempTwo . '</div>';
                    }
                    if (Str::contains($tempTwo, 'data-type="delete"')) {
                        $primaryAction .= '<div class="tdActionButtonCommon tdActionButtonDelete">' . $tempTwo . '</div>';
                    }
                    if (Str::contains($tempTwo, 'data-type="info"')) {
                        $primaryAction .= '<div class="tdActionButtonCommon tdActionButtonInfo">' . $tempTwo . '</div>';
                    }
                    if (Str::contains($tempTwo, 'data-type="access"')) {
                        $primaryAction .= '<div class="tdActionButtonCommon tdActionButtonAccess">' . $tempTwo . '</div>';
                    }
                    if (Str::contains($tempTwo, 'data-type="default"')) {
                        $primaryAction .= '<div class="tdActionButtonCommon tdActionButtonDefault">' . $tempTwo . '</div>';
                    }
                }

                foreach ($tempOne['data']['secondary'] as $tempTwo) {
                    if ($tempTwo != '') {
                        $secondaryAction .= '<div class="tdActionInnerCommon">' . $tempTwo . '</div>';
                    }
                }

                if ($secondaryAction != '') {
                    $toggleButton = '<div class="tdActionButtonCommon tdActionButtonToggle"><a type="button" class="btn btn-sm"><i class="mdi mdi-menu-open"></i></a></div>';
                } else {
                    $toggleButton = '';
                }

                if ($primaryAction == '' && $secondaryAction == '') {
                    $html = '<div class="tdAction"><div class="tdActionButton">No Action Found</div><div class="tdActionInner"></div></div>';
                } else {
                    $html = '<div class="tdAction"><div class="tdActionButton">' . $primaryAction . $toggleButton . '</div><div class="tdActionInner">' . $secondaryAction . '</div></div>';
                }

                $return['dtAction'] = [
                    'custom' => $html,
                    'raw' => $tempOne['data']
                ];
            }

            if ($tempOne['type'] == 'dtNavPermission') {
                $navHtml = '';

                foreach ($tempOne['data'] as $tempTwo) {
                    if ($tempTwo['extraData']['hasMainNav'] <= 0) {
                        $navHtml .= '<div class="npbType"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempTwo['name'] . '</span></div><div class="npbhRight">Nav Type (No Main nav Found)</div></div></div>';
                    } else {
                        $navHtml .= '<div class="npbType"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempTwo['name'] . '</span></div></div>';
                        foreach ($tempTwo['mainNav'] as $tempThree) {
                            $permission = ManageRoleHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.managePermission.permission.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'filterData' => [
                                            'navTypeId' => $tempTwo['id'],
                                            'mainNavId' => $tempThree['id'],
                                            'subRoleId' => isset($tempOne['otherDataPasses']['permission']['subRoleId']) ? $tempOne['otherDataPasses']['permission']['subRoleId'] : '',
                                            'mainRoleId' => $tempOne['otherDataPasses']['permission']['mainRoleId'],
                                        ]
                                    ]
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.managePermission.permission.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                            if ($tempThree['extraData']['hasSubNav'] <= 0) {
                                $navHtml .= '<div class="npbMain"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempThree['name'] . '</span></div><div class="npbhRight"><div class="npbCheckCommon">';
                                if ($permission == null) {
                                    $navHtml .= '<div class="npbCheckNoAccess"><span>No access is set yet for <b>main nav</b>, please set access before set permission.</span></div>';
                                } else {
                                    foreach ($permission['privilege'] as $keySix => $tempSix) {
                                        $navHtml .= '<div class="npbCheckYesAccess"><div class="npbcHeading"><span>' . $keySix . '</span></div><div class="npbcbInput">';
                                        if ($tempSix['allowed'] == true) {
                                            if ($tempSix['permission'] == true) {
                                                $navHtml .= '<input type="checkbox" name="' . $permission['uniqueId'] . '[' . $keySix . ']" value="1" checked class="lcSwitch" autocomplete="off" />';
                                            } else {
                                                $navHtml .= '<input type="checkbox" name="' . $permission['uniqueId'] . '[' . $keySix . ']" value="0" class="lcSwitch" autocomplete="off" />';
                                            }
                                        } else {
                                            $navHtml .= '<span><i class=" las la-low-vision"></i></span>';
                                        }
                                        $navHtml .= '</div></div>';
                                    }
                                    $navHtml .= '<input type="hidden" name="id[' . $permission['uniqueId'] . ']" value="' . $permission['id'] . '">';
                                }
                                $navHtml .= '</div></div></div></div>';
                            } else {
                                $navHtml .= '<div class="npbMain"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempThree['name'] . '</span></div></div>';
                                foreach ($tempThree['subNav'] as $tempFour) {
                                    $permission = ManageRoleHelper::getDetail([
                                        [
                                            'getDetail' => [
                                                'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                                'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.managePermission.permission.type'),
                                            ],
                                            'otherDataPasses' => [
                                                'filterData' => [
                                                    'navTypeId' => $tempTwo['id'],
                                                    'mainNavId' => $tempThree['id'],
                                                    'subNavId' => $tempFour['id'],
                                                    'subRoleId' => isset($tempOne['otherDataPasses']['permission']['subRoleId']) ? $tempOne['otherDataPasses']['permission']['subRoleId'] : '',
                                                    'mainRoleId' => $tempOne['otherDataPasses']['permission']['mainRoleId'],
                                                ]
                                            ]
                                        ],
                                    ])[Config::get('constants.typeCheck.adminRelated.rolePermission.managePermission.permission.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                                    if ($tempFour['extraData']['hasNestedNav'] <= 0) {
                                        $navHtml .= '<div class="npbSub"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempFour['name'] . '</span></div><div class="npbhRight"><div class="npbCheckCommon">';
                                        if ($permission == null) {
                                            $navHtml .= '<div class="npbCheckNoAccess"><span>No access is set yet for <b>sub nav</b>, please set access before set permission.</span></div>';
                                        } else {
                                            foreach ($permission['privilege'] as $keySix => $tempSix) {
                                                $navHtml .= '<div class="npbCheckYesAccess"><div class="npbcHeading"><span>' . $keySix . '</span></div><div class="npbcbInput">';
                                                if ($tempSix['allowed'] == true) {
                                                    if ($tempSix['permission'] == true) {
                                                        $navHtml .= '<input type="checkbox" name="' . $permission['uniqueId'] . '[' . $keySix . ']" value="1" checked class="lcSwitch" autocomplete="off" />';
                                                    } else {
                                                        $navHtml .= '<input type="checkbox" name="' . $permission['uniqueId'] . '[' . $keySix . ']" value="0" class="lcSwitch" autocomplete="off" />';
                                                    }
                                                } else {
                                                    $navHtml .= '<span><i class=" las la-low-vision"></i></span>';
                                                }
                                                $navHtml .= '</div></div>';
                                            }
                                            $navHtml .= '<input type="hidden" name="id[' . $permission['uniqueId'] . ']" value="' . $permission['id'] . '">';
                                        }
                                        $navHtml .= '</div></div></div></div>';
                                    } else {
                                        $navHtml .= '<div class="npbSub"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempFour['name'] . '</span></div><div class="npbhRight"></div></div>';
                                        foreach ($tempFour['nestedNav'] as $tempFive) {
                                            $permission = ManageRoleHelper::getDetail([
                                                [
                                                    'getDetail' => [
                                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.managePermission.permission.type'),
                                                    ],
                                                    'otherDataPasses' => [
                                                        'filterData' => [
                                                            'navTypeId' => $tempTwo['id'],
                                                            'mainNavId' => $tempThree['id'],
                                                            'subNavId' => $tempFour['id'],
                                                            'nestedNavId' => $tempFive['id'],
                                                            'subRoleId' => isset($tempOne['otherDataPasses']['permission']['subRoleId']) ? $tempOne['otherDataPasses']['permission']['subRoleId'] : '',
                                                            'mainRoleId' => $tempOne['otherDataPasses']['permission']['mainRoleId'],
                                                        ]
                                                    ]
                                                ],
                                            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.managePermission.permission.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                                            $navHtml .= '<div class="npbNested"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempFive['name'] . '</span></div><div class="npbhRight"><div class="npbCheckCommon">';
                                            if ($permission == null) {
                                                $navHtml .= '<div class="npbCheckNoAccess"><span>No access is set yet for <b>nested nav</b>, please set access before set permission.</span></div>';
                                            } else {
                                                foreach ($permission['privilege'] as $keySix => $tempSix) {
                                                    $navHtml .= '<div class="npbCheckYesAccess"><div class="npbcHeading"><span>' . $keySix . '</span></div><div class="npbcbInput">';
                                                    if ($tempSix['allowed'] == true) {
                                                        if ($tempSix['permission'] == true) {
                                                            $navHtml .= '<input type="checkbox" name="' . $permission['uniqueId'] . '[' . $keySix . ']" value="1" checked class="lcSwitch" autocomplete="off" />';
                                                        } else {
                                                            $navHtml .= '<input type="checkbox" name="' . $permission['uniqueId'] . '[' . $keySix . ']" value="0" class="lcSwitch" autocomplete="off" />';
                                                        }
                                                    } else {
                                                        $navHtml .= '<span><i class=" las la-low-vision"></i></span>';
                                                    }
                                                    $navHtml .= '</div></div>';
                                                }
                                                $navHtml .= '<input type="hidden" name="id[' . $permission['uniqueId'] . ']" value="' . $permission['id'] . '">';
                                            }
                                            $navHtml .= '</div></div></div></div>';
                                        }
                                        $navHtml .= '</div>';
                                    }
                                }
                                $navHtml .= '</div>';
                            }
                        }
                        $navHtml .= '</div>';
                    }
                }

                $html = '<div class="navPermissionMain">
                        <div class="navPermissionSub">
                            <div class="npMainRole">
                                <div class="npGo">
                                    <span>Click for set permission</span>
                                </div>
                                <div class="npHead">
                                    <div class="nphLeft"></div>
                                    <div class="nphRight">
                                        <div class="nphrTop"></div>
                                        <div class="nphrBottom">
                                            <span class="btn btn-warning" id="permissionCheckAll" data-type="none">Check all</span>
                                            <button class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="npBody">' . $navHtml . '</div>
                                <div class="npFoot">
                                    <div class="npfLeft"></div>
                                    <div class="npfRight mt-3 text-end">';
                if ($tempOne['otherDataPasses']['getPrivilege']['update']['permission'] == true) {
                    $html .= '<button class="btn btn-success">Update</button>';
                }
                $html .= '</div></div></div></div></div>';

                $return['dtNavPermission'] = [
                    'custom' => $html,
                    'raw' => $tempOne['data']
                ];
            }
        }
        return $return;
        // } catch (Exception $e) {
        //     return false;
        // }
    }

    public static function customizeInText($params)
    {
        try {
            $return = array();
            foreach ($params as $temp) {
                if ($temp['type'] == Config::get('constants.typeCheck.customizeInText.type')) {
                    if ($temp['value'] == Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.amenities.type')) {
                        $custom = '<span class="pa_amenities">' . Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.amenities.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.amenities.name');
                        $raw = $temp['value'];
                    } else if ($temp['value'] == Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.propertyFeatures.type')) {
                        $custom = '<span class="pa_propertyFeatures">' . Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.propertyFeatures.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.propertyFeatures.name');
                        $raw = $temp['value'];
                    } else if ($temp['value'] == Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.societyFeatures.type')) {
                        $custom = '<span class="pa_societyFeatures">' . Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.societyFeatures.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.societyFeatures.name');
                        $raw = $temp['value'];
                    } else if ($temp['value'] == Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.typeOfFloorings.type')) {
                        $custom = '<span class="pa_typeOfFloorings">' . Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.typeOfFloorings.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.typeOfFloorings.name');
                        $raw = $temp['value'];
                    } else if ($temp['value'] == Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.parkingTypes.type')) {
                        $custom = '<span class="pa_parkingTypes">' . Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.parkingTypes.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.parkingTypes.name');
                        $raw = $temp['value'];
                    } else if ($temp['value'] == Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.locatedNear.type')) {
                        $custom = '<span class="pa_locatedNear">' . Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.locatedNear.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.locatedNear.name');
                        $raw = $temp['value'];
                    } else {
                        $custom = '<span class="pa_locationAdvantages">' . Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.locationAdvantages.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttribute.attributes.locationAdvantages.name');
                        $raw = $temp['value'];
                    }
                    $return[Config::get('constants.typeCheck.customizeInText.type')] = [
                        'custom' => $custom,
                        'formatted' => $formatted,
                        'raw' => $raw,
                        'type' => $temp['type'],
                    ];
                }
                if ($temp['type'] == Config::get('constants.typeCheck.customizeInText.status')) {
                    if ($temp['value'] == Config::get('constants.status')['active']) {
                        $custom = '<span class="badge bg-success">Active</span>';
                        $formatted = 'Active';
                        $raw = $temp['value'];
                    } else {
                        $custom = '<span class="badge bg-danger">In Active</span>';
                        $formatted = 'In Active';
                        $raw = $temp['value'];
                    }
                    $return[Config::get('constants.typeCheck.customizeInText.status')] = [
                        'custom' => $custom,
                        'formatted' => $formatted,
                        'raw' => $raw,
                        'type' => $temp['type'],
                    ];
                }
                if ($temp['type'] == Config::get('constants.typeCheck.customizeInText.default')) {
                    if ($temp['value'] == Config::get('constants.status')['yes']) {
                        $custom = '<span class="badge bg-success">Yes</span>';
                        $formatted = 'Yes';
                        $raw = $temp['value'];
                    } else {
                        $custom = '<span class="badge bg-danger">No</span>';
                        $formatted = 'No';
                        $raw = $temp['value'];
                    }
                    $return[Config::get('constants.typeCheck.customizeInText.default')] = [
                        'custom' => $custom,
                        'formatted' => $formatted,
                        'raw' => $raw,
                        'type' => $temp['type'],
                    ];
                }
                if ($temp['type'] == Config::get('constants.typeCheck.customizeInText.access')) {
                    if ($temp['value'] == null) {
                        $custom = '<span class="badge bg-danger">No Access Found</span>';
                    } else {
                        $custom = '<span class="badge bg-success" data-access="' . json_encode($temp['value']) . '">Access Found</span>';
                    }
                    $return[Config::get('constants.typeCheck.customizeInText.access')] = [
                        'custom' => $custom,
                        'raw' => $temp['value'],
                        'type' => $temp['type'],
                    ];
                }
                if ($temp['type'] == Config::get('constants.typeCheck.customizeInText.child')) {
                    if ($temp['value'] <= 0) {
                        $custom = '<span class="badge bg-danger">No</span>';
                    } else {
                        $custom = '<span class="badge bg-success">Yes</span>';
                    }
                    $return[Config::get('constants.typeCheck.customizeInText.child')] = [
                        'custom' => $custom,
                        'raw' => $temp['value'],
                        'type' => $temp['type'],
                    ];
                }
                if ($temp['type'] == Config::get('constants.typeCheck.customizeInText.permission')) {
                    if ($temp['value'] <= 0) {
                        $custom = '<span class="badge bg-danger">No</span>';
                    } else {
                        $custom = '<span class="badge bg-success">Yes</span>';
                    }
                    $return[Config::get('constants.typeCheck.customizeInText.permission')] = [
                        'custom' => $custom,
                        'raw' => $temp['value'],
                        'type' => $temp['type'],
                    ];
                }
            }
            return $return;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function hyperLinkInText($params)
    {
        try {
            $custom = '';
            $raw = $params['value'];

            if (Arr::exists($params, 'targetRoute') && Arr::exists($params, 'targetId')) {
                $custom = '<a href="' . route($params['targetRoute'], encrypt($params['targetId'])) . '" target="_blank">' . $params['value'] . '</a>';
            } else {
                $custom = "NA";
            }

            return [
                'custom' => $custom,
                'raw' => $raw,
            ];
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getNavAccessList($params = null)
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                [
                    'checkFirst' => $checkFirst,
                    'otherDataPasses' => $otherDataPasses,
                ] = $tempOne;
                if (Config::get('constants.typeCheck.helperCommon.access.ay') == $checkFirst['type']) {
                    $access = $privilege = $finalData = array();
                    foreach (Config::get('constants.rolePermission.accessType') as $temp) {
                        $access = Arr::prepend($access, true, $temp);
                        $privilege = Arr::prepend(
                            $privilege,
                            [
                                'allowed' => true,
                                'permission' => true
                            ],
                            $temp
                        );
                    }
                    $finalData[Config::get('constants.typeCheck.helperCommon.access.ay')] = [
                        'access' => $access,
                        'privilege' => $privilege,
                    ];
                }
                if (Config::get('constants.typeCheck.helperCommon.access.an') == $checkFirst['type']) {
                    $access = $privilege = $finalData = array();
                    foreach (Config::get('constants.rolePermission.accessType') as $temp) {
                        $access = Arr::prepend($access, false, $temp);
                        $privilege = Arr::prepend(
                            $privilege,
                            [
                                'allowed' => false,
                                'permission' => false
                            ],
                            $temp
                        );
                    }
                    $finalData[Config::get('constants.typeCheck.helperCommon.access.an')] = [
                        'access' => $access,
                        'privilege' => $privilege,
                    ];
                }
                if (Config::get('constants.typeCheck.helperCommon.access.fns') == $checkFirst['type']) {
                    $access = $privilege = $finalData = array();
                    foreach (Config::get('constants.rolePermission.accessType') as $temp) {
                        if (Arr::only($otherDataPasses['access'], [$temp])) {
                            $access = Arr::prepend($access, true, $temp);
                            $privilege = Arr::prepend(
                                $privilege,
                                [
                                    'allowed' => true,
                                    'permission' => false
                                ],
                                $temp
                            );
                        } else {
                            $access = Arr::prepend($access, false, $temp);
                            $privilege = Arr::prepend(
                                $privilege,
                                [
                                    'allowed' => false,
                                    'permission' => false
                                ],
                                $temp
                            );
                        }
                    }
                    $finalData[Config::get('constants.typeCheck.helperCommon.access.fns')] = [
                        'access' => $access,
                        'privilege' => $privilege,
                    ];
                }
                if (Config::get('constants.typeCheck.helperCommon.access.frs') == $checkFirst['type']) {
                    $access = $privilege = $finalData = array();
                    if ($otherDataPasses['access'] == null) {
                        foreach (Config::get('constants.rolePermission.accessType') as $temp) {
                            $access = Arr::prepend($access, false, $temp);
                            $privilege = Arr::prepend(
                                $privilege,
                                [
                                    'allowed' => false,
                                    'permission' => false
                                ],
                                $temp
                            );
                        }
                    } else {
                        foreach ($otherDataPasses['access'] as $key => $temp) {
                            if ($temp == true) {
                                $access = Arr::prepend($access, true, $key);
                                $privilege = Arr::prepend(
                                    $privilege,
                                    [
                                        'allowed' => true,
                                        'permission' => false
                                    ],
                                    $key
                                );
                            } else {
                                $access = Arr::prepend($access, false, $key);
                                $privilege = Arr::prepend(
                                    $privilege,
                                    [
                                        'allowed' => false,
                                        'permission' => false
                                    ],
                                    $key
                                );
                            }
                        }
                    }
                    $finalData[Config::get('constants.typeCheck.helperCommon.access.frs')] = [
                        'access' => $access,
                        'privilege' => $privilege,
                    ];
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function generateYourChoice($params)
    {
        $return = array();
        foreach ($params as $tempOne) {
            if ($tempOne['type'] == Config::get('constants.generateType.uniqueId')) {
                $start = '1';
                $end = '9';
                $field = $tempOne['field'] == '' ? 'uniqueId' : $tempOne['field'];
                for ($i = 1; $i < $tempOne['length']; $i++) {
                    $start .= '0';
                    $end .= '9';
                }
                repeatAgain1:
                if ($tempOne['preString'] == '') {
                    $result = mt_rand($start, $end);
                } else {
                    $result = $tempOne['preString'] . '-' . mt_rand($start, $end);
                }
                if (app($tempOne['model'])::where($field, $result)->count() == 0) {
                    $return[Config::get('constants.generateType.uniqueId')] = [
                        'length' => $tempOne['length'],
                        'preString' => $tempOne['preString'],
                        'result' => $result,
                    ];
                } else {
                    goto repeatAgain1;
                }
            }

            if ($tempOne['type'] == Config::get('constants.generateType.lastSegment')) {
                $field = $tempOne['field'] == '' ? 'slug' : $tempOne['field'];
                $afterRemove = preg_replace('/[^A-Za-z0-9 ]/', '', $tempOne['name']);
                $afterTrim = Str::trim($afterRemove);
                $afterLower = Str::lower($afterTrim);
                static $staticLastSegment = Str::slug($afterLower, '-');
                $lastSegment = $staticLastSegment;
                $tempCount = 1;
                repeatAgain2:
                $resp = app($tempOne['model'])::where(
                    function ($query) use ($tempOne, $lastSegment, $field) {
                        if ($tempOne['targetId'] == '') {
                            return $query->where($field, $lastSegment);
                        } else {
                            return $query->where([
                                [$field, $lastSegment],
                                ['id', '!=', $tempOne['targetId']]
                            ]);
                        }
                    }
                )->get();
                if ($resp->count() >= 1) {
                    $lastSegment = $staticLastSegment . '-' . $tempCount;
                    $tempCount++;
                    goto repeatAgain2;
                } else {
                    $return[Config::get('constants.generateType.lastSegment')] = [
                        'afterRemove' => $afterRemove,
                        'afterTrim' => $afterTrim,
                        'afterLower' => $afterLower,
                        'result' => $lastSegment,
                    ];
                }
            }

            if ($tempOne['type'] == Config::get('constants.generateType.route')) {
                $field = $tempOne['field'] == '' ? 'slug' : $tempOne['field'];
                $afterSlug = '';
                $eachStageData = array();
                foreach ($tempOne['name'] as $tempTwo) {
                    $afterRemove = preg_replace('/[^A-Za-z0-9 ]/', '', $tempTwo);
                    $afterTrim = Str::trim($afterRemove);
                    $afterLower = Str::lower($afterTrim);
                    $afterSlug .= Str::slug($afterLower, '-') . '/';
                    $eachStageData[] = [
                        'afterRemove' => $afterRemove,
                        'afterTrim' => $afterTrim,
                        'afterLower' => $afterLower,
                    ];
                }
                static $staticRoute =  Str::rtrim($afterSlug, '/');
                $route = $staticRoute;
                $tempCount = 1;
                repeatAgain3:
                $resp = app($tempOne['model'])::where(
                    function ($query) use ($tempOne, $route, $field) {
                        if ($tempOne['targetId'] == '') {
                            return $query->where($field, $route);
                        } else {
                            return $query->where([
                                [$field, $route],
                                ['id', '!=', $tempOne['targetId']]
                            ]);
                        }
                    }
                )->get();
                if ($resp->count() >= 1) {
                    $route = $staticRoute . '-' . $tempCount;
                    $tempCount++;
                    goto repeatAgain3;
                } else {
                    $return[Config::get('constants.generateType.route')] = [
                        'eachStageData' => $eachStageData,
                        'result' => $route,
                    ];
                }
            }
        }
        return $return;
    }

    public function cleanStr($string)
    {
        //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = trim($string);
        $string = preg_replace("/[^a-zA-Z0-9\s]/", "", $string); // Removes special chars.
        $string = preg_replace('# {2,}#', ' ', $string);
        return $string;
    }

    public function getCommaSeparatedString($string, $model)
    {
        try {
            $data = '';
            $arr = explode(",", $string);
            foreach ($arr as $temp) {
                if ($string == 'NA') {
                    $data = 'NA';
                    goto a;
                } else {
                    $value = app("App\\Models\\$model")::findOrFail($temp);
                }

                if ($model == 'LifestyleDisorders') {
                    $data .= $value->disorderName . ", ";
                } elseif ($model == 'Tests') {
                    $data .= $value->testName . ", ";
                }
            }
            $data = rtrim($data, ", ");
            a:
            return $data;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function subStrString($length, $text, $with)
    {
        $finalText = strip_tags($text);
        if (strlen($finalText) <= 0) {
            return 'NA';
        } else {
            if (strlen($finalText) <= $length) {
                return $finalText;
            } else {
                return substr($finalText, 0, $length) . $with;
            }
        }
    }
}

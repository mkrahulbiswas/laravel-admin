<?php

namespace app\Traits;

use App\Helpers\ManagePanel\GetManageAccessHelper;
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
        // try {
        DB::beginTransaction();
        if ($params['type'] == Config::get('constants.action.status.smsfa')) {
            $field = ($params['targetField'] == null) ? 'default' : $params['targetField'][0];
            $data = app($params['targetModel'])::where('id', $params['targetId'])->first();
            app($params['targetModel'])::where($field, config('constants.status')['yes'])->update([$field => config('constants.status')['no']]);
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
        } elseif ($params['type'] == Config::get('constants.action.status.smmf')) {
        } elseif ($params['type'] == Config::get('constants.action.status.mmsf')) {
        } else {
        }
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return false;
        // }
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
        try {
            $return = array();
            foreach ($params as $tempOne) {
                if ($tempOne['type'] == 'dtMultiData') {
                    $appendHtml = '';
                    foreach ($tempOne['data'] as $tempTwo) {
                        if ($tempTwo['type'] == Config::get('constants.typeCheck.customizeInText.status')) {
                            $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataStatus"><label>Status:</label>' . $tempOne['data']['status']['custom'] . '</div>';
                        }

                        if ($tempTwo['type'] == Config::get('constants.typeCheck.customizeInText.default')) {
                            $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataDefault"><label>Default:</label>' . $tempOne['data']['default']['custom'] . '</div>';
                        }

                        if ($tempTwo['type'] == Config::get('constants.typeCheck.customizeInText.access')) {
                            $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataAccess"><label>Access:</label>' . $tempOne['data']['access']['custom'] . '</div>';
                        }

                        if ($tempTwo['type'] == Config::get('constants.typeCheck.customizeInText.hasChild')) {
                            $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataAccess"><label>Child:</label>' . $tempOne['data']['hasChild']['custom'] . '</div>';
                        }

                        if ($tempTwo['type'] == Config::get('constants.typeCheck.customizeInText.hasPermission')) {
                            $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataAccess"><label>Permission:</label>' . $tempOne['data']['hasPermission']['custom'] . '</div>';
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
                        if ($tempTwo['extraData']['hasNavMain'] <= 0) {
                            $navHtml .= '<div class="npbType"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempTwo['name'] . '</span></div><div class="npbhRight">Nav Type (No Nav Main Found)</div></div></div>';
                        } else {
                            $navHtml .= '<div class="npbType"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempTwo['name'] . '</span></div></div>';
                            foreach ($tempTwo['navMain'] as $tempThree) {
                                $permission = GetManageAccessHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.manageAccess.permission.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'filterData' => [
                                                'navTypeId' => $tempTwo['id'],
                                                'navMainId' => $tempThree['id'],
                                                'roleSubId' => isset($tempOne['otherDataPasses']['permission']['roleSubId']) ? $tempOne['otherDataPasses']['permission']['roleSubId'] : '',
                                                'roleMainId' => $tempOne['otherDataPasses']['permission']['roleMainId'],
                                            ]
                                        ]
                                    ],
                                ])[Config::get('constants.typeCheck.manageAccess.permission.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                                if ($tempThree['extraData']['hasNavSub'] <= 0) {
                                    $navHtml .= '<div class="npbMain"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempThree['name'] . '</span></div><div class="npbhRight"><div class="npbCheckCommon">';
                                    if ($permission == null) {
                                        $navHtml .= '<div class="npbCheckNoAccess"><span>No access is set yet for <b>nav main</b>, please set access before set permission.</span></div>';
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
                                    foreach ($tempThree['navSub'] as $tempFour) {
                                        $permission = GetManageAccessHelper::getDetail([
                                            [
                                                'getDetail' => [
                                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                                    'for' => Config::get('constants.typeCheck.manageAccess.permission.type'),
                                                ],
                                                'otherDataPasses' => [
                                                    'filterData' => [
                                                        'navTypeId' => $tempTwo['id'],
                                                        'navMainId' => $tempThree['id'],
                                                        'navSubId' => $tempFour['id'],
                                                        'roleSubId' => isset($tempOne['otherDataPasses']['permission']['roleSubId']) ? $tempOne['otherDataPasses']['permission']['roleSubId'] : '',
                                                        'roleMainId' => $tempOne['otherDataPasses']['permission']['roleMainId'],
                                                    ]
                                                ]
                                            ],
                                        ])[Config::get('constants.typeCheck.manageAccess.permission.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                                        if ($tempFour['extraData']['hasNavNested'] <= 0) {
                                            $navHtml .= '<div class="npbSub"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempFour['name'] . '</span></div><div class="npbhRight"><div class="npbCheckCommon">';
                                            if ($permission == null) {
                                                $navHtml .= '<div class="npbCheckNoAccess"><span>No access is set yet for <b>nav sub</b>, please set access before set permission.</span></div>';
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
                                            $navHtml .= '<div class="npbSub"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempFour['name'] . '</span></div><div class="npbhRight">There some nav nested found.....</div></div>';
                                            foreach ($tempFour['navNested'] as $tempFive) {
                                                $permission = GetManageAccessHelper::getDetail([
                                                    [
                                                        'getDetail' => [
                                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                                            'for' => Config::get('constants.typeCheck.manageAccess.permission.type'),
                                                        ],
                                                        'otherDataPasses' => [
                                                            'filterData' => [
                                                                'navTypeId' => $tempTwo['id'],
                                                                'navMainId' => $tempThree['id'],
                                                                'navSubId' => $tempFour['id'],
                                                                'navNestedId' => $tempFive['id'],
                                                                'roleSubId' => isset($tempOne['otherDataPasses']['permission']['roleSubId']) ? $tempOne['otherDataPasses']['permission']['roleSubId'] : '',
                                                                'roleMainId' => $tempOne['otherDataPasses']['permission']['roleMainId'],
                                                            ]
                                                        ]
                                                    ],
                                                ])[Config::get('constants.typeCheck.manageAccess.permission.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                                                $navHtml .= '<div class="npbNested"><div class="npbHeading"><div class="npbhLeft"><span>' . $tempFive['name'] . '</span></div><div class="npbhRight"><div class="npbCheckCommon">';
                                                if ($permission == null) {
                                                    $navHtml .= '<div class="npbCheckNoAccess"><span>No access is set yet for <b>nav nested</b>, please set access before set permission.</span></div>';
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
                            <div class="npRoleMain">
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
        } catch (Exception $e) {
            return false;
        }
    }

    public static function customizeInText($params)
    {
        try {
            $return = array();
            foreach ($params as $temp) {
                if ($temp['type'] == Config::get('constants.typeCheck.customizeInText.type')) {
                    if ($temp['value'] == Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.amenities.type')) {
                        $custom = '<span class="pa_amenities">' . Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.amenities.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.amenities.name');
                        $raw = $temp['value'];
                    } else if ($temp['value'] == Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.propertyFeatures.type')) {
                        $custom = '<span class="pa_propertyFeatures">' . Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.propertyFeatures.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.propertyFeatures.name');
                        $raw = $temp['value'];
                    } else if ($temp['value'] == Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.societyFeatures.type')) {
                        $custom = '<span class="pa_societyFeatures">' . Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.societyFeatures.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.societyFeatures.name');
                        $raw = $temp['value'];
                    } else if ($temp['value'] == Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.typeOfFloorings.type')) {
                        $custom = '<span class="pa_typeOfFloorings">' . Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.typeOfFloorings.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.typeOfFloorings.name');
                        $raw = $temp['value'];
                    } else if ($temp['value'] == Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.parkingTypes.type')) {
                        $custom = '<span class="pa_parkingTypes">' . Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.parkingTypes.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.parkingTypes.name');
                        $raw = $temp['value'];
                    } else if ($temp['value'] == Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.locatedNear.type')) {
                        $custom = '<span class="pa_locatedNear">' . Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.locatedNear.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.locatedNear.name');
                        $raw = $temp['value'];
                    } else {
                        $custom = '<span class="pa_locationAdvantages">' . Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.locationAdvantages.name') . '</span>';
                        $formatted = Config::get('constants.typeCheck.propertyRelated.propertyAttributes.attributes.locationAdvantages.name');
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
                if (Config::get('constants.typeCheck.helperCommon.access.al') == $checkFirst['type']) {
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
                    $finalData[Config::get('constants.typeCheck.helperCommon.access.al')] = [
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
                if (Config::get('constants.typeCheck.helperCommon.access.bm.fns') == $checkFirst['type']) {
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
                    $finalData[Config::get('constants.typeCheck.helperCommon.access.bm.fns')] = [
                        'access' => $access,
                        'privilege' => $privilege,
                    ];
                }
                if (Config::get('constants.typeCheck.helperCommon.access.bm.frs') == $checkFirst['type']) {
                    $access = $privilege = $finalData = array();
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
                    $finalData[Config::get('constants.typeCheck.helperCommon.access.bm.frs')] = [
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

    // public static function getNavAccessList($params = null)
    // {
    //     try {
    //         $access = $privilege = array();
    //         if ($params == null) {
    //             foreach (Config::get('constants.rolePermission.accessType') as $temp) {
    //                 $access = Arr::prepend($access, false, $temp);
    //                 $privilege = Arr::prepend(
    //                     $privilege,
    //                     [
    //                         'allowed' => true,
    //                         'permission' => true
    //                     ],
    //                     $temp
    //                 );
    //             }
    //         } else {
    //             foreach (Config::get('constants.rolePermission.accessType') as $temp) {
    //                 if (Arr::only($params, [$temp])) {
    //                     $access = Arr::prepend($access, true, $temp);
    //                     $privilege = Arr::prepend(
    //                         $privilege,
    //                         [
    //                             'allowed' => true,
    //                             'permission' => false
    //                         ],
    //                         $temp
    //                     );
    //                 } else {
    //                     $access = Arr::prepend($access, false, $temp);
    //                     $privilege = Arr::prepend(
    //                         $privilege,
    //                         [
    //                             'allowed' => false,
    //                             'permission' => false
    //                         ],
    //                         $temp
    //                     );
    //                 }
    //             }
    //         }
    //         return [
    //             'access' => $access,
    //             'privilege' => $privilege,
    //         ];
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }

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

    public function generateSlug($title, $column_name, $table, $operation, $id)
    {
        if ($operation == 'insert') {
            $slugExist = DB::table($table)->where($column_name, $title)->get();
            $count = $slugExist->count();
            if ($count > 0) {
                $slug2 = Str::slug($title, '-');
                $slug = $slug2 . '-' . $count;

                b:
                $slugExist = DB::table($table)->where('slug', $slug)->get();
                if ($slugExist->count() > 0) {
                    $slug = $slug2 . '-' . $count++;
                    goto b;
                }
            } else {
                $slug = Str::slug($title, '-');
            }
        } else {
            $slugExist = DB::table($table)->where($column_name, $title)->where('id', $id)->get();
            $count = $slugExist->count();
            if ($count > 0) {
                $slug = $slugExist[0]->slug;
            } else {
                $slugExist = DB::table($table)->where($column_name, $title)->get();
                $count = $slugExist->count();
                if ($count > 0) {
                    $slug2 = Str::slug($title, '-');
                    $slug = $slug2 . '-' . $count;

                    a:
                    $slugExist = DB::table($table)->where('slug', $slug)->get();
                    if ($slugExist->count() > 0) {
                        $slug = $slug2 . '-' . $count++;
                        goto a;
                    }
                } else {
                    $slug = Str::slug($title, '-');
                }
            }
        }
        return $slug;
    }

    public function generateNo($model, $column)
    {
        a:
        $no = mt_rand(1111, 9999);
        $exist = app("App\\Models\\$model")::where($column, $no)->get();
        $count = $exist->count();
        if ($count > 0) {
            goto a;
        } else {
            return $no;
        }
    }

    public function generateBookingNo()
    {
        $micro_time = microtime(true);
        $micro_time = explode(".", $micro_time);
        $micro_time = implode("", $micro_time);

        for ($i = strlen($micro_time); $i < 14; $i++) {
            $micro_time = $micro_time . '0';
        }
        return $micro_time;
    }

    public function generateAlphaNumericString()
    {
        $character = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#<!)>';
        $charactersLength = strlen($character);
        $string = '';
        for ($i = 0; $i < 8; $i++) {
            $string .= $character[mt_rand(0, $charactersLength - 1)];
        }

        return $string;
    }

    public function cleanStr($string)
    {
        //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = trim($string);
        $string = preg_replace("/[^a-zA-Z0-9\s]/", "", $string); // Removes special chars.
        $string = preg_replace('# {2,}#', ' ', $string);
        return $string;
    }

    public static function formatDateTime($datetime)
    {
        $DateTime = explode(" ", $datetime);
        $date = date("d-m-Y", strtotime($DateTime[0]));
        $time = date("g:i A", strtotime($DateTime[1]));

        $date_time = array("date" => $date, "time" => $time);

        return $date_time;
    }

    public static function formatDate($date)
    {
        $date = date("d-m-Y", strtotime($date));
        return $date;
    }

    public static function formatTime($time)
    {
        $time = date("g:i A", strtotime($time));
        return $time;
    }

    public function getNextDayName($noOfDay, $countryId)
    {
        $timeZone = $this->getTimeZone($countryId);
        date_default_timezone_set($timeZone);

        $dayName = array();
        $date = time();
        $next = strtotime('+' . $noOfDay . ' days');
        while ($date < $next) { // loop until next six
            $dayName[] = date('l', $date); // push the day name
            $date = strtotime('+1 day', $date); // add +1 on $date
        }

        return $dayName;
    }

    public function getNextDate($noOfDate, $countryId)
    {
        $timeZone = $this->getTimeZone($countryId);
        date_default_timezone_set($timeZone);

        $dates = array();
        $date = time();
        $next = strtotime('+' . $noOfDate . ' days');
        while ($date < $next) { // loop until next six
            $dates[] = date('Y-m-d', $date); // push the day name
            $date = strtotime('+1 day', $date); // add +1 on $date
        }
        return $dates;
    }

    public function checkNull($data)
    {
        if ($data == null) {
            $data = 'NA';
        }

        return $data;
    }

    public function numberAlign($number, $type)
    {
        if ($type == 'pin') {
            $x = strlen($number) / 2;
            return substr($number, 0, $x) . ' ' . substr($number, -$x);
        } else if ($type == 'phone') {
            $x = strlen($number) / 2;
            return substr($number, 0, $x) . ' ' . substr($number, -$x);
        } else {
            return 'No Function Found';
        }
    }


    public static function generateCode($data)
    {
        $start = '1';
        $end = '9';
        $field = $data['field'] == '' ? 'uniqueId' : $data['field'];

        for ($i = 1; $i < $data['length']; $i++) {
            $start .= '0';
            $end .= '9';
        }

        a:
        if ($data['preString'] == '') {
            $result = mt_rand($start, $end);
        } else {
            $result = $data['preString'] . '-' . mt_rand($start, $end);
        }
        if (app($data['model'])::where($field, $result)->count() == 0) {
            return $result;
        } else {
            goto a;
        }
    }


    public function convertDateTimeByTimeZone($fromTimeZone, $toTimeZone, $dateTime)
    {
        $date = new DateTime($dateTime, new DateTimeZone($fromTimeZone));
        $date->setTimezone(new DateTimeZone($toTimeZone));
        return $date->format('Y-m-d H:i:s');
    }

    public static function subStrString($length, $text, $with)
    {
        $finalText = strip_tags($text);
        if (strlen($finalText) <= $length) {
            return $finalText;
        } else {
            return substr($finalText, 0, $length) . $with;
        }
    }

    public function getDifferentBetweenTwoTimeStamp($from, $to, $type)
    {
        $from = ($from == '') ? new DateTime(date('Y-m-d H:i:s', strtotime(Carbon::now()))) : new DateTime(date('Y-m-d H:i:s', strtotime($from)));
        $to = ($to == '') ? new DateTime(date('Y-m-d H:i:s', strtotime(Carbon::now()))) : new DateTime(date('Y-m-d H:i:s', strtotime($to)));
        if ($type == 'minute') {
            $different = [
                'res' => $to->diff($from)->format('%i'),
                'from' => $from,
                'to' => $to,
            ];
        } else {
            $different = [
                'res' => $to->diff($from),
                'from' => $from,
                'to' => $to,
            ];
        }
        return $different;
    }
}

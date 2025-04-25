<?php

namespace app\Traits;

use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use DateTimeZone;
use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

trait CommonTrait
{
    public function changeStatus($params)
    {
        try {
            if ($params['type'] == Config::get('constants.actionFor.statusType.smsf')) {
                $field = ($params['targetField'] == null) ? 'status' : $params['targetField'][0];
                $data = app($params['targetModel'])::where('id', $params['targetId'])->first();
                if ($data->$field == config('constants.status')['inactive']) {
                    $data->$field = config('constants.status')['active'];
                    if ($data->update()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    $data->$field = config('constants.status')['inactive'];
                    if ($data->update()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } elseif ($params['type'] == Config::get('constants.actionFor.statusType.smmf')) {
            } elseif ($params['type'] == Config::get('constants.actionFor.statusType.mmsf')) {
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
            return false;
        }
    }

    public function deleteItem($params)
    {
        try {
            if ($params['type'] == Config::get('constants.actionFor.deleteType.smsr')) {
                $idByField = ($params['idByField'] == '') ? 'id' : $params['idByField'];
                $data = app($params['targetModal'])::where($idByField, $params['targetId'])->first();
                if ($params['picUrl'] != '') {
                    $picPath = config('constants.' . $params['picUrl']);
                    if ($data->image != 'NA') {
                        if (unlink($picPath . $data->image)) {
                            if ($data->delete()) {
                                return true;
                            }
                        } else {
                            return false;
                        }
                    } else {
                        if ($data->delete()) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                } else {
                    if ($data->delete()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                $response = false;
                $idByField = ($params['idByField'] == '') ? 'id' : $params['idByField'];
                $data = app($params['targetModal'])::where($idByField, $params['targetId'])->get();
                if (sizeof($data) > 0) {
                    foreach ($data as $temp) {
                        if ($params['picUrl'] != '') {
                            $picPath = config('constants.' . $params['picUrl']);
                            if ($temp->image != 'NA') {
                                if (unlink($picPath . $temp->image)) {
                                    if ($temp->delete()) {
                                        $response = true;
                                    }
                                } else {
                                    return false;
                                }
                            } else {
                                if ($temp->delete()) {
                                    $response = true;
                                } else {
                                    return false;
                                }
                            }
                        } else {
                            if ($temp->delete()) {
                                $response = true;
                            } else {
                                return false;
                            }
                        }
                    }
                    if ($response == true) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function changeDefault($id, $model, $field, $type)
    {

        try {
            if ($type == config('constants.statusSingle')) {
                $field = ($field == null) ? 'isDefault' : $field[0];
                $data = app($model)::where('id', $id)->first();
                if ($data->$field == '0') {
                    $data->$field = '1';
                    if ($data->update()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    $data->$field = '0';
                    if ($data->update()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } elseif ($type == config('constants.statusMultiple')) {
            } else {
                foreach ($field as $temp) {
                    if (app($model)::where($temp, '1')->update([$temp => '0'])) {
                        $responce = app($model)::where('id', $id)->update([$temp => '1']);
                    } else {
                        return false;
                    }
                }

                if ($responce) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
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
                        if ($tempTwo['type'] == 'status') {
                            $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataStatus"><label>Status:</label>' . $tempOne['data']['status']['custom'] . '</div>';
                        }

                        if ($tempTwo['type'] == 'access') {
                            $appendHtml .= '<div class="dtMultiDataCommon dtMultiDataAccess"><label>Access:</label>' . $tempOne['data']['access']['custom'] . '</div>';
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
                        if (Str::contains($tempTwo, 'data-type="details"')) {
                            $primaryAction .= '<div class="tdActionButtonCommon tdActionButtonDetails">' . $tempTwo . '</div>';
                        }
                        if (Str::contains($tempTwo, 'data-type="access"')) {
                            $primaryAction .= '<div class="tdActionButtonCommon tdActionButtonAccess">' . $tempTwo . '</div>';
                        }
                    }

                    foreach ($tempOne['data']['secondary'] as $tempTwo) {
                        $secondaryAction .= '<div class="tdActionInnerCommon">' . $tempTwo . '</div>';
                    }

                    if (sizeof($tempOne['data']['secondary']) > 0) {
                        $toggleButton = '<div class="tdActionButtonCommon tdActionButtonToggle"><a type="button" class="btn btn-sm"><i class="mdi mdi-menu-open"></i></a></div>';
                    } else {
                        $toggleButton = '';
                    }

                    $html = '<div class="tdAction"><div class="tdActionButton">' . $primaryAction . $toggleButton . '</div><div class="tdActionInner">' . $secondaryAction . '</div></div>';

                    $return['dtAction'] = [
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
                if ($temp['type'] == 'status') {
                    if ($temp['value'] == Config::get('constants.status')['active']) {
                        $custom = '<span class="badge bg-success">Active</span>';
                        $formatted = 'Active';
                        $raw = $temp['value'];
                    } else {
                        $custom = '<span class="badge bg-danger">In Active</span>';
                        $formatted = 'In Active';
                        $raw = $temp['value'];
                    }
                    $return['status'] = [
                        'custom' => $custom,
                        'formatted' => $formatted,
                        'raw' => $raw,
                        'type' => $temp['type'],
                    ];
                }
                if ($temp['type'] == 'access') {
                    if ($temp['value'] == null) {
                        $custom = '<span class="badge bg-danger">No Access Found</span>';
                    } else {
                        $custom = '<span class="badge bg-success"data-access="' . json_encode($temp['value']) . '">Access Found</span>';
                    }
                    $return['access'] = [
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

    public function getNavAccessList($params = null)
    {
        try {
            $access = $privilege = array();
            if ($params == null) {
                foreach (Config::get('constants.rolePermission.accessType') as $temp) {
                    $access = Arr::prepend($access, false, $temp);
                    $privilege = Arr::prepend(
                        $privilege,
                        [
                            'access' => false,
                            'privilege' => false
                        ],
                        $temp
                    );
                }
            } else {
                foreach (Config::get('constants.rolePermission.accessType') as $temp) {
                    if (Arr::only($params, [$temp])) {
                        $access = Arr::prepend($access, true, $temp);
                        $privilege = Arr::prepend(
                            $privilege,
                            [
                                'access' => true,
                                'privilege' => false
                            ],
                            $temp
                        );
                    } else {
                        $access = Arr::prepend($access, false, $temp);
                        $privilege = Arr::prepend(
                            $privilege,
                            [
                                'access' => false,
                                'privilege' => false
                            ],
                            $temp
                        );
                    }
                }
            }
            return [
                'access' => $access,
                'privilege' => $privilege,
            ];
        } catch (Exception $e) {
            return false;
        }
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

    public function itemPermission()
    {
        $role_id = Auth::guard('admin')->user()->role_id;
        $url = url()->current();
        $url = explode("/", $url);
        $itemPermission = DB::table('role_permission')
            ->join('sub_module', 'sub_module.id', '=', 'role_permission.sub_module_id')
            ->select('role_permission.*', 'sub_module.last_segment')
            ->where('role_permission.role_id', $role_id)
            ->where('role_permission.sub_module_access', '1')
            ->get();
        foreach ($itemPermission as $temp) {
            if (in_array($temp->last_segment, $url)) {
                $permission = array(
                    "add_item" => $temp->add_item,
                    "edit_item" => $temp->edit_item,
                    "details_item" => $temp->details_item,
                    "delete_item" => $temp->delete_item,
                    "status_item" => $temp->status_item,
                    "other_item" => $temp->other_item
                );
                goto a;
            }
        }
        a:
        // $permission = array("add_item" => 1, "edit_item" => 1, "details_item" => 1, "delete_item" => 1, "status_item" => 1, "other_item" => 1);
        return $permission;
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


    function generateCode($data)
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

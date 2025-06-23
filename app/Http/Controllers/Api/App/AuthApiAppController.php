<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;

use App\Helpers\CommonHelper;

use App\Models\User;

use App\Mail\resetAuthSendMail;

use App\Traits\ValidationTrait;
use App\Traits\ProfileTrait;
use App\Traits\CommonTrait;

use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class AuthApiAppController extends Controller
{
    use ValidationTrait, ProfileTrait, CommonTrait;
    public $platform = 'app';


    public function checkUser(Request $request)
    {
        $values = $request->only('dialCode', 'phone', 'email');
        // try {
        $checkBy = '';
        $whereRaw = "`created_at` is not null";
        $otp = $this->generateYourChoice([['length' => 6, 'type' => Config::get('constants.generateType.number')]])[Config::get('constants.generateType.number')]['result'];

        if ($values['email'] == '' && $values['phone'] != '') {
            $whereRaw .= " and `dialCode` = '" . $values['dialCode'] . "' and `phone` = '" . $values['phone'] . "'";
            $checkBy = Config::get('constants.typeCheck.logRegBy.phone');
        } else if ($values['email'] != '' && $values['phone'] == '') {
            $whereRaw .= " and `email` = '" . $values['email'] . "'";
            $checkBy = Config::get('constants.typeCheck.logRegBy.email');
        } else {
            return response()->json(['status' => 0, 'type' => "warning", 'title' => "Check User", 'msg' => __('messages.checkUserInvalidInputMsg'), "payload" =>  (object)[]], config('constants.errorCode.ok'));
        }

        $validator = $this->isValid(['input' => $request->all(), 'for' => 'checkUser', 'id' => 0, 'checkBy' => $checkBy, 'platform' => $this->platform]);
        if ($validator->fails()) {
            $vErrors = $this->getVErrorMessages($validator->errors());
            return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], config('constants.errorCode.ok'));
        } else {
            $user = User::whereRaw($whereRaw)->first();
            if ($user == null) {
                $user = new User();
                if ($checkBy == Config::get('constants.typeCheck.logRegBy.phone')) {
                    $user->dialCode = $values['dialCode'];
                    $user->phone = $values['phone'];
                } else {
                    $user->email = $values['email'];
                }
                $user->otp = $otp;
                $user->otpFor = Config::get('constants.otpFor.register');
                $user->status = Config::get('constants.status.incomplete');
                if ($user->save()) {
                    goto next;
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Check User", 'msg' => __('messages.createUserMsg.failed'), "payload" =>  (object)[]], config('constants.errorCode.ok'));
                }
            } else if ($user->status == Config::get('constants.status.incomplete')) {
                $user->otp = $otp;
                if ($user->update()) {
                    goto next;
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Check User", 'msg' => __('messages.createUserMsg.failed'), "payload" =>  (object)[]], config('constants.errorCode.ok'));
                }
            } else {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Check User", 'msg' => __('messages.loginSuccess') . '-> 2', "payload" =>  ['checkBy' => $checkBy, 'isUserFound' => true, 'otpFor' => Config::get('constants.otpFor.login'),]], config('constants.errorCode.ok'));
            }

            next:
            if ($checkBy == Config::get('constants.typeCheck.logRegBy.phone')) {
                $replaceVariableWithValue = CommonHelper::replaceVariableWithValue([
                    'replaceData' => [
                        ['key' => '[~otp~]', 'value' => $otp],
                    ],
                    'alertType' => 'ALTY-756816',
                    'alertFor' => 'ALFO-909372',
                ]);
                $data = array(
                    'subject' => $replaceVariableWithValue['heading'],
                    'content' => $replaceVariableWithValue['content'],
                );
                Mail::to('biswas.rahul31@gmail.com')->send(new resetAuthSendMail($data));
            } else {
                $replaceVariableWithValue = CommonHelper::replaceVariableWithValue([
                    'replaceData' => [
                        ['key' => '[~otp~]', 'value' => $otp],
                    ],
                    'alertType' => 'ALTY-894165',
                    'alertFor' => 'ALFO-562883',
                ]);
                $data = array(
                    'subject' => $replaceVariableWithValue['heading'],
                    'content' => $replaceVariableWithValue['content'],
                );
                Mail::to($values['email'])->send(new resetAuthSendMail($data));
            }
            return response()->json(['status' => 1, 'type' => "success", 'title' => "Check User", 'msg' => __('messages.loginSuccess'), "payload" => ['id' => encrypt($user->id), 'otp' => $otp, 'otpFor' => Config::get('constants.otpFor.register'), 'checkBy' => $checkBy, 'isUserFound' => false,]], config('constants.errorCode.ok'));
        }
        // } catch (Exception $e) {
        //     return response()->json(['status' => 0, 'type' => "error", 'title' => "Check User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        // }
    }

    public function verifyUser(Request $request)
    {
        $values = $request->only('otp', 'id');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        // try {
        $validator = $this->isValid(['input' => $request->all(), 'for' => 'verifyUser', 'id' => 0, 'platform' => $this->platform]);
        if ($validator->fails()) {
            $vErrors = $this->getVErrorMessages($validator->errors());
            return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], config('constants.errorCode.ok'));
        } else {
            $user = User::findOrFail($id);
            if ($user->otpFor == Config::get('constants.otpFor.register')) {
                if ($user->otp == $values['otp']) {
                    $user->otp = null;
                    $user->otpFor = 'NA';
                    if ($user->update()) {
                        return response()->json(['status' => 1, 'type' => "success", 'title' => "Verify User", 'msg' => __('messages.otpVerifyMsg.success'), "payload" => (object)[]], config('constants.errorCode.ok'));
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Verify User", 'msg' => __('messages.createUserMsg.failed'), "payload" =>  (object)[]], config('constants.errorCode.ok'));
                    }
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Verify User", 'msg' => __('messages.otpVerifyMsg.failed'), "payload" =>  (object)[]], config('constants.errorCode.ok'));
                }
            } else {
                $user->otp = null;
                $user->otpVerifiedAt = null;
                $user->otpFor = 'NA';
            }
        }
        // } catch (Exception $e) {
        //     return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        // }
    }
}

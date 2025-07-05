<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;

use App\Helpers\CommonHelper;

use App\Models\User;

use App\Mail\ResetAuthSendMail;

use App\Traits\ValidationTrait;
use App\Traits\ProfileTrait;
use App\Traits\CommonTrait;
use app\Traits\FileTrait;

use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthAppController extends Controller
{
    use ValidationTrait, ProfileTrait, CommonTrait, FileTrait;
    public $platform = 'app';


    public function checkUser(Request $request)
    {
        $values = $request->only('checkBy', 'dialCode', 'phone', 'email');
        try {
            $whereRaw = "`created_at` is not null";
            $otp = $this->generateYourChoice([['length' => 6, 'type' => Config::get('constants.generateType.number')]])[Config::get('constants.generateType.number')]['result'];

            if ($values['checkBy'] == 'phone') {
                $whereRaw .= " and `dialCode` = '" . $values['dialCode'] . "' and `phone` = '" . $values['phone'] . "'";
            } else if ($values['checkBy'] == 'email') {
                $whereRaw .= " and `email` = '" . $values['email'] . "'";
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Check User", 'msg' => __('messages.checkUserInvalidInputMsg'), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
            }

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'checkUser', 'id' => 0, 'checkBy' => $values['checkBy'], 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], Config::get('constants.errorCode.validation'));
            } else {
                $user = User::whereRaw($whereRaw)->first();
                if ($user == null) {
                    $user = new User();
                    if ($values['checkBy'] == 'phone') {
                        $user->dialCode = $values['dialCode'];
                        $user->phone = $values['phone'];
                    } else {
                        $user->email = $values['email'];
                    }
                    $user->otp = $otp;
                    $user->uniqueId = $this->generateYourChoice([
                        [
                            'preString' => 'APU',
                            'length' => 6,
                            'model' => User::class,
                            'field' => '',
                            'type' => Config::get('constants.generateType.uniqueId')
                        ]
                    ])[Config::get('constants.generateType.uniqueId')]['result'];
                    $user->otpFor = Config::get('constants.otpFor.register');
                    $user->status = Config::get('constants.status.incomplete');
                    if ($user->save()) {
                        goto next;
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Check User", 'msg' => __('messages.createUserMsg.failed'), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
                    }
                } else if ($user->status == Config::get('constants.status.incomplete')) {
                    $user->otpFor = Config::get('constants.otpFor.login');
                    $user->otp = $otp;
                    if ($user->update()) {
                        goto next;
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Check User", 'msg' => __('messages.createUserMsg.failed'), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Check User", 'msg' => __('messages.loginSuccess') . '-> 2', "payload" =>  ['checkBy' => $values['checkBy'], 'isUserFound' => true, 'otpFor' => Config::get('constants.otpFor.login'),]], Config::get('constants.errorCode.ok'));
                }

                next:
                if ($values['checkBy'] == 'phone') {
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
                    Mail::to('biswas.rahul31@gmail.com')->send(new ResetAuthSendMail($data));
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
                    Mail::to($values['email'])->send(new ResetAuthSendMail($data));
                }
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Check User", 'msg' => __('messages.otpMsg.success'), "payload" => ['id' => encrypt($user->id), 'otp' => $otp, 'otpFor' => Config::get('constants.otpFor.register'), 'checkBy' => $values['checkBy'], 'isUserFound' => false]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Check User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }

    public function verifyUser(Request $request)
    {
        $values = $request->only('otp', 'id', 'checkBy', 'otpFor', 'isUserFound');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'verifyUser', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], Config::get('constants.errorCode.validation'));
            } else {
                $user = User::findOrFail($id);
                if ($user->otp == $values['otp']) {
                    $user->otp = null;
                    $user->otpFor = 'NA';
                    if ($user->update()) {
                        if ($values['otpFor'] == Config::get('constants.otpFor.register')) {
                            return response()->json(['status' => 1, 'type' => "success", 'title' => "Verify User", 'msg' => __('messages.otpVerifyMsg.success'), "payload" => ['id' => $values['id'], 'otpFor' => $values['otpFor'], 'checkBy' => $values['checkBy'], 'isUserFound' => $values['isUserFound']]], Config::get('constants.errorCode.ok'));
                        } else {
                            if (Auth::loginUsingId($user->id)) {
                                $user = Auth::user();
                                $token = $user->createToken($user->userType . $user->id)->plainTextToken;
                                if ($token) {
                                    $data = $this->getProfileInfo($user->id, $this->platform);
                                    if ($data === false) {
                                        return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                                    } else {
                                        return response()->json(['status' => 1, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.loginSuccess'), "payload" => ['tokenType' => 'Bearer', 'token' => $token, 'user' => $data]], Config::get('constants.errorCode.ok'));
                                    }
                                } else {
                                    return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                                }
                            } else {
                                return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.loginErr'), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                            }
                        }
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Verify User", 'msg' => __('messages.createUserMsg.failed'), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Verify User", 'msg' => __('messages.otpVerifyMsg.failed'), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }

    public function registerUser(Request $request)
    {
        $values = $request->only('id', 'checkBy', 'name', 'dialCode', 'phone', 'email', 'password', 'userType');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Register User", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'registerUser', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], Config::get('constants.errorCode.validation'));
            } else {
                $user = User::findOrFail($id);
                if ($user->status == Config::get('constants.status.incomplete')) {
                    if ($user == null) {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Register User", 'msg' => __('messages.createUserMsg.failed'), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
                    } else {
                        $user->name = $values['name'];
                        $user->dialCode = $values['dialCode'];
                        $user->phone = $values['phone'];
                        $user->email = $values['email'];
                        $user->password = Hash::make($values['password']);
                        $user->userType = $values['userType'];
                        $user->status = Config::get('constants.status.active');
                        if ($user->update()) {
                            $token = $user->createToken($user->userType . $user->id)->plainTextToken;
                            if ($token) {
                                $data = $this->getProfileInfo($user->id, $this->platform);
                                if ($data === false) {
                                    return response()->json(['status' => 0, 'type' => "error", 'title' => "Register User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                                } else {
                                    return response()->json(['status' => 1, 'type' => "error", 'title' => "Register User", 'msg' => __('messages.loginSuccess'), "payload" => ['tokenType' => 'Bearer', 'token' => $token, 'data' => $data]], Config::get('constants.errorCode.ok'));
                                }
                            } else {
                                return response()->json(['status' => 0, 'type' => "error", 'title' => "Register User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                            }
                        } else {
                            return response()->json(['status' => 0, 'type' => "warning", 'title' => "Register User", 'msg' => __('messages.createUserMsg.failed'), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
                        }
                    }
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Register User", 'msg' => __('messages.alreadyUserCreateMsg'), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Register User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }

    public function loginUser(Request $request)
    {
        $values = $request->only('checkBy', 'dialCode', 'phone', 'email', 'password');

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'loginUser', 'checkBy' => $values['checkBy'], 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], Config::get('constants.errorCode.validation'));
            } else {
                if ($values['checkBy'] == 'phone') {
                    $credential = ['dialCode' => $values['dialCode'], 'phone' => $values['phone'], 'password' => $values['password']];
                    $user = User::where('dialCode', $values['dialCode'])->where('phone', $values['phone'])->first();
                } else {
                    $credential = ['email' => $values['email'], 'password' => $values['password']];
                    $user = User::where('email', $values['email'])->first();
                }
                if ($user->status == Config::get('constants.status.inactive')) {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Login User", 'msg' => __('messages.inactiveUserMsg'), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
                } else if ($user->status == Config::get('constants.status.incomplete')) {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Login User", 'msg' => __('messages.incompleteUserMsg'), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
                } else {
                    if (Auth::attempt($credential)) {
                        $user = Auth::user();
                        $user = User::findOrFail($user->id);
                        $token = $user->createToken($user->userType . $user->id)->plainTextToken;
                        if ($token) {
                            $data = $this->getProfileInfo($user->id, $this->platform);
                            if ($data === false) {
                                return response()->json(['status' => 0, 'type' => "error", 'title' => "Login User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                            } else {
                                return response()->json(['status' => 1, 'type' => "error", 'title' => "Login User", 'msg' => __('messages.loginSuccess'), "payload" => ['tokenType' => 'Bearer', 'token' => $token, 'data' => $data]], Config::get('constants.errorCode.ok'));
                            }
                        } else {
                            return response()->json(['status' => 0, 'type' => "warning", 'title' => "Login User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                        }
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Login User", 'msg' => __('messages.loginErr'), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Login User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }

    public function logoutUser()
    {
        try {
            $user = Auth::user();
            if ($user) {
                if ($user->currentAccessToken()->delete()) {
                    return response()->json(['status' => 1, 'msg' => __('messages.logoutSuccess'), 'payload' => (object)[]], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'msg' => __('messages.logoutSuccess'), 'payload' => (object)[]], config('constants.ok'));
                }
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.logoutSuccess'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Login User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }

    public function changePassword(Request $request)
    {
        $values = $request->only('oldPassword', 'newPassword', 'confirmPassword');
        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'changePassword', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], Config::get('constants.errorCode.validation'));
            } else {
                if (Hash::check($values['oldPassword'], Auth::user()->password)) {
                    $user = User::findOrFail(Auth::user()->id);
                    $user->password = Hash::make($values['newPassword']);
                    if ($user->update()) {
                        return response()->json(['status' => 1, 'type' => "success", 'title' => "Change Password", 'msg' => __('messages.changeMsg', ['type' => 'Password'])['success'], 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Change Password", 'msg' => __('messages.changeMsg', ['type' => 'Password'])['failed'], 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Change Password", 'msg' => __('messages.oldPassPinNotMatchMsg', ['type' => 'Password']), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Change Password", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }

    public function updateDeviceToken(Request $request)
    {
        $values = $request->only('deviceType', 'deviceToken');
        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateDeviceToken', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], Config::get('constants.errorCode.validation'));
            } else {
                $user = User::findOrFail(Auth::user()->id);
                $user->deviceType = $values['deviceType'];
                $user->deviceToken = $values['deviceToken'];
                if ($user->update()) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Device Token", 'msg' => __('messages.updateMsg.success', ['type' => 'Device token']), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "error", 'title' => "Device Token", 'msg' => __('messages.updateMsg.error', ['type' => 'Device token']), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Device Token", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }

    public function getProfile()
    {
        try {
            $user = Auth::user();
            $data = $this->getProfileInfo($user->id, $this->platform);
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.noProfileDataMsg.failed'), 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.noProfileDataMsg.success'), "payload" => ['data' => $data]], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }

    public function updateProfilePic(Request $request)
    {
        $file = $request->file('file');
        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateProfilePic', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], Config::get('constants.errorCode.ok'));
            } else {
                $user = User::find(Auth::user()->id);
                if ($file) {
                    $uploadFile = $this->uploadFile([
                        'file' => ['current' => $file, 'previous' => $user->image],
                        'platform' => $this->platform,
                        'storage' => Config::get('constants.storage')['appUsers']
                    ]);
                    if ($uploadFile['type'] == false) {
                        return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Profile pic", 'msg' => $uploadFile['msg']], Config::get('constants.errorCode.ok'));
                    } else {
                        $user->image = $uploadFile['name'];
                    }
                }
                if ($user->update()) {
                    $getFile = FileTrait::getFile([
                        'fileName' => $user->image,
                        'storage' => Config::get('constants.storage')['appUsers']
                    ])['public']['fullPath']['asset'];
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Profile pic", 'payload' => ['image' => $getFile], 'msg' => __('messages.changeMsg', ['type' => 'Profile pic'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Profile pic", 'msg' => __('messages.changeMsg', ['type' => 'Profile pic'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Profile pic", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }

    public function resetSendOtp(Request $request)
    {
        $values = $request->only('checkBy', 'dialCode', 'phone', 'email');
        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'resetSendOtp', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], Config::get('constants.errorCode.ok'));
            } else {
                if ($values['checkBy'] == 'phone') {
                    $whereRaw = "`dialCode` = '" . $values['dialCode'] . "' and `phone` = '" . $values['phone'] . "'";
                } else if ($values['checkBy'] == 'email') {
                    $whereRaw = "`email` = '" . $values['email'] . "'";
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Send OTP", 'msg' => __('messages.checkUserInvalidInputMsg'), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
                }
                $user = User::whereRaw($whereRaw)->first();
                if ($user == null) {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Send OTP", 'msg' => __('messages.noDataFoundMsg', ['type' => 'user']), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
                } else {
                    $otp = $this->generateYourChoice([['length' => 6, 'type' => Config::get('constants.generateType.number')]])[Config::get('constants.generateType.number')]['result'];
                    $user->otp = $otp;
                    $user->otpFor = Config::get('constants.otpFor.resetPass');
                    if ($user->update()) {
                        if ($values['checkBy'] == 'phone') {
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
                            Mail::to('biswas.rahul31@gmail.com')->send(new ResetAuthSendMail($data));
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
                            Mail::to($values['email'])->send(new ResetAuthSendMail($data));
                        }
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Send OTP", 'msg' => __('messages.otpMsg')['success'], "payload" => ['id' => encrypt($user->id), 'otp' => $otp]], Config::get('constants.errorCode.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Send OTP", 'msg' => __('messages.otpMsg')['failed'], 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Send OTP", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }

    public function resetVerifyOtp(Request $request)
    {
        $values = $request->only('otp', 'id');
        // try {
        $validator = $this->isValid(['input' => $request->all(), 'for' => 'resetVerifyOtp', 'id' => 0, 'platform' => $this->platform]);
        if ($validator->fails()) {
            $vErrors = $this->getVErrorMessages($validator->errors());
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], Config::get('constants.errorCode.ok'));
        } else {
            $user = User::findOrFail(decrypt($values['id']));
            if ($user->otp == $values['otp']) {
                $user->otp = null;
                $user->otpFor = 'NA';
                if ($user->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Verify OTP", 'msg' => __('messages.otpVerifyMsg')['success'], 'payload' => ['id' => $values['id']]], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Verify OTP", 'msg' => __('messages.otpVerifyMsg')['failed'], 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                }
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Verify OTP", 'msg' => __('messages.otpVerifyMsg.failed'), "payload" =>  (object)[]], Config::get('constants.errorCode.ok'));
            }
        }
        // } catch (Exception $e) {
        //     return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify OTP", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        // }
    }

    public function resetChangePassword(Request $request)
    {
        $values = $request->only('password', 'confirmPassword', 'id');
        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'resetChangePassword', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], Config::get('constants.errorCode.ok'));
            } else {
                $user = User::findOrFail(decrypt($values['id']));
                $user->password = Hash::make($values['password']);
                if ($user->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Change Password", 'msg' => __('messages.updateMsg', ['type' => 'password'])['success'], 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Change Password", 'msg' => __('messages.updateMsg', ['type' => 'password'])['failed'], 'payload' => (object)[]], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Change Password", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], Config::get('constants.errorCode.server'));
        }
    }
}

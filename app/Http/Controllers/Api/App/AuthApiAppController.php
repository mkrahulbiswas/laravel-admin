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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiAppController extends Controller
{
    use ValidationTrait, ProfileTrait, CommonTrait;
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
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Check User", 'msg' => __('messages.checkUserInvalidInputMsg'), "payload" =>  (object)[]], config('constants.errorCode.ok'));
            }

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'checkUser', 'id' => 0, 'checkBy' => $values['checkBy'], 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], config('constants.errorCode.ok'));
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
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Check User", 'msg' => __('messages.loginSuccess') . '-> 2', "payload" =>  ['checkBy' => $values['checkBy'], 'isUserFound' => true, 'otpFor' => Config::get('constants.otpFor.login'),]], config('constants.errorCode.ok'));
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
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Check User", 'msg' => __('messages.loginSuccess'), "payload" => ['id' => encrypt($user->id), 'otp' => $otp, 'otpFor' => Config::get('constants.otpFor.register'), 'checkBy' => $values['checkBy'], 'isUserFound' => false]], config('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Check User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function verifyUser(Request $request)
    {
        $values = $request->only('otp', 'id', 'checkBy', 'otpFor', 'isUserFound');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'verifyUser', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], config('constants.errorCode.ok'));
            } else {
                $user = User::findOrFail($id);
                if ($user->otp == $values['otp']) {
                    $user->otp = null;
                    $user->otpFor = 'NA';
                    if ($user->update()) {
                        if ($values['otpFor'] == Config::get('constants.otpFor.register')) {
                            return response()->json(['status' => 1, 'type' => "success", 'title' => "Verify User", 'msg' => __('messages.otpVerifyMsg.success'), "payload" => ['id' => $values['id'], 'otpFor' => $values['otpFor'], 'checkBy' => $values['checkBy'], 'isUserFound' => $values['isUserFound']]], config('constants.errorCode.ok'));
                        } else {
                            if (Auth::loginUsingId($user->id)) {
                                $user = Auth::user();
                                $token = $user->createToken($user->userType . $user->id)->plainTextToken;
                                if ($token) {
                                    $data = $this->getProfileInfo($user->id, $this->platform);
                                    if ($data === false) {
                                        return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]],  config('constants.errorCode.ok'));
                                    } else {
                                        return response()->json(['status' => 1, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.loginSuccess'), "payload" => ['tokenType' => 'Bearer', 'token' => $token, 'user' => $data]], config('constants.errorCode.ok'));
                                    }
                                } else {
                                    return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.errorCode.ok'));
                                }
                            } else {
                                return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.loginErr'), 'payload' => (object)[]],  config('constants.errorCode.ok'));
                            }
                        }
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Verify User", 'msg' => __('messages.createUserMsg.failed'), "payload" =>  (object)[]], config('constants.errorCode.ok'));
                    }
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Verify User", 'msg' => __('messages.otpVerifyMsg.failed'), "payload" =>  (object)[]], config('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Verify User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function registerUser(Request $request)
    {
        $values = $request->only('id', 'checkBy', 'name', 'dialCode', 'phone', 'email', 'password', 'userType');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Register User", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'registerUser', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], config('constants.errorCode.ok'));
            } else {
                $user = User::findOrFail($id);
                if ($user->status == Config::get('constants.status.incomplete')) {
                    if ($user == null) {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Register User", 'msg' => __('messages.createUserMsg.failed'), "payload" =>  (object)[]], config('constants.errorCode.ok'));
                    } else {
                        $user->name = $values['name'];
                        $user->dialCode = $values['dialCode'];
                        $user->phone = $values['phone'];
                        $user->email = $values['email'];
                        $user->password = Hash::make($values['password']);
                        $user->userType = $values['userType'];
                        $user->status = Config::get('constants.status.active');
                        if ($user->update()) {
                            // if ($values['checkBy'] == 'phone') {
                            //     $credential = ['dialCode' => $values['dialCode'], 'phone' => $values['phone'], 'password' => $values['password']];
                            // } else {
                            //     $credential = ['email' => $values['email'], 'password' => $values['password']];
                            // }
                            // if (Auth::attempt($credential)) {
                            $token = $user->createToken($user->userType . $user->id)->plainTextToken;
                            if ($token) {
                                $data = $this->getProfileInfo($user->id, $this->platform);
                                if ($data === false) {
                                    return response()->json(['status' => 0, 'type' => "error", 'title' => "Register User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]],  config('constants.errorCode.ok'));
                                } else {
                                    return response()->json(['status' => 1, 'type' => "error", 'title' => "Register User", 'msg' => __('messages.loginSuccess'), "payload" => ['tokenType' => 'Bearer', 'token' => $token, 'user' => $data]], config('constants.errorCode.ok'));
                                }
                            } else {
                                return response()->json(['status' => 0, 'type' => "error", 'title' => "Register User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.errorCode.ok'));
                            }
                            // } else {
                            //     return response()->json(['status' => 0, 'type' => "error", 'title' => "Register User", 'msg' => __('messages.loginErr'), 'payload' => (object)[]],  config('constants.errorCode.ok'));
                            // }
                        } else {
                            return response()->json(['status' => 0, 'type' => "warning", 'title' => "Register User", 'msg' => __('messages.createUserMsg.failed'), "payload" =>  (object)[]], config('constants.errorCode.ok'));
                        }
                    }
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Register User", 'msg' => __('messages.alreadyUserCreateMsg'), "payload" =>  (object)[]], config('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Register User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function loginUser(Request $request)
    {
        $values = $request->only('checkBy', 'dialCode', 'phone', 'email', 'password');

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'loginUser', 'checkBy' => $values['checkBy'], 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                $vErrors = $this->getVErrorMessages($validator->errors());
                return response()->json(['status' => 0, 'type' => "warning", 'title' => 'Validation', 'msg' => __('messages.vErrMsg'), 'payload' => ['errors' => $vErrors]], config('constants.errorCode.ok'));
            } else {
                if ($values['checkBy'] == 'phone') {
                    $credential = ['dialCode' => $values['dialCode'], 'phone' => $values['phone'], 'password' => $values['password']];
                } else {
                    $credential = ['email' => $values['email'], 'password' => $values['password']];
                }
                if (Auth::attempt($credential)) {
                    $user = Auth::user();
                    $user = User::findOrFail($user->id);
                    $token = $user->createToken($user->userType . $user->id)->plainTextToken;
                    if ($token) {
                        $data = $this->getProfileInfo($user->id, $this->platform);
                        if ($data === false) {
                            return response()->json(['status' => 0, 'type' => "error", 'title' => "Login User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]],  config('constants.errorCode.ok'));
                        } else {
                            return response()->json(['status' => 1, 'type' => "error", 'title' => "Login User", 'msg' => __('messages.loginSuccess'), "payload" => ['tokenType' => 'Bearer', 'token' => $token, 'user' => $data]], config('constants.errorCode.ok'));
                        }
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Login User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.errorCode.ok'));
                    }
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Login User", 'msg' => __('messages.loginErr'), 'payload' => (object)[]],  config('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Login User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function logoutUser(Request $request)
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
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Login User", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function profileUser()
    {
        try {
            $user = Auth::user();
            $data = $this->getProfileInfo($user->id, $this->platform);
            if ($data === false) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.noProfileDataMsg.failed'), 'payload' => (object)[]],  config('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 1, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.noProfileDataMsg.success'), "payload" => ['user' => $data]], config('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }
}

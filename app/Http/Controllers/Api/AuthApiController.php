<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Traits\ValidationTrait;
use App\Traits\ProfileTrait;

use App\Models\User;
use App\Models\VersionControl;

use Exception;
use Illuminate\Support\Str;

class AuthApiController extends Controller
{
    use ValidationTrait, ProfileTrait;
    public $platform = 'app';


    public function checkUser(Request $request)
    {
        // try {
        $values = $request->only('dialCode', 'phone', 'email', 'checkBy');
        dd($values);
        // } catch (Exception $e) {
        //     return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        // }
    }

    public function login(Request $request)
    {
        // try {
        $values = $request->only('phone', 'password');
        $credentials = ['phone' => $values['phone'], 'password' => $values['password']];
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // $token = $user->createToken('user' . $user->id)->accessToken;
            $token = $user->createToken('user' . $user->id)->plainTextToken;
            if ($token) {
                $data = $this->getProfileInfo($user->id, $this->platform);
                if ($data === false) {
                    return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]],  config('constants.ok'));
                } else {
                    return response()->json([
                        'status' => 1,
                        'msg' => __('messages.loginSuccess'),
                        "payload" => [
                            'tokenType' => 'Bearer',
                            'token' => $token,
                            'user' => $data
                        ]
                    ], config('constants.errorCode.ok'));

                    // return response()->json([
                    //     'response_code' => 200,
                    //     'status'        => 'success',
                    //     'message'       => 'Login successful',
                    //     'user_info'     => [
                    //         'id'    => $user->id,
                    //         'name'  => $user->name,
                    //         'email' => $user->email,
                    //     ],
                    //     'token'       => $token,
                    //     'token_type'  => 'Bearer',
                    // ]);
                }
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } else {
            return response()->json(['status' => 0, 'msg' => __('messages.loginErr'), 'payload' => (object)[]],  config('constants.ok'));
        }
        // } catch (Exception $e) {
        //     return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        // }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['status' => 1, 'msg' => __('messages.logoutSuccess'), 'payload' => (object)[]], config('constants.ok'));
    }

    public function getProfile()
    {
        try {
            $user = Auth::user();
            $data = $this->getProfileInfo($user->id, $this->platform);
            if ($data === false) {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
            }
            return response()->json(['status' => 1, 'msg' => config('constants.successMsg'), 'payload' => ['user' => $data]], config('constants.ok'));
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function getAppVersion()
    {
        try {
            $versionControl = VersionControl::first();

            $data = array(
                'appVersion' => $versionControl->appVersion,
            );
            return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => $data], config('constants.ok'));
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function forgotPassword(Request $request)
    {
        //Parameter: email
        try {
            if (!$this->isValid($request->all(), 'forgotPassword', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            }

            $values = $request->only('email');
            $user = User::where('email', $values['email'])->first();

            if ($user != null) {
                if ($user->status == '0') {
                    return response()->json(['status' => 0, 'msg' => __('messages.blockMsg'), 'payload' => (object)[]], config('constants.ok'));
                } else {
                    $data = array(
                        'userId' => $user->id,
                        'email' => $user->email
                    );
                    return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => $data], config('constants.ok'));
                }
            } else {
                return response()->json(['status' => 0, 'msg' => 'This email is not registered.', 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function resetPassword(Request $request)
    {
        //Parameter: userId, password
        try {
            $values = $request->only('password', 'userId');

            if (!$this->isValid($request->all(), 'resetPassword', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            }

            $user = User::find($values['userId']);
            $user->password = Hash::make($values['password']);

            if ($user->update()) {
                return response()->json(['status' => 1, 'msg' => 'Password has been successfully reset.', 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => 'Failed to reset your password.', 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function changePassword(Request $request)
    {
        //Parameter: currentPassword, newPassword
        // try {
        $values = $request->only('oldPassword', 'newPassword');

        if (!$this->isValid($request->all(), 'changePassword', 0, $this->platform)) {
            $vErrors = $this->getVErrorMessages($this->vErrors);
            return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
        }

        if (Hash::check($values['oldPassword'], Auth::user()->password)) {
            $user = User::findOrFail(Auth::user()->id);
            $user->password = Hash::make($values['newPassword']);
            if ($user->update()) {
                return response()->json(['status' => 1, 'msg' => 'Password has been successfully change.', 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
            }
        } else {
            return response()->json(['status' => 0, 'msg' => 'Current password does not match.', 'payload' => (object)[]], config('constants.ok'));
        }
        // } catch (Exception $e) {
        //     return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        // }
    }

    public function updateDeviceToken(Request $request)
    {
        //Parameter: deviceType, deviceToken
        try {
            $values = json_decode($request->getContent());

            if (!$this->isValid($request->all(), 'updateDeviceToken', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            }

            $userInfo = Auth::user();

            $user = User::findOrFail($userInfo->id);
            $user->deviceType = $values->deviceType;
            $user->deviceToken = $values->deviceToken;
            if ($user->update()) {
                return response()->json(['status' => 1, 'msg' => 'Device token successfully updated.', 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => config('constants.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function sendOtp(Request $request)
    {
        try {
            if (!$this->isValid($request->all(), 'sendOtp', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            }

            $values = $request->only('isdCode', 'phone', 'for');
            $otp = mt_rand(1000, 9999);
            $data = array();

            if (Str::upper($values['for']) == config('constants.otpFor')['login']) {
                $user = User::where([
                    ['isdCode', $values['isdCode']],
                    ['phone', $values['phone']]
                ])->first();

                $msg = $otp . " is the OTP for verification on SAFFRON MULTICUISIN APP. Do not share this with anyone.";

                if ($user != null) {
                    // $user->address=$otp;
                    // $user->update();
                    $data = array(
                        'otp' => $otp,
                        'isRegistered' => true,
                        'msg' => 'This Number is already registered',
                    );
                } else {
                    $data = array(
                        'otp' => $otp,
                        'isRegistered' => false,
                        'msg' => 'This Number is not registered previously',
                    );
                }
                goto otp;
            }

            if (Str::upper($values['for']) == config('constants.otpFor')['delivery']) {
                $msg = $otp . " is the OTP for verification on SAFFRON MULTICUISIN APP. Do not share this with anyone.";
                $data = array(
                    'otp' => $otp,
                );
                goto otp;
            }


            otp:
            $url = config('constants.smsGateway') . 'user=' . env('SMS_GATEWAY_USER') . '&key=' . env('SMS_GATEWAY_KEY') . '&mobile=' . $values['isdCode'] . $values['phone'] . '&message=' . urlencode($msg) . '&senderid=' . env('SMS_GATEWAY_SENDER_ID') . '&accusage=' . env('SMS_GATEWAY_ACCUSAGE');
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            // Mail::to($values['email'])->send(new MailOtp($data));

            return response()->json(['status' => 1, 'msg' => __('messages.otpSuccess'), 'payload' => $data], config('constants.ok'));
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function uploadProfilePic(Request $request)
    {
        try {
            if (!$this->isValid($request->all(), 'uploadProfilePic', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            }

            $values = $request->only('image');
            $user = Auth::user();

            $image = $this->uploadPicture($values['image'], $user->image, $this->platform, 'customersPic');
            if ($image === false) {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
            }

            $user = User::findOrFail($user->id);
            $user->image = $image;

            if ($user->update()) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $values = $request->only('name', 'email');

            if (!$this->isValid($request->all(), 'updateProfile', 0, $this->platform)) {
                $vErrors = $this->getVErrorMessages($this->vErrors);
                return response()->json(['status' => 0, 'msg' => $vErrors, 'payload' => ['verrors' => $vErrors]], config('constants.vErr'));
            }

            $auth = Auth::user();

            $user = User::findOrFail($auth->id);
            $user->name = $values['name'];
            $user->email = $values['email'];

            if ($user->update()) {
                return response()->json(['status' => 1, 'msg' => __('messages.successMsg'), 'payload' => (object)[]], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg'), 'payload' => (object)[]], config('constants.serverErr'));
        }
    }
}

<?php


namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\ValidationTrait;
use App\Traits\ProfileTrait;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;
use App\Mail\MailOtp;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Carbon;

class AuthWebController extends Controller

{
    use ValidationTrait, ProfileTrait;
    public $platform = 'web';


    public function checkLogin(Request $request)
    {
        try {
            $values = $request->only('email', 'password');

            $validator = $this->isValid($request->all(), 'checkLogin', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'title' => 'Login', 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $user = User::where('email', $values['email'])->first();
                if ($user != null && $user->email_verified_at == null) {
                    $data = [
                        'email' => $user->email,
                        'id' => encrypt($user->id),
                    ];
                    return response()->json(['status' => 2, 'title' => 'Login', 'msg' => __('messages.emailNotVerify'), 'data' => $data], config('constants.ok'));
                } else if ($user != null && $user->status == config('constants.status')['0']) {
                    return response()->json(['status' => 3, 'title' => 'Login', 'msg' => __('messages.blockMsg')], config('constants.ok'));
                } else {
                    if (Auth::guard('web')->attempt([
                        'email' => $values['email'],
                        'password' => $values['password']
                    ])) {
                        return response()->json(['status' => 1, 'title' => 'Login', 'msg' => __('messages.loginSuccess')], config('constants.ok'));
                    } else {
                        return response()->json(['status' => 0, 'title' => 'Login', 'msg' => __('messages.adminLoginErr')], config('constants.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'title' => 'Login', 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function saveRegister(Request $request)
    {
        try {
            $values = $request->only('name', 'phone', 'email', 'password');
            $otp = $this->generateCode('', 6, User::class, 'otp');

            $user = User::where('email', $values['email'])->first();
            if ($user != null && $user->email_verified_at == null) {

                $user->otp = $otp;

                if ($user->update()) {
                    $data = array(
                        'id' => encrypt($user->id),
                        'otp' => $otp,
                        'email' => $user->email,
                        'name' => $user->name,
                        'msg' => "OTP"
                    );
                    Mail::to($user->email)->send(new MailOtp($data));
                    return response()->json(['status' => 1, 'title' => 'Registration', 'msg' => __('messages.emailOtpReg'), 'data' => $data], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'title' => 'Registration', 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            } else {
                $validator = $this->isValid($request->all(), 'saveRegister', 0, $this->platform);
                if ($validator->fails()) {
                    return response()->json(['status' => 0, 'title' => 'Registration', 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
                } else {
                    $user = new User;
                    $user->name = $values['name'];
                    $user->phone = $values['phone'];
                    $user->email = $values['email'];
                    $user->otp = $otp;
                    $user->password = Hash::make($values['password']);
                    $user->userType = config('constants.userType')['client'];
                    $user->uniqueId = $this->generateCode('CLI', 6, User::class, 'uniqueId');

                    if ($user->save()) {
                        $data = array(
                            'id' => encrypt($user->id),
                            'otp' => $otp,
                            'email' => $values['email'],
                            'name' => $values['name'],
                            'msg' => "OTP"
                        );
                        Mail::to($values['email'])->send(new MailOtp($data));
                        return response()->json(['status' => 1, 'title' => 'Registration', 'msg' => __('messages.registerSuccess'), 'data' => $data], config('constants.ok'));
                    } else {
                        return response()->json(['status' => 0, 'title' => 'Registration', 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'title' => 'Registration', 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function checkOtp(Request $request)
    {
        $values = $request->only('id', 'otp');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'title' => 'Check OTP', 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid($request->all(), 'checkOtp', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'title' => 'Check OTP', 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $user = User::where('id', $id)->first();
                if ($this->getDifferentBetweenTwoTimeStamp('', $user->updated_at, 'minute')['res'] >= 10) {
                    return response()->json(['status' => 2, 'title' => 'Check OTP', 'msg' => __('messages.otpSuccessTwo')], config('constants.ok'));
                } else {
                    if ($values['otp'] == $user->otp) {
                        $user->email_verified_at = Carbon::now();
                        if ($user->update()) {
                            if (Auth::loginUsingId($user->id)) {
                                return response()->json(['status' => 3, 'title' => 'Registration', 'msg' => __('messages.otpVerifySuccess')], config('constants.ok'));
                            } else {
                                return response()->json(['status' => 0, 'title' => 'Login', 'msg' => __('messages.adminLoginErr')], config('constants.ok'));
                            }
                        } else {
                            return response()->json(['status' => 0, 'title' => 'Registration', 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                        }
                        return response()->json(['status' => 1, 'title' => 'Check OTP', 'msg' => __('messages.successMsg')], config('constants.ok'));
                    } else {
                        return response()->json(['status' => 2, 'title' => 'Check OTP', 'msg' => __('messages.otpNotMatch')], config('constants.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'title' => 'Check OTP', 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function resendOtp(Request $request)
    {
        $values = $request->only('id');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'title' => 'Resend OTP', 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $otp = $this->generateCode('', 6, User::class, 'otp');
            $user = User::where('id', $id)->first();
            $user->otp = $otp;
            if ($user->update()) {
                $data = array(
                    'id' => encrypt($user->id),
                    'otp' => $otp,
                    'email' => $user->email,
                    'name' => $user->name,
                    'msg' => "OTP"
                );
                Mail::to($user->email)->send(new MailOtp($data));
                return response()->json(['status' => 1, 'title' => 'Resend OTP', 'msg' => __('messages.otpSuccess'), 'data' => $data], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'title' => 'Resend OTP', 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'title' => 'Resend OTP', 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function doLogout()
    {
        try {
            Auth::guard('web')->logout();
            return redirect()->route('web.show.home');
        } catch (Exception $e) {
            abort(500);
        }
    }
}

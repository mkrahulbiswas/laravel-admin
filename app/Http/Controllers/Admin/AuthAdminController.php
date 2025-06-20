<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Helpers\CommonHelper;
use App\Helpers\AdminRelated\RolePermission\ManageRoleHelper;
use App\Helpers\UsersRelated\ManageUsers\ManageUsersHelper;

use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\UsersRelated\ManageUsers\AdminUsers;
use App\Models\UsersRelated\UsersInfo;

use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use App\Mail\resetAuthSendMail;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class AuthAdminController extends Controller
{

    use ValidationTrait, FileTrait;
    public $platform = 'backend';


    public function showLogin()
    {
        try {
            if (!Auth::guard('admin')->check()) {
                return view('admin.auth.login');
            } else {
                return redirect()->route('admin.show.QuickOverview');
            }
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function checkLogin(Request $request)
    {
        try {
            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'checkLogin',
                'id' => 0,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $values = $request->only('phone', 'password');
                $adminUsers = AdminUsers::where('phone', $values['phone'])->first();
                if ($adminUsers == null) {
                    return response()->json(['status' => 0, 'msg' => __('messages.adminLoginErr')], Config::get('constants.errorCode.ok'));
                } else {
                    if ($adminUsers->status == 0) {
                        return response()->json(['status' => 0, 'msg' => 'You are blocked by admin'], Config::get('constants.errorCode.ok'));
                    } else {
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
                        ]);
                        if ($mainRole == false) {
                            return response()->json(['status' => 0, 'msg' => 'Oops! we could not detect your role (main), please contact with administrator.'], Config::get('constants.errorCode.ok'));
                        } else {
                            $mainRole = $mainRole[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                            if ($mainRole['extraData']['hasSubRole'] > 0) {
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
                                ]);
                                if ($subRole == false) {
                                    return response()->json(['status' => 0, 'msg' => 'Oops! we could not detect your role (sub), please contact with administrator.'], Config::get('constants.errorCode.ok'));
                                } else {
                                    goto login;
                                }
                            } else {
                                goto login;
                            }

                            login:
                            if (Auth::guard('admin')->attempt(['phone' => $values['phone'], 'password' => $values['password']])) {
                                return response()->json(['status' => 1, 'msg' => __('messages.successMsg')], Config::get('constants.errorCode.ok'));
                            } else {
                                return response()->json(['status' => 0, 'msg' => __('messages.adminLoginErr')], Config::get('constants.errorCode.ok'));
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function saveForgotPassword(Request $request)
    {
        try {
            $values = $request->only('email');

            $validator = $this->isValid($request->all(), 'saveForgotPassword', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $otp = rand(100000, 999999);
                $admin = AdminUsers::where('email', $values['email'])->first();
                if ($admin == null) {
                    return response()->json(['status' => 0, 'msg' => 'Email not found, please check it again.'], Config::get('constants.errorCode.ok'));
                } else {
                    $admin->otp = $otp;
                    if ($admin->update()) {
                        $name = $admin->name;
                        $data = array('name' => $name, 'otp' => $otp);

                        if (Mail::to($values['email'])->send(new ForgotPassword($data)) == false) {
                            return response()->json(['status' => 1, 'msg' => 'OTP is send to your email, please check it.'], Config::get('constants.errorCode.ok'));
                        } else {
                            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
                        }
                    } else {
                        return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateResetPassword(Request $request)
    {
        try {
            $values = $request->only('otp', 'password', 'confirmPassword');

            $validator = $this->isValid($request->all(), 'updateResetPassword', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $admin = AdminUsers::where('otp', $values['otp'])->first();
                if ($admin == null) {
                    return response()->json(['status' => 0, 'msg' => 'OTP does\'t match.'], Config::get('constants.errorCode.ok'));
                } else {
                    $admin->otp = null;
                    $admin->password = Hash::make($values['confirmPassword']);
                    if ($admin->update()) {
                        return response()->json(['status' => 1, 'msg' => 'Password Changed Successfully'], Config::get('constants.errorCode.ok'));
                    } else {
                        return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }




    // public function changePasswordLogin(Request $request)
    // {
    //     $values = $request->only('id', 'password', 'password_confirmation');
    //     $id = decrypt($values['id']);

    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'password' => 'required|min:6|max:20|confirmed',
    //         ],
    //         [
    //             'password.required' => 'This field is required.',
    //             'password.min' => 'Password should be minimum 6 characters.',
    //             'password.max' => 'Password should be maximum 20 characters.'
    //         ]
    //     );

    //     if ($validator->fails()) {
    //         return view('admin.auth.change_password', ['id' => $id])->withErrors($validator);
    //         //return redirect('/admin/changePassword')->withErrors($validator);
    //     } else {
    //         $admin = AdminUsers::findOrFail($id);
    //         $admin->password = Hash::make($values['password']);
    //         $admin->isPwChange = '1';
    //         if ($admin->update()) {
    //             Auth::guard('admin')->loginUsingId($id);
    //             return redirect('admin/dashboard');
    //         } else {
    //             return redirect('/admin/changePassword')->with('loginErr', 'Something went wrong a.');
    //         }
    //     }
    // }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }


    /*------- ( Profile ) -------*/
    public function showAuthProfile()
    {
        try {
            $adminUsers = ManageUsersHelper::getDetail([
                [
                    'getDetail' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                        'for' => Config::get('constants.typeCheck.manageUsers.adminUsers.type'),
                    ],
                    'otherDataPasses' => [
                        'id' => encrypt(Auth::guard('admin')->user()->id)
                    ]
                ],
            ])[Config::get('constants.typeCheck.manageUsers.adminUsers.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];

            $data = [
                'detail' => $adminUsers
            ];

            return view('admin.auth.profile.show_profile', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function editAuthProfile()
    {
        try {
            $adminUsers = ManageUsersHelper::getDetail([
                [
                    'getDetail' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                        'for' => Config::get('constants.typeCheck.manageUsers.adminUsers.type'),
                    ],
                    'otherDataPasses' => [
                        'id' => encrypt(Auth::guard('admin')->user()->id)
                    ]
                ],
            ])[Config::get('constants.typeCheck.manageUsers.adminUsers.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];

            $data = [
                'detail' => $adminUsers
            ];

            return view('admin.auth.profile.edit_profile', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateAuthProfile(Request $request)
    {
        DB::beginTransaction();
        $values = $request->only('id', 'name', 'about', 'pinCode', 'state', 'country', 'address');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateAuthProfile', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $adminUsers = AdminUsers::find($id);
                $adminUsers->name = $values['name'];
                if ($adminUsers->update()) {
                    $usersInfo = UsersInfo::where([
                        ['userId', $adminUsers->id],
                        ['userType', Config::get('constants.userType.admin')],
                    ])->first();
                    $usersInfo->pinCode = $values['pinCode'];
                    $usersInfo->state = $values['state'];
                    $usersInfo->country = $values['country'];
                    $usersInfo->about = $values['about'];
                    $usersInfo->address = $values['address'];
                    if ($usersInfo->update()) {
                        DB::commit();
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update", 'msg' => __('messages.updateMsg', ['type' => 'Profile'])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        DB::rollback();
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update", 'msg' => __('messages.updateMsg', ['type' => 'Profile'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    DB::rollback();
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update", 'msg' => __('messages.updateMsg', ['type' => 'Profile'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function changeAuthPassword(Request $request)
    {
        $values = $request->only('id', 'oldPassword', 'newPassword', 'confirmPassword');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'changeAuthPassword', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $adminUsers = AdminUsers::find($id);
                if (Hash::check($values['oldPassword'], Auth::guard('admin')->user()->password)) {
                    $adminUsers->password = Hash::make($values['newPassword']);
                    if ($adminUsers->update()) {
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Change", 'msg' => __('messages.changeMsg', ['type' => 'Password'])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Change", 'msg' => __('messages.changeMsg', ['type' => 'Password'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    return Response()->Json(['status' => 2, 'type' => "warning", 'title' => "Change", 'msg' => __('messages.oldPassPinNotMatchMsg', ['type' => 'Password'])], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Change", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function changeAuthImage(Request $request)
    {
        $values = $request->only('id', 'for');
        $file = $request->file('file');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'changeAuthImage', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $adminUsers = AdminUsers::find($id);
                if ($file) {
                    $uploadFile = $this->uploadFile([
                        'file' => ['current' => $file, 'previous' => $adminUsers->image],
                        'platform' => $this->platform,
                        'storage' => Config::get('constants.storage')['adminUsers']
                    ]);
                    if ($uploadFile['type'] == false) {
                        return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => $uploadFile['msg']], Config::get('constants.errorCode.ok'));
                    } else {
                        $adminUsers->image = $uploadFile['name'];
                    }
                }
                if ($adminUsers->update()) {
                    $getFile = FileTrait::getFile([
                        'fileName' => AdminUsers::where('id', $id)->first()->image,
                        'storage' => Config::get('constants.storage')['adminUsers']
                    ])['public']['fullPath']['asset'];
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Change", 'data' => ['image' => $getFile], 'msg' => __('messages.changeMsg', ['type' => 'Profile pic'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Change", 'msg' => __('messages.changeMsg', ['type' => 'Profile pic'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Change", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function changeAuthPin(Request $request)
    {
        $values = $request->only('id', 'oldPin', 'newPin', 'confirmPin');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'changeAuthPin', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                if (Hash::check($values['oldPin'], Auth::guard('admin')->user()->pin)) {
                    $adminUsers = AdminUsers::find($id);
                    $adminUsers->pin = Hash::make($values['newPin']);
                    if ($adminUsers->update()) {
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Change", 'msg' => __('messages.changeMsg', ['type' => 'PIN'])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Change", 'msg' => __('messages.changeMsg', ['type' => 'PIN'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    return Response()->Json(['status' => 2, 'type' => "warning", 'title' => "Change", 'msg' => __('messages.oldPassPinNotMatchMsg', ['type' => 'Password'])], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Change", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function changeAuthSend(Request $request)
    {
        $values = $request->only('id', 'type', 'email', 'phone');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'changeAuthSend', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                if ($values['type'] == 'email') {
                    $otp = $this->generateYourChoice([
                        [
                            'length' => 6,
                            'type' => Config::get('constants.generateType.number')
                        ]
                    ])[Config::get('constants.generateType.number')]['result'];
                    if ($values['type'] == 'phone') {
                        // $alertType = 'ALTY-756816';
                        // $alertFor = 'ALFO-237854';
                        $alertType = 'ALTY-894165';
                        $alertFor = 'ALFO-471078';
                    } else {
                        $alertType = 'ALTY-894165';
                        $alertFor = 'ALFO-471078';
                    }
                    $adminUsers = AdminUsers::where('id', $id)->first();
                    $adminUsers->otp = $otp;
                    $adminUsers->otpVerifiedAt = null;
                    $adminUsers->otpVerifiedType = Str::upper($values['type']);
                    if ($adminUsers->update()) {
                        $replaceVariableWithValue = CommonHelper::replaceVariableWithValue([
                            'replaceData' => [
                                ['key' => '[~otp~]', 'value' => $otp],
                                ['key' => '[~name~]', 'value' => $adminUsers->name],
                            ],
                            'alertType' => $alertType,
                            'alertFor' => $alertFor,
                        ]);
                        $data = array(
                            'subject' => $replaceVariableWithValue['heading'],
                            'content' => $replaceVariableWithValue['content'],
                        );
                        Mail::to([$adminUsers->email, $values['email']])->send(new resetAuthSendMail($data));
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "OTP", 'msg' => __('messages.otpMsg')['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "OTP", 'msg' => __('messages.otpMsg')['failed']], Config::get('constants.errorCode.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "OTP", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function changeAuthVerify(Request $request)
    {
        $values = $request->only('id', 'type', 'otp');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'changeAuthVerify', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $adminUsers = AdminUsers::where('id', $id)->first();
                if ($adminUsers->otpVerifiedType == Str::upper($values['type'])) {
                    if ($adminUsers->otp == $values['otp']) {
                        $adminUsers->isOtpVerified = date('d-m-y H:m:s');
                        if ($adminUsers->update()) {
                            return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Verification", 'msg' => __('messages.otpVerifyMsg')['success']], Config::get('constants.errorCode.ok'));
                        } else {
                            return Response()->Json(['status' => 0, 'type' => "success", 'title' => "Verification", 'msg' => __('messages.otpVerifyMsg')['failed']], Config::get('constants.errorCode.ok'));
                        }
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Verification", 'msg' => __('messages.otpNotMatchMsg')], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Verification", 'msg' => __('messages.otpNotTypeMsg')], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Verification", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function resetAuthSend(Request $request)
    {
        $values = $request->only('id', 'type');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $otp = $this->generateYourChoice([
                [
                    'length' => 6,
                    'type' => Config::get('constants.generateType.number')
                ]
            ])[Config::get('constants.generateType.number')]['result'];
            if ($values['type'] == 'pin') {
                $alertFor = 'ALFO-799299';
            } else {
                $alertFor = 'ALFO-928865';
            }
            $adminUsers = AdminUsers::where('id', $id)->first();
            $adminUsers->otp = $otp;
            $adminUsers->otpVerifiedAt = null;
            $adminUsers->otpVerifiedType = Str::upper($values['type']);
            if ($adminUsers->update()) {
                $replaceVariableWithValue = CommonHelper::replaceVariableWithValue([
                    'replaceData' => [
                        ['key' => '[~otp~]', 'value' => $otp],
                        ['key' => '[~name~]', 'value' => $adminUsers->name],
                    ],
                    'alertType' => 'ALTY-894165',
                    'alertFor' => $alertFor,
                ]);
                $data = array(
                    'subject' => $replaceVariableWithValue['heading'],
                    'content' => $replaceVariableWithValue['content'],
                );
                Mail::to($adminUsers->email)->send(new resetAuthSendMail($data));
                return Response()->Json(['status' => 1, 'type' => "success", 'title' => "OTP", 'msg' => __('messages.otpMsg')['success']], Config::get('constants.errorCode.ok'));
            } else {
                return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "OTP", 'msg' => __('messages.otpMsg')['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "OTP", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function resetAuthVerify(Request $request)
    {
        $values = $request->only('id', 'type', 'otp');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'resetAuthVerify', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $adminUsers = AdminUsers::where('id', $id)->first();
                if ($adminUsers->otpVerifiedType == Str::upper($values['type'])) {
                    if ($adminUsers->otp == $values['otp']) {
                        $adminUsers->isOtpVerified = date('d-m-y H:m:s');
                        if ($adminUsers->update()) {
                            return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Verification", 'msg' => __('messages.otpVerifyMsg')['success']], Config::get('constants.errorCode.ok'));
                        } else {
                            return Response()->Json(['status' => 0, 'type' => "success", 'title' => "Verification", 'msg' => __('messages.otpVerifyMsg')['failed']], Config::get('constants.errorCode.ok'));
                        }
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Verification", 'msg' => __('messages.otpNotMatchMsg')], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Verification", 'msg' => __('messages.otpNotTypeMsg')], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Verification", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function resetAuthUpdate(Request $request)
    {
        $values = $request->only('id', 'type', 'newPin', 'confirmPin', 'newPassword', 'confirmPassword');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Profile", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => (($values['type'] == 'pin') ? 'resetAuthPin' : 'resetAuthPassword'), 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $adminUsers = AdminUsers::where('id', $id)->first();
                if ($adminUsers->isOtpVerified != null) {
                    $adminUsers->otpVerifiedAt = null;
                    $adminUsers->otpVerifiedType = 'NA';
                    if ($values['type'] == 'pin') {
                        $adminUsers->pin = Hash::make($values['newPin']);
                    } else {
                        $adminUsers->password = Hash::make($values['newPassword']);
                    }
                    if ($adminUsers->update()) {
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Verification", 'msg' => __('messages.resetMsg', ['type' => $values['type']])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Verification", 'msg' => __('messages.resetMsg', ['type' => $values['type']])['failed']], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    return Response()->Json(['status' => 2, 'type' => "warning", 'title' => "Verification", 'msg' => __('messages.otpNotVerifiedMsg')], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Verification", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }
}

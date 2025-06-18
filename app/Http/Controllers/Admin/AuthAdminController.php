<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Helpers\AdminRelated\RolePermission\ManageRoleHelper;
use App\Helpers\UsersRelated\ManageUsers\ManageUsersHelper;

use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\User;
use App\Models\UsersRelated\ManageUsers\AdminUsers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Config;

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
    public function showProfile()
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
            // dd($data);
            return view('admin.auth.profile.show_profile', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }
    public function editProfile()
    {
        try {
            return view('admin.auth.profile.edit_profile');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateProfile(Request $request)
    {
        DB::beginTransaction();
        try {
            $values = $request->only('address', 'name', 'email', 'phone', 'orgName', 'orgAddress', 'orgEmail', 'orgPhone');
            $file = $request->file('file');

            $admin = AdminUsers::find(Auth::guard('admin')->id());

            $validator = $this->isValid($request->all(), 'updateProfile', $admin->id, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            }


            if ($file) {
                $imgType = 'adminPic';
                $previousImg = $admin->profilePic;
                $image = $this->uploadPicture($file, $previousImg, $this->platform, $imgType);
                if ($image === false) {
                    return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update Profile", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
                }
            }

            $admin->name = $values['name'];
            $admin->email = $values['email'];
            $admin->phone = $values['phone'];
            $admin->orgName = $values['orgName'];
            $admin->orgAddress = $values['orgAddress'];
            $admin->orgEmail = $values['orgEmail'];
            $admin->orgPhone = $values['orgPhone'];
            if ($file) {
                $admin->profilePic = $image;
            }
            if ($admin->update()) {
                $user = User::where('id', $admin->id)->first();
                $user->name = $values['name'];
                $user->email = $values['email'];
                $user->phone = $values['phone'];
                $user->update();

                DB::commit();
                return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update Profile", 'msg' => 'Profile successfully update.'], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Helpers\GetManageAccessHelper;

use App\Models\User;
use App\Models\ManageUsers\AdminUsers;
use App\Models\ManagePanel\ManageAccess\RoleMain;
use App\Models\ManagePanel\ManageAccess\RoleSub;

use Validator;
use Exception;
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
                return response()->json(['status' => 0, 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $values = $request->only('phone', 'password');
                $adminUsers = AdminUsers::where('phone', $values['phone'])->first();
                if ($adminUsers == null) {
                    return response()->json(['status' => 0, 'msg' => __('messages.adminLoginErr')], config('constants.ok'));
                } else {
                    if ($adminUsers->status == 0) {
                        return response()->json(['status' => 0, 'msg' => 'You are blocked by admin'], config('constants.ok'));
                    } else {
                        $roleMain = GetManageAccessHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'for' => Config::get('constants.typeCheck.manageAccess.roleMain.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($adminUsers->roleMainId)
                                ]
                            ],
                        ]);
                        if ($roleMain == false) {
                            return response()->json(['status' => 0, 'msg' => 'Oops! we could not detect your role (main), please contact with administrator.'], config('constants.ok'));
                        } else {
                            $roleMain = $roleMain[Config::get('constants.typeCheck.manageAccess.roleMain.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                            if ($roleMain['extraData']['hasRoleSub'] > 0) {
                                $roleSub = GetManageAccessHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($adminUsers->roleSubId)
                                        ]
                                    ],
                                ]);
                                if ($roleSub == false) {
                                    return response()->json(['status' => 0, 'msg' => 'Oops! we could not detect your role (sub), please contact with administrator.'], config('constants.ok'));
                                } else {
                                    goto login;
                                }
                            } else {
                                goto login;
                            }

                            login:
                            if (Auth::guard('admin')->attempt(['phone' => $values['phone'], 'password' => $values['password']])) {
                                return response()->json(['status' => 1, 'msg' => __('messages.successMsg')], config('constants.ok'));
                            } else {
                                return response()->json(['status' => 0, 'msg' => __('messages.adminLoginErr')], config('constants.ok'));
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function saveForgotPassword(Request $request)
    {
        try {
            $values = $request->only('email');

            $validator = $this->isValid($request->all(), 'saveForgotPassword', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $otp = rand(100000, 999999);
                $admin = AdminUsers::where('email', $values['email'])->first();
                if ($admin == null) {
                    return response()->json(['status' => 0, 'msg' => 'Email not found, please check it again.'], config('constants.ok'));
                } else {
                    $admin->otp = $otp;
                    if ($admin->update()) {
                        $name = $admin->name;
                        $data = array('name' => $name, 'otp' => $otp);

                        if (Mail::to($values['email'])->send(new ForgotPassword($data)) == false) {
                            return response()->json(['status' => 1, 'msg' => 'OTP is send to your email, please check it.'], config('constants.ok'));
                        } else {
                            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                        }
                    } else {
                        return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateResetPassword(Request $request)
    {
        try {
            $values = $request->only('otp', 'password', 'confirmPassword');

            $validator = $this->isValid($request->all(), 'updateResetPassword', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $admin = AdminUsers::where('otp', $values['otp'])->first();
                if ($admin == null) {
                    return response()->json(['status' => 0, 'msg' => 'OTP does\'t match.'], config('constants.ok'));
                } else {
                    $admin->otp = null;
                    $admin->password = Hash::make($values['confirmPassword']);
                    if ($admin->update()) {
                        return response()->json(['status' => 1, 'msg' => 'Password Changed Successfully'], config('constants.ok'));
                    } else {
                        return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }




    public function changePasswordLogin(Request $request)
    {
        $values = $request->only('id', 'password', 'password_confirmation');
        $id = decrypt($values['id']);

        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|min:6|max:20|confirmed',
            ],
            [
                'password.required' => 'This field is required.',
                'password.min' => 'Password should be minimum 6 characters.',
                'password.max' => 'Password should be maximum 20 characters.'
            ]
        );

        if ($validator->fails()) {
            return view('admin.auth.change_password', ['id' => $id])->withErrors($validator);
            //return redirect('/admin/changePassword')->withErrors($validator);
        } else {
            $admin = AdminUsers::findOrFail($id);
            $admin->password = Hash::make($values['password']);
            $admin->isPwChange = '1';
            if ($admin->update()) {
                Auth::guard('admin')->loginUsingId($id);
                return redirect('admin/dashboard');
            } else {
                return redirect('/admin/changePassword')->with('loginErr', 'Something went wrong a.');
            }
        }
    }

    public function showChangePassword()
    {
        return view('admin.auth.passwordChange');
    }

    public function updatePassword(Request $request)
    {
        $values = $request->only('currentPassword', 'password');
        $validator = $this->isValid($request->all(), 'changePassword', 0, $this->platform);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Validation error occurs.');
        }

        if (Hash::check($values['currentPassword'], Auth::guard('admin')->user()->password)) {
            $user = AdminUsers::find(Auth::guard('admin')->user()->id);
            $user->password = Hash::make($values['password']);
            if ($user->update()) {
                return redirect()->back()->with('success', 'Password successfully changed.');
            } else {
                return redirect()->back()->with('error', 'Failed to change Password.');
            }
        } else {
            return redirect()->back()->with('error', 'Current password does not match.');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }


    public function showProfile()
    {
        try {
            $admin = AdminUsers::where('id', Auth::guard('admin')->user()->id)->first();
            $data = array(
                'id' => encrypt($admin->id),
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
                'address' => $admin->address,
                'orgName' => $admin->orgName,
                'orgAddress' => $admin->orgAddress,
                'orgEmail' => $admin->orgEmail,
                'orgPhone' => $admin->orgPhone,
                'image' => $this->picUrl($admin->profilePic, 'adminPic', $this->platform),
            );
            return view('admin.auth.profileChange', ['data' => $data]);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
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
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            }


            if ($file) {
                $imgType = 'adminPic';
                $previousImg = $admin->profilePic;
                $image = $this->uploadPicture($file, $previousImg, $this->platform, $imgType);
                if ($image === false) {
                    return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update Profile", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
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
                return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update Profile", 'msg' => 'Profile successfully update.'], config('constants.ok'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }
}

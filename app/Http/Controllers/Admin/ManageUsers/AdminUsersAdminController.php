<?php

namespace App\Http\Controllers\Admin\ManageUsers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use App\Models\ManagePanel\ManageAccess\RoleMain;

use App\Helpers\GetManageAccessHelper;
use App\Models\ManageUsers\AdminUsers;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;

class AdminUsersAdminController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Admin Users ) ----*/
    public function showAdminUsers()
    {
        try {
            $roleMain = GetManageAccessHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageAccess.roleMain.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                        ],
                    ],
                ],
            ]);

            $data = [
                'roleMain' => $roleMain[Config::get('constants.typeCheck.manageAccess.roleMain.type')],
            ];

            return view('admin.manage_users.admin_users.admin_users_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getAdminUsers(Request $request)
    {
        try {
            $roleMain = GetManageAccessHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageAccess.roleMain.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'uniqueId' => Config::get('constants.superAdminCheck')['roleMain'],
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.manageAccess.roleMain.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $getPrivilege = GetManageAccessHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($roleMain)
                ->addIndexColumn()
                ->addColumn('description', function ($data) {
                    $description = $this->subStrString(40, $data['description'], '....');
                    return $description;
                })
                ->addColumn('uniqueId', function ($data) {
                    $uniqueId = $data['uniqueId']['raw'];
                    return $uniqueId;
                })
                ->addColumn('statInfo', function ($data) {
                    $statInfo = $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtMultiData',
                            'data' => $data['customizeInText']
                        ]
                    ])['dtMultiData']['custom'];
                    return $statInfo;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['status'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.roleMain') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.roleMain') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
                        }
                    } else {
                        $status = '';
                    }

                    if ($getPrivilege['edit']['permission'] == true) {
                        $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Update"><i class="las la-edit"></i></a>';
                    } else {
                        $edit = '';
                    }

                    if ($getPrivilege['delete']['permission'] == true) {
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.roleMain') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($getPrivilege['info']['permission'] == true) {
                        $info = '<a href="JavaScript:void(0);" data-type="info" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Info" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    } else {
                        $info = '';
                    }

                    if ($getPrivilege['permission']['permission'] == true) {
                        if ($data['extraData']['hasRoleSub'] <= 0) {
                            $access = '<a href="' .  route('admin.show.permissionRoleMain') . '/' .  $data['id'] . '" data-type="permission" title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
                        } else {
                            $access = '<a href="JavaScript:void(0);" data-type="permission" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
                        }
                    } else {
                        $access = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete, $info],
                                'secondary' => [$access],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['description', 'uniqueId', 'statInfo', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function addAdminUsers()
    {
        try {
            $roleMain = GetManageAccessHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageAccess.roleMain.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'uniqueId' => Config::get('constants.superAdminCheck')['roleMain'],
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.manageAccess.roleMain.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $data = [
                'roleMain' => $roleMain,
            ];

            return view('admin.manage_users.admin_users.admin_users_add', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function saveAdminUsers(Request $request)
    {
        try {
            DB::beginTransaction();
            $values = $request->only('name', 'email', 'phone', 'roleMain', 'roleSub', 'pinCode', 'state', 'country', 'address', 'about');
            $file = $request->file('file');

            //--Checking The Validation--//
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveAdminUsers', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                // if ($file) {
                //     $profilePic = $this->uploadPicture($file, '', $this->platform, 'adminPic');
                //     if ($profilePic === false) {
                //         return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                //     }
                // }

                $user = new AdminUsers();
                $user->userType = config('constants.userType')['subAdmin'];
                $user->uniqueId = $this->generateCode('ADM', 6, User::class, 'uniqueId');
                $user->name = $values['name'];
                $user->email = $values['email'];
                $user->phone = $values['phone'];
                $user->address = ($values['address'] == '') ? 'NA' : $values['address'];
                $user->password = Hash::make($values['password']);
                if ($file) {
                    $user->image = $profilePic;
                }

                if ($user->save()) {
                    DB::commit();
                    $admin = new Admin;
                    $admin->id = $user->id;
                    $admin->name = $values['name'];
                    $admin->email = $values['email'];
                    $admin->phone = $values['phone'];
                    $admin->role_id = ($values['role'] == '') ? null : decrypt($values['role']);
                    $admin->address = ($values['address'] == '') ? 'NA' : $values['address'];
                    $admin->password = Hash::make($values['password']);
                    if ($file) {
                        $admin->profilePic = $profilePic;
                    }
                    if ($admin->save()) {
                        DB::commit();
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Add Sub Admin", 'msg' => 'Sub Admin Successfully saved.'], config('constants.ok'));
                    } else {
                        DB::rollback();
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Add Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                    }
                } else {
                    DB::rollback();
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Add Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Add Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function editAdminUsers($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $data =  $role = array();
            foreach (Role::whereNotIn('id', [1])->where('adminId', Auth::guard('admin')->user()->id)->get() as $temp) {
                $role[] = array(
                    'id' => encrypt($temp->id),
                    'role' => $temp->role,
                    'adminId' => Auth::guard('admin')->user()->id,
                );
            }
            $admin = Admin::where('id', $id)->first();
            $data = array(
                'role' => $role,
                'id' => encrypt($admin->id),
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
                'address' => $admin->address,
                'roleId' => $admin->role_id,
                'restaurantId' => $admin->restaurantId,
                'image' => $this->picUrl($admin->profilePic, 'adminPic', $this->platform),
            );
            return view('admin.users.admin.edit_admin', ['data' => $data]);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function updateAdminUsers(Request $request)
    {
        $values = $request->only('id', 'name', 'email', 'phone', 'address', 'role');
        $file = $request->file('file');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $admin = Admin::findOrFail($id);
            $user = User::findOrFail($id);

            $validator = $this->isValid($request->all(), 'updateAdmin', $id, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                if ($file) {
                    $image = $this->uploadPicture($file, $admin->profilePic, $this->platform, 'adminPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    }
                }

                $user->name = $values['name'];
                $user->email = $values['email'];
                $user->phone = $values['phone'];
                $user->address = $values['address'];

                if ($file) {
                    $user->image = $image;
                }

                if ($user->update()) {
                    $admin->name = $values['name'];
                    $admin->email = $values['email'];
                    $admin->phone = $values['phone'];
                    $admin->address = $values['address'];
                    $admin->role_id = decrypt($values['role']);
                    // $admin->password = $values['address'];

                    if ($file) {
                        $admin->profilePic = $image;
                    }

                    if ($admin->update()) {
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update Sub Admin", 'msg' => 'Sub Admin successfully update.'], config('constants.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                    }
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusAdminUsers($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => RoleMain::class,
                'targetField' => [],
                'type' => Config::get('constants.actionFor.statusType.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Role Main'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Role Main'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deletAdminUsers($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => RoleMain::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Role Main'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Role Main'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }
}

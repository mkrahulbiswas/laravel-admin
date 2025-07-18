<?php

namespace App\Http\Controllers\Admin\UsersRelated\ManageUsers;

use App\Http\Controllers\Controller;

use App\Helpers\AdminRelated\RolePermission\ManagePermissionHelper;
use App\Helpers\AdminRelated\RolePermission\ManageRoleHelper;
use App\Helpers\CommonHelper;
use App\Helpers\UsersRelated\ManageUsers\ManageUsersHelper;

use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use App\Models\UsersRelated\UsersInfo;
use App\Models\UsersRelated\ManageUsers\AdminUsers;
use App\Models\AdminRelated\RolePermission\ManageRole\MainRole;

use Illuminate\Support\Facades\Mail;
use App\Mail\ManageUsers\AdminUsersWelcomeMail;

use Exception;
use Throwable;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;

class AdminUsersAdminController extends Controller
{

    use ValidationTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Admin Users ) ----*/
    public function showAdminUsers()
    {
        try {
            $mainRole = ManageRoleHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $data = [
                'mainRole' => $mainRole,
            ];

            return view('admin.manage_users.admin_users.admin_users_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getAdminUsers(Request $request)
    {
        try {
            $adminUsers = ManageUsersHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.usersRelated.manageUsers.adminUsers.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'mainRoleId' => $request->mainRole,
                            'subRoleId' => $request->subRole,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.usersRelated.manageUsers.adminUsers.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($adminUsers)
                ->addIndexColumn()
                ->addColumn('role', function ($data) {
                    if ($data['subRole'] == []) {
                        $role = $data['mainRole']['name'];
                    } else {
                        $role = $data['subRole']['name'];
                    }
                    return $role;
                })
                ->addColumn('uniqueId', function ($data) {
                    $uniqueId = $data['uniqueId']['raw'];
                    return $uniqueId;
                })
                ->addColumn('image', function ($data) {
                    $image = '<img src="' . $data['getFile']['public']['fullPath']['asset'] . '" class="img-fluid rounded" width="100"/>';
                    return $image;
                })
                ->addColumn('status', function ($data) {
                    $status = $data['customizeInText']['status']['custom'];
                    return $status;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['status'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.adminUsers') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.adminUsers') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
                        }
                    } else {
                        $status = '';
                    }

                    if ($getPrivilege['edit']['permission'] == true) {
                        $edit = '<a href="' . route('admin.edit.adminUsers') . '/' . $data['id'] . '" data-type="edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Edit"><i class="las la-edit"></i></a>';
                    } else {
                        $edit = '';
                    }

                    if ($getPrivilege['delete']['permission'] == true) {
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.adminUsers') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($getPrivilege['edit']['permission'] == true) {
                        $detail = '<a href="' . route('admin.detail.adminUsers') . '/' . $data['id'] . '" target="_blank" data-type="edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Detail"><i class="mdi mdi-eye"></i></a>';
                    } else {
                        $detail = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete, $detail],
                                'secondary' => [],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['uniqueId', 'status', 'image', 'role', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function addAdminUsers()
    {
        try {
            $mainRole = ManageRoleHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'uniqueId' => Config::get('constants.superAdminCheck')['mainRole'],
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $data = [
                'mainRole' => $mainRole,
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
            $values = $request->only('name', 'email', 'phone', 'mainRole', 'subRole', 'pinCode', 'state', 'country', 'address', 'about');
            $file = $request->file('file');
            $password = CommonTrait::generateYourChoice([
                [
                    'length' => 8,
                    'type' => Config::get('constants.generateType.alpNum')
                ]
            ])[Config::get('constants.generateType.alpNum')]['result'];

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveAdminUsers', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                if (MainRole::where('id', decrypt($values['mainRole']))->first()->uniqueId == Config::get('constants.superAdminCheck')['mainRole']) {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save", 'msg' => __('messages.notAllowMsg')], Config::get('constants.errorCode.ok'));
                } else {
                    if ($file) {
                        $uploadFile = $this->uploadFile([
                            'file' => ['current' => $file, 'previous' => ''],
                            'platform' => $this->platform,
                            'storage' => Config::get('constants.storage')['adminUsers']
                        ]);
                        if ($uploadFile['type'] == false) {
                            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => $uploadFile['msg']], Config::get('constants.errorCode.ok'));
                        } else {
                            $fileName = $uploadFile['name'];
                        }
                    } else {
                        $fileName = 'NA';
                    }
                    $adminUsers = new AdminUsers();
                    $adminUsers->uniqueId = $this->generateYourChoice([
                        [
                            'preString' => 'AU',
                            'length' => 6,
                            'model' => AdminUsers::class,
                            'field' => '',
                            'type' => Config::get('constants.generateType.uniqueId')
                        ]
                    ])[Config::get('constants.generateType.uniqueId')]['result'];
                    $adminUsers->name = $values['name'];
                    $adminUsers->email = $values['email'];
                    $adminUsers->phone = $values['phone'];
                    $adminUsers->status = Config::get('constants.status')['active'];
                    $adminUsers->mainRoleId = decrypt($values['mainRole']);
                    if ($values['subRole'] != '') {
                        $adminUsers->subRoleId = decrypt($values['subRole']);
                    }
                    $adminUsers->password = Hash::make($password);
                    $adminUsers->pin = Hash::make($password);
                    if ($file) {
                        $adminUsers->image = $fileName;
                    }
                    if ($adminUsers->save()) {
                        $usersInfo = new UsersInfo();
                        $usersInfo->userId = $adminUsers->id;
                        $usersInfo->pinCode = $values['pinCode'];
                        $usersInfo->state = $values['state'];
                        $usersInfo->country = $values['country'];
                        $usersInfo->address = $values['address'];
                        $usersInfo->userType = Config::get('constants.userType')['admin'];
                        $usersInfo->about = ($values['about'] == '') ? 'NA' : $values['about'];
                        if ($usersInfo->save()) {
                            try {
                                $replaceVariableWithValue = CommonHelper::replaceVariableWithValue([
                                    'replaceData' => [
                                        ['key' => '[~password~]', 'value' => $password],
                                        ['key' => '[~phone~]', 'value' => $values['phone']],
                                        ['key' => '[~name~]', 'value' => $values['name']],
                                    ],
                                    'alertType' => 'ALTY-894165',
                                    'alertFor' => 'ALFO-580923',
                                ]);

                                $data = array(
                                    'subject' => $replaceVariableWithValue['heading'],
                                    'content' => $replaceVariableWithValue['content'],
                                    'name' => $values['name'],
                                    'phone' => $values['phone'],
                                    'password' => $password
                                );

                                Mail::to($values['email'])->send(new AdminUsersWelcomeMail($data));
                                DB::commit();
                                return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Save", 'msg' => __('messages.saveMsg', ['type' => 'Admin Users'])['success']], Config::get('constants.errorCode.ok'));
                            } catch (Throwable $th) {
                                DB::rollback();
                                return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
                            }
                        } else {
                            DB::rollback();
                            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save", 'msg' => __('messages.saveMsg', ['type' => 'Admin Users'])['failed']], Config::get('constants.errorCode.ok'));
                        }
                    } else {
                        DB::rollback();
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save", 'msg' => __('messages.saveMsg', ['type' => 'Admin Users'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Save", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }
    }

    public function editAdminUsers($id)
    {
        try {
            $mainRole = ManageRoleHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'uniqueId' => Config::get('constants.superAdminCheck')['mainRole'],
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $adminUsers = ManageUsersHelper::getDetail([
                [
                    'getDetail' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                        'for' => Config::get('constants.typeCheck.usersRelated.manageUsers.adminUsers.type'),
                    ],
                    'otherDataPasses' => [
                        'id' => $id
                    ]
                ],
            ])[Config::get('constants.typeCheck.usersRelated.manageUsers.adminUsers.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];

            $subRole = ManageRoleHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'mainRoleId' => $adminUsers['mainRole']['id']
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $data = [
                'mainRole' => $mainRole,
                'subRole' => $subRole,
                'adminUsers' => $adminUsers,
            ];

            return view('admin.manage_users.admin_users.admin_users_edit', ['data' => $data]);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function updateAdminUsers(Request $request)
    {
        $values = $request->only('id', 'name', 'email', 'phone', 'mainRole', 'subRole', 'pinCode', 'state', 'country', 'address', 'about');
        $file = $request->file('file');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }

        try {
            DB::beginTransaction();
            $values = $request->only('uniqueId', 'name', 'email', 'phone', 'mainRole', 'subRole', 'pinCode', 'state', 'country', 'address', 'about');
            $file = $request->file('file');

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateAdminUsers', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                if ($values['uniqueId'] != Config::get('constants.superAdminCheck.admin')) {
                    if (MainRole::where('id', decrypt($values['mainRole']))->first()->uniqueId == Config::get('constants.superAdminCheck')['mainRole']) {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update", 'msg' => __('messages.notAllowMsg')], Config::get('constants.errorCode.ok'));
                    } else {
                        goto next;
                    }
                } else {
                    goto next;
                }
                next:
                $adminUsers = AdminUsers::findOrFail($id);
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
                $adminUsers->name = $values['name'];
                $adminUsers->email = $values['email'];
                $adminUsers->phone = $values['phone'];
                $adminUsers->status = Config::get('constants.status')['active'];
                if (Auth::guard('admin')->user()->uniqueId != Config::get('constants.superAdminCheck.admin')) {
                    $adminUsers->mainRoleId = decrypt($values['mainRole']);
                    if ($values['subRole'] != '') {
                        $adminUsers->subRoleId = decrypt($values['subRole']);
                    }
                }
                $adminUsers->password = Hash::make(123456);
                if ($adminUsers->update()) {
                    $usersInfo = UsersInfo::where([
                        ['userId', $adminUsers->id],
                        ['userType', Config::get('constants.userType.admin')],
                    ])->first();
                    $usersInfo->pinCode = $values['pinCode'];
                    $usersInfo->state = $values['state'];
                    $usersInfo->country = $values['country'];
                    $usersInfo->address = $values['address'];
                    $usersInfo->about = ($values['about'] == '') ? 'NA' : $values['about'];
                    if ($usersInfo->update()) {
                        DB::commit();
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update", 'msg' => __('messages.updateMsg', ['type' => 'Admin Users'])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        DB::rollback();
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update", 'msg' => __('messages.updateMsg', ['type' => 'Admin Users'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    DB::rollback();
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update", 'msg' => __('messages.updateMsg', ['type' => 'Admin Users'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }
    }

    public function detailAdminUsers($id)
    {
        try {
            $mainRole = ManageRoleHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'uniqueId' => Config::get('constants.superAdminCheck')['mainRole'],
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $adminUsers = ManageUsersHelper::getDetail([
                [
                    'getDetail' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                        'for' => Config::get('constants.typeCheck.usersRelated.manageUsers.adminUsers.type'),
                    ],
                    'otherDataPasses' => [
                        'id' => $id
                    ]
                ],
            ])[Config::get('constants.typeCheck.usersRelated.manageUsers.adminUsers.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];

            $subRole = ManageRoleHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'mainRoleId' => $adminUsers['mainRole']['id']
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $data = [
                'mainRole' => $mainRole,
                'subRole' => $subRole,
                'detail' => $adminUsers,
            ];

            return view('admin.manage_users.admin_users.admin_users_detail', ['data' => $data]);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function statusAdminUsers($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => AdminUsers::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Admin Users'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Admin Users'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }
    }

    public function deleteAdminUsers($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => AdminUsers::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
                [
                    'model' => UsersInfo::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'userId'], ['search' => Config::get('constants.userType.admin'), 'field' => 'userType']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Admin Users'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Admin Users'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }
    }
}

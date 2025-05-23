<?php

namespace App\Http\Controllers\Admin\ManageUsers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use App\Models\ManagePanel\ManageAccess\RoleMain;

use App\Helpers\GetManageAccessHelper;
use App\Helpers\GetManageUsersHelper;

use App\Models\ManageUsers\AdminUsers;
use App\Models\ManageUsers\UsersInfo;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminUsersAdminController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Admin Users ) ----*/
    public function showAdminUsers()
    {
        // $adminUsers = GetManageUsersHelper::getList([
        //     [
        //         'getList' => [
        //             'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
        //             'for' => Config::get('constants.typeCheck.manageUsers.adminUsers.type'),
        //         ],
        //         'otherDataPasses' => [
        //             'filterData' => [],
        //             'orderBy' => [
        //                 'id' => 'desc'
        //             ],
        //         ],
        //     ],
        // ])[Config::get('constants.typeCheck.manageUsers.adminUsers.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

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
            $adminUsers = GetManageUsersHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageUsers.adminUsers.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.manageUsers.adminUsers.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $getPrivilege = GetManageAccessHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($adminUsers)
                ->addIndexColumn()
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

                    if ($getPrivilege['info']['permission'] == true) {
                        $info = '<a href="JavaScript:void(0);" data-type="info" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Info" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    } else {
                        $info = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete, $info],
                                'secondary' => [],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['uniqueId', 'status', 'image', 'action'])
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

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveAdminUsers', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                if (RoleMain::where('id', decrypt($values['roleMain']))->first()->uniqueId == Config::get('constants.superAdminCheck')['roleMain']) {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save", 'msg' => __('messages.notAllowMsg')], config('constants.ok'));
                } else {
                    // if ($file) {
                    //     $uploadPicture = $this->uploadFile([
                    //         'file' => ['current' => $file, 'previous' => ''],
                    //         'platform' => $this->platform,
                    //         'storage' => Config::get('constants.storage')['adminUsers']
                    //     ]);
                    //     if ($uploadPicture['type'] == false) {
                    //         return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => $uploadPicture['msg']], config('constants.ok'));
                    //     } else {
                    //         $fileName = $uploadPicture['name'];
                    //     }
                    // } else {
                    //     $fileName = 'NA';
                    // }
                    if ($file) {
                        $image = $this->uploadPicture($file, '', $this->platform, 'adminUsers');
                        if ($image == false) {
                            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => 'LOL'], config('constants.ok'));
                        } else {
                            $fileName = $image;
                        }
                    } else {
                        $fileName = 'NA';
                    }
                    $adminUsers = new AdminUsers();
                    $adminUsers->uniqueId = $this->generateCode(['preString' => 'AU', 'length' => 6, 'model' => AdminUsers::class, 'field' => '']);;
                    $adminUsers->name = $values['name'];
                    $adminUsers->email = $values['email'];
                    $adminUsers->phone = $values['phone'];
                    $adminUsers->status = Config::get('constants.status')['active'];
                    $adminUsers->roleMainId = decrypt($values['roleMain']);
                    if ($values['roleSub'] != '') {
                        $adminUsers->roleSubId = decrypt($values['roleSub']);
                    }
                    $adminUsers->password = Hash::make(123456);
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
                            DB::commit();
                            return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Save", 'msg' => __('messages.saveMsg', ['type' => 'Admin Users'])['success']], config('constants.ok'));
                        } else {
                            DB::rollback();
                            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save", 'msg' => __('messages.saveMsg', ['type' => 'Admin Users'])['failed']], config('constants.ok'));
                        }
                    } else {
                        DB::rollback();
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save", 'msg' => __('messages.saveMsg', ['type' => 'Admin Users'])['failed']], config('constants.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Save", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function editAdminUsers($id)
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

            $adminUsers = GetManageUsersHelper::getDetail([
                [
                    'getDetail' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.yd')],
                        'for' => Config::get('constants.typeCheck.manageUsers.adminUsers.type'),
                    ],
                    'otherDataPasses' => [
                        'id' => $id
                    ]
                ],
            ])[Config::get('constants.typeCheck.manageUsers.adminUsers.type')][Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'];

            $roleSub = GetManageAccessHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'roleMainId' => $adminUsers['roleMain']['id']
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.manageAccess.roleSub.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $data = [
                'roleMain' => $roleMain,
                'roleSub' => $roleSub,
                'adminUsers' => $adminUsers,
            ];

            return view('admin.manage_users.admin_users.admin_users_edit', ['data' => $data]);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function updateAdminUsers(Request $request)
    {
        $values = $request->only('id', 'name', 'email', 'phone', 'roleMain', 'roleSub', 'pinCode', 'state', 'country', 'address', 'about');
        $file = $request->file('file');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            DB::beginTransaction();
            $values = $request->only('name', 'email', 'phone', 'roleMain', 'roleSub', 'pinCode', 'state', 'country', 'address', 'about');
            $file = $request->file('file');

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateAdminUsers', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                if (RoleMain::where('id', decrypt($values['roleMain']))->first()->uniqueId == Config::get('constants.superAdminCheck')['roleMain']) {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update", 'msg' => __('messages.notAllowMsg')], config('constants.ok'));
                } else {
                    $adminUsers = AdminUsers::findOrFail($id);
                    if ($file) {
                        $uploadPicture = $this->uploadFile([
                            'file' => ['current' => $file, 'previous' => $adminUsers->image],
                            'platform' => $this->platform,
                            'storage' => Config::get('constants.storage')['adminUsers']
                        ]);
                        if ($uploadPicture['type'] == false) {
                            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => $uploadPicture['msg']], config('constants.ok'));
                        } else {
                            $adminUsers->image = $uploadPicture['name'];
                        }
                    }
                    // if ($file) {
                    //     $image = $this->uploadPicture($file, $adminUsers->image, $this->platform, 'adminUsers');
                    //     if ($image == false) {
                    //         return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => 'LOL'], config('constants.ok'));
                    //     } else {
                    //         $adminUsers->image = $image;
                    //     }
                    // }
                    $adminUsers->uniqueId = $this->generateCode(['preString' => 'AU', 'length' => 6, 'model' => AdminUsers::class, 'field' => '']);;
                    $adminUsers->name = $values['name'];
                    $adminUsers->email = $values['email'];
                    $adminUsers->phone = $values['phone'];
                    $adminUsers->status = Config::get('constants.status')['active'];
                    $adminUsers->roleMainId = decrypt($values['roleMain']);
                    if ($values['roleSub'] != '') {
                        $adminUsers->roleSubId = decrypt($values['roleSub']);
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
                            return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update", 'msg' => __('messages.updateMsg', ['type' => 'Admin Users'])['success']], config('constants.ok'));
                        } else {
                            DB::rollback();
                            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update", 'msg' => __('messages.updateMsg', ['type' => 'Admin Users'])['failed']], config('constants.ok'));
                        }
                    } else {
                        DB::rollback();
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update", 'msg' => __('messages.updateMsg', ['type' => 'Admin Users'])['failed']], config('constants.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
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
                "targetModel" => AdminUsers::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Admin Users'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Admin Users'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteAdminUsers($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
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
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Admin Users'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Admin Users'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }
}

<?php

namespace App\Http\Controllers\Admin\UsersRelated\ManageUsers;

use App\Http\Controllers\Controller;

use App\Helpers\AdminRelated\RolePermission\ManagePermissionHelper;
use App\Helpers\UsersRelated\ManageUsers\ManageUsersHelper;

use App\Models\User;
use App\Models\UsersRelated\UsersInfo;

use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;

class AppUsersAdminController extends Controller
{

    use ValidationTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( App Users ) ----*/
    public function showAppUsers()
    {
        try {
            return view('admin.manage_users.app_users.app_users_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getAppUsers(Request $request)
    {
        try {
            $appUsers = ManageUsersHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.usersRelated.manageUsers.appUsers.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'userType' => $request->userType,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.usersRelated.manageUsers.appUsers.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($appUsers)
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
                ->addColumn('userType', function ($data) {
                    $userType = $data['customizeInText']['userType']['custom'];
                    return $userType;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['status'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.appUsers') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.appUsers') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
                        }
                    } else {
                        $status = '';
                    }

                    if ($getPrivilege['delete']['permission'] == true) {
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.appUsers') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($getPrivilege['edit']['permission'] == true) {
                        $detail = '<a href="' . route('admin.detail.appUsers') . '/' . $data['id'] . '" target="_blank" data-type="edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Detail"><i class="mdi mdi-eye"></i></a>';
                    } else {
                        $detail = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $delete, $detail],
                                'secondary' => [],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['uniqueId', 'status', 'userType', 'image', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function detailAppUsers($id)
    {
        try {
            $appUsers = ManageUsersHelper::getDetail([
                [
                    'getDetail' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                        'for' => Config::get('constants.typeCheck.usersRelated.manageUsers.appUsers.type'),
                    ],
                    'otherDataPasses' => [
                        'id' => $id
                    ]
                ],
            ])[Config::get('constants.typeCheck.usersRelated.manageUsers.appUsers.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];

            $data = [
                'detail' => $appUsers,
            ];

            return view('admin.manage_users.app_users.app_users_detail', ['data' => $data]);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function statusAppUsers($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => User::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'App Users'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'App Users'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }
    }

    public function deleteAppUsers($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => User::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
                [
                    'model' => UsersInfo::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'userId'], ['search' => User::where('id', $id)->first()->userType, 'field' => 'userType']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'App Users'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'App Users'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.server'));
        }
    }
}

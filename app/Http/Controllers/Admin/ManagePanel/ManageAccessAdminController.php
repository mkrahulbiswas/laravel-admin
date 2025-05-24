<?php

namespace App\Http\Controllers\Admin\ManagePanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use App\Models\ManagePanel\ManageAccess\RoleMain;
use App\Models\ManagePanel\ManageAccess\RoleSub;
use App\Models\ManagePanel\ManageAccess\Permission;

use App\Helpers\GetManageNavHelper;
use App\Helpers\GetManageAccessHelper;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Arr;

class ManageAccessAdminController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Role Main ) ----*/
    public function showRoleMain()
    {
        try {
            return view('admin.manage_panel.manage_access.role_main.role_main_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getRoleMain(Request $request)
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
                    if ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.roleMain')) {
                        if ($getPrivilege['status']['permission'] == true) {
                            if ($data['status'] == Config::get('constants.status')['inactive']) {
                                $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.roleMain') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                            } else {
                                $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.roleMain') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
                            }
                        } else {
                            $status = '';
                        }
                    } else {
                        $status = '';
                    }

                    if ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.roleMain')) {
                        if ($getPrivilege['edit']['permission'] == true) {
                            $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Update"><i class="las la-edit"></i></a>';
                        } else {
                            $edit = '';
                        }
                    } else {
                        $edit = '';
                    }

                    if ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.roleMain')) {
                        if ($getPrivilege['delete']['permission'] == true) {
                            $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.roleMain') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                        } else {
                            $delete = '';
                        }
                    } else {
                        $delete = '';
                    }


                    if ($getPrivilege['info']['permission'] == true) {
                        $info = '<a href="JavaScript:void(0);" data-type="info" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Info" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    } else {
                        $info = '';
                    }

                    if ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.roleMain')) {
                        if ($getPrivilege['permission']['permission'] == true) {
                            if ($data['extraData']['hasRoleSub'] <= 0) {
                                $access = '<a href="' .  route('admin.show.permissionRoleMain') . '/' .  $data['id'] . '" data-type="permission" title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
                            } else {
                                $access = '<a href="JavaScript:void(0);" data-type="permission" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
                            }
                        } else {
                            $access = '';
                        }
                    } else {
                        $access = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete, $info],
                                'secondary' => ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.roleMain')) ? [$access] : [],
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

    public function saveRoleMain(Request $request)
    {
        try {
            $values = $request->only('name', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'saveRoleMain',
                'id' => 0,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $roleMain = new RoleMain();
                $roleMain->name = $values['name'];
                $roleMain->description = $values['description'];
                $roleMain->uniqueId = $this->generateCode(['preString' => 'RM', 'length' => 6, 'model' => RoleMain::class, 'field' => '']);
                $roleMain->status = Config::get('constants.status')['active'];

                if ($roleMain->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Role Main", 'msg' => __('messages.saveMsg', ['type' => 'Role Main'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Role Main", 'msg' => __('messages.saveMsg', ['type' => 'Role Main'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Role Main", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateRoleMain(Request $request)
    {
        $values = $request->only('id', 'name', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Role Main", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'updateRoleMain',
                'id' => $id,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $roleMain = RoleMain::find($id);

                $roleMain->name = $values['name'];
                $roleMain->description = $values['description'];

                if ($roleMain->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Role Main", 'msg' => __('messages.updateMsg', ['type' => 'Role Main'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Role Main", 'msg' => __('messages.updateMsg', ['type' => 'Role Main'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Role Main", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusRoleMain($id)
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
                'type' => Config::get('constants.action.status.smsf')
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

    public function deleteRoleMain($id)
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
                [
                    'model' => RoleSub::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'roleMainId']],
                ],
                [
                    'model' => Permission::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'roleMainId']],
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

    public function showPermissionRoleMain($roleMainId)
    {
        try {
            $navType = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageNav.navType.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active']
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ]);

            $data = [
                'navType' => $navType[Config::get('constants.typeCheck.manageNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'],
                'roleMainId' => $roleMainId
            ];

            return view('admin.manage_panel.manage_access.role_main.role_main_permission', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getPermissionRoleMain(Request $request)
    {
        try {
            $getNav = GetManageNavHelper::getNav([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.nav.np')],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'navTypeId' => $request->navType,
                            'navMainId' => $request->navMain,
                            'navSubId' => $request->navSub,
                        ],
                        'orderBy' => [
                            'position' => 'asc'
                        ]
                    ],
                ]
            ]);

            return Datatables::of($getNav)
                ->addIndexColumn()
                ->addColumn('permission', function ($data) {
                    $permission = $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtNavPermission',
                            'data' => $data,
                            'otherDataPasses' => [
                                'permission' => [
                                    'model' => Permission::class,
                                    'roleMainId' => request()->roleMainId
                                ]
                            ]
                        ]
                    ])['dtNavPermission']['custom'];
                    return $permission;
                })
                ->rawColumns(['permission'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function updatePermissionRoleMain(Request $request)
    {
        // try {
        foreach ($request->get('id') as $keyOne => $tempOne) {
            $permission = GetManageAccessHelper::getDetail([
                [
                    'getDetail' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                        'for' => Config::get('constants.typeCheck.manageAccess.permission.type'),
                    ],
                    'otherDataPasses' => ['filterData' => ['id' => $tempOne]]
                ],
            ])[Config::get('constants.typeCheck.manageAccess.permission.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
            $finalArray = [];
            foreach ($permission['privilege'] as $keyTwo => $tempTwo) {
                if ($request->get($keyOne) == []) {
                    $tempTwo['permission'] = false;
                    $finalArray = Arr::prepend(
                        $finalArray,
                        $tempTwo,
                        $keyTwo
                    );
                } else {
                    if (array_key_exists($keyTwo, $request->get($keyOne))) {
                        $tempTwo['permission'] = true;
                        $finalArray = Arr::prepend(
                            $finalArray,
                            $tempTwo,
                            $keyTwo
                        );
                    } else {
                        $tempTwo['permission'] = false;
                        $finalArray = Arr::prepend(
                            $finalArray,
                            $tempTwo,
                            $keyTwo
                        );
                    }
                }
            }
            $permission['permission']->privilege = json_encode($finalArray);
            $permission['permission']->update();
        }
        return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Permission", 'msg' => 'Permissions are successfully updated.'], config('constants.ok'));
        // } catch (Exception $e) {
        //     return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        // }
    }


    /*---- ( Role Sub ) ----*/
    public function showRoleSub()
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

            return view('admin.manage_panel.manage_access.role_sub.role_sub_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getRoleSub(Request $request)
    {
        try {
            $roleSub = GetManageAccessHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'roleMainId' => $request->roleMain
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.manageAccess.roleSub.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            $getPrivilege = GetManageAccessHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($roleSub)
                ->addIndexColumn()
                ->addColumn('description', function ($data) {
                    $description = $this->subStrString(40, $data['description'], '....');
                    return $description;
                })
                ->addColumn('uniqueId', function ($data) {
                    $uniqueId = $data['uniqueId']['raw'];
                    return $uniqueId;
                })
                ->addColumn('status', function ($data) {
                    $status = $data['customizeInText']['status']['custom'];
                    return $status;
                })
                ->addColumn(Config::get('constants.typeCheck.manageAccess.roleMain.type'), function ($data) {
                    $roleMain = $data[Config::get('constants.typeCheck.manageAccess.roleMain.type')]['name'];
                    return $roleMain;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['status'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.roleSub') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.roleSub') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.roleSub') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($getPrivilege['info']['permission'] == true) {
                        $info = '<a href="JavaScript:void(0);" data-type="info" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Info" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    } else {
                        $info = '';
                    }

                    if ($getPrivilege['permission']['permission'] == true) {
                        $access = '<a href="' .  route('admin.show.permissionRoleSub') . '/' .  $data['id'] . '" data-type="permission" title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
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
                ->rawColumns(['description', Config::get('constants.typeCheck.manageAccess.roleMain.type'), 'uniqueId', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveRoleSub(Request $request)
    {
        try {
            $values = $request->only('name', 'roleMain', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'saveRoleSub',
                'id' => 0,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                if (RoleMain::where('id', decrypt($values['roleMain']))->first()->uniqueId == Config::get('constants.superAdminCheck')['roleMain']) {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Role Sub", 'msg' => __('messages.notAllowMsg')], config('constants.ok'));
                } else {
                    $roleSub = new RoleSub();
                    $roleSub->name = $values['name'];
                    $roleSub->roleMainId = decrypt($values['roleMain']);
                    $roleSub->description = $values['description'];
                    $roleSub->uniqueId = $this->generateCode(['preString' => 'RS', 'length' => 6, 'model' => RoleSub::class, 'field' => '']);
                    $roleSub->status = Config::get('constants.status')['active'];

                    if ($roleSub->save()) {
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Role Sub", 'msg' => __('messages.saveMsg', ['type' => 'Role Sub'])['success']], config('constants.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Role Sub", 'msg' => __('messages.saveMsg', ['type' => 'Role Sub'])['failed']], config('constants.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Role Sub", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateRoleSub(Request $request)
    {
        $values = $request->only('id', 'name', 'roleMain', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Role Sub", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'updateRoleSub',
                'id' => $id,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $roleSub = RoleSub::find($id);

                $roleSub->name = $values['name'];
                $roleSub->roleMainId = decrypt($values['roleMain']);
                $roleSub->description = $values['description'];

                if ($roleSub->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Role Sub", 'msg' => __('messages.updateMsg', ['type' => 'Role Sub'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Role Sub", 'msg' => __('messages.updateMsg', ['type' => 'Role Sub'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Role Sub", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusRoleSub($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => RoleSub::class,
                'targetField' => [],
                'type' => Config::get('constants.actionFor.statusType.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Role Sub'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Role Sub'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteRoleSub($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => RoleSub::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
                [
                    'model' => Permission::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'roleSubId']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Role Sub'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Role Sub'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function showPermissionRoleSub($roleSubId)
    {
        try {
            $navType = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageNav.navType.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active']
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ]);

            $data = [
                'navType' => $navType[Config::get('constants.typeCheck.manageNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'],
                'roleSubId' => $roleSubId
            ];

            return view('admin.manage_panel.manage_access.role_sub.role_sub_permission', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getPermissionRoleSub(Request $request)
    {
        try {
            $getNav = GetManageNavHelper::getNav([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.nav.np')],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'navTypeId' => $request->navType,
                            'navMainId' => $request->navMain,
                            'navSubId' => $request->navSub,
                        ],
                        'orderBy' => [
                            'position' => 'asc'
                        ]
                    ],
                ]
            ]);

            return Datatables::of($getNav)
                ->addIndexColumn()
                ->addColumn('permission', function ($data) {
                    $permission = $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtNavPermission',
                            'data' => $data,
                            'otherDataPasses' => [
                                'permission' => [
                                    'model' => Permission::class,
                                    'roleMainId' => encrypt(RoleSub::where('id', decrypt(request()->roleSubId))->first()->roleMainId),
                                    'roleSubId' => request()->roleSubId
                                ]
                            ]
                        ]
                    ])['dtNavPermission']['custom'];
                    return $permission;
                })
                ->rawColumns(['permission'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function updatePermissionRoleSub(Request $request)
    {
        try {
            foreach ($request->get('id') as $keyOne => $tempOne) {
                $permission = GetManageAccessHelper::getDetail([
                    [
                        'getDetail' => [
                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                            'for' => Config::get('constants.typeCheck.manageAccess.permission.type'),
                        ],
                        'otherDataPasses' => ['filterData' => ['id' => $tempOne]]
                    ],
                ])[Config::get('constants.typeCheck.manageAccess.permission.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                $finalArray = [];
                foreach ($permission['privilege'] as $keyTwo => $tempTwo) {
                    if ($request->get($keyOne) == []) {
                        $tempTwo['permission'] = false;
                        $finalArray = Arr::prepend(
                            $finalArray,
                            $tempTwo,
                            $keyTwo
                        );
                    } else {
                        if (array_key_exists($keyTwo, $request->get($keyOne))) {
                            $tempTwo['permission'] = true;
                            $finalArray = Arr::prepend(
                                $finalArray,
                                $tempTwo,
                                $keyTwo
                            );
                        } else {
                            $tempTwo['permission'] = false;
                            $finalArray = Arr::prepend(
                                $finalArray,
                                $tempTwo,
                                $keyTwo
                            );
                        }
                    }
                }
                $permission['permission']->privilege = json_encode($finalArray);
                $permission['permission']->update();
            }
            return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Permission", 'msg' => 'Permissions are successfully updated.'], config('constants.ok'));
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }


    /*---- ( Permission ) ----*/
    public function showPermissions()
    {
        // try {
        $getPrivilege = GetManageAccessHelper::getPrivilege([
            ['type' => [Config::get('constants.typeCheck.helperCommon.privilege.np')]]
        ])[Config::get('constants.typeCheck.helperCommon.privilege.np')];
        dd($getPrivilege);
        return view('admin.manage_panel.manage_access.permissions.permissions_list');
        // } catch (Exception $e) {
        //     abort(500);
        // }
    }

    public function getPermissions(Request $request)
    {
        try {
            $roleSub = GetManageAccessHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'roleMainId' => $request->roleMain
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ]);

            return Datatables::of($roleSub[Config::get('constants.typeCheck.manageAccess.roleSub.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'])
                ->addIndexColumn()
                ->addColumn('description', function ($data) {
                    $description = $this->subStrString(40, $data['description'], '....');
                    return $description;
                })
                ->addColumn('uniqueId', function ($data) {
                    $uniqueId = $data['uniqueId']['raw'];
                    return $uniqueId;
                })
                ->addColumn('status', function ($data) {
                    $status = $data['customizeInText']['status']['custom'];
                    return $status;
                })
                ->addColumn(Config::get('constants.typeCheck.manageAccess.roleMain.type'), function ($data) {
                    $roleMain = $data[Config::get('constants.typeCheck.manageAccess.roleMain.type')]['name'];
                    return $roleMain;
                })
                ->addColumn('action', function ($data) {

                    // $itemPermission = $this->itemPermission();

                    // if ($itemPermission['status_item'] == '1') {
                    if ($data['status'] == Config::get('constants.status')['inactive']) {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.roleSub') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                    } else {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.roleSub') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
                    }
                    // } else {
                    //     $status = '';
                    // }

                    // if ($itemPermission['edit_item'] == '1') {
                    $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Update"><i class="las la-edit"></i></a>';
                    // } else {
                    //     $edit = '';
                    // }

                    // if ($itemPermission['delete_item'] == '1') {
                    $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.roleSub') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    // } else {
                    //     $delete = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $details = '<a href="JavaScript:void(0);" data-type="details" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    // } else {
                    //     $details = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $access = '<a href="JavaScript:void(0);" data-type="access" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Access" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-access-point"></i><span>Change Access</span></a>';
                    // } else {
                    //     $details = '';
                    // }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete, $details],
                                'secondary' => [$access],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['description', Config::get('constants.typeCheck.manageAccess.roleMain.type'), 'uniqueId', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function updatePermissions(Request $request)
    {
        $values = $request->only('id', 'name', 'roleMain', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Role Sub", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'updateRoleSub',
                'id' => $id,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $roleSub = RoleSub::find($id);

                $roleSub->name = $values['name'];
                $roleSub->roleMainId = decrypt($values['roleMain']);
                $roleSub->description = $values['description'];

                if ($roleSub->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Role Sub", 'msg' => __('messages.updateMsg', ['type' => 'Role Sub'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Role Sub", 'msg' => __('messages.updateMsg', ['type' => 'Role Sub'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Role Sub", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }
}

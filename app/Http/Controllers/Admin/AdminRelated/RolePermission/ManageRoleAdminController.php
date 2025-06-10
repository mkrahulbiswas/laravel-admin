<?php

namespace App\Http\Controllers\Admin\AdminRelated\RolePermission;

use App\Http\Controllers\Controller;

use App\Helpers\AdminRelated\RolePermission\ManagePermissionHelper;
use App\Helpers\AdminRelated\RolePermission\ManageRoleHelper;
use App\Helpers\ManagePanel\GetManageNavHelper;

use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use App\Models\ManagePanel\ManageAccess\Permission;
use App\Models\AdminRelated\RolePermission\ManageRole\MainRole;
use App\Models\AdminRelated\RolePermission\ManageRole\SubRole;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ManageRoleAdminController extends Controller
{

    use ValidationTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Main Role ) ----*/
    public function showMainRole()
    {
        try {
            return view('admin.admin_related.role_permission.manage_role.main_role.main_role_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getMainRole(Request $request)
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
                            'status' => $request->status,
                            'uniqueId' => Config::get('constants.superAdminCheck')['mainRole'],
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($mainRole)
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
                    if ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.mainRole')) {
                        if ($getPrivilege['status']['permission'] == true) {
                            if ($data['status'] == Config::get('constants.status')['inactive']) {
                                $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.mainRole') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                            } else {
                                $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.mainRole') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
                            }
                        } else {
                            $status = '';
                        }
                    } else {
                        $status = '';
                    }

                    if ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.mainRole')) {
                        if ($getPrivilege['edit']['permission'] == true) {
                            $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Update"><i class="las la-edit"></i></a>';
                        } else {
                            $edit = '';
                        }
                    } else {
                        $edit = '';
                    }

                    if ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.mainRole')) {
                        if ($getPrivilege['delete']['permission'] == true) {
                            $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.mainRole') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
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

                    if ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.mainRole')) {
                        if ($getPrivilege['permission']['permission'] == true) {
                            if ($data['extraData']['hasSubRole'] <= 0) {
                                if ($data['extraData']['hasPermission'] <= 0) {
                                    $permission = '<a href="JavaScript:void(0);" data-type="setPermission" data-action="' . route('admin.permission.mainRole') . '/' . $data['id'] . '" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apple-keyboard-command"></i><span>Set Permission</span></a>';
                                } else {
                                    $permission = '<a href="' .  route('admin.show.permissionMainRole') . '/' .  $data['id'] . '" data-type="permission" title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
                                }
                            } else {
                                $permission = '<a href="JavaScript:void(0);" data-type="permission" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
                            }
                        } else {
                            $permission = '';
                        }
                    } else {
                        $permission = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete, $info],
                                'secondary' => ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.mainRole')) ? [$permission] : [],
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

    public function saveMainRole(Request $request)
    {
        try {
            $values = $request->only('name', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveMainRole', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {

                $mainRole = new MainRole();
                $mainRole->name = $values['name'];
                $mainRole->description = $values['description'];
                $mainRole->uniqueId = $this->generateCode(['preString' => 'RM', 'length' => 6, 'model' => MainRole::class, 'field' => '']);
                $mainRole->status = Config::get('constants.status')['active'];

                if ($mainRole->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Main role", 'msg' => __('messages.saveMsg', ['type' => 'Main role'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Main role", 'msg' => __('messages.saveMsg', ['type' => 'Main role'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Main role", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateMainRole(Request $request)
    {
        $values = $request->only('id', 'name', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Main role", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateMainRole', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $mainRole = MainRole::find($id);

                $mainRole->name = $values['name'];
                $mainRole->description = $values['description'];

                if ($mainRole->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Main role", 'msg' => __('messages.updateMsg', ['type' => 'Main role'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Main role", 'msg' => __('messages.updateMsg', ['type' => 'Main role'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Main role", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function permissionMainRole($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Main role", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $setPermission = ManagePermissionHelper::setPermission([
                [
                    'checkFirst' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.set.pfr')],
                        'for' => Config::get('constants.typeCheck.helperCommon.privilege.sp'),
                    ],
                    'otherDataPasses' => [
                        'mainRoleId' => $id,
                    ]
                ]
            ]);
            if ($setPermission) {
                return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Main nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav Permission'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Main nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav Permission'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Main role", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function statusMainRole($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => MainRole::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Main role'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Main role'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteMainRole($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => MainRole::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
                [
                    'model' => SubRole::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'mainRoleId']],
                ],
                [
                    'model' => Permission::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'mainRoleId']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Main role'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Main role'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function showPermissionMainRole($mainRoleId)
    {
        try {
            $navType = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
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
                'navType' => $navType[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'],
                'mainRoleId' => $mainRoleId
            ];

            return view('admin.admin_related.role_permission.manage_role.main_role.main_role_permission', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getPermissionMainRole(Request $request)
    {
        try {
            $getNav = GetManageNavHelper::getNav([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.nav.np')],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'navTypeId' => $request->navType,
                            'mainNavId' => $request->navMain,
                            'subNavId' => $request->navSub,
                        ],
                        'orderBy' => [
                            'position' => 'asc'
                        ]
                    ],
                ]
            ]);

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($getNav)
                ->addIndexColumn()
                ->addColumn('permission', function ($data) use ($getPrivilege) {
                    $permission = $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtNavPermission',
                            'data' => $data,
                            'otherDataPasses' => [
                                'permission' => [
                                    'model' => Permission::class,
                                    'mainRoleId' => request()->mainRoleId
                                ],
                                'getPrivilege' => $getPrivilege
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

    public function updatePermissionMainRole(Request $request)
    {
        try {
            foreach ($request->get('id') as $keyOne => $tempOne) {
                $permission = ManageRoleHelper::getDetail([
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
            return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Permission", 'msg' => 'Permissions are successfully updated.'], Config::get('constants.errorCode.ok'));
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }


    /*---- ( Sub Role ) ----*/
    public function showSubRole()
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

            return view('admin.admin_related.role_permission.manage_role.sub_role.sub_role_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getSubRole(Request $request)
    {
        try {
            $subRole = ManageRoleHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'mainRoleId' => $request->mainRole
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($subRole)
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
                ->addColumn(Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'), function ($data) {
                    $mainRole = $data[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')]['name'];
                    return $mainRole;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['status'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.subRole') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.subRole') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.subRole') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($getPrivilege['info']['permission'] == true) {
                        $info = '<a href="JavaScript:void(0);" data-type="info" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Info" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    } else {
                        $info = '';
                    }

                    if ($getPrivilege['permission']['permission'] == true) {
                        if ($data['extraData']['hasPermission'] <= 0) {
                            $permission = '<a href="JavaScript:void(0);" data-type="setPermission" data-action="' . route('admin.permission.subRole') . '/' . $data['id'] . '" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apple-keyboard-command"></i><span>Set Permission</span></a>';
                        } else {
                            $permission = '<a href="' .  route('admin.show.permissionSubRole') . '/' .  $data['id'] . '" data-type="permission" title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
                        }
                    } else {
                        $permission = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete, $info],
                                'secondary' => [$permission],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['description', Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'), 'uniqueId', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveSubRole(Request $request)
    {
        try {
            $values = $request->only('name', 'mainRole', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveSubRole', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                if (MainRole::where('id', decrypt($values['mainRole']))->first()->uniqueId == Config::get('constants.superAdminCheck')['mainRole']) {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Sub role", 'msg' => __('messages.notAllowMsg')], Config::get('constants.errorCode.ok'));
                } else {
                    $subRole = new SubRole();
                    $subRole->name = $values['name'];
                    $subRole->mainRoleId = decrypt($values['mainRole']);
                    $subRole->description = $values['description'];
                    $subRole->uniqueId = $this->generateCode(['preString' => 'RS', 'length' => 6, 'model' => SubRole::class, 'field' => '']);
                    $subRole->status = Config::get('constants.status')['active'];

                    if ($subRole->save()) {
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Sub role", 'msg' => __('messages.saveMsg', ['type' => 'Sub role'])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Sub role", 'msg' => __('messages.saveMsg', ['type' => 'Sub role'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Sub role", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateSubRole(Request $request)
    {
        $values = $request->only('id', 'name', 'mainRole', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Sub role", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateSubRole', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $subRole = SubRole::find($id);

                $subRole->name = $values['name'];
                $subRole->mainRoleId = decrypt($values['mainRole']);
                $subRole->description = $values['description'];

                if ($subRole->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Sub role", 'msg' => __('messages.updateMsg', ['type' => 'Sub role'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Sub role", 'msg' => __('messages.updateMsg', ['type' => 'Sub role'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Sub role", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function permissionSubRole($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Sub role", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        // try {
        $setPermission = ManagePermissionHelper::setPermission([
            [
                'checkFirst' => [
                    'type' => [Config::get('constants.typeCheck.helperCommon.set.pfr')],
                    'for' => Config::get('constants.typeCheck.helperCommon.privilege.sp'),
                ],
                'otherDataPasses' => [
                    'mainRoleId' => SubRole::where('id', $id)->first()->mainRoleId,
                    'subRoleId' => $id,
                ]
            ]
        ]);
        if ($setPermission) {
            return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Sub nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav Permission'])['success']], Config::get('constants.errorCode.ok'));
        } else {
            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Sub nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav Permission'])['failed']], Config::get('constants.errorCode.ok'));
        }
        // } catch (Exception $e) {
        //     return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Sub role", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        // }
    }

    public function statusSubRole($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => SubRole::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Sub role'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Sub role'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteSubRole($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => SubRole::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
                [
                    'model' => Permission::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'subRoleId']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Sub role'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Sub role'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function showPermissionSubRole($subRoleId)
    {
        try {
            $navType = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
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
                'navType' => $navType[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'],
                'subRoleId' => $subRoleId
            ];

            return view('admin.admin_related.role_permission.manage_role.sub_role.sub_role_permission', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getPermissionSubRole(Request $request)
    {
        try {
            $getNav = GetManageNavHelper::getNav([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.nav.np')],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active'],
                            'navTypeId' => $request->navType,
                            'mainNavId' => $request->navMain,
                            'subNavId' => $request->navSub,
                        ],
                        'orderBy' => [
                            'position' => 'asc'
                        ]
                    ],
                ]
            ]);

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($getNav)
                ->addIndexColumn()
                ->addColumn('permission', function ($data) use ($getPrivilege) {
                    $permission = $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtNavPermission',
                            'data' => $data,
                            'otherDataPasses' => [
                                'permission' => [
                                    'model' => Permission::class,
                                    'mainRoleId' => encrypt(SubRole::where('id', decrypt(request()->subRoleId))->first()->mainRoleId),
                                    'subRoleId' => request()->subRoleId
                                ],
                                'getPrivilege' => $getPrivilege
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

    public function updatePermissionSubRole(Request $request)
    {
        try {
            foreach ($request->get('id') as $keyOne => $tempOne) {
                $permission = ManageRoleHelper::getDetail([
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
            return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Permission", 'msg' => 'Permissions are successfully updated.'], Config::get('constants.errorCode.ok'));
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }


    /*---- ( Permission ) ----*/
    public function showPermissions()
    {
        // try {
        $getPrivilege = ManagePermissionHelper::getPrivilege([
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
            $subRole = ManageRoleHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'mainRoleId' => $request->mainRole
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ]);

            return Datatables::of($subRole[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'])
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
                ->addColumn(Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'), function ($data) {
                    $mainRole = $data[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')]['name'];
                    return $mainRole;
                })
                ->addColumn('action', function ($data) {

                    // $itemPermission = $this->itemPermission();

                    // if ($itemPermission['status_item'] == '1') {
                    if ($data['status'] == Config::get('constants.status')['inactive']) {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.subRole') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                    } else {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.subRole') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                    $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.subRole') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    // } else {
                    //     $delete = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $details = '<a href="JavaScript:void(0);" data-type="details" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    // } else {
                    //     $details = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $permission = '<a href="JavaScript:void(0);" data-type="access" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Access" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-access-point"></i><span>Change Access</span></a>';
                    // } else {
                    //     $details = '';
                    // }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete, $details],
                                'secondary' => [$permission],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['description', Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'), 'uniqueId', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function updatePermissions(Request $request)
    {
        $values = $request->only('id', 'name', 'mainRole', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Sub role", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateSubRole', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $subRole = SubRole::find($id);

                $subRole->name = $values['name'];
                $subRole->mainRoleId = decrypt($values['mainRole']);
                $subRole->description = $values['description'];

                if ($subRole->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Sub role", 'msg' => __('messages.updateMsg', ['type' => 'Sub role'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Sub role", 'msg' => __('messages.updateMsg', ['type' => 'Sub role'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Sub role", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }
}

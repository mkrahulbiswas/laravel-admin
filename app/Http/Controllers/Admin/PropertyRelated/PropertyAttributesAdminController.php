<?php

namespace App\Http\Controllers\Admin\PropertyRelated;

use App\Http\Controllers\Controller;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use App\Models\ManagePanel\ManageAccess\RoleMain;
use App\Models\ManagePanel\ManageAccess\RoleSub;
use App\Models\ManagePanel\ManageAccess\Permission;

use App\Helpers\ManagePanel\GetManageAccessHelper;
use App\Helpers\ManagePanel\GetManageNavHelper;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PropertyAttributesAdminController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Amenities ) ----*/
    public function showAmenities()
    {
        try {
            return view('admin.property_related.property_attributes.amenities.amenities_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getAmenities(Request $request)
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
                                if ($data['extraData']['hasPermission'] <= 0) {
                                    $permission = '<a href="JavaScript:void(0);" data-type="setPermission" data-action="' . route('admin.permission.roleMain') . '/' . $data['id'] . '" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apple-keyboard-command"></i><span>Set Permission</span></a>';
                                } else {
                                    $permission = '<a href="' .  route('admin.show.permissionRoleMain') . '/' .  $data['id'] . '" data-type="permission" title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
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
                                'secondary' => ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.roleMain')) ? [$permission] : [],
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

    public function saveAmenities(Request $request)
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

    public function updateAmenities(Request $request)
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

    public function defaultAmenities($id)
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

    public function deleteAmenities($id)
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

    /*---- ( Property Features ) ----*/
    public function showPropertyFeatures()
    {
        try {
            return view('admin.property_related.property_attributes.property_features.property_features_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getPropertyFeatures(Request $request)
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
                                if ($data['extraData']['hasPermission'] <= 0) {
                                    $permission = '<a href="JavaScript:void(0);" data-type="setPermission" data-action="' . route('admin.permission.roleMain') . '/' . $data['id'] . '" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apple-keyboard-command"></i><span>Set Permission</span></a>';
                                } else {
                                    $permission = '<a href="' .  route('admin.show.permissionRoleMain') . '/' .  $data['id'] . '" data-type="permission" title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
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
                                'secondary' => ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.roleMain')) ? [$permission] : [],
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

    public function savePropertyFeatures(Request $request)
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

    public function updatePropertyFeatures(Request $request)
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

    public function defaultPropertyFeatures($id)
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

    public function deletePropertyFeatures($id)
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

    /*---- ( Society Features ) ----*/
    public function showSocietyFeatures()
    {
        try {
            return view('admin.property_related.property_attributes.society_features.society_features_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getSocietyFeatures(Request $request)
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
                                if ($data['extraData']['hasPermission'] <= 0) {
                                    $permission = '<a href="JavaScript:void(0);" data-type="setPermission" data-action="' . route('admin.permission.roleMain') . '/' . $data['id'] . '" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apple-keyboard-command"></i><span>Set Permission</span></a>';
                                } else {
                                    $permission = '<a href="' .  route('admin.show.permissionRoleMain') . '/' .  $data['id'] . '" data-type="permission" title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
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
                                'secondary' => ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.roleMain')) ? [$permission] : [],
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

    public function saveSocietyFeatures(Request $request)
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

    public function updateSocietyFeatures(Request $request)
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

    public function defaultSocietyFeatures($id)
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

    public function deleteSocietyFeatures($id)
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

    /*---- ( Type Of Floorings ) ----*/
    public function showTypeOfFloorings()
    {
        try {
            return view('admin.property_related.property_attributes.type_of_floorings.type_of_floorings_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getTypeOfFloorings(Request $request)
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
                                if ($data['extraData']['hasPermission'] <= 0) {
                                    $permission = '<a href="JavaScript:void(0);" data-type="setPermission" data-action="' . route('admin.permission.roleMain') . '/' . $data['id'] . '" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apple-keyboard-command"></i><span>Set Permission</span></a>';
                                } else {
                                    $permission = '<a href="' .  route('admin.show.permissionRoleMain') . '/' .  $data['id'] . '" data-type="permission" title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
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
                                'secondary' => ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.roleMain')) ? [$permission] : [],
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

    public function saveTypeOfFloorings(Request $request)
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

    public function updateTypeOfFloorings(Request $request)
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

    public function defaultTypeOfFloorings($id)
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

    public function deleteTypeOfFloorings($id)
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

    /*---- ( Parking Types ) ----*/
    public function showParkingTypes()
    {
        try {
            return view('admin.property_related.property_attributes.parking_types.parking_types_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getParkingTypes(Request $request)
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
                                if ($data['extraData']['hasPermission'] <= 0) {
                                    $permission = '<a href="JavaScript:void(0);" data-type="setPermission" data-action="' . route('admin.permission.roleMain') . '/' . $data['id'] . '" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apple-keyboard-command"></i><span>Set Permission</span></a>';
                                } else {
                                    $permission = '<a href="' .  route('admin.show.permissionRoleMain') . '/' .  $data['id'] . '" data-type="permission" title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
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
                                'secondary' => ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.roleMain')) ? [$permission] : [],
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

    public function saveParkingTypes(Request $request)
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

    public function updateParkingTypes(Request $request)
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

    public function defaultParkingTypes($id)
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

    public function deleteParkingTypes($id)
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

    /*---- ( Located Near ) ----*/
    public function showLocatedNear()
    {
        try {
            return view('admin.property_related.property_attributes.located_near.located_near_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getLocatedNear(Request $request)
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
                                if ($data['extraData']['hasPermission'] <= 0) {
                                    $permission = '<a href="JavaScript:void(0);" data-type="setPermission" data-action="' . route('admin.permission.roleMain') . '/' . $data['id'] . '" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apple-keyboard-command"></i><span>Set Permission</span></a>';
                                } else {
                                    $permission = '<a href="' .  route('admin.show.permissionRoleMain') . '/' .  $data['id'] . '" data-type="permission" title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
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
                                'secondary' => ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.roleMain')) ? [$permission] : [],
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

    public function saveLocatedNear(Request $request)
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

    public function updateLocatedNear(Request $request)
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

    public function defaultLocatedNear($id)
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

    public function deleteLocatedNear($id)
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

    /*---- ( Location Advantages ) ----*/
    public function showLocationAdvantages()
    {
        try {
            return view('admin.property_related.property_attributes.location_advantages.location_advantages_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getLocationAdvantages(Request $request)
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
                                if ($data['extraData']['hasPermission'] <= 0) {
                                    $permission = '<a href="JavaScript:void(0);" data-type="setPermission" data-action="' . route('admin.permission.roleMain') . '/' . $data['id'] . '" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apple-keyboard-command"></i><span>Set Permission</span></a>';
                                } else {
                                    $permission = '<a href="' .  route('admin.show.permissionRoleMain') . '/' .  $data['id'] . '" data-type="permission" title="Permission" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-apache-kafka"></i><span>Change Permission</span></a>';
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
                                'secondary' => ($data['uniqueId']['raw'] != Config::get('constants.superAdminCheck.roleMain')) ? [$permission] : [],
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

    public function saveLocationAdvantages(Request $request)
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

    public function updateLocationAdvantages(Request $request)
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

    public function defaultLocationAdvantages($id)
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

    public function deleteLocationAdvantages($id)
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
}

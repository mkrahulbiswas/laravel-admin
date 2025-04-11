<?php

namespace App\Http\Controllers\Admin\ManagePanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\ManagePanel\ManageAccess\RoleMain;
use App\Models\ManagePanel\ManageAccess\RoleSub;

use App\Helpers\GetManageAccessHelper;

use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\DataTables;

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
            $status = $request->status;
            $roleMain = $request->roleMain;

            $query = "`created_at` is not null";

            if (!empty($status)) {
                $query .= " and `status` = '" . $status . "'";
            }

            if (!empty($roleMain)) {
                $query .= " and `roleMainId` = " . decrypt($roleMain);
            }

            $roleMain = RoleMain::orderBy('id', 'desc')->whereRaw($query)->get();

            return Datatables::of($roleMain)
                ->addIndexColumn()
                ->addColumn('description', function ($data) {
                    $description = $this->subStrString(40, $data->description, '....');
                    return $description;
                })
                ->addColumn('status', function ($data) {
                    $status = CommonTrait::customizeInText(['type' => 'status', 'value' => $data->status])['status'];
                    return $status;
                })
                ->addColumn('action', function ($data) {

                    // $itemPermission = $this->itemPermission();

                    $dataArray = [
                        'id' => encrypt($data->id),
                        'name' => $data->name,
                        'description' => $data->description,
                    ];


                    // if ($itemPermission['status_item'] == '1') {
                    if ($data->status == Config::get('constants.status')['inactive']) {
                        $status = '<li><a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.roleMain') . '/' . $dataArray['id'] . '" class="dropdown-item actionDatatable" title="Unblock"><i class="las la-lock-open align-bottom me-2 text-muted"></i> <span>Change status</span></a></li>';
                    } else {
                        $status = '<li><a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.roleMain') . '/' . $dataArray['id'] . '" class="dropdown-item actionDatatable" title="Block"><i class="las la-lock align-bottom me-2 text-muted"></i> <span>Change status</span></a></li>';
                    }
                    // } else {
                    //     $status = '';
                    // }

                    // if ($itemPermission['edit_item'] == '1') {
                    $edit = '<li><a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="dropdown-item actionDatatable" title="Update"><i class="las la-edit align-bottom me-2 text-muted"></i> <span>Edit Role Main</span></a></li>';
                    // } else {
                    //     $edit = '';
                    // }

                    // if ($itemPermission['delete_item'] == '1') {
                    $delete = '<li><a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.roleMain') . '/' . $dataArray['id'] . '" class="dropdown-item actionDatatable" title="Delete"><i class="las la-trash align-bottom me-2 text-muted"></i> <span>Delete item</span></a></li>';
                    // } else {
                    //     $delete = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $details = '<li><a href="JavaScript:void(0);" data-type="details" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="dropdown-item actionDatatable"><i class="las la-info-circle align-bottom me-2 text-muted"></i> <span>Quick view</span></a></li>';
                    // } else {
                    //     $details = '';
                    // }

                    $action = '<td>
                    <div class="dropdown d-inline-block tableActionContent">
                    <button class="btn btn-soft-info btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-equalizer-fill"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">' . $status . $edit . $delete . $details . '</ul>
                    </div>
                    </td>';

                    return $action;
                })
                ->rawColumns(['description', 'status', 'action'])
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

    public function deleteRoleMain($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem([
                'targetId' => $id,
                'targetModal' => RoleMain::class,
                'picUrl' => '',
                'type' => Config::get('constants.actionFor.deleteType.smsr'),
                'idByField' => ''
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


    /*---- ( Role Sub ) ----*/
    public function showRoleSub()
    {
        try {
            $roleMain = GetManageAccessHelper::getList([
                'type' => ['roleMain'],
                'otherDataPasses' => [
                    'filterData' => [
                        'status' => Config::get('constants.status')['active']
                    ]
                ],
            ]);

            $roleMain = array();

            foreach (RoleMain::all() as $key => $value) {
                $roleMain[] = [
                    'id' => encrypt($value->id),
                    'name' => $value->name
                ];
            }

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
            $status = $request->status;

            $query = "`created_at` is not null";

            if (!empty($status)) {
                $query .= " and `status` = '" . $status . "'";
            }

            $roleSub = RoleSub::orderBy('id', 'desc')->whereRaw($query)->get();

            return Datatables::of($roleSub)
                ->addIndexColumn()
                ->addColumn('description', function ($data) {
                    $description = $this->subStrString(40, $data->description, '....');
                    return $description;
                })
                ->addColumn('status', function ($data) {
                    $status = CommonTrait::customizeInText(['type' => 'status', 'value' => $data->status])['status'];
                    return $status;
                })
                ->addColumn('roleMain', function ($data) {
                    $roleMain = RoleMain::where('id', $data->roleMainId)->first()->name;
                    return $roleMain;
                })
                ->addColumn('action', function ($data) {

                    // $itemPermission = $this->itemPermission();

                    $dataArray = [
                        'id' => encrypt($data->id),
                        'roleMain' => RoleMain::where('id', $data->roleMainId)->first()->name,
                        'name' => $data->name,
                        'description' => $data->description,
                    ];


                    // if ($itemPermission['status_item'] == '1') {
                    if ($data->status == Config::get('constants.status')['inactive']) {
                        $status = '<li><a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.roleSub') . '/' . $dataArray['id'] . '" class="dropdown-item actionDatatable" title="Unblock"><i class="las la-lock-open align-bottom me-2 text-muted"></i> <span>Change status</span></a></li>';
                    } else {
                        $status = '<li><a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.roleSub') . '/' . $dataArray['id'] . '" class="dropdown-item actionDatatable" title="Block"><i class="las la-lock align-bottom me-2 text-muted"></i> <span>Change status</span></a></li>';
                    }
                    // } else {
                    //     $status = '';
                    // }

                    // if ($itemPermission['edit_item'] == '1') {
                    $edit = '<li><a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="dropdown-item actionDatatable" title="Update"><i class="las la-edit align-bottom me-2 text-muted"></i> <span>Edit Role Sub</span></a></li>';
                    // } else {
                    //     $edit = '';
                    // }

                    // if ($itemPermission['delete_item'] == '1') {
                    $delete = '<li><a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.roleSub') . '/' . $dataArray['id'] . '" class="dropdown-item actionDatatable" title="Delete"><i class="las la-trash align-bottom me-2 text-muted"></i> <span>Delete item</span></a></li>';
                    // } else {
                    //     $delete = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $details = '<li><a href="JavaScript:void(0);" data-type="details" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="dropdown-item actionDatatable"><i class="las la-info-circle align-bottom me-2 text-muted"></i> <span>Quick view</span></a></li>';
                    // } else {
                    //     $details = '';
                    // }

                    $action = '<td>
                    <div class="dropdown d-inline-block tableActionContent">
                    <button class="btn btn-soft-info btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-equalizer-fill"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">' . $status . $edit . $delete . $details . '</ul>
                    </div>
                    </td>';

                    return $action;
                })
                ->rawColumns(['description', 'roleMain', 'status', 'action'])
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
                'targetId' => $id,
                'targetModal' => RoleSub::class,
                'picUrl' => '',
                'type' => Config::get('constants.actionFor.deleteType.smsr'),
                'idByField' => ''
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
}

<?php

namespace App\Http\Controllers\Admin\SetupAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\SetupAdmin\Role;
use App\Models\SetupAdmin\RolePermission;
use App\Models\SetupAdmin\SubMenu;

use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use League\Flysystem\Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;


class RolePermissionController extends Controller
{

    use CommonTrait, ValidationTrait;
    public $platform = 'backend';


    /*-----( Role )------*/
    public function showRole()
    {
        try {
            $role = Role::all();
            return view('admin.setup_admin.role_permission.roles', ['role' => $role]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getRole()
    {
        try {
            $role = Role::orderBy('id', 'desc')->where('adminId', Auth::guard('admin')->user()->id)->select('id', 'role', 'description', 'status');

            return Datatables::of($role)
                ->addIndexColumn()
                ->addColumn('description', function ($data) {
                    $description = $this->substarString(20, $data->description, '...');
                    return $description;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == '0') {
                        $status = '<span class="label label-danger">Blocked</span>';
                    } else {
                        $status = '<span class="label label-success">Active</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($data) {

                    $itemPermission = $this->itemPermission();

                    $dataArray = [
                        'id' => encrypt($data->id),
                        'role' => $data->role,
                        'description' => $data->description,
                    ];

                    if ($itemPermission['status_item'] == '1') {
                        if ($data->status == "0") {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.roles') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.roles') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        }
                    } else {
                        $status = '';
                    }

                    if ($itemPermission['edit_item'] == '1') {
                        $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="actionDatatable"><i class="md md-edit" style="font-size: 20px;"></i></a>';
                    } else {
                        $edit = '';
                    }

                    if ($itemPermission['details_item'] == '1') {
                        $detail = '<a href="JavaScript:void(0);" data-type="detail" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="actionDatatable"><i class="md md-visibility" style="font-size: 20px; color: green;"></i></a>';
                    } else {
                        $detail = '';
                    }

                    if ($data->id != 1) {
                        if ($itemPermission['delete_item'] == '1') {
                            $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.delete.roles') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                        } else {
                            $delete = '';
                        }
                    } else {
                        $delete = '';
                    }

                    if ($itemPermission['other_item'] == '1') {
                        $other = '<a href="' .  route('admin.edit.permissions') . '/' . $dataArray['id'] . '" target="_blank" title="Details"><i class="md md-now-widgets" style="font-size: 20px; color: blue;"></i></a>';
                    } else {
                        $other = '';
                    }

                    return $status . ' ' . $edit . ' ' . $detail . ' ' . $delete . ' ' . $other;
                })
                ->rawColumns(['description', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function saveRole(Request $request)
    {
        try {
            $values = $request->only('role', 'description');
            $validator = $this->isValid($request->all(), 'saveRole', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $role = new Role;
                $role->role = $values['role'];
                $role->adminId = Auth::guard('admin')->user()->id;
                $role->description = $values['description'];
                if ($role->save()) {
                    $role_id = $role->id;
                    $sub_module = SubMenu::all();
                    //print_r($sub_module); exit();

                    foreach ($sub_module as $temp) {
                        //echo $temp->id;
                        $permission = new RolePermission;
                        $permission->role_id = $role_id;
                        $permission->module_id = $temp->module_id;
                        $permission->sub_module_id = $temp->id;
                        $permission->module_access = 0;
                        $permission->sub_module_access = 0;
                        $permission->access_item = 0;
                        $permission->add_item = 0;
                        $permission->edit_item = 0;
                        $permission->details_item = 0;
                        $permission->delete_item = 0;
                        $permission->status_item = 0;
                        $permission->other_item = 0;
                        $permission->save();
                    }

                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Add Role", 'msg' => 'Banner Successfully saved.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Add Role", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Add Role", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateRole(Request $request)
    {
        $values = $request->only('id', 'role', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            //--Checking The Validation--//
            $validator = $this->isValid($request->all(), 'updateRole', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Add Role", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $role = Role::find($id);
                $role->role = $values['role'];
                $role->description = $values['description'];

                if ($role->update()) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Role", 'msg' => 'Role Successfully updated.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Update Role", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Role", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusRole($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, Role::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteRole($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            if (RolePermission::where('role_id', $id)->delete()) {
                $result = $this->deleteItem($id, Role::class, '');
                if ($result === true) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => 'Role and Permissions are deleted successfully changed.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    /*-----( Permission )------*/
    public function getPermissions()
    {
        try {
            $id = session()->get('id');

            $permissions = DB::table('role_permission')
                ->join('module', 'module.id', '=', 'role_permission.module_id')
                ->join('sub_module', 'sub_module.id', '=', 'role_permission.sub_module_id')
                ->orderBy('module.orders', 'asc')
                ->orderBy('sub_module.orders', 'asc')
                ->select(
                    'role_permission.*',
                    'module.name as module_name',
                    'sub_module.name as sub_module_name',
                    'sub_module.add_action',
                    'sub_module.edit_action',
                    'sub_module.details_action',
                    'sub_module.delete_action',
                    'sub_module.status_action',
                    'sub_module.other_action'
                )->where('role_permission.role_id', $id);

            return Datatables::of($permissions)
                ->addIndexColumn()
                ->addColumn('accessItem', function ($data) {
                    if ($data->access_item == 1) {
                        $accessItem = '<div class=""><input type="checkbox" class="checkbox" name="access_item' . $data->id . '" value="1" checked="true" /></div>';
                    } else {
                        $accessItem = '<div class=""><input type="checkbox" class="checkbox" name="access_item' . $data->id . '" value="0" /></div>';
                    }
                    return $accessItem . '<input type="hidden" name="id[]" value="' . $data->id . '">';
                })
                ->addColumn('addAction', function ($data) {
                    if ($data->add_action == 1) {
                        if ($data->add_item == 1) {
                            $addAction = '<div class=""><input type="checkbox" class="checkbox" name="add_item' . $data->id . '" value="1" checked="true" /></div>';
                        } else {
                            $addAction = '<div class=""><input type="checkbox" class="checkbox" name="add_item' . $data->id . '" value="0" /></div>';
                        }
                    } else {
                        $addAction = '<div class=""><input type="hidden" name="add_item' . $data->id . '" value="0" /><span class="label label-danger">NA</span></div>';
                    }
                    return $addAction . '<input type="hidden" name="id[]" value="' . $data->id . '">';
                })
                ->addColumn('editAction', function ($data) {
                    if ($data->edit_action == 1) {
                        if ($data->edit_item == 1) {
                            $editAction = '<div class=""><input type="checkbox" class="checkbox" name="edit_item' . $data->id . '" value="1" checked="true" /></div>';
                        } else {
                            $editAction = '<div class=""><input type="checkbox" class="checkbox" name="edit_item' . $data->id . '" value="0" /></div>';
                        }
                    } else {
                        $editAction = '<div class=""><input type="hidden" name="edit_item' . $data->id . '" value="0" /><span class="label label-danger">NA</span></div>';
                    }
                    return $editAction;
                })
                ->addColumn('deleteAction', function ($data) {
                    if ($data->delete_action == 1) {
                        if ($data->delete_item == 1) {
                            $deleteAction = '<div class=""><input type="checkbox" class="checkbox" name="delete_item' . $data->id . '" value="1" checked="true" /></div>';
                        } else {
                            $deleteAction = '<div class=""><input type="checkbox" class="checkbox" name="delete_item' . $data->id . '" value="0" /></div>';
                        }
                    } else {
                        $deleteAction = '<div class=""><input type="hidden" name="delete_item' . $data->id . '" value="0" /><span class="label label-danger">NA</span></div>';
                    }
                    return $deleteAction;
                })
                ->addColumn('detailsAction', function ($data) {
                    if ($data->details_action == 1) {
                        if ($data->details_item == 1) {
                            $detailsAction = '<div class=""><input type="checkbox" class="checkbox" name="details_item' . $data->id . '" value="1" checked="true" /></div>';
                        } else {
                            $detailsAction = '<div class=""><input type="checkbox" class="checkbox" name="details_item' . $data->id . '" value="0" /></div>';
                        }
                    } else {
                        $detailsAction = '<div class=""><input type="hidden" name="details_item' . $data->id . '" value="0" /><span class="label label-danger">NA</span></div>';
                    }
                    return $detailsAction;
                })
                ->addColumn('statusAction', function ($data) {
                    if ($data->status_action == 1) {
                        if ($data->status_item == 1) {
                            $statusAction = '<div class=""><input type="checkbox" class="checkbox" name="status_item' . $data->id . '" value="1" checked="true" /></div>';
                        } else {
                            $statusAction = '<div class=""><input type="checkbox" class="checkbox" name="status_item' . $data->id . '" value="0" /></div>';
                        }
                    } else {
                        $statusAction = '<div class=""><input type="hidden" name="status_item' . $data->id . '" value="0" /><span class="label label-danger">NA</span></div>';
                    }
                    return $statusAction;
                })
                ->addColumn('otherAction', function ($data) {
                    if ($data->other_action == 1) {
                        if ($data->other_item == 1) {
                            $otherAction = '<div class=""><input type="checkbox" class="checkbox" name="other_item' . $data->id . '" value="1" checked="true" /></div>';
                        } else {
                            $otherAction = '<div class=""><input type="checkbox" class="checkbox" name="other_item' . $data->id . '" value="0" /></div>';
                        }
                    } else {
                        $otherAction = '<div class=""><input type="hidden" name="other_item' . $data->id . '" value="0" /><span class="label label-danger">NA</span></div>';
                    }
                    return $otherAction;
                })
                ->rawColumns(['accessItem', 'addAction', 'editAction', 'deleteAction', 'detailsAction', 'statusAction', 'otherAction'])
                ->make(true);
            session()->forget('id');
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Role", 'msg' =>  __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function editPermission($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', __('messages.serverErrMsg'));
        }

        try {
            session()->put('id', $id);
            $data = array(
                'roleId' => $id,
            );
            return view('admin.setup_admin.role_permission.edit_permissions', ['data' => $data]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('messages.serverErrMsg'));
        }
    }

    public function updatePermission(Request $request)
    {
        $user = auth()->guard('admin')->user();
        $ids = $request->get('id');
        $role_id = $request->get('role_id');

        foreach ($ids as $i) {
            $access_item = $request->get('access_item' . $i);
            $add_item = $request->get('add_item' . $i);
            $edit_item = $request->get('edit_item' . $i);
            $details_item = $request->get('details_item' . $i);
            $delete_item = $request->get('delete_item' . $i);
            $status_item = $request->get('status_item' . $i);
            $other_item = $request->get('other_item' . $i);

            $permission = RolePermission::where([['id', $i], ['role_id', $role_id]])->first();


            if (!empty($access_item)) {
                $permission->access_item = $access_item;
                $permission->module_access = 1;
                $permission->sub_module_access = 1;
            } else {
                $permission->access_item = 0;
                $permission->module_access = 0;
                $permission->sub_module_access = 0;
            }

            if (!empty($add_item)) {
                $permission->add_item = $add_item;
            } else {
                $permission->add_item = 0;
            }

            if (!empty($edit_item)) {
                $permission->edit_item = $edit_item;
            } else {
                $permission->edit_item = 0;
            }

            if (!empty($details_item)) {
                $permission->details_item = $details_item;
            } else {
                $permission->details_item = 0;
            }

            if (!empty($delete_item)) {
                $permission->delete_item = $delete_item;
            } else {
                $permission->delete_item = 0;
            }

            if (!empty($status_item)) {
                $permission->status_item = $status_item;
            } else {
                $permission->status_item = 0;
            }

            if (!empty($other_item)) {
                $permission->other_item = $other_item;
            } else {
                $permission->other_item = 0;
            }

            $permission->update();
        }

        return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Permission", 'msg' => 'Permissions are successfully updated.'], config('constants.ok'));
    }
}

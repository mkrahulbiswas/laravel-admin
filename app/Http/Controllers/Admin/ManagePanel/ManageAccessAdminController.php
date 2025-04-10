<?php

namespace App\Http\Controllers\Admin\ManagePanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\ManageAccess\ManageNav\MainRole;

use App\Helpers\GetManageNavHelper;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\DataTables;

class ManageAccessAdminController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Main Role ) ----*/
    public function showMainRole()
    {
        try {
            return view('admin.manage_panel.manage_access.main_role.main_role_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getMainRole(Request $request)
    {
        try {
            $status = $request->status;

            $query = "`created_at` is not null";

            if (!empty($status)) {
                $query .= " and `status` = '" . $status . "'";
            }

            $mainRole = MainRole::orderBy('id', 'desc')->whereRaw($query)->get();

            return Datatables::of($mainRole)
                ->addIndexColumn()
                ->addColumn('description', function ($data) {
                    $description = $this->subStrString(40, $data->description, '....');
                    return $description;
                })
                ->addColumn('status', function ($data) {
                    $status = CommonTrait::customizeInText(['type' => 'status', 'value' => $data->status])['status'];
                    return $status;
                })
                ->addColumn('icon', function ($data) {
                    $icon = '<i class="' . $data->icon . '"></i>';
                    return $icon;
                })
                ->addColumn('action', function ($data) {

                    // $itemPermission = $this->itemPermission();

                    $dataArray = [
                        'id' => encrypt($data->id),
                        'name' => $data->name,
                        'icon' => $data->icon,
                        'description' => $data->description,
                    ];


                    // if ($itemPermission['status_item'] == '1') {
                    if ($data->status == Config::get('constants.status')['inactive']) {
                        $status = '<li><a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.mainRole') . '/' . $dataArray['id'] . '" class="dropdown-item actionDatatable" title="Unblock"><i class="las la-lock-open align-bottom me-2 text-muted"></i> <span>Change status</span></a></li>';
                    } else {
                        $status = '<li><a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.mainRole') . '/' . $dataArray['id'] . '" class="dropdown-item actionDatatable" title="Block"><i class="las la-lock align-bottom me-2 text-muted"></i> <span>Change status</span></a></li>';
                    }
                    // } else {
                    //     $status = '';
                    // }

                    // if ($itemPermission['edit_item'] == '1') {
                    $edit = '<li><a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="dropdown-item actionDatatable" title="Update"><i class="las la-edit align-bottom me-2 text-muted"></i> <span>Edit Main Role</span></a></li>';
                    // } else {
                    //     $edit = '';
                    // }

                    // if ($itemPermission['delete_item'] == '1') {
                    $delete = '<li><a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.mainRole') . '/' . $dataArray['id'] . '" class="dropdown-item actionDatatable" title="Delete"><i class="las la-trash align-bottom me-2 text-muted"></i> <span>Delete item</span></a></li>';
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
                ->rawColumns(['description', 'status', 'icon', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveMainRole(Request $request)
    {
        try {
            $values = $request->only('name', 'icon', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'saveMainRole',
                'id' => 0,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $mainRole = new MainRole;
                $mainRole->name = $values['name'];
                $mainRole->icon = $values['icon'];
                $mainRole->description = $values['description'];
                $mainRole->uniqueId = $this->generateCode(['preString' => 'NT', 'length' => 6, 'model' => MainRole::class, 'field' => '']);
                $mainRole->status = Config::get('constants.status')['active'];
                $mainRole->position = MainRole::max('position') + 1;

                if ($mainRole->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Main Role", 'msg' => __('messages.saveMsg', ['type' => 'Main Role'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Main Role", 'msg' => __('messages.saveMsg', ['type' => 'Main Role'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Main Role", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateMainRole(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Main Role", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'updateMainRole',
                'id' => $id,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $mainRole = MainRole::find($id);

                $mainRole->name = $values['name'];
                $mainRole->icon = $values['icon'];
                $mainRole->description = $values['description'];

                if ($mainRole->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Main Role", 'msg' => __('messages.updateMsg', ['type' => 'Main Role'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Main Role", 'msg' => __('messages.updateMsg', ['type' => 'Main Role'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Main Role", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusMainRole($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => MainRole::class,
                'targetField' => [],
                'type' => Config::get('constants.actionFor.statusType.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Main Role'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Main Role'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteMainRole($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem([
                'targetId' => $id,
                'targetModal' => MainRole::class,
                'picUrl' => '',
                'type' => Config::get('constants.actionFor.deleteType.smsr'),
                'idByField' => ''
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Main Role'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Main Role'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }
}

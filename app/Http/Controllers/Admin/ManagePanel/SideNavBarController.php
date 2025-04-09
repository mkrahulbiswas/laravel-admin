<?php

namespace App\Http\Controllers\Admin\SetupAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


use App\Models\SetupAdmin\Role;
use App\Models\SetupAdmin\RolePermission;
use App\Models\SetupAdmin\MainMenu;
use App\Models\SetupAdmin\SubMenu;

use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use League\Flysystem\Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;


class SideNavBarController extends Controller
{

    use CommonTrait, ValidationTrait;
    public $platform = 'backend';


    /*-----( Side Nav Bar )------*/
    public function showSideNavBar()
    {
        try {
            $mainMenuData = array();
            $subMenuData = array();

            foreach (MainMenu::orderBy('orders', 'asc')->get() as $tempOne) {
                foreach (SubMenu::where('module_id', $tempOne->id)->orderBy('orders', 'asc')->get() as $tempTwo) {
                    $subMenuData[] = array(
                        'id' => $tempTwo->id,
                        'name' => $tempTwo->name,
                        'icon' => $tempTwo->icon,
                        'orders' => $tempTwo->orders,
                    );
                }
                $mainMenuData[] = array(
                    'id' => $tempOne->id,
                    'name' => $tempOne->name,
                    'icon' => $tempOne->icon,
                    'orders' => $tempOne->orders,
                    'subMenuData' => $subMenuData,
                );
                $subMenuData = array();
            }

            $data = array(
                'mainMenu' => MainMenu::select('id', 'name')->where('status', '1')->get(),
                'sideNavBar' => $mainMenuData
            );

            return view('admin.setup_admin.side_nav_bar.index', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    /*-----( Main Menu )------*/
    public function getMainMenu()
    {
        try {
            $mainMenu = MainMenu::orderBy('orders', 'asc')->select('id', 'name', 'icon', 'status', 'created_at');

            return Datatables::of($mainMenu)
                ->addIndexColumn()
                ->addColumn('icon', function ($data) {
                    $icon = '<i class="md ' . $data->icon . '"></i>';
                    return $icon;
                })
                ->addColumn('createAt', function ($data) {
                    $createAt = date('d-M-Y, h:i A', strtotime($data->created_at));
                    return $createAt;
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
                        'name' => $data->name,
                        'icon' => $data->icon,
                    ];

                    if ($itemPermission['status_item'] == '1') {
                        if ($data->status == "0") {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.mainMenu') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.mainMenu') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        }
                    } else {
                        $status = '';
                    }

                    if ($itemPermission['edit_item'] == '1') {
                        $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="actionDatatable"><i class="md md-edit" style="font-size: 20px;"></i></a>';
                    } else {
                        $edit = '';
                    }

                    if ($itemPermission['delete_item'] == '1') {
                        $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.delete.mainMenu') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                    } else {
                        $delete = '';
                    }

                    return $status . ' ' . $edit . ' ' . $delete;
                })
                ->rawColumns(['icon', 'createAt', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function saveMainMenu(Request $request)
    {
        try {
            $values = $request->only('name', 'icon');
            $validator = $this->isValid($request->all(), 'saveMainMenu', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $mainMenu = new MainMenu;
                $mainMenu->name = $values['name'];
                $mainMenu->icon = $values['icon'];
                $mainMenu->orders = MainMenu::max('orders') + 1;
                if ($mainMenu->save()) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Add Main Menu", 'msg' => 'Main Menu Successfully saved.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Add Main Menu", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Add Main Menu", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateMainMenu(Request $request)
    {
        $values = $request->only('id', 'name', 'icon');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $validator = $this->isValid($request->all(), 'updateMainMenu', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $mainMenu = MainMenu::find($id);
                $mainMenu->name = $values['name'];
                $mainMenu->icon = $values['icon'];
                if ($mainMenu->update()) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Main Menu", 'msg' => 'Main Menu Successfully updated.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Update Main Menu", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Main Menu", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusMainMenu($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, MainMenu::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteMainMenu($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $subMenu = SubMenu::where('module_id', $id)->first();
            if ($subMenu == null) {
                goto a;
            } else {
                goto b;
            }
            b:
            if (SubMenu::where('module_id', $id)->delete()) {
                if (RolePermission::where('module_id', $id)->delete()) {
                    a:
                    $result = $this->deleteItem($id, MainMenu::class, '');
                    if ($result === true) {
                        return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => 'Role and Permissions are deleted successfully changed.'], config('constants.ok'));
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                    }
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


    /*-----( Sub Menu )------*/
    public function getSubMenu()
    {
        try {
            $subMenu = SubMenu::orderBy('id', 'asc')->select('id', 'name', 'module_id', 'link', 'last_segment', 'add_action', 'edit_action', 'details_action', 'delete_action', 'status_action', 'other_action', 'status', 'created_at');

            return Datatables::of($subMenu)
                ->addIndexColumn()
                ->addColumn('createAt', function ($data) {
                    $createAt = date('d-M-Y, h:i A', strtotime($data->created_at));
                    return $createAt;
                })
                ->addColumn('mainMenu', function ($data) {
                    $mainMenu = MainMenu::where('id', $data->module_id)->value('name');
                    return $mainMenu;
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
                        'mainMenuId' => $data->module_id,
                        'mainMenu' => MainMenu::where('id', $data->module_id)->value('name'),
                        'name' => $data->name,
                        'linkTo' => $data->link,
                        'lastSegment' => $data->last_segment,
                        'addAction' => $data->add_action,
                        'editAction' => $data->edit_action,
                        'detailsAction' => $data->details_action,
                        'deleteAction' => $data->delete_action,
                        'statusAction' => $data->status_action,
                        'statusAction' => $data->status_action,
                        'otherAction' => $data->other_action,
                    ];

                    if ($itemPermission['status_item'] == '1') {
                        if ($data->status == "0") {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.subMenu') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.subMenu') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
                        }
                    } else {
                        $status = '';
                    }

                    if ($itemPermission['edit_item'] == '1') {
                        $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="actionDatatable"><i class="md md-edit" style="font-size: 20px;"></i></a>';
                    } else {
                        $edit = '';
                    }

                    if ($itemPermission['delete_item'] == '1') {
                        $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.delete.subMenu') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($itemPermission['details_item'] == '1') {
                        $detail = '<a href="JavaScript:void(0);" data-type="detail" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="actionDatatable"><i class="md md-visibility" style="font-size: 20px; color: green;"></i></a>';
                    } else {
                        $detail = '';
                    }

                    return $status . ' ' . $edit . ' ' . $delete . ' ' . $detail;
                })
                ->rawColumns(['createAt', 'mainMenu', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function saveSubMenu(Request $request)
    {
        $values = $request->only('mainMenu', 'name', 'addAction', 'editAction', 'detailsAction', 'deleteAction', 'statusAction', 'otherAction');

        try {
            $validator = $this->isValid($request->all(), 'saveSubMenu', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $subMenu = new SubMenu;
                $subMenu->name = $values['name'];
                $subMenu->module_id = $values['mainMenu'];
                $subMenu->link = 'admin/' . strtolower(str_replace(" ", "-", MainMenu::where('id', $values['mainMenu'])->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $subMenu->last_segment = strtolower(str_replace(" ", "-", $values['name']));
                $subMenu->add_action = ($values['addAction'] == '') ? 0 : $values['addAction'];
                $subMenu->edit_action = ($values['editAction'] == '') ? 0 : $values['editAction'];
                $subMenu->details_action = ($values['detailsAction'] == '') ? 0 : $values['detailsAction'];
                $subMenu->delete_action = ($values['deleteAction'] == '') ? 0 : $values['deleteAction'];
                $subMenu->status_action = ($values['statusAction'] == '') ? 0 : $values['statusAction'];
                $subMenu->other_action = ($values['otherAction'] == '') ? 0 : $values['otherAction'];
                $subMenu->orders = SubMenu::max('orders') + 1;
                if ($subMenu->save()) {

                    foreach (Role::get() as $temp) {
                        $permission = new RolePermission;
                        $permission->role_id = $temp->id;
                        $permission->module_id = $values['mainMenu'];
                        $permission->sub_module_id = $subMenu->id;
                        $permission->module_access = 1;
                        $permission->sub_module_access = 1;
                        $permission->access_item = 1;
                        $permission->add_item = 0;
                        $permission->edit_item = 0;
                        $permission->details_item = 0;
                        $permission->delete_item = 0;
                        $permission->status_item = 0;
                        $permission->other_item = 0;
                        $permission->save();
                    }

                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Add Sub Menu", 'msg' => 'Sub Menu Successfully saved.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Add Sub Menu", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Add Sub Menu", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateSubMenu(Request $request)
    {
        $values = $request->only('id', 'mainMenu', 'name', 'addAction', 'editAction', 'detailsAction', 'deleteAction', 'statusAction', 'otherAction');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $validator = $this->isValid($request->all(), 'updateSubMenu', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $subMenu = SubMenu::find($id);
                $subMenu->name = $values['name'];
                $subMenu->module_id = $values['mainMenu'];
                $subMenu->link = 'admin/' . strtolower(str_replace(" ", "-", MainMenu::where('id', $values['mainMenu'])->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $subMenu->last_segment = strtolower(str_replace(" ", "-", $values['name']));
                $subMenu->add_action = ($values['addAction'] == '') ? 0 : $values['addAction'];
                $subMenu->edit_action = ($values['editAction'] == '') ? 0 : $values['editAction'];
                $subMenu->details_action = ($values['detailsAction'] == '') ? 0 : $values['detailsAction'];
                $subMenu->delete_action = ($values['deleteAction'] == '') ? 0 : $values['deleteAction'];
                $subMenu->status_action = ($values['statusAction'] == '') ? 0 : $values['statusAction'];
                $subMenu->other_action = ($values['otherAction'] == '') ? 0 : $values['otherAction'];
                if ($subMenu->update()) {
                    if (RolePermission::where('sub_module_id', $id)->delete()) {
                        foreach (Role::get() as $temp) {
                            $permission = new RolePermission;
                            $permission->role_id = $temp->id;
                            $permission->module_id = $values['mainMenu'];
                            $permission->sub_module_id = $subMenu->id;
                            $permission->module_access = 1;
                            $permission->sub_module_access = 1;
                            $permission->access_item = 1;
                            $permission->add_item = 0;
                            $permission->edit_item = 0;
                            $permission->details_item = 0;
                            $permission->delete_item = 0;
                            $permission->status_item = 0;
                            $permission->other_item = 0;
                            $permission->save();
                        }
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Update Sub Menu", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                    }
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Sub Menu", 'msg' => 'Sub Menu Successfully updated.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Update Sub Menu", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Sub Menu", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusSubMenu($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, SubMenu::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteSubMenu($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            if (RolePermission::where('sub_module_id', $id)->delete()) {
                $result = $this->deleteItem($id, SubMenu::class, '');
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


    /*-----( Arrange Order )------*/
    public function updateArrangeOrder(Request $request)
    {
        $values = $request->only('mainMenuOrder', 'subMenuOrder');

        try {
            foreach ($values['mainMenuOrder'] as $key => $temp) {
                MainMenu::where('id', $temp)->update([
                    'orders' => ($key+1)
                ]);
            }
            foreach ($values['subMenuOrder'] as $key => $temp) {
                SubMenu::where('id', $temp)->update([
                    'orders' => ($key+1)
                ]);
            }
            return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Sub Menu", 'msg' => $values], config('constants.ok'));
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Sub Menu", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }
}

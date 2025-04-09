<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\Admin;
use App\Models\Credits;
use App\Models\SetupAdmin\Role;
use App\Models\User;
use App\Models\PurchaseEntry;
use App\Models\SalesEntry;
use App\Models\Payment;
use App\Models\Product;

use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class UserAdminController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';



    /*------- ( ADMINS ) -------*/
    public function showSubAdmins()
    {
        try {
            return view('admin.users.admin.list_admin');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getSubAdmins()
    {
        $admin = Admin::orderBy('id', 'desc')->select('id', 'role_id', 'name', 'email', 'phone', 'profilePic', 'address', 'status')->whereNotIn('role_id', [1]);

        return Datatables::of($admin)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                $image = '<img src="' . $this->picUrl($data->profilePic, 'adminPic', $this->platform) . '" class="img-fluid rounded" width="100"/>';
                return $image;
            })
            ->addColumn('role', function ($data) {
                $role = Role::where('id', $data->role_id)->value('role');
                return $role;
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
                ];

                if ($itemPermission['status_item'] == '1') {
                    if ($data->status == "0") {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.usersAdmin') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                    } else {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.usersAdmin') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
                    }
                } else {
                    $status = '';
                }

                if ($itemPermission['edit_item'] == '1') {
                    $edit = '<a href="' . route('admin.edit.usersAdmin') . '/' . $dataArray['id'] . '" title="Update"><i class="md md-edit" style="font-size: 20px;"></i></a>';
                } else {
                    $edit = '';
                }

                if ($itemPermission['details_item'] == '1') {
                    $detail = '<a href="' .  route('admin.details.usersAdmin') . '/' . $dataArray['id'] . '" target="_blank" title="Details"><i class="md md-visibility" style="font-size: 20px; color: green;"></i></a>';
                } else {
                    $detail = '';
                }

                if ($data->id != 1) {
                    if ($itemPermission['delete_item'] == '1') {
                        $delete = '<a href="JavaScript:void(0);" data-action="' . route('admin.delete.usersAdmin') . '/' . $dataArray['id'] . '" data-type="delete" class="actionDatatable" title="Delete"><i class="md md-delete" style="font-size: 20px; color: red;"></i></a>';
                    } else {
                        $delete = '';
                    }
                } else {
                    $delete = '';
                }

                return $status . ' ' . $edit . ' ' . $detail . ' ' . $delete;
            })
            ->rawColumns(['image', 'role', 'status', 'action'])
            ->make(true);
    }

    public function addSubAdmin()
    {
        try {
            $data =  $role = array();
            foreach (Role::whereNotIn('id', [1])->where('adminId', Auth::guard('admin')->user()->id)->get() as $temp) {
                $role[] = array(
                    'id' => encrypt($temp->id),
                    'role' => $temp->role,
                );
            }
            $data = array(
                'role' => $role,
            );
            return view('admin.users.admin.add_admin', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function saveSubAdmin(Request $request)
    {
        try {
            DB::beginTransaction();
            $values = $request->only('name', 'email', 'phone', 'password', 'confirmPassword', 'role', 'address');
            $file = $request->file('file');

            //--Checking The Validation--//
            $validator = $this->isValid($request->all(), 'saveAdmin', 0, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                if ($file) {
                    $profilePic = $this->uploadPicture($file, '', $this->platform, 'adminPic');
                    if ($profilePic === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    }
                }

                $user = new User;
                $user->userType = config('constants.userType')['subAdmin'];
                $user->uniqueId = $this->generateCode('ADM', 6, User::class, 'uniqueId');
                $user->name = $values['name'];
                $user->email = $values['email'];
                $user->phone = $values['phone'];
                $user->address = ($values['address'] == '') ? 'NA' : $values['address'];
                $user->password = Hash::make($values['password']);
                if ($file) {
                    $user->image = $profilePic;
                }

                if ($user->save()) {
                    DB::commit();
                    $admin = new Admin;
                    $admin->id = $user->id;
                    $admin->name = $values['name'];
                    $admin->email = $values['email'];
                    $admin->phone = $values['phone'];
                    $admin->role_id = ($values['role'] == '') ? null : decrypt($values['role']);
                    $admin->address = ($values['address'] == '') ? 'NA' : $values['address'];
                    $admin->password = Hash::make($values['password']);
                    if ($file) {
                        $admin->profilePic = $profilePic;
                    }
                    if ($admin->save()) {
                        DB::commit();
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Add Sub Admin", 'msg' => 'Sub Admin Successfully saved.'], config('constants.ok'));
                    } else {
                        DB::rollback();
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Add Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                    }
                } else {
                    DB::rollback();
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Add Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Add Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function editSubAdmin($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $data =  $role = array();
            foreach (Role::whereNotIn('id', [1])->where('adminId', Auth::guard('admin')->user()->id)->get() as $temp) {
                $role[] = array(
                    'id' => encrypt($temp->id),
                    'role' => $temp->role,
                    'adminId' => Auth::guard('admin')->user()->id,
                );
            }
            $admin = Admin::where('id', $id)->first();
            $data = array(
                'role' => $role,
                'id' => encrypt($admin->id),
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
                'address' => $admin->address,
                'roleId' => $admin->role_id,
                'restaurantId' => $admin->restaurantId,
                'image' => $this->picUrl($admin->profilePic, 'adminPic', $this->platform),
            );
            return view('admin.users.admin.edit_admin', ['data' => $data]);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function updateSubAdmin(Request $request)
    {
        $values = $request->only('id', 'name', 'email', 'phone', 'address', 'role');
        $file = $request->file('file');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $admin = Admin::findOrFail($id);
            $user = User::findOrFail($id);

            $validator = $this->isValid($request->all(), 'updateAdmin', $id, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                if ($file) {
                    $image = $this->uploadPicture($file, $admin->profilePic, $this->platform, 'adminPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    }
                }

                $user->name = $values['name'];
                $user->email = $values['email'];
                $user->phone = $values['phone'];
                $user->address = $values['address'];

                if ($file) {
                    $user->image = $image;
                }

                if ($user->update()) {
                    $admin->name = $values['name'];
                    $admin->email = $values['email'];
                    $admin->phone = $values['phone'];
                    $admin->address = $values['address'];
                    $admin->role_id = decrypt($values['role']);
                    // $admin->password = $values['address'];

                    if ($file) {
                        $admin->profilePic = $image;
                    }

                    if ($admin->update()) {
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update Sub Admin", 'msg' => 'Sub Admin successfully update.'], config('constants.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                    }
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusSubAdmin($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, Admin::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteSubAdmin($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem($id, Admin::class, '');
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => 'Deleted successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function detailSubAdmin($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $admin = Admin::where('id', $id)->first();
            $data = array(
                'image' => $this->picUrl($admin->profilePic, 'adminPic', $this->platform),
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
                'role' => Role::where('id', $admin->role_id)->value('role'),
                'address' => $admin->address,
            );
            return view('admin.users.admin.detail_admin')->with('data', $data);
        } catch (Exception $e) {
            return redirect()->abort();
        }
    }



    public function editMyAccount()
    {
        try {
            foreach (Role::get() as $temp) {
                $role[] = array(
                    'id' => $temp->id,
                    'role' => $temp->role,
                );
            }
            $admin = Admin::where('id', Auth::guard('admin')->user()->id)->first();
            $data = array(
                'role' => $role,
                'id' => encrypt($admin->id),
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
                'address' => $admin->address,
                'orgAddress' => $admin->orgAddress,
                'orgAddress' => $admin->orgAddress,
                'orgEmail' => $admin->orgEmail,
                'orgPhone' => $admin->orgPhone,
                'roleId' => $admin->role_id,
                'image' => $this->picUrl($admin->profilePic, 'adminPic', $this->platform),
            );
            return view('admin.my_account.edit_admin', ['data' => $data]);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function updateMyAccount(Request $request)
    {
        $values = $request->only('id', 'name', 'email', 'phone', 'password', 'confirmPassword', 'role', 'address', 'orgName', 'orgAddress');
        $file = $request->file('file');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $admin = Admin::findOrFail($id);

            $validator = $this->isValid($request->all(), 'updateAdmin', $id, $this->platform);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                if ($file) {
                    $image = $this->uploadPicture($file, $admin->profilePic, $this->platform, 'adminPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    }
                }

                $admin->name = $values['name'];
                $admin->email = $values['email'];
                $admin->phone = $values['phone'];
                $admin->role_id = $values['role'];
                $admin->address = $values['address'];

                if ($values['password'] != '') {
                    $admin->password = Hash::make($values['password']);
                }

                if ($file) {
                    $admin->profilePic = $image;
                }

                if ($admin->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update Sub Admin", 'msg' => 'Sub Admin successfully update.'], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update Sub Admin", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }


    /*------- ( Client ) -------*/
    public function showClient()
    {
        try {
            return view('admin.users.client.list_client');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getClient()
    {
        $user = User::orderBy('id', 'desc')->where('userType', config('constants.userType')['client'])->select('id', 'image', 'phone', 'name', 'email', 'status');

        return Datatables::of($user)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == '0') {
                    $status = '<span class="label label-danger">Blocked</span>';
                } else {
                    $status = '<span class="label label-success">Active</span>';
                }
                return $status;
            })
            ->addColumn('image', function ($data) {
                $image = '<img src="' . $this->picUrl($data->image, 'clientPic', $this->platform) . '" class="img-fluid rounded" width="100"/>';
                return $image;
            })
            ->addColumn('action', function ($data) {

                $itemPermission = $this->itemPermission();

                $dataArray = [
                    'id' => encrypt($data->id),
                ];

                if ($itemPermission['status_item'] == '1') {
                    if ($data->status == "0") {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.client') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Block"><i class="md md-lock" style="font-size: 20px; color: #2bbbad;"></i></a>';
                    } else {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.client') . '/' . $dataArray['id'] . '" class="actionDatatable" title="Unblock"><i class="md md-lock-open" style="font-size: 20px; color: #2bbbad;"></i></a>';
                    }
                } else {
                    $status = '';
                }

                if ($itemPermission['edit_item'] == '1') {
                    $edit = '<a href="' . route('admin.edit.client') . '/' . $dataArray['id'] . '" title="Update"><i class="md md-edit" style="font-size: 20px;"></i></a>';
                } else {
                    $edit = '';
                }

                if ($itemPermission['details_item'] == '1') {
                    $detail = '<a href="' .  route('admin.details.client') . '/' . $dataArray['id'] . '" target="_blank" title="Details"><i class="md md-visibility" style="font-size: 20px; color: green;"></i></a>';
                } else {
                    $detail = '';
                }

                return $status . ' ' .  $edit . ' ' . $detail;
            })
            ->rawColumns(['image', 'role', 'status', 'action'])
            ->make(true);
    }

    public function addClient()
    {
        try {
            return view('admin.users.client.add_client');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function saveClient(Request $request)
    {
        try {
            $values = $request->only('name', 'phone', 'altPhone', 'email', 'address', 'businessName', 'businessEmail', 'businessAddress');
            $file = $request->file('file');

            //--Checking The Validation--//
            $validator = $this->isValid($request->all(), 'saveClient', 0, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                if (!empty($file)) {
                    $image = $this->uploadPicture($file, '', $this->platform, 'clientPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    }
                } else {
                    $image = "NA";
                }

                $user = new User();
                $user->uniqueId = $this->generateCode('CLI', 6, User::class, 'uniqueId');
                $user->businessName = $values['businessName'];
                $user->businessEmail = $values['businessEmail'];
                $user->businessAddress = $values['businessAddress'];
                $user->name = $values['name'];
                $user->phone = $values['phone'];
                $user->image = $image;
                $user->email = ($values['email'] == '') ? 'NA' : $values['email'];
                $user->address = ($values['address'] == '') ? null : $values['address'];
                $user->userType = config('constants.userType')['client'];
                $user->password = Hash::make(123456);

                if ($user->save()) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Add Client", 'msg' => 'Client Successfully saved.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Add Client", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Add Client", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function editClient($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $user = User::where('id', $id)->first();
            $data = array(
                'id' => encrypt($user->id),
                'name' => $user->name,
                'phone' => $user->phone,
                'businessName' => $user->businessName,
                'businessEmail' => $user->businessEmail,
                'businessAddress' => $user->businessAddress,
                'image' => $this->picUrl($user->image, 'clientPic', $this->platform),
                'email' => ($user->email == 'NA') ? '' : $user->email,
                'address' => ($user->address == null) ? '' : $user->address,
            );
            return view('admin.users.client.edit_client', ['data' => $data]);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function updateClient(Request $request)
    {
        $values = $request->only('id', 'name', 'phone', 'altPhone', 'email', 'address', 'businessName', 'businessEmail', 'businessAddress');
        $file = $request->file('file');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Client", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid($request->all(), 'updateClient', $id, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $user = User::findOrFail($id);

                if (!empty($file)) {
                    $image = $this->uploadPicture($file, $user->image, $this->platform, 'clientPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
                    } else {
                        $user->image = $image;
                    }
                }

                $user->name = $values['name'];
                $user->phone = $values['phone'];
                $user->email = ($values['email'] == '') ? 'NA' : $values['email'];
                $user->address = ($values['address'] == '') ? null : $values['address'];
                $user->businessName = $values['businessName'];
                $user->businessEmail = $values['businessEmail'];
                $user->businessAddress = $values['businessAddress'];

                if ($user->update()) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Client", 'msg' => 'Client successfully update.'], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Update Client", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Client", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusClient($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus($id, User::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function detailClient($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }

        try {
            $salesEntry = $payment = array();
            $user = User::where('id', $id)->first();
            $clientPay = $clientNeverPay = 0;

            foreach (SalesEntry::where('clientId', $id)->get() as $tempOne) {
                foreach (Payment::where([
                    ['clientId', $id],
                    ['targetId', $tempOne->id],
                    ['paymentFor', config('constants.paymentFor')['sales']]
                ])->get() as $tempTwo) {
                    if ($tempTwo->settlement == 0) {
                        $clientPay += $tempTwo->amount;
                        $settlement = '<span class="label label-success">Payed By Client</span>';
                    } else {
                        $clientNeverPay += $tempTwo->amount;
                        $settlement = '<span class="label label-danger">Client is not payed</span>';
                    }
                    $payment[] = array(
                        'amount' => $tempTwo->amount,
                        'settlement' => $settlement,
                        'date' => date('d-m-Y', strtotime($tempTwo->date)),
                    );
                }
                $salesEntry[] = array(
                    'uniqueId' => '<a href="' . route('admin.details.salesEntry', encrypt($tempOne->id)) . '" target="_blank">' . $tempOne->uniqueId . '</a>',
                    'totalSale' => $tempOne->totalSale,
                    'clientPay' => $clientPay,
                    'clientNeverPay' => $clientNeverPay,
                    'payment' => $payment,
                );
                $payment = array();
                $clientPay = $clientNeverPay = 0;
            }

            $data = array(
                'name' => $user->name,
                'phone' => $user->phone,
                'businessName' => $user->businessName,
                'businessEmail' => $user->businessEmail,
                'businessAddress' => $user->businessAddress,
                'image' => $this->picUrl($user->image, 'clientPic', $this->platform),
                'email' => ($user->email == 'NA') ? '' : $user->email,
                'address' => ($user->address == null) ? '' : $user->address,
                'salesEntry' => $salesEntry,
                'credits' => $this->getCreditPayment([
                    'models' => [
                        'credits' => Credits::class,
                        'payment' => Payment::class,
                    ],
                    'userId' => $id
                ])
            );

            return view('admin.users.client.detail_client')->with('data', $data);
        } catch (Exception $e) {
            return redirect()->abort();
        }
    }
}

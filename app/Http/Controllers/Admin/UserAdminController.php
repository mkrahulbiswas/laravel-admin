<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\Credits;
use App\Models\ManageUsers\Admin;
use App\Models\SetupAdmin\Role;
use App\Models\User;
use App\Models\SalesEntry;
use App\Models\Payment;

use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class UserAdminController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


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
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                if (!empty($file)) {
                    $image = $this->uploadPicture($file, '', $this->platform, 'clientPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
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
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Add Client", 'msg' => 'Client Successfully saved.'], Config::get('constants.errorCode.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Add Client", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Add Client", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
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
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Client", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid($request->all(), 'updateClient', $id, $this->platform);
            if ($validator->fails()) {
                return response()->json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {

                $user = User::findOrFail($id);

                if (!empty($file)) {
                    $image = $this->uploadPicture($file, $user->image, $this->platform, 'clientPic');
                    if ($image === false) {
                        return Response()->Json(['status' => 0, 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
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
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Update Client", 'msg' => 'Client successfully update.'], Config::get('constants.errorCode.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Update Client", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Update Client", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function statusClient($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus($id, User::class, [], config('constants.statusSingle'));
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => 'Status successfully changed.'], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
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
            );

            return view('admin.users.client.detail_client')->with('data', $data);
        } catch (Exception $e) {
            return redirect()->abort();
        }
    }
}

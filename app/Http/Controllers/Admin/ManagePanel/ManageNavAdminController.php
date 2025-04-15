<?php

namespace App\Http\Controllers\Admin\ManagePanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\ManagePanel\ManageNav\NavType;
use App\Models\ManagePanel\ManageNav\NavMain;
use App\Models\ManagePanel\ManageNav\NavSub;
use App\Models\ManagePanel\ManageNav\NavNested;

use App\Helpers\GetManageNavHelper;

use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\DataTables;

class ManageNavAdminController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Nav Type ) ----*/
    public function showNavType()
    {
        try {
            return view('admin.manage_panel.manage_nav.nav_type.nav_type_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getNavType(Request $request)
    {
        try {
            $status = $request->status;

            $query = "`created_at` is not null";

            if (!empty($status)) {
                $query .= " and `status` = '" . $status . "'";
            }

            $navType = NavType::orderBy('id', 'desc')->whereRaw($query)->get();

            return Datatables::of($navType)
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
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.navType') . '/' . $dataArray['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                    } else {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.navType') . '/' . $dataArray['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
                    }
                    // } else {
                    //     $status = '';
                    // }

                    // if ($itemPermission['edit_item'] == '1') {
                    $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Update"><i class="las la-edit"></i></a>';
                    // } else {
                    //     $edit = '';
                    // }

                    // if ($itemPermission['delete_item'] == '1') {
                    $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.navType') . '/' . $dataArray['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    // } else {
                    //     $delete = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $details = '<a href="JavaScript:void(0);" data-type="details" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    // } else {
                    //     $details = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $access = '<a href="JavaScript:void(0);" data-type="access" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Access" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i><span>Change Access</span></a>';
                    // } else {
                    //     $details = '';
                    // }

                    return $this->dataTableHtmlPurse([
                        'action' => [
                            'primary' => [$status, $edit, $delete, $details],
                            'secondary' => [$access],
                        ]
                    ]);
                })
                ->rawColumns(['description', 'status', 'icon', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveNavType(Request $request)
    {
        try {
            $values = $request->only('name', 'icon', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'saveNavType',
                'id' => 0,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $navType = new NavType;
                $navType->name = $values['name'];
                $navType->icon = $values['icon'];
                $navType->description = $values['description'];
                $navType->uniqueId = $this->generateCode(['preString' => 'NT', 'length' => 6, 'model' => NavType::class, 'field' => '']);
                $navType->status = Config::get('constants.status')['active'];
                $navType->position = NavType::max('position') + 1;

                if ($navType->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nav Type", 'msg' => __('messages.saveMsg', ['type' => 'Nav type'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nav Type", 'msg' => __('messages.saveMsg', ['type' => 'Nav type'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nav Type", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateNavType(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Nav Type", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'updateNavType',
                'id' => $id,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $navType = NavType::find($id);

                $navType->name = $values['name'];
                $navType->icon = $values['icon'];
                $navType->description = $values['description'];

                if ($navType->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nav Type", 'msg' => __('messages.updateMsg', ['type' => 'Nav type'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nav Type", 'msg' => __('messages.updateMsg', ['type' => 'Nav type'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nav Type", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusNavType($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => NavType::class,
                'targetField' => [],
                'type' => Config::get('constants.actionFor.statusType.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Nav type'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Nav type'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteNavType($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem([
                'targetId' => $id,
                'targetModal' => NavType::class,
                'picUrl' => '',
                'type' => Config::get('constants.actionFor.deleteType.smsr'),
                'idByField' => ''
            ]);
            if ($result === true) {
                $result = $this->deleteItem([
                    'targetId' => $id,
                    'targetModal' => NavMain::class,
                    'picUrl' => '',
                    'type' => Config::get('constants.actionFor.deleteType.mmmr'),
                    'idByField' => 'navTypeId'
                ]);
                if ($result === true) {
                    $result = $this->deleteItem([
                        'targetId' => $id,
                        'targetModal' => NavSub::class,
                        'picUrl' => '',
                        'type' => Config::get('constants.actionFor.deleteType.mmmr'),
                        'idByField' => 'navTypeId'
                    ]);
                    if ($result === true) {
                        $result = $this->deleteItem([
                            'targetId' => $id,
                            'targetModal' => NavNested::class,
                            'picUrl' => '',
                            'type' => Config::get('constants.actionFor.deleteType.mmmr'),
                            'idByField' => 'navTypeId'
                        ]);
                        if ($result === true) {
                            return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav type'])['success']], config('constants.ok'));
                        } else {
                            return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav type'])['failed']], config('constants.ok'));
                        }
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav type'])['failed']], config('constants.ok'));
                    }
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav type'])['failed']], config('constants.ok'));
                }
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav type'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }


    /*---- ( Nav Main ) ----*/
    public function showNavMain()
    {
        try {
            $navType = GetManageNavHelper::getList([
                'type' => [Config::get('constants.typeCheck.manageNav.navType.type')],
                'otherDataPasses' => [
                    'filterData' => [
                        'status' => Config::get('constants.status')['active']
                    ]
                ],
            ]);

            $data = [
                'navType' => $navType['navType'],
            ];

            return view('admin.manage_panel.manage_nav.nav_main.nav_main_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getNavMain(Request $request)
    {
        try {
            $status = $request->status;
            $navType = $request->navType;

            $query = "`created_at` is not null";

            if (!empty($status)) {
                $query .= " and `status` = '" . $status . "'";
            }

            if (!empty($navType)) {
                $query .= " and `navTypeId` = " . decrypt($navType);
            }

            $navMain = NavMain::orderBy('id', 'desc')->whereRaw($query)->get();

            return Datatables::of($navMain)
                ->addIndexColumn()
                ->addColumn('navType', function ($data) {
                    $navType = NavType::where('id', $data->navTypeId)->first()->name;
                    return $navType;
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
                        'navType' => NavType::where('id', $data->navTypeId)->first()->name,
                        'name' => $data->name,
                        'icon' => $data->icon,
                        'description' => $data->description,
                    ];


                    // if ($itemPermission['status_item'] == '1') {
                    if ($data->status == Config::get('constants.status')['inactive']) {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.navMain') . '/' . $dataArray['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                    } else {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.navMain') . '/' . $dataArray['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
                    }
                    // } else {
                    //     $status = '';
                    // }

                    // if ($itemPermission['edit_item'] == '1') {
                    $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Update"><i class="las la-edit"></i></a>';
                    // } else {
                    //     $edit = '';
                    // }

                    // if ($itemPermission['delete_item'] == '1') {
                    $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.navMain') . '/' . $dataArray['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    // } else {
                    //     $delete = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $details = '<a href="JavaScript:void(0);" data-type="details" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    // } else {
                    //     $details = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $access = '<a href="JavaScript:void(0);" data-type="access" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Access" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i><span>Change Access</span></a>';
                    // } else {
                    //     $details = '';
                    // }

                    return $this->dataTableHtmlPurse([
                        'action' => [
                            'primary' => [$status, $edit, $delete, $details],
                            'secondary' => [$access],
                        ]
                    ]);
                })
                ->rawColumns(['navType', 'status', 'icon', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveNavMain(Request $request)
    {
        try {
            $values = $request->only('name', 'icon', 'navType', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'saveNavMain',
                'id' => 0,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $navMain = new NavMain();
                $navMain->name = $values['name'];
                $navMain->icon = $values['icon'];
                $navMain->navTypeId = decrypt($values['navType']);
                $navMain->description = $values['description'];
                $navMain->uniqueId = $this->generateCode(['preString' => 'NM', 'length' => 6, 'model' => NavMain::class, 'field' => '']);
                $navMain->status = Config::get('constants.status')['active'];
                $navMain->position = NavMain::max('position') + 1;
                $navMain->route = strtolower(str_replace(" ", "-", $values['name']));
                $navMain->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navMain->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nav Main", 'msg' => __('messages.saveMsg', ['type' => 'Nav main'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nav Main", 'msg' =>  __('messages.saveMsg', ['type' => 'Nav main'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nav Main", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateNavMain(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'navType', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Nav Main", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'updateNavMain',
                'id' => $id,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $navMain = NavMain::find($id);

                $navMain->name = $values['name'];
                $navMain->icon = $values['icon'];
                $navMain->navTypeId = decrypt($values['navType']);
                $navMain->description = $values['description'];
                $navMain->route = strtolower(str_replace(" ", "-", $values['name']));
                $navMain->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navMain->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nav Main", 'msg' => __('messages.updateMsg', ['type' => 'Nav main'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nav Main", 'msg' => __('messages.updateMsg', ['type' => 'Nav main'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nav Main", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusNavMain($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => NavMain::class,
                'targetField' => [],
                'type' => Config::get('constants.actionFor.statusType.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Nav main'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Nav main'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteNavMain($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem([
                'targetId' => $id,
                'targetModal' => NavMain::class,
                'picUrl' => '',
                'type' => Config::get('constants.actionFor.deleteType.smsr'),
                'idByField' => ''
            ]);
            if ($result === true) {
                $result = $this->deleteItem([
                    'targetId' => $id,
                    'targetModal' => NavSub::class,
                    'picUrl' => '',
                    'type' => Config::get('constants.actionFor.deleteType.mmmr'),
                    'idByField' => 'navMainId'
                ]);
                if ($result === true) {
                    $result = $this->deleteItem([
                        'targetId' => $id,
                        'targetModal' => NavNested::class,
                        'picUrl' => '',
                        'type' => Config::get('constants.actionFor.deleteType.mmmr'),
                        'idByField' => 'navMainId'
                    ]);
                    if ($result === true) {
                        return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav main'])['success']], config('constants.ok'));
                    } else {
                        return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav main'])['failed']], config('constants.ok'));
                    }
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav main'])['failed']], config('constants.ok'));
                }
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav main'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }


    /*---- ( Nav Sub ) ----*/
    public function showNavSub()
    {
        try {
            $navType = GetManageNavHelper::getList([
                'type' => [Config::get('constants.typeCheck.manageNav.navType.type')],
                'otherDataPasses' => [
                    'filterData' => [
                        'status' => Config::get('constants.status')['active']
                    ]
                ],
            ]);

            $data = [
                'navType' => $navType['navType'],
            ];

            return view('admin.manage_panel.manage_nav.nav_sub.nav_sub_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getNavSub(Request $request)
    {
        try {
            $status = $request->status;
            $navType = $request->navType;
            $navMain = $request->navMain;

            $query = "`created_at` is not null";

            if (!empty($status)) {
                $query .= " and `status` = '" . $status . "'";
            }

            if (!empty($navType)) {
                $query .= " and `navTypeId` = " . decrypt($navType);
            }

            if (!empty($navMain)) {
                $query .= " and `navMainId` = " . decrypt($navMain);
            }

            $navSub = NavSub::orderBy('id', 'desc')->whereRaw($query)->get();

            return Datatables::of($navSub)
                ->addIndexColumn()
                ->addColumn('navType', function ($data) {
                    $navType = NavType::where('id', $data->navTypeId)->first()->name;
                    return $navType;
                })
                ->addColumn('navMain', function ($data) {
                    $navMain = NavMain::where('id', $data->navMainId)->first()->name;
                    return $navMain;
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
                        'navType' => NavType::where('id', $data->navTypeId)->first()->name,
                        'navMain' => NavMain::where('id', $data->navMainId)->first()->name,
                        'name' => $data->name,
                        'icon' => $data->icon,
                        'description' => $data->description,
                    ];


                    // if ($itemPermission['status_item'] == '1') {
                    if ($data->status == Config::get('constants.status')['inactive']) {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.navSub') . '/' . $dataArray['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                    } else {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.navSub') . '/' . $dataArray['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
                    }
                    // } else {
                    //     $status = '';
                    // }

                    // if ($itemPermission['edit_item'] == '1') {
                    $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Update"><i class="las la-edit"></i></a>';
                    // } else {
                    //     $edit = '';
                    // }

                    // if ($itemPermission['delete_item'] == '1') {
                    $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.navSub') . '/' . $dataArray['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    // } else {
                    //     $delete = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $details = '<a href="JavaScript:void(0);" data-type="details" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    // } else {
                    //     $details = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $access = '<a href="JavaScript:void(0);" data-type="access" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Access" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i><span>Change Access</span></a>';
                    // } else {
                    //     $details = '';
                    // }

                    return $this->dataTableHtmlPurse([
                        'action' => [
                            'primary' => [$status, $edit, $delete, $details],
                            'secondary' => [$access],
                        ]
                    ]);
                })
                ->rawColumns(['navType', 'navMain', 'status', 'icon', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveNavSub(Request $request)
    {
        try {
            $values = $request->only('name', 'icon', 'navType', 'navMain', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'saveNavSub',
                'id' => 0,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $navSub = new NavSub();
                $navSub->name = $values['name'];
                $navSub->icon = $values['icon'];
                $navSub->navTypeId = decrypt($values['navType']);
                $navSub->navMainId = decrypt($values['navMain']);
                $navSub->description = $values['description'];
                $navSub->uniqueId = $this->generateCode(['preString' => 'NS', 'length' => 6, 'model' => NavSub::class, 'field' => '']);
                $navSub->status = Config::get('constants.status')['active'];
                $navSub->position = NavSub::max('position') + 1;
                $navSub->route = strtolower(str_replace(" ", "-", NavMain::where('id', decrypt($values['navMain']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $navSub->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navSub->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nav Sub", 'msg' => __('messages.saveMsg', ['type' => 'Nav sub'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nav Sub", 'msg' => __('messages.saveMsg', ['type' => 'Nav sub'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nav Sub", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateNavSub(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'navType', 'navMain', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Nav Sub", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'updateNavSub',
                'id' => $id,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $navSub = NavSub::find($id);

                $navSub->name = $values['name'];
                $navSub->icon = $values['icon'];
                $navSub->navTypeId = decrypt($values['navType']);
                $navSub->navMainId = decrypt($values['navMain']);
                $navSub->description = $values['description'];
                $navSub->route = strtolower(str_replace(" ", "-", NavMain::where('id', decrypt($values['navMain']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $navSub->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navSub->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nav Sub", 'msg' => __('messages.updateMsg', ['type' => 'Nav sub'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nav Sub", 'msg' =>  __('messages.updateMsg', ['type' => 'Nav sub'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nav Sub", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusNavSub($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => NavSub::class,
                'targetField' => [],
                'type' => Config::get('constants.actionFor.statusType.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Nav sub'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Nav sub'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteNavSub($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem([
                'targetId' => $id,
                'targetModal' => NavSub::class,
                'picUrl' => '',
                'type' => Config::get('constants.actionFor.deleteType.smsr'),
                'idByField' => ''
            ]);
            if ($result === true) {
                $result = $this->deleteItem([
                    'targetId' => $id,
                    'targetModal' => NavNested::class,
                    'picUrl' => '',
                    'type' => Config::get('constants.actionFor.deleteType.mmmr'),
                    'idByField' => 'navSubId'
                ]);
                if ($result === true) {
                    return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav sub'])['success']], config('constants.ok'));
                } else {
                    return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav sub'])['failed']], config('constants.ok'));
                }
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav sub'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }


    /*---- ( Nav Nested ) ----*/
    public function showNavNested()
    {
        try {
            $navType = GetManageNavHelper::getList([
                'type' => [Config::get('constants.typeCheck.manageNav.navType.type')],
                'otherDataPasses' => [
                    'filterData' => [
                        'status' => Config::get('constants.status')['active']
                    ]
                ],
            ]);

            $data = [
                'navType' => $navType['navType'],
            ];

            return view('admin.manage_panel.manage_nav.nav_nested.nav_nested_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getNavNested(Request $request)
    {
        try {
            $status = $request->status;
            $navSub = $request->navSub;
            $navMain = $request->navMain;
            $navType = $request->navType;

            $query = "`created_at` is not null";

            if (!empty($status)) {
                $query .= " and `status` = '" . $status . "'";
            }

            if (!empty($navType)) {
                $query .= " and `navTypeId` = " . decrypt($navType);
            }

            if (!empty($navMain)) {
                $query .= " and `navMainId` = " . decrypt($navMain);
            }

            if (!empty($navSub)) {
                $query .= " and `navSubId` = " . decrypt($navSub);
            }

            $navNested = NavNested::orderBy('id', 'desc')->whereRaw($query)->get();

            return Datatables::of($navNested)
                ->addIndexColumn()
                ->addColumn('navType', function ($data) {
                    $navType = NavType::where('id', $data->navTypeId)->first()->name;
                    return $navType;
                })
                ->addColumn('navMain', function ($data) {
                    $navMain = NavMain::where('id', $data->navMainId)->first()->name;
                    return $navMain;
                })
                ->addColumn('navSub', function ($data) {
                    $navSub = NavSub::where('id', $data->navSubId)->first()->name;
                    return $navSub;
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
                        'navType' => NavType::where('id', $data->navTypeId)->first()->name,
                        'navMain' => NavMain::where('id', $data->navMainId)->first()->name,
                        'navSub' => NavSub::where('id', $data->navSubId)->first()->name,
                        'name' => $data->name,
                        'icon' => $data->icon,
                        'description' => $data->description,
                    ];


                    // if ($itemPermission['status_item'] == '1') {
                    if ($data->status == Config::get('constants.status')['inactive']) {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.navNested') . '/' . $dataArray['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                    } else {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.navNested') . '/' . $dataArray['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
                    }
                    // } else {
                    //     $status = '';
                    // }

                    // if ($itemPermission['edit_item'] == '1') {
                    $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Update"><i class="las la-edit"></i></a>';
                    // } else {
                    //     $edit = '';
                    // }

                    // if ($itemPermission['delete_item'] == '1') {
                    $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.navNested') . '/' . $dataArray['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    // } else {
                    //     $delete = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $details = '<a href="JavaScript:void(0);" data-type="details" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Details" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    // } else {
                    //     $details = '';
                    // }

                    // if ($itemPermission['details_item'] == '1') {
                    $access = '<a href="JavaScript:void(0);" data-type="access" data-array=\'' . json_encode($dataArray, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Access" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i><span>Change Access</span></a>';
                    // } else {
                    //     $details = '';
                    // }

                    return $this->dataTableHtmlPurse([
                        'action' => [
                            'primary' => [$status, $edit, $delete, $details],
                            'secondary' => [$access],
                        ]
                    ]);
                })
                ->rawColumns(['navType', 'navMain', 'navSub', 'status', 'icon', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveNavNested(Request $request)
    {
        try {
            $values = $request->only('name', 'icon', 'navType', 'navMain', 'navSub', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'saveNavNested',
                'id' => 0,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $navNested = new NavNested;
                $navNested->name = $values['name'];
                $navNested->icon = $values['icon'];
                $navNested->navTypeId = decrypt($values['navType']);
                $navNested->navMainId = decrypt($values['navMain']);
                $navNested->navSubId = decrypt($values['navSub']);
                $navNested->description = $values['description'];
                $navNested->uniqueId = $this->generateCode(['preString' => 'NN', 'length' => 6, 'model' => NavNested::class, 'field' => '']);
                $navNested->status = Config::get('constants.status')['active'];
                $navNested->position = NavNested::max('position') + 1;
                $navNested->route = strtolower(str_replace(" ", "-", NavMain::where('id', decrypt($values['navMain']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", NavSub::where('id', decrypt($values['navSub']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $navNested->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navNested->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nav Nested", 'msg' => __('messages.saveMsg', ['type' => 'Nav nested'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nav Nested", 'msg' => __('messages.saveMsg', ['type' => 'Nav nested'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nav Nested", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updateNavNested(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'navType', 'navMain', 'navSub', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Nav Nested", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'updateNavNested',
                'id' => $id,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $navNested = NavNested::find($id);

                $navNested->name = $values['name'];
                $navNested->icon = $values['icon'];
                $navNested->navTypeId = decrypt($values['navType']);
                $navNested->navMainId = decrypt($values['navMain']);
                $navNested->navSubId = decrypt($values['navSub']);
                $navNested->description = $values['description'];
                $navNested->route = strtolower(str_replace(" ", "-", NavMain::where('id', decrypt($values['navMain']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", NavSub::where('id', decrypt($values['navSub']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $navNested->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navNested->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nav Nested", 'msg' => __('messages.updateMsg', ['type' => 'Nav nested'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nav Nested", 'msg' => __('messages.updateMsg', ['type' => 'Nav nested'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nav Nested", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusNavNested($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => NavNested::class,
                'targetField' => [],
                'type' => Config::get('constants.actionFor.statusType.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Nav nested'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Nav nested'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deleteNavNested($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem([
                'targetId' => $id,
                'targetModal' => NavNested::class,
                'picUrl' => '',
                'type' => Config::get('constants.actionFor.deleteType.smsr'),
                'idByField' => ''
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav nested'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav nested'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }


    /*---- ( Arrange Nav ) ----*/
    public function showArrangeNav()
    {
        try {
            $navList = GetManageNavHelper::getNav([
                'type' => ['all'],
                'otherDataPasses' => [
                    'filterData' => [
                        'status' => Config::get('constants.status')['active']
                    ],
                    'orderBy' => [
                        'position' => 'asc'
                    ]
                ],
            ]);

            $data = [
                'navList' => $navList['all'],
            ];

            return view('admin.manage_panel.manage_nav.arrange_nav.arrange_nav_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateArrangeNav(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'navType', 'navMain', 'navSub', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Nav Nested", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'updateNavNested',
                'id' => $id,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $navNested = NavNested::find($id);

                $navNested->name = $values['name'];
                $navNested->icon = $values['icon'];
                $navNested->navTypeId = decrypt($values['navType']);
                $navNested->navMainId = decrypt($values['navMain']);
                $navNested->navSubId = decrypt($values['navSub']);
                $navNested->description = $values['description'];
                $navNested->route = strtolower(str_replace(" ", "-", NavMain::where('id', decrypt($values['navMain']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", NavSub::where('id', decrypt($values['navSub']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $navNested->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navNested->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nav Nested", 'msg' => __('messages.updateMsg', ['type' => 'Nav nested'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nav Nested", 'msg' => __('messages.updateMsg', ['type' => 'Nav nested'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nav Nested", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }
}

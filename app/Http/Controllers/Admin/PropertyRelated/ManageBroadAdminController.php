<?php

namespace App\Http\Controllers\Admin\PropertyRelated;

use App\Http\Controllers\Controller;

use App\Helpers\AdminRelated\RolePermission\ManagePermissionHelper;
use App\Helpers\PropertyRelated\GetManageBroadHelper;
use App\Helpers\PropertyRelated\GetPropertyTypeHelper;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use App\Models\PropertyRelated\ManageBroad\BroadType;
use App\Models\PropertyRelated\ManageBroad\AssignBroad;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;

class ManageBroadAdminController extends Controller
{

    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Broad Type ) ----*/
    public function showBroadType()
    {
        try {
            return view('admin.property_related.manage_broad.broad_type.broad_type_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getBroadType(Request $request)
    {
        try {
            $broadType = GetManageBroadHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($broadType)
                ->addIndexColumn()
                ->addColumn('about', function ($data) {
                    $about = $this->subStrString(40, $data['about'], '....');
                    return $about;
                })
                ->addColumn('uniqueId', function ($data) {
                    $uniqueId = $data['uniqueId']['raw'];
                    return $uniqueId;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['customizeInText']['status']['raw'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.broadType') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.broadType') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.broadType') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($getPrivilege['info']['permission'] == true) {
                        $info = '<a href="JavaScript:void(0);" data-type="info" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Info" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    } else {
                        $info = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete, $info],
                                'secondary' => [],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['about', 'uniqueId', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveBroadType(Request $request)
    {
        try {
            $values = $request->only('name', 'about');

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveBroadType', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {

                $broadType = new BroadType();
                $broadType->name = $values['name'];
                $broadType->about = $values['about'];
                $broadType->uniqueId = $this->generateYourChoice([['preString' => 'PRBT', 'length' => 6, 'model' => BroadType::class, 'field' => '', 'type' => Config::get('constants.generateType.uniqueId')]]);

                if ($broadType->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Broad type'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Broad type'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Save data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateBroadType(Request $request)
    {
        $values = $request->only('id', 'name', 'about');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Update data", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateBroadType', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $broadType = BroadType::find($id);

                $broadType->name = $values['name'];
                $broadType->about = $values['about'];

                if ($broadType->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Broad type'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Broad type'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function statusBroadType($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => BroadType::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Broad type'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Broad type'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Change status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteBroadType($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => BroadType::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Broad type'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Broad type'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }


    /*---- ( Assign Broad ) ----*/
    public function showAssignBroad()
    {
        try {
            $broadType = GetManageBroadHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => ['status' => Config::get('constants.status.active')],
                        'orderBy' => ['id' => 'desc'],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.manageBroad.broadType.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];

            $propertyType = GetPropertyTypeHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyType.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => ['status' => Config::get('constants.status.active')],
                        'orderBy' => ['id' => 'desc'],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyType.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];

            $data = [
                'broadType' => $broadType,
                'propertyType' => $propertyType,
            ];

            return view('admin.property_related.manage_broad.assign_broad.assign_broad_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getAssignBroad(Request $request)
    {
        try {
            $assignBroad = GetManageBroadHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'default' => $request->default,
                            'propertyType' => $request->propertyType,
                            'broadType' => $request->broadType,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.manageBroad.assignBroad.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($assignBroad)
                ->addIndexColumn()
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
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['customizeInText']['status']['raw'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.assignBroad') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.assignBroad') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.assignBroad') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($getPrivilege['info']['permission'] == true) {
                        $info = '<a href="JavaScript:void(0);" data-type="info" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Info" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    } else {
                        $info = '';
                    }

                    if ($getPrivilege['default']['permission'] == true) {
                        if ($data['customizeInText']['default']['raw'] == Config::get('constants.status')['no']) {
                            $default = '<a href="JavaScript:void(0);" data-type="default" data-default="unblock" data-action="' . route('admin.default.assignBroad') . '/' . $data['id'] . '" title="Default" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-shield-lock-open-outline"></i></a>';
                        } else {
                            $default = '<a href="JavaScript:void(0);" data-type="default" data-default="unblock" data-action="' . route('admin.default.assignBroad') . '/' . $data['id'] . '" title="Default" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-shield-lock-outline"></i></a>';
                        }
                    } else {
                        $default = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $default, $edit, $delete, $info],
                                'secondary' => [],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['uniqueId', 'statInfo', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveAssignBroad(Request $request)
    {
        try {
            $values = $request->only('propertyType', 'broadType', 'about');

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveAssignBroad', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                if (AssignBroad::where([
                    ['propertyTypeId', decrypt($values['propertyType'])],
                    ['broadTypeId', decrypt($values['broadType'])],
                ])->get()->count() > 0) {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Already exist", 'msg' => __('messages.existMsg', ['type' => 'selected both property type and broad type'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    $assignBroad = new AssignBroad();
                    $assignBroad->propertyTypeId = decrypt($values['propertyType']);
                    $assignBroad->broadTypeId = decrypt($values['broadType']);
                    $assignBroad->about = $values['about'];
                    $assignBroad->uniqueId = $this->generateYourChoice([['preString' => 'PRAB', 'length' => 6, 'model' => AssignBroad::class, 'field' => '', 'type' => Config::get('constants.generateType.uniqueId')]]);

                    if ($assignBroad->save()) {
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Assign broad'])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Assign broad'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Save data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateAssignBroad(Request $request)
    {
        $values = $request->only('id', 'propertyType', 'broadType', 'about');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Update data", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateAssignBroad', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                if (AssignBroad::where([
                    ['propertyTypeId', decrypt($values['propertyType'])],
                    ['broadTypeId', decrypt($values['broadType'])],
                    ['id', '!=', $id],
                ])->get()->count() > 0) {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Already exist", 'msg' => __('messages.existMsg', ['type' => 'selected both property type and broad type'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    $assignBroad = AssignBroad::find($id);

                    $assignBroad->propertyTypeId = decrypt($values['propertyType']);
                    $assignBroad->broadTypeId = decrypt($values['broadType']);
                    $assignBroad->about = $values['about'];

                    if ($assignBroad->update()) {
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Assign broad'])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Assign broad'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function defaultAssignBroad($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->setDefault([
                'targetId' => $id,
                "targetModel" => AssignBroad::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsfs')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Set default", 'msg' => __('messages.defaultMsg', ['type' => 'Assign broad'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Set default", 'msg' => __('messages.defaultMsg', ['type' => 'Assign broad'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Set default", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function statusAssignBroad($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => AssignBroad::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Assign broad'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Assign broad'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Change status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteAssignBroad($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => AssignBroad::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Assign broad'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Assign broad'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }
}

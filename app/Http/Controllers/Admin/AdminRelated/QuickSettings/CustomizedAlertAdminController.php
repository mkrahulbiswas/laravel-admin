<?php

namespace App\Http\Controllers\Admin\AdminRelated\QuickSettings;

use App\Http\Controllers\Controller;

use App\Helpers\AdminRelated\QuickSetting\CustomizedAlertHelper;
use App\Helpers\AdminRelated\RolePermission\ManagePermissionHelper;

use App\Models\AdminRelated\QuickSetting\CustomizedAlert\AlertFor;
use App\Models\AdminRelated\QuickSetting\CustomizedAlert\AlertTemplate;
use App\Models\AdminRelated\QuickSetting\CustomizedAlert\AlertType;

use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Str;

class CustomizedAlertAdminController extends Controller
{

    use ValidationTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Alert Type ) ----*/
    public function showAlertType()
    {
        try {
            return view('admin.admin_related.quick_setting.customized_alert.alert_type.alert_type_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getAlertType(Request $request)
    {
        try {
            $broadType = CustomizedAlertHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.bnf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type'),
                    ],
                    'otherDataPasses' => [],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type')][Config::get('constants.typeCheck.helperCommon.get.bnf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($broadType)
                ->addIndexColumn()
                ->addColumn('uniqueId', function ($data) {
                    $uniqueId = $data['uniqueId']['raw'];
                    return $uniqueId;
                })
                ->addColumn('status', function ($data) {
                    $status = $data['customizeInText']['status']['custom'];
                    return $status;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['customizeInText']['status']['raw'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.alertType') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.alertType') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.alertType') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    } else {
                        $delete = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete],
                                'secondary' => [],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['uniqueId', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveAlertType(Request $request)
    {
        try {
            $values = $request->only('name');

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveAlertType', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $alertType = new AlertType();
                $alertType->name = $values['name'];
                $alertType->uniqueId = $this->generateYourChoice([
                    [
                        'preString' => 'ALTY',
                        'length' => 6,
                        'model' => AlertType::class,
                        'field' => '',
                        'type' => Config::get('constants.generateType.uniqueId')
                    ]
                ])[Config::get('constants.generateType.uniqueId')]['result'];
                if ($alertType->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Alert type'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Alert type'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Save data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateAlertType(Request $request)
    {
        $values = $request->only('id', 'name');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Update data", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateAlertType', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $alertType = AlertType::find($id);
                $alertType->name = $values['name'];
                if ($alertType->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Alert type'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Alert type'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function statusAlertType($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => AlertType::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Alert type'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Alert type'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Change status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteAlertType($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => AlertType::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Alert type'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Alert type'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }


    /*---- ( Alert For ) ----*/
    public function showAlertFor()
    {
        try {
            $getList = CustomizedAlertHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.inf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type'),
                    ],
                    'otherDataPasses' => [],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type')][Config::get('constants.typeCheck.helperCommon.get.inf')]['list'];

            $data = [
                'alertType' => $getList
            ];

            return view('admin.admin_related.quick_setting.customized_alert.alert_for.alert_for_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getAlertFor(Request $request)
    {
        try {
            $alertFor = CustomizedAlertHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'alertTypeId' => $request->alertType,
                            'status' => $request->status,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($alertFor)
                ->addIndexColumn()
                ->addColumn('uniqueId', function ($data) {
                    $uniqueId = $data['uniqueId']['raw'];
                    return $uniqueId;
                })
                ->addColumn('alertType', function ($data) {
                    $alertType = $data['alertType']['name'];
                    return $alertType;
                })
                ->addColumn('status', function ($data) {
                    $status = $data['customizeInText']['status']['custom'];
                    return $status;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['customizeInText']['status']['raw'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.alertFor') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.alertFor') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.alertFor') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    } else {
                        $delete = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete],
                                'secondary' => [],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['uniqueId', 'alertType', 'status', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveAlertFor(Request $request)
    {
        try {
            $values = $request->only('alertType', 'name');

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveAlertFor', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $alertFor = new AlertFor();
                $alertFor->alertTypeId = decrypt($values['alertType']);
                $alertFor->name = $values['name'];
                $alertFor->uniqueId = $this->generateYourChoice([
                    [
                        'preString' => 'ALFO',
                        'length' => 6,
                        'model' => AlertFor::class,
                        'field' => '',
                        'type' => Config::get('constants.generateType.uniqueId')
                    ]
                ])[Config::get('constants.generateType.uniqueId')]['result'];
                if ($alertFor->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Alert for'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Alert for'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Save data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateAlertFor(Request $request)
    {
        $values = $request->only('id', 'alertType', 'name');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Update data", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateAlertFor', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $alertFor = AlertFor::find($id);
                $alertFor->name = $values['name'];
                $alertFor->alertTypeId = decrypt($values['alertType']);
                if ($alertFor->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Alert for'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Alert for'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function statusAlertFor($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => AlertFor::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Alert for'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Alert for'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Change status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteAlertFor($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => AlertFor::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Alert for'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Alert for'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }


    /*---- ( Alert Template ) ----*/
    public function showAlertTemplate()
    {
        try {
            $getList = CustomizedAlertHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.inf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type'),
                    ],
                    'otherDataPasses' => [],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertType.type')][Config::get('constants.typeCheck.helperCommon.get.inf')]['list'];

            $data = [
                'alertType' => $getList
            ];

            return view('admin.admin_related.quick_setting.customized_alert.alert_template.alert_template_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getAlertTemplate(Request $request)
    {
        try {
            $alertTemplate = CustomizedAlertHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertTemplate.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'alertTypeId' => $request->alertType,
                            'alertForId' => $request->alertFor,
                            'default' => $request->default,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertTemplate.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($alertTemplate)
                ->addIndexColumn()
                ->addColumn('uniqueId', function ($data) {
                    $uniqueId = $data['uniqueId']['raw'];
                    return $uniqueId;
                })
                ->addColumn('alertType', function ($data) {
                    $alertType = $data['alertType']['name'];
                    return $alertType;
                })
                ->addColumn('alertFor', function ($data) {
                    $alertFor = $data['alertFor']['name'];
                    return $alertFor;
                })
                ->addColumn('default', function ($data) {
                    $default = $data['customizeInText']['default']['custom'];
                    return $default;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['edit']['permission'] == true) {
                        $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Update"><i class="las la-edit"></i></a>';
                    } else {
                        $edit = '';
                    }

                    if ($getPrivilege['delete']['permission'] == true) {
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.alertTemplate') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
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
                            $default = '<a href="JavaScript:void(0);" data-type="default" data-default="unblock" data-action="' . route('admin.default.alertTemplate') . '/' . $data['id'] . '" title="Default" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-shield-lock-open-outline"></i></a>';
                        } else {
                            $default = '';
                        }
                    } else {
                        $default = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$default, $edit, $delete, $info],
                                'secondary' => [],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['uniqueId', 'alertType', 'alertFor', 'default', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveAlertTemplate(Request $request)
    {
        try {
            $values = $request->only('alertType', 'alertFor', 'heading', 'content');

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveAlertTemplate', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                preg_match_all('/\[~([a-zA-Z\s]+)~\]/', $values['content'], $matches);
                $alertTemplate = new AlertTemplate();
                $alertTemplate->alertTypeId = decrypt($values['alertType']);
                $alertTemplate->alertForId = decrypt($values['alertFor']);
                $alertTemplate->heading = $values['heading'];
                $alertTemplate->content = $values['content'];
                $alertTemplate->variable = json_encode($matches[0]);
                $alertTemplate->default = AlertTemplate::where([
                    ['alertTypeId', decrypt($values['alertType'])],
                    ['alertForId', decrypt($values['alertFor'])],
                    ['default', Config::get('constants.status.yes')],
                ])->get()->count() > 0 ? Config::get('constants.status.no') : Config::get('constants.status.yes');
                $alertTemplate->uniqueId = $this->generateYourChoice([
                    [
                        'preString' => 'ALTE',
                        'length' => 6,
                        'model' => AlertTemplate::class,
                        'field' => '',
                        'type' => Config::get('constants.generateType.uniqueId')
                    ]
                ])[Config::get('constants.generateType.uniqueId')]['result'];
                if ($alertTemplate->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Alert template'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Alert template'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Save data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateAlertTemplate(Request $request)
    {
        $values = $request->only('id', 'alertType', 'alertFor', 'heading', 'content');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Update data", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateAlertTemplate', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                preg_match_all('/\[~([a-zA-Z\s]+)~\]/', $values['content'], $matches);
                $alertTemplate = AlertTemplate::find($id);
                if ($alertTemplate->default == Config::get('constants.status.yes')) {
                    if ($alertTemplate->alertTypeId == decrypt($values['alertType']) && $alertTemplate->alertForId == decrypt($values['alertFor'])) {
                        goto pass;
                    } else {
                        if (AlertTemplate::where([
                            ['alertTypeId', $alertTemplate->alertTypeId],
                            ['alertForId', $alertTemplate->alertForId],
                            ['default', Config::get('constants.status.no')],
                        ])->get()->count() > 0) {
                            return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update data a", 'msg' => __('messages.changeOriginMsg', ['type' => 'Alert template'])['failed']], Config::get('constants.errorCode.ok'));
                        } else {
                            $alertTemplate->default = AlertTemplate::where([
                                ['alertTypeId', decrypt($values['alertType'])],
                                ['alertForId', decrypt($values['alertFor'])],
                                ['default', Config::get('constants.status.yes')],
                            ])->get()->count() > 0 ? Config::get('constants.status.no') : Config::get('constants.status.yes');
                            goto pass;
                        }
                    }
                } else {
                    $alertTemplate->default = AlertTemplate::where([
                        ['alertTypeId', decrypt($values['alertType'])],
                        ['alertForId', decrypt($values['alertFor'])],
                        ['default', Config::get('constants.status.yes')],
                    ])->get()->count() > 0 ? Config::get('constants.status.no') : Config::get('constants.status.yes');
                    goto pass;
                }
                pass:
                $alertTemplate->alertTypeId = decrypt($values['alertType']);
                $alertTemplate->alertForId = decrypt($values['alertFor']);
                $alertTemplate->heading = $values['heading'];
                $alertTemplate->content = $values['content'];
                $alertTemplate->variable = json_encode($matches[0]);
                if ($alertTemplate->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Alert template'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Alert template'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function defaultAlertTemplate($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Default", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $alertTemplate = AlertTemplate::where('id', $id)->first();
            $result = $this->setDefault([
                [
                    'targetId' => $id,
                    "model" => AlertTemplate::class,
                    'field' => '',
                    'type' => Config::get('constants.action.default.smyon'),
                    'filter' => [
                        ['value' => $alertTemplate->alertTypeId, 'key' => 'alertTypeId'],
                        ['value' => $alertTemplate->alertForId, 'key' => 'alertForId']
                    ],
                ]
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Set default", 'msg' => __('messages.statusMsg', ['type' => 'Alert template'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Set default", 'msg' => __('messages.statusMsg', ['type' => 'Alert template'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Set default", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteAlertTemplate($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => AlertTemplate::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Alert template'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Alert template'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }
}

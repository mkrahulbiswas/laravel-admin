<?php

namespace App\Http\Controllers\Admin\PropertyRelated;

use App\Http\Controllers\Controller;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use App\Helpers\ManagePanel\GetManageAccessHelper;
use App\Helpers\PropertyRelated\GetPropertyCategoryHelper;
use App\Helpers\PropertyRelated\GetPropertyTypeHelper;

use App\Models\PropertyRelated\ManageBroad\AssignBroad;
use App\Models\PropertyRelated\PropertyCategory\AssignCategory;
use App\Models\PropertyRelated\PropertyCategory\ManageCategory;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;

class PropertyCategoryAdminController extends Controller
{
    use ValidationTrait, FileTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Main Category ) ----*/
    public function showManageCategory()
    {
        try {
            return view('admin.property_related.property_category.manage_category.manage_category_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getManageCategory(Request $request)
    {
        try {
            $manageCategory = GetPropertyCategoryHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'type' => $request['type'],
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $getPrivilege = GetManageAccessHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($manageCategory)
                ->addIndexColumn()
                ->addColumn('uniqueId', function ($data) {
                    $uniqueId = $data['uniqueId']['raw'];
                    return $uniqueId;
                })
                ->addColumn('about', function ($data) {
                    $about = $this->subStrString(40, $data['about'], '....');
                    return $about;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['customizeInText']['status']['raw'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.manageCategory') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.manageCategory') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.manageCategory') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
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
                ->rawColumns(['uniqueId', 'about', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveManageCategory(Request $request)
    {
        try {
            $values = $request->only('name', 'about', 'type');

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveManageCategory', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $manageCategory = new ManageCategory();
                $manageCategory->name = $values['name'];
                $manageCategory->about = $values['about'];
                $manageCategory->type = $values['type'];
                $manageCategory->uniqueId = $this->generateCode(['preString' => 'PRMC', 'length' => 6, 'model' => ManageCategory::class, 'field' => '']);
                if ($manageCategory->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Main category'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Main category'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Save data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateManageCategory(Request $request)
    {
        $values = $request->only('id', 'name', 'about');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Update data", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateManageCategory', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $manageCategory = ManageCategory::find($id);
                $manageCategory->name = $values['name'];
                $manageCategory->about = $values['about'];
                $manageCategory->type = $values['type'];
                if ($manageCategory->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Main category'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Main category'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function statusManageCategory($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => ManageCategory::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Main category'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Main category'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Change status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteManageCategory($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => ManageCategory::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Main category'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Main category'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }


    /*---- ( Assign Category ) ----*/
    public function showAssignCategory()
    {
        try {
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

            $manageCategory = GetPropertyCategoryHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.iyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => ['status' => Config::get('constants.status.active')],
                        'orderBy' => ['id' => 'desc'],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyCategory.manageCategory.type')][Config::get('constants.typeCheck.helperCommon.get.iyf')]['list'];

            $data = [
                'propertyType' => $propertyType,
                'manageCategory' => $manageCategory,
            ];

            return view('admin.property_related.property_category.assign_category.assign_category_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getAssignCategory(Request $request)
    {
        try {
            $assignCategory = GetPropertyCategoryHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyCategory.assignCategory.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'default' => $request->default,
                            'manageCategory' => $request->manageCategory,
                            'propertyType' => $request->propertyType,
                            'assignBroad' => $request->assignBroad,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyCategory.assignCategory.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            $getPrivilege = GetManageAccessHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($assignCategory)
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
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.assignCategory') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.assignCategory') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.assignCategory') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
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
                            $default = '<a href="JavaScript:void(0);" data-type="default" data-default="unblock" data-action="' . route('admin.default.assignCategory') . '/' . $data['id'] . '" title="Default" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-shield-lock-open-outline"></i></a>';
                        } else {
                            $default = '<a href="JavaScript:void(0);" data-type="default" data-default="unblock" data-action="' . route('admin.default.assignCategory') . '/' . $data['id'] . '" title="Default" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-shield-lock-outline"></i></a>';
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

    public function saveAssignCategory(Request $request)
    {
        try {
            $values = $request->only('mainCategory', 'propertyType', 'assignBroad', 'about');

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveAssignCategory', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                if (AssignCategory::where([
                    ['propertyTypeId', decrypt($values['propertyType'])],
                    ['mainCategoryId', decrypt($values['mainCategory'])],
                    ['assignBroadId', decrypt($values['assignBroad'])],
                ])->get()->count() > 0) {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Already exist", 'msg' => __('messages.existMsg', ['type' => 'selected both property type and broad type'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    $assignCategory = new AssignCategory();
                    $assignCategory->mainCategoryId = decrypt($values['mainCategory']);
                    $assignCategory->propertyTypeId = decrypt($values['propertyType']);
                    $assignCategory->assignBroadId = decrypt($values['assignBroad']);
                    $assignCategory->broadTypeId = AssignBroad::where('id', decrypt($values['assignBroad']))->value('broadTypeId');
                    $assignCategory->about = $values['about'];
                    $assignCategory->uniqueId = $this->generateCode(['preString' => 'PRAC', 'length' => 6, 'model' => AssignCategory::class, 'field' => '']);

                    if ($assignCategory->save()) {
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Assign Category'])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Assign Category'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Save data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateAssignCategory(Request $request)
    {
        $values = $request->only('id', 'mainCategory', 'propertyType', 'assignBroad', 'about');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Update data", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateAssignCategory', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                if (AssignCategory::where([
                    ['propertyTypeId', decrypt($values['propertyType'])],
                    ['mainCategoryId', decrypt($values['mainCategory'])],
                    ['assignBroadId', decrypt($values['assignBroad'])],
                    ['id', '!=', $id],
                ])->get()->count() > 0) {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Already exist", 'msg' => __('messages.existMsg', ['type' => 'selected both property type and broad type'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    $assignCategory = AssignCategory::find($id);

                    $assignCategory->mainCategoryId = decrypt($values['mainCategory']);
                    $assignCategory->propertyTypeId = decrypt($values['propertyType']);
                    $assignCategory->assignBroadId = decrypt($values['assignBroad']);
                    $assignCategory->broadTypeId = AssignBroad::where('id', decrypt($values['assignBroad']))->value('broadTypeId');
                    $assignCategory->about = $values['about'];

                    if ($assignCategory->update()) {
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Assign Category'])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Assign Category'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function defaultAssignCategory($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->setDefault([
                'targetId' => $id,
                "targetModel" => AssignCategory::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsfs')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Set default", 'msg' => __('messages.defaultMsg', ['type' => 'Assign Category'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Set default", 'msg' => __('messages.defaultMsg', ['type' => 'Assign Category'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Set default", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function statusAssignCategory($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => AssignCategory::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Assign Category'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Assign Category'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Change status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteAssignCategory($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => AssignCategory::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Assign Category'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Assign Category'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }
}

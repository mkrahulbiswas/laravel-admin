<?php

namespace App\Http\Controllers\Admin\PropertyRelated;

use App\Http\Controllers\Controller;

use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use App\Models\PropertyRelated\PropertyAttributes;

use App\Helpers\ManagePanel\GetManageAccessHelper;
use App\Helpers\PropertyRelated\GetPropertyAttributesHelper;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;

class PropertyAttributesAdminController extends Controller
{

    use ValidationTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Property Attributes ) ----*/
    public function showPropertyAttributes()
    {
        try {
            return view('admin.property_related.property_attributes.property_attributes_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getPropertyAttributes(Request $request)
    {
        try {
            $propertyAttributes = GetPropertyAttributesHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.propertyRelated.propertyAttributes.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'type' => $request->type,
                            'default' => $request->default,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ],
                    ],
                ],
            ])[Config::get('constants.typeCheck.propertyRelated.propertyAttributes.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

            $getPrivilege = GetManageAccessHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($propertyAttributes)
                ->addIndexColumn()
                ->addColumn('about', function ($data) {
                    $about = $this->subStrString(40, $data['about'], '....');
                    return $about;
                })
                ->addColumn('uniqueId', function ($data) {
                    $uniqueId = $data['uniqueId']['raw'];
                    return $uniqueId;
                })
                ->addColumn('type', function ($data) {
                    $type = $data['customizeInText'][Config::get('constants.typeCheck.customizeInText.type')]['custom'];
                    return $type;
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
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.propertyAttributes') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.propertyAttributes') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.propertyAttributes') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
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
                            $default = '<a href="JavaScript:void(0);" data-type="default" data-default="unblock" data-action="' . route('admin.default.propertyAttributes') . '/' . $data['id'] . '" title="Default" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-shield-lock-open-outline"></i></a>';
                        } else {
                            $default = '<a href="JavaScript:void(0);" data-type="default" data-default="unblock" data-action="' . route('admin.default.propertyAttributes') . '/' . $data['id'] . '" title="Default" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-shield-lock-outline"></i></a>';
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
                ->rawColumns(['about', 'uniqueId', 'statInfo', 'action', 'type'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function savePropertyAttributes(Request $request)
    {
        try {
            $values = $request->only('name', 'about', 'type');

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'savePropertyAttributes', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {

                $propertyAttributes = new PropertyAttributes();
                $propertyAttributes->name = $values['name'];
                $propertyAttributes->about = $values['about'];
                $propertyAttributes->type = $values['type'];
                $propertyAttributes->uniqueId = $this->generateCode(['preString' => 'PRPA', 'length' => 6, 'model' => PropertyAttributes::class, 'field' => '']);
                $propertyAttributes->status = Config::get('constants.status')['active'];

                if ($propertyAttributes->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Property attributes'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Property attributes'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Save data", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function updatePropertyAttributes(Request $request)
    {
        $values = $request->only('id', 'name', 'about', 'type');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Update data", 'msg' => config('constants.serverErrMsg')], config('constants.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updatePropertyAttributes', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], config('constants.ok'));
            } else {
                $propertyAttributes = PropertyAttributes::find($id);

                $propertyAttributes->name = $values['name'];
                $propertyAttributes->about = $values['about'];
                $propertyAttributes->type = $values['type'];

                if ($propertyAttributes->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Property attributes'])['success']], config('constants.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Property attributes'])['failed']], config('constants.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update data", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function defaultPropertyAttributes($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->setDefault([
                'targetId' => $id,
                "targetModel" => PropertyAttributes::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsfs')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Set default", 'msg' => __('messages.defaultMsg', ['type' => 'Property attributes'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Set default", 'msg' => __('messages.defaultMsg', ['type' => 'Property attributes'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Set default", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function statusPropertyAttributes($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => PropertyAttributes::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Property attributes'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Change status", 'msg' => __('messages.statusMsg', ['type' => 'Property attributes'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Change status", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }

    public function deletePropertyAttributes($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => PropertyAttributes::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Property attributes'])['success']], config('constants.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete data", 'msg' => __('messages.deleteMsg', ['type' => 'Property attributes'])['failed']], config('constants.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete data", 'msg' => __('messages.serverErrMsg')], config('constants.ok'));
        }
    }
}

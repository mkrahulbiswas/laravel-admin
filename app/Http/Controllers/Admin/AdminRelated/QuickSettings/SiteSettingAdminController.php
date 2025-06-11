<?php

namespace App\Http\Controllers\Admin\AdminRelated\QuickSettings;

use App\Http\Controllers\Controller;

use App\Helpers\AdminRelated\QuickSetting\SiteSettingHelper;
use App\Helpers\AdminRelated\RolePermission\ManagePermissionHelper;

use App\Models\AdminRelated\QuickSetting\SiteSetting\Logo;

use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;

class SiteSettingAdminController extends Controller
{

    use ValidationTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Logo ) ----*/
    public function showLogo()
    {
        try {
            return view('admin.admin_related.quick_setting.site_setting.logo.logo_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getLogo()
    {
        try {
            $logo = SiteSettingHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.inf')],
                        'for' => Config::get('constants.typeCheck.quickSettings.logo.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [],
                        'orderBy' => ['id' => 'desc'],
                    ],
                ],
            ])[Config::get('constants.typeCheck.quickSettings.logo.type')][Config::get('constants.typeCheck.helperCommon.get.inf')]['list'];
            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];
            return Datatables::of($logo)
                ->addIndexColumn()
                ->addColumn('bigLogo', function ($data) {
                    $bigLogo = '<img src="' . $data['bigLogo'] . '" class="img-fluid rounded" width="100"/>';
                    return $bigLogo;
                })
                ->addColumn('smallLogo', function ($data) {
                    $smallLogo = '<img src="' . $data['smallLogo'] . '" class="img-fluid rounded" width="100"/>';
                    return $smallLogo;
                })
                ->addColumn('favicon', function ($data) {
                    $favicon = '<img src="' . $data['favicon'] . '" class="img-fluid rounded" width="100"/>';
                    return $favicon;
                })
                ->addColumn('default', function ($data) {
                    $default = $data['customizeInText'][Config::get('constants.typeCheck.customizeInText.default')]['custom'];
                    return $default;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['default']['permission'] == true) {
                        if ($data['customizeInText'][Config::get('constants.typeCheck.customizeInText.default')]['raw'] == Config::get('constants.status')['yes']) {
                            $default = '';
                        } else {
                            $default = '<a href="JavaScript:void(0);" data-type="default" data-action="' . route('admin.default.logo') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Default"><i class="mdi mdi-cursor-default-click"></i></a>';
                        }
                    } else {
                        $default = '';
                    }

                    if ($getPrivilege['edit']['permission'] == true) {
                        $edit = '<a href="JavaScript:void(0);" data-type="edit" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Edit" class="btn btn-sm waves-effect waves-light actionDatatable" title="Update"><i class="las la-edit"></i></a>';
                    } else {
                        $edit = '';
                    }

                    if ($getPrivilege['delete']['permission'] == true) {
                        if ($data['customizeInText'][Config::get('constants.typeCheck.customizeInText.default')]['raw'] == Config::get('constants.status')['yes']) {
                            $delete = '';
                        } else {
                            $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.logo') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                        }
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
                                'primary' => [$default, $edit, $delete, $info],
                                'secondary' => [],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['bigLogo', 'smallLogo', 'favicon', 'default', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveLogo(Request $request)
    {
        $bigLogo = $request->file('bigLogo');
        $smallLogo = $request->file('smallLogo');
        $favicon = $request->file('favicon');

        try {
            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'saveLogo',
                'id' => 0,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {

                if ($bigLogo) {
                    $uploadFile = $this->uploadFile([
                        'file' => ['current' => $bigLogo, 'previous' => ''],
                        'platform' => $this->platform,
                        'storage' => Config::get('constants.storage')['bigLogo']
                    ]);
                    if ($uploadFile['type'] == false) {
                        return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => $uploadFile['msg']], Config::get('constants.errorCode.ok'));
                    } else {
                        $bigLogo = $uploadFile['name'];
                    }
                } else {
                    $bigLogo = 'NA';
                }

                if ($smallLogo) {
                    $uploadFile = $this->uploadFile([
                        'file' => ['current' => $smallLogo, 'previous' => ''],
                        'platform' => $this->platform,
                        'storage' => Config::get('constants.storage')['smallLogo']
                    ]);
                    if ($uploadFile['type'] == false) {
                        return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => $uploadFile['msg']], Config::get('constants.errorCode.ok'));
                    } else {
                        $smallLogo = $uploadFile['name'];
                    }
                } else {
                    $smallLogo = 'NA';
                }

                if ($favicon) {
                    $uploadFile = $this->uploadFile([
                        'file' => ['current' => $favicon, 'previous' => ''],
                        'platform' => $this->platform,
                        'storage' => Config::get('constants.storage')['favicon']
                    ]);
                    if ($uploadFile['type'] == false) {
                        return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => $uploadFile['msg']], Config::get('constants.errorCode.ok'));
                    } else {
                        $favicon = $uploadFile['name'];
                    }
                } else {
                    $favicon = 'NA';
                }

                $logo = new Logo();
                $logo->bigLogo = $bigLogo;
                $logo->smallLogo = $smallLogo;
                $logo->favicon = $favicon;
                $logo->uniqueId = $this->generateYourChoice([['preString' => 'LOGO', 'length' => 6, 'model' => Logo::class, 'field' => '', 'type' => Config::get('constants.generateType.uniqueId')]]);

                if ($logo->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Logo'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Save data", 'msg' => __('messages.saveMsg', ['type' => 'Logo'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Save data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateLogo(Request $request)
    {
        $values = $request->only('id');
        $bigLogo = $request->file('bigLogo');
        $smallLogo = $request->file('smallLogo');
        $favicon = $request->file('favicon');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Logo", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid([
                'input' => $request->all(),
                'for' => 'updateLogo',
                'id' => $id,
                'platform' => $this->platform
            ]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $logo = Logo::find($id);
                if ($bigLogo) {
                    $uploadFile = $this->uploadFile([
                        'file' => ['current' => $bigLogo, 'previous' => $logo->bigLogo],
                        'platform' => $this->platform,
                        'storage' => Config::get('constants.storage')['bigLogo']
                    ]);
                    if ($uploadFile['type'] == false) {
                        return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => $uploadFile['msg']], Config::get('constants.errorCode.ok'));
                    } else {
                        $logo->bigLogo = $uploadFile['name'];
                    }
                }
                if ($smallLogo) {
                    $uploadFile = $this->uploadFile([
                        'file' => ['current' => $smallLogo, 'previous' => $logo->smallLogo],
                        'platform' => $this->platform,
                        'storage' => Config::get('constants.storage')['smallLogo']
                    ]);
                    if ($uploadFile['type'] == false) {
                        return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => $uploadFile['msg']], Config::get('constants.errorCode.ok'));
                    } else {
                        $logo->smallLogo = $uploadFile['name'];
                    }
                }
                if ($favicon) {
                    $uploadFile = $this->uploadFile([
                        'file' => ['current' => $favicon, 'previous' => $logo->favicon],
                        'platform' => $this->platform,
                        'storage' => Config::get('constants.storage')['favicon']
                    ]);
                    if ($uploadFile['type'] == false) {
                        return Response()->Json(['status' => 0, 'type' => "error", 'title' => "File Upload", 'msg' => $uploadFile['msg']], Config::get('constants.errorCode.ok'));
                    } else {
                        $logo->favicon = $uploadFile['name'];
                    }
                }
                if ($logo->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Logo'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Update data", 'msg' => __('messages.updateMsg', ['type' => 'Logo'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Update data", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function defaultLogo($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Default", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        // try {
        $result = $this->setDefault([
            'targetId' => $id,
            "targetModel" => Logo::class,
            'targetField' => [],
            'type' => Config::get('constants.action.status.smsfa')
        ]);
        if ($result === true) {
            return response()->json(['status' => 1, 'type' => "success", 'title' => "Default", 'msg' => __('messages.defaultMsg', ['type' => 'Logo'])['success']], Config::get('constants.errorCode.ok'));
        } else {
            return response()->json(['status' => 0, 'type' => "warning", 'title' => "Default", 'msg' => __('messages.defaultMsg', ['type' => 'Logo'])['failed']], Config::get('constants.errorCode.ok'));
        }
        // } catch (Exception $e) {
        //     return response()->json(['status' => 0, 'type' => "error", 'title' => "Default", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        // }
    }

    public function deleteLogo($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => Logo::class,
                    'picUrl' => [
                        [
                            'field' => 'bigLogo',
                            'storage' => Config::get('constants.storage')['bigLogo']
                        ],
                        [
                            'field' => 'smallLogo',
                            'storage' => Config::get('constants.storage')['smallLogo']
                        ],
                        [
                            'field' => 'favicon',
                            'storage' => Config::get('constants.storage')['favicon']
                        ]
                    ],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Logo'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Logo'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }
}

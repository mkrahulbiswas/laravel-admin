<?php

namespace App\Http\Controllers\Admin\AdminRelated\NavigationAccess;

use App\Http\Controllers\Controller;

use App\Helpers\AdminRelated\RolePermission\ManagePermissionHelper;
use App\Helpers\ManagePanel\GetManageNavHelper;

use App\Models\AdminRelated\NavigationAccess\ManageSideNav\MainNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\NestedNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\SubNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\NavType;
use App\Models\ManagePanel\ManageAccess\Permission;

use App\Traits\CommonTrait;
use App\Traits\ValidationTrait;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;

class ManageSideNavAdminController extends Controller
{

    use ValidationTrait, CommonTrait;
    public $platform = 'backend';


    /*---- ( Nav Type ) ----*/
    public function showNavType()
    {
        try {
            return view('admin.admin_related.navigation_access.manage_side_nav.nav_type.nav_type_list');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getNavType(Request $request)
    {
        // try {
        $navType = GetManageNavHelper::getList([
            [
                'getList' => [
                    'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                    'for' => Config::get('constants.typeCheck.manageNav.navType.type'),
                ],
                'otherDataPasses' => [
                    'filterData' => [
                        'status' => $request->status
                    ],
                    'orderBy' => [
                        'id' => 'desc'
                    ]
                ],
            ],
        ])[Config::get('constants.typeCheck.manageNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

        $getPrivilege = ManagePermissionHelper::getPrivilege([
            [
                'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                'otherDataPasses' => []
            ]
        ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

        return Datatables::of($navType)
            ->addIndexColumn()
            ->addColumn('description', function ($data) {
                $description = $this->subStrString(40, $data['description'], '....');
                return $description;
            })
            ->addColumn('uniqueId', function ($data) {
                $uniqueId = $data['uniqueId']['raw'];
                return $uniqueId;
            })
            ->addColumn('status', function ($data) {
                $status = $data['customizeInText']['status']['custom'];
                return $status;
            })
            ->addColumn('icon', function ($data) {
                $icon = '<i class="' . $data['icon'] . '"></i>';
                return $icon;
            })
            ->addColumn('action', function ($data) use ($getPrivilege) {
                if ($getPrivilege['status']['permission'] == true) {
                    if ($data['status'] == Config::get('constants.status')['inactive']) {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.navType') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                    } else {
                        $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.navType') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                    $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.navType') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
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
                            'secondary' => []
                        ]
                    ]
                ])['dtAction']['custom'];
            })
            ->rawColumns(['description', 'uniqueId', 'status', 'icon', 'action'])
            ->make(true);
        // } catch (Exception $e) {
        //     return redirect()->back()->with('error', 'Something went wrong.');
        // }
    }

    public function saveNavType(Request $request)
    {
        try {
            $values = $request->only('name', 'icon', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveNavType', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {

                $navType = new NavType;
                $navType->name = $values['name'];
                $navType->icon = $values['icon'];
                $navType->description = ($values['description'] == '') ? 'NA' : $values['description'];;
                $navType->uniqueId = $this->generateCode(['preString' => 'NT', 'length' => 6, 'model' => NavType::class, 'field' => '']);
                $navType->status = Config::get('constants.status')['active'];
                $navType->position = NavType::max('position') + 1;

                if ($navType->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nav Type", 'msg' => __('messages.saveMsg', ['type' => 'Nav type'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nav Type", 'msg' => __('messages.saveMsg', ['type' => 'Nav type'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nav Type", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateNavType(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Nav Type", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateNavType', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $navType = NavType::find($id);

                $navType->name = $values['name'];
                $navType->icon = $values['icon'];
                $navType->description = ($values['description'] == '') ? 'NA' : $values['description'];;

                if ($navType->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nav Type", 'msg' => __('messages.updateMsg', ['type' => 'Nav type'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nav Type", 'msg' => __('messages.updateMsg', ['type' => 'Nav type'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nav Type", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function statusNavType($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => NavType::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Nav type'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Nav type'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteNavType($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => NavType::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
                [
                    'model' => MainNav::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'navTypeId']],
                ],
                [
                    'model' => SubNav::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'navTypeId']],
                ],
                [
                    'model' => NestedNav::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'navTypeId']],
                ],
            ]);
            if ($result == true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav type'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nav type'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }


    /*---- ( Main Nav ) ----*/
    public function showMainNav()
    {
        try {
            $navType = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageNav.navType.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active']
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ]);

            $data = [
                Config::get('constants.typeCheck.manageNav.navType.type') => $navType[Config::get('constants.typeCheck.manageNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'],
            ];

            return view('admin.admin_related.navigation_access.manage_side_nav.main_nav.main_nav_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getNavMain(Request $request)
    {
        try {
            $navMain = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.manageNav.navMain.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'navTypeId' => $request->navType
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ])[Config::get('constants.typeCheck.manageNav.navMain.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($navMain)
                ->addIndexColumn()
                ->addColumn('navType', function ($data) {
                    $navType = $data[Config::get('constants.typeCheck.manageNav.navType.type')]['name'];
                    return $navType;
                })
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
                ->addColumn('icon', function ($data) {
                    $icon = '<i class="' . $data['icon'] . '"></i>';
                    return $icon;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['status'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.mainNav') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.mainNav') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.mainNav') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($getPrivilege['info']['permission'] == true) {
                        $info = '<a href="JavaScript:void(0);" data-type="info" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Info" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    } else {
                        $info = '';
                    }

                    if ($getPrivilege['access']['permission'] == true) {
                        $access = '<a href="JavaScript:void(0);" data-type="access" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Access" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-access-point"></i><span>Change Access</span></a>';
                    } else {
                        $access = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete, $info],
                                'secondary' => [$access],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['navType', 'uniqueId', 'statInfo', 'icon', 'action'])
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

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveNavMain', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {

                $navMain = new MainNav();
                $navMain->name = $values['name'];
                $navMain->icon = $values['icon'];
                $navMain->navTypeId = decrypt($values['navType']);
                $navMain->description = ($values['description'] == '') ? 'NA' : $values['description'];;
                $navMain->uniqueId = $this->generateCode(['preString' => 'NM', 'length' => 6, 'model' => MainNav::class, 'field' => '']);
                $navMain->status = Config::get('constants.status')['active'];
                $navMain->position = MainNav::max('position') + 1;
                $navMain->route = strtolower(str_replace(" ", "-", $values['name']));
                $navMain->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navMain->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Main nav", 'msg' => __('messages.saveMsg', ['type' => 'Main nav'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Main nav", 'msg' =>  __('messages.saveMsg', ['type' => 'Main nav'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Main nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateNavMain(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'navType', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Main nav", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateNavMain', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $navMain = MainNav::find($id);

                $navMain->name = $values['name'];
                $navMain->icon = $values['icon'];
                $navMain->navTypeId = decrypt($values['navType']);
                $navMain->description = ($values['description'] == '') ? 'NA' : $values['description'];;
                $navMain->route = strtolower(str_replace(" ", "-", $values['name']));
                $navMain->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navMain->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Main nav", 'msg' => __('messages.updateMsg', ['type' => 'Main nav'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Main nav", 'msg' => __('messages.updateMsg', ['type' => 'Main nav'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Main nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function accessNavMain(Request $request)
    {
        DB::beginTransaction();
        $values = $request->only('id', 'name', 'access');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Main nav", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            if (isset($values['access'])) {
                $getNavAccessList = $this->getNavAccessList([
                    [
                        'checkFirst' => [
                            'type' => Config::get('constants.typeCheck.helperCommon.access.fns')
                        ],
                        'otherDataPasses' => [
                            'access' => $values['access']
                        ]
                    ]
                ])[Config::get('constants.typeCheck.helperCommon.access.fns')];
                $navMain = MainNav::find($id);
                $navMain->access = $getNavAccessList['access'];
                if ($navMain->update()) {
                    $setPermission = ManagePermissionHelper::setPermission([
                        [
                            'checkFirst' => [
                                'type' => [Config::get('constants.typeCheck.helperCommon.set.pfn')],
                                'for' => Config::get('constants.typeCheck.helperCommon.privilege.sp'),
                            ],
                            'otherDataPasses' => [
                                'getNavAccessList' => $getNavAccessList,
                                'for' => Config::get('constants.typeCheck.manageNav.navMain.type'),
                                'id' => $id,
                            ]
                        ]
                    ]);
                    if ($setPermission) {
                        DB::commit();
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Main nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav access'])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        DB::rollBack();
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Main nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav access'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    DB::rollBack();
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Main nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav access'])['failed']], Config::get('constants.errorCode.ok'));
                }
            } else {
                DB::rollBack();
                return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Validation", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav access'])['validation']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Main nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function statusNavMain($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => MainNav::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Main nav'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Main nav'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteNavMain($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => MainNav::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
                [
                    'model' => SubNav::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'mainNavId']],
                ],
                [
                    'model' => NestedNav::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'mainNavId']],
                ],
                [
                    'model' => Permission::class,
                    'picUrl' => [],
                    'filter' => [
                        ['search' => $id, 'field' => 'mainNavId'],
                        ['search' => null, 'field' => 'subNavId'],
                        ['search' => null, 'field' => 'nestedNavId'],
                    ],
                ],
            ]);

            if ($result == true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Main nav'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Main nav'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }


    /*---- ( Sub Nav ) ----*/
    public function showSubNav()
    {
        try {
            $navType = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageNav.navType.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active']
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ]);

            $data = [
                'navType' => $navType[Config::get('constants.typeCheck.manageNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'],
            ];

            return view('admin.admin_related.navigation_access.manage_side_nav.sub_nav.sub_nav_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getNavSub(Request $request)
    {
        try {
            $navSub = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.manageNav.navSub.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'navTypeId' => $request->navType,
                            'mainNavId' => $request->navMain
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ])[Config::get('constants.typeCheck.manageNav.navSub.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($navSub)
                ->addIndexColumn()
                ->addColumn('navType', function ($data) {
                    $navType = $data[Config::get('constants.typeCheck.manageNav.navType.type')]['name'];
                    return $navType;
                })
                ->addColumn('navMain', function ($data) {
                    $navMain = $data[Config::get('constants.typeCheck.manageNav.navMain.type')]['name'];
                    return $navMain;
                })
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
                ->addColumn('icon', function ($data) {
                    $icon = '<i class="' . $data['icon'] . '"></i>';
                    return $icon;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['status'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.subNav') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.subNav') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.subNav') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($getPrivilege['info']['permission'] == true) {
                        $info = '<a href="JavaScript:void(0);" data-type="info" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Info" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    } else {
                        $info = '';
                    }

                    if ($getPrivilege['access']['permission'] == true) {
                        $access = '<a href="JavaScript:void(0);" data-type="access" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Access" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-access-point"></i><span>Change Access</span></a>';
                    } else {
                        $access = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete, $info],
                                'secondary' => [$access],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['navType', 'navMain', 'uniqueId', 'statInfo', 'icon', 'action'])
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

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveNavSub', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {

                $navSub = new SubNav();
                $navSub->name = $values['name'];
                $navSub->icon = $values['icon'];
                $navSub->navTypeId = decrypt($values['navType']);
                $navSub->mainNavId = decrypt($values['navMain']);
                $navSub->description = ($values['description'] == '') ? 'NA' : $values['description'];;
                $navSub->uniqueId = $this->generateCode(['preString' => 'NS', 'length' => 6, 'model' => SubNav::class, 'field' => '']);
                $navSub->status = Config::get('constants.status')['active'];
                $navSub->position = SubNav::max('position') + 1;
                $navSub->route = strtolower(str_replace(" ", "-", MainNav::where('id', decrypt($values['navMain']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $navSub->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navSub->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Sub nav", 'msg' => __('messages.saveMsg', ['type' => 'Sub nav'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Sub nav", 'msg' => __('messages.saveMsg', ['type' => 'Sub nav'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Sub nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateNavSub(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'navType', 'navMain', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Sub nav", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateNavSub', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $navSub = SubNav::find($id);

                $navSub->name = $values['name'];
                $navSub->icon = $values['icon'];
                $navSub->navTypeId = decrypt($values['navType']);
                $navSub->mainNavId = decrypt($values['navMain']);
                $navSub->description = ($values['description'] == '') ? 'NA' : $values['description'];;
                $navSub->route = strtolower(str_replace(" ", "-", MainNav::where('id', decrypt($values['navMain']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $navSub->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navSub->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Sub nav", 'msg' => __('messages.updateMsg', ['type' => 'Sub nav'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Sub nav", 'msg' =>  __('messages.updateMsg', ['type' => 'Sub nav'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Sub nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function accessNavSub(Request $request)
    {
        DB::beginTransaction();
        $values = $request->only('id', 'name', 'access');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Sub nav", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            if (isset($values['access'])) {
                $getNavAccessList = $this->getNavAccessList([
                    [
                        'checkFirst' => [
                            'type' => Config::get('constants.typeCheck.helperCommon.access.fns')
                        ],
                        'otherDataPasses' => [
                            'access' => $values['access']
                        ]
                    ]
                ])[Config::get('constants.typeCheck.helperCommon.access.fns')];
                $navSub = SubNav::find($id);
                $navSub->access = $getNavAccessList['access'];
                if ($navSub->update()) {
                    $setPermission = ManagePermissionHelper::setPermission([
                        [
                            'checkFirst' => [
                                'type' => [Config::get('constants.typeCheck.helperCommon.set.pfn')],
                                'for' => Config::get('constants.typeCheck.helperCommon.privilege.sp'),
                            ],
                            'otherDataPasses' => [
                                'getNavAccessList' => $getNavAccessList,
                                'for' => Config::get('constants.typeCheck.manageNav.navSub.type'),
                                'id' => $id,
                            ]
                        ]
                    ]);
                    if ($setPermission) {
                        DB::commit();
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Sub nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav access'])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        DB::rollBack();
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Sub nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav access'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    DB::rollBack();
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Sub nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav access'])['failed']], Config::get('constants.errorCode.ok'));
                }
            } else {
                DB::rollBack();
                return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Validation", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav access'])['validation']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Sub nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function statusNavSub($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => SubNav::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Sub nav'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Sub nav'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteNavSub($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => SubNav::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
                [
                    'model' => NestedNav::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'subNavId']],
                ],
                [
                    'model' => Permission::class,
                    'picUrl' => [],
                    'filter' => [
                        ['search' => $id, 'field' => 'mainNavId'],
                        ['search' => null, 'field' => 'nestedNavId'],
                    ],
                ],
            ]);
            if ($result == true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Sub nav'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Sub nav'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }


    /*---- ( Nested Nav ) ----*/
    public function showNestedNav()
    {
        try {
            $navType = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.manageNav.navType.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => Config::get('constants.status')['active']
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ]);

            $data = [
                'navType' => $navType[Config::get('constants.typeCheck.manageNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'],
            ];

            return view('admin.admin_related.navigation_access.manage_side_nav.nested_nav.nested_nav_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getNavNested(Request $request)
    {
        try {
            $navNested = GetManageNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.manageNav.navNested.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'navTypeId' => $request->navType,
                            'mainNavId' => $request->navMain,
                            'subNavId' => $request->navSub,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ])[Config::get('constants.typeCheck.manageNav.navNested.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($navNested)
                ->addIndexColumn()
                ->addColumn('navType', function ($data) {
                    $navType = $data[Config::get('constants.typeCheck.manageNav.navType.type')]['name'];
                    return $navType;
                })
                ->addColumn('navMain', function ($data) {
                    $navMain = $data[Config::get('constants.typeCheck.manageNav.navMain.type')]['name'];
                    return $navMain;
                })
                ->addColumn('navSub', function ($data) {
                    $navSub = $data[Config::get('constants.typeCheck.manageNav.navSub.type')]['name'];
                    return $navSub;
                })
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
                ->addColumn('icon', function ($data) {
                    $icon = '<i class="' . $data['icon'] . '"></i>';
                    return $icon;
                })
                ->addColumn('action', function ($data) use ($getPrivilege) {
                    if ($getPrivilege['status']['permission'] == true) {
                        if ($data['status'] == Config::get('constants.status')['inactive']) {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="unblock" data-action="' . route('admin.status.nestedNav') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Unblock"><i class="las la-lock-open"></i></a>';
                        } else {
                            $status = '<a href="JavaScript:void(0);" data-type="status" data-status="block" data-action="' . route('admin.status.nestedNav') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Block"><i class="las la-lock"></i></a>';
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
                        $delete = '<a href="JavaScript:void(0);" data-type="delete" data-action="' . route('admin.delete.nestedNav') . '/' . $data['id'] . '" class="btn btn-sm waves-effect waves-light actionDatatable" title="Delete"><i class="las la-trash"></i></a>';
                    } else {
                        $delete = '';
                    }

                    if ($getPrivilege['info']['permission'] == true) {
                        $info = '<a href="JavaScript:void(0);" data-type="info" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Info" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="las la-info-circle"></i></a>';
                    } else {
                        $info = '';
                    }

                    if ($getPrivilege['access']['permission'] == true) {
                        $access = '<a href="JavaScript:void(0);" data-type="access" data-array=\'' . json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) . '\' title="Access" class="btn btn-sm waves-effect waves-light actionDatatable"><i class="mdi mdi-access-point"></i><span>Change Access</span></a>';
                    } else {
                        $access = '';
                    }

                    return $this->dynamicHtmlPurse([
                        [
                            'type' => 'dtAction',
                            'data' => [
                                'primary' => [$status, $edit, $delete, $info],
                                'secondary' => [$access],
                            ]
                        ]
                    ])['dtAction']['custom'];
                })
                ->rawColumns(['navType', 'navMain', 'navSub', 'uniqueId', 'statInfo', 'icon', 'action'])
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

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveNavNested', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {

                $navNested = new NestedNav();
                $navNested->name = $values['name'];
                $navNested->icon = $values['icon'];
                $navNested->navTypeId = decrypt($values['navType']);
                $navNested->mainNavId = decrypt($values['navMain']);
                $navNested->subNavId = decrypt($values['navSub']);
                $navNested->description = ($values['description'] == '') ? 'NA' : $values['description'];
                $navNested->uniqueId = $this->generateCode(['preString' => 'NN', 'length' => 6, 'model' => NestedNav::class, 'field' => '']);
                $navNested->status = Config::get('constants.status')['active'];
                $navNested->position = NestedNav::max('position') + 1;
                $navNested->route = strtolower(str_replace(" ", "-", MainNav::where('id', decrypt($values['navMain']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", SubNav::where('id', decrypt($values['navSub']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $navNested->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navNested->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nested nav", 'msg' => __('messages.saveMsg', ['type' => 'Nested nav'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nested nav", 'msg' => __('messages.saveMsg', ['type' => 'Nested nav'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nested nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateNavNested(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'navType', 'navMain', 'navSub', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Nested nav", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateNavNested', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $navNested = NestedNav::find($id);

                $navNested->name = $values['name'];
                $navNested->icon = $values['icon'];
                $navNested->navTypeId = decrypt($values['navType']);
                $navNested->mainNavId = decrypt($values['navMain']);
                $navNested->subNavId = decrypt($values['navSub']);
                $navNested->description = ($values['description'] == '') ? 'NA' : $values['description'];;
                $navNested->route = strtolower(str_replace(" ", "-", MainNav::where('id', decrypt($values['navMain']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", SubNav::where('id', decrypt($values['navSub']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $navNested->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($navNested->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nested nav", 'msg' => __('messages.updateMsg', ['type' => 'Nested nav'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nested nav", 'msg' => __('messages.updateMsg', ['type' => 'Nested nav'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nested nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function accessNavNested(Request $request)
    {
        DB::beginTransaction();
        $values = $request->only('id', 'name', 'access');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Nested nav", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            if (isset($values['access'])) {
                $getNavAccessList = $this->getNavAccessList([
                    [
                        'checkFirst' => [
                            'type' => Config::get('constants.typeCheck.helperCommon.access.fns')
                        ],
                        'otherDataPasses' => [
                            'access' => $values['access']
                        ]
                    ]
                ])[Config::get('constants.typeCheck.helperCommon.access.fns')];
                $navNested = NestedNav::find($id);
                $navNested->access = $getNavAccessList['access'];
                if ($navNested->update()) {
                    $setPermission = ManagePermissionHelper::setPermission([
                        [
                            'checkFirst' => [
                                'type' => [Config::get('constants.typeCheck.helperCommon.set.pfn')],
                                'for' => Config::get('constants.typeCheck.helperCommon.privilege.sp'),
                            ],
                            'otherDataPasses' => [
                                'getNavAccessList' => $getNavAccessList,
                                'for' => Config::get('constants.typeCheck.manageNav.navNested.type'),
                                'id' => $id,
                            ]
                        ]
                    ]);
                    if ($setPermission) {
                        DB::commit();
                        return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Main nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav access'])['success']], Config::get('constants.errorCode.ok'));
                    } else {
                        DB::rollBack();
                        return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Main nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav access'])['failed']], Config::get('constants.errorCode.ok'));
                    }
                } else {
                    DB::rollBack();
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nested nav", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav access'])['failed']], Config::get('constants.errorCode.ok'));
                }
            } else {
                DB::rollBack();
                return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Validation", 'msg' => __('messages.setAccessMsg', ['type' => 'Nav access'])['validation']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nested nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function statusNavNested($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->changeStatus([
                'targetId' => $id,
                "targetModel" => NestedNav::class,
                'targetField' => [],
                'type' => Config::get('constants.action.status.smsf')
            ]);
            if ($result === true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Nested nav'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Status", 'msg' => __('messages.statusMsg', ['type' => 'Nested nav'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Status", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function deleteNavNested($id)
    {
        try {
            $id = decrypt($id);
        } catch (DecryptException $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $result = $this->deleteItem([
                [
                    'model' => NestedNav::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => '']],
                ],
                [
                    'model' => Permission::class,
                    'picUrl' => [],
                    'filter' => [['search' => $id, 'field' => 'nestedNavId']],
                ],
            ]);
            if ($result == true) {
                return response()->json(['status' => 1, 'type' => "success", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nested nav'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                return response()->json(['status' => 0, 'type' => "warning", 'title' => "Delete", 'msg' => __('messages.deleteMsg', ['type' => 'Nested nav'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            return response()->json(['status' => 0, 'type' => "error", 'title' => "Delete", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }


    /*---- ( Arrange Nav ) ----*/
    public function showArrangeNav()
    {
        try {
            $getNav = GetManageNavHelper::getNav([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.nav.sn')],
                    'otherDataPasses' => [
                        'filterData' => ['status' => Config::get('constants.status')['active']],
                        'orderBy' => ['position' => 'asc']
                    ],
                ]
            ])[Config::get('constants.typeCheck.helperCommon.nav.sn')];

            $data = [
                'navList' => $getNav,
            ];

            return view('admin.admin_related.navigation_access.arrange_side_nav.arrange_side_nav_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function updateArrangeNav(Request $request)
    {
        DB::beginTransaction();
        $values = $request->only('navType', 'navMain', 'navSub', 'navNested');

        try {
            foreach ($values['navType'] as $key => $temp) {
                if (NavType::where('id', $temp)->update([
                    'position' => ($key + 1)
                ])) {
                    $response = true;
                } else {
                    $response = false;
                    goto next;
                }
            }
            foreach ($values['navMain'] as $key => $temp) {
                if (MainNav::where('id', $temp)->update([
                    'position' => ($key + 1)
                ])) {
                    $response = true;
                } else {
                    $response = false;
                    goto next;
                }
            }
            foreach ($values['navSub'] as $key => $temp) {
                if (SubNav::where('id', $temp)->update([
                    'position' => ($key + 1)
                ])) {
                    $response = true;
                } else {
                    $response = false;
                    goto next;
                }
            }
            foreach ($values['navNested'] as $key => $temp) {
                if (NestedNav::where('id', $temp)->update([
                    'position' => ($key + 1)
                ])) {
                    $response = true;
                } else {
                    $response = false;
                    goto next;
                }
            }

            next:
            if ($response == true) {
                DB::commit();
                return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nested nav", 'msg' => __('messages.updateMsg', ['type' => 'Nested nav'])['success']], Config::get('constants.errorCode.ok'));
            } else {
                DB::roleBack();
                return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nested nav", 'msg' => __('messages.updateMsg', ['type' => 'Nested nav'])['failed']], Config::get('constants.errorCode.ok'));
            }
        } catch (Exception $e) {
            DB::roleBack();
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nested nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }
}

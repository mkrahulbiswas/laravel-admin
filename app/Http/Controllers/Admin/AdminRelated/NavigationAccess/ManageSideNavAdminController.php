<?php

namespace App\Http\Controllers\Admin\AdminRelated\NavigationAccess;

use App\Http\Controllers\Controller;

use App\Helpers\AdminRelated\NavigationAccess\ManageSideNavHelper;
use App\Helpers\AdminRelated\RolePermission\ManagePermissionHelper;

use App\Models\AdminRelated\NavigationAccess\ManageSideNav\MainNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\NestedNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\SubNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\NavType;
use App\Models\AdminRelated\RolePermission\ManagePermission\Permission;

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
        try {
            $navType = ManageSideNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
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
            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];

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
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
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
            $navType = ManageSideNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
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
                Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => $navType[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'],
            ];

            return view('admin.admin_related.navigation_access.manage_side_nav.main_nav.main_nav_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getMainNav(Request $request)
    {
        try {
            $mainNav = ManageSideNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
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
            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($mainNav)
                ->addIndexColumn()
                ->addColumn('navType', function ($data) {
                    $navType = $data[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')]['name'];
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

    public function saveMainNav(Request $request)
    {
        try {
            $values = $request->only('name', 'icon', 'navType', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveMainNav', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {

                $mainNav = new MainNav();
                $mainNav->name = $values['name'];
                $mainNav->icon = $values['icon'];
                $mainNav->navTypeId = decrypt($values['navType']);
                $mainNav->description = ($values['description'] == '') ? 'NA' : $values['description'];;
                $mainNav->uniqueId = $this->generateCode(['preString' => 'NM', 'length' => 6, 'model' => MainNav::class, 'field' => '']);
                $mainNav->status = Config::get('constants.status')['active'];
                $mainNav->position = MainNav::max('position') + 1;
                $mainNav->route = strtolower(str_replace(" ", "-", $values['name']));
                $mainNav->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($mainNav->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Main nav", 'msg' => __('messages.saveMsg', ['type' => 'Main nav'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Main nav", 'msg' =>  __('messages.saveMsg', ['type' => 'Main nav'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Main nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateMainNav(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'navType', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Main nav", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateMainNav', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $mainNav = MainNav::find($id);

                $mainNav->name = $values['name'];
                $mainNav->icon = $values['icon'];
                $mainNav->navTypeId = decrypt($values['navType']);
                $mainNav->description = ($values['description'] == '') ? 'NA' : $values['description'];;
                $mainNav->route = strtolower(str_replace(" ", "-", $values['name']));
                $mainNav->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($mainNav->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Main nav", 'msg' => __('messages.updateMsg', ['type' => 'Main nav'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Main nav", 'msg' => __('messages.updateMsg', ['type' => 'Main nav'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Main nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function accessMainNav(Request $request)
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
                $mainNav = MainNav::find($id);
                $mainNav->access = $getNavAccessList['access'];
                if ($mainNav->update()) {
                    $setPermission = ManagePermissionHelper::setPermission([
                        [
                            'checkFirst' => [
                                'type' => [Config::get('constants.typeCheck.helperCommon.set.pfn')],
                                'for' => Config::get('constants.typeCheck.helperCommon.privilege.sp'),
                            ],
                            'otherDataPasses' => [
                                'getNavAccessList' => $getNavAccessList,
                                'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
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

    public function statusMainNav($id)
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

    public function deleteMainNav($id)
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
            $navType = ManageSideNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
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
                'navType' => $navType[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'],
            ];

            return view('admin.admin_related.navigation_access.manage_side_nav.sub_nav.sub_nav_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getSubNav(Request $request)
    {
        try {
            $subNav = ManageSideNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'navTypeId' => $request->navType,
                            'mainNavId' => $request->mainNav
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($subNav)
                ->addIndexColumn()
                ->addColumn('navType', function ($data) {
                    $navType = $data[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')]['name'];
                    return $navType;
                })
                ->addColumn('mainNav', function ($data) {
                    $mainNav = $data[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')]['name'];
                    return $mainNav;
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
                ->rawColumns(['navType', 'mainNav', 'uniqueId', 'statInfo', 'icon', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveSubNav(Request $request)
    {
        try {
            $values = $request->only('name', 'icon', 'navType', 'mainNav', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveSubNav', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {

                $subNav = new SubNav();
                $subNav->name = $values['name'];
                $subNav->icon = $values['icon'];
                $subNav->navTypeId = decrypt($values['navType']);
                $subNav->mainNavId = decrypt($values['mainNav']);
                $subNav->description = ($values['description'] == '') ? 'NA' : $values['description'];;
                $subNav->uniqueId = $this->generateCode(['preString' => 'NS', 'length' => 6, 'model' => SubNav::class, 'field' => '']);
                $subNav->status = Config::get('constants.status')['active'];
                $subNav->position = SubNav::max('position') + 1;
                $subNav->route = strtolower(str_replace(" ", "-", MainNav::where('id', decrypt($values['mainNav']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $subNav->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($subNav->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Sub nav", 'msg' => __('messages.saveMsg', ['type' => 'Sub nav'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Sub nav", 'msg' => __('messages.saveMsg', ['type' => 'Sub nav'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Sub nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateSubNav(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'navType', 'mainNav', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Sub nav", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateSubNav', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $subNav = SubNav::find($id);

                $subNav->name = $values['name'];
                $subNav->icon = $values['icon'];
                $subNav->navTypeId = decrypt($values['navType']);
                $subNav->mainNavId = decrypt($values['mainNav']);
                $subNav->description = ($values['description'] == '') ? 'NA' : $values['description'];;
                $subNav->route = strtolower(str_replace(" ", "-", MainNav::where('id', decrypt($values['mainNav']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $subNav->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($subNav->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Sub nav", 'msg' => __('messages.updateMsg', ['type' => 'Sub nav'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Sub nav", 'msg' =>  __('messages.updateMsg', ['type' => 'Sub nav'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Sub nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function accessSubNav(Request $request)
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
                $subNav = SubNav::find($id);
                $subNav->access = $getNavAccessList['access'];
                if ($subNav->update()) {
                    $setPermission = ManagePermissionHelper::setPermission([
                        [
                            'checkFirst' => [
                                'type' => [Config::get('constants.typeCheck.helperCommon.set.pfn')],
                                'for' => Config::get('constants.typeCheck.helperCommon.privilege.sp'),
                            ],
                            'otherDataPasses' => [
                                'getNavAccessList' => $getNavAccessList,
                                'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
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

    public function statusSubNav($id)
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

    public function deleteSubNav($id)
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
            $navType = ManageSideNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
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
                'navType' => $navType[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'],
            ];

            return view('admin.admin_related.navigation_access.manage_side_nav.nested_nav.nested_nav_list', ['data' => $data]);
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function getNestedNav(Request $request)
    {
        try {
            $nestedNav = ManageSideNavHelper::getList([
                [
                    'getList' => [
                        'type' => [Config::get('constants.typeCheck.helperCommon.get.dyf')],
                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type'),
                    ],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $request->status,
                            'navTypeId' => $request->navType,
                            'mainNavId' => $request->mainNav,
                            'subNavId' => $request->subNav,
                        ],
                        'orderBy' => [
                            'id' => 'desc'
                        ]
                    ],
                ],
            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')][Config::get('constants.typeCheck.helperCommon.get.dyf')]['list'];

            $getPrivilege = ManagePermissionHelper::getPrivilege([
                [
                    'type' => [Config::get('constants.typeCheck.helperCommon.privilege.gp')],
                    'otherDataPasses' => []
                ]
            ])[Config::get('constants.typeCheck.helperCommon.privilege.gp')];

            return Datatables::of($nestedNav)
                ->addIndexColumn()
                ->addColumn('navType', function ($data) {
                    $navType = $data[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')]['name'];
                    return $navType;
                })
                ->addColumn('mainNav', function ($data) {
                    $mainNav = $data[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')]['name'];
                    return $mainNav;
                })
                ->addColumn('subNav', function ($data) {
                    $subNav = $data[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')]['name'];
                    return $subNav;
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
                ->rawColumns(['navType', 'mainNav', 'subNav', 'uniqueId', 'statInfo', 'icon', 'action'])
                ->make(true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function saveNestedNav(Request $request)
    {
        try {
            $values = $request->only('name', 'icon', 'navType', 'mainNav', 'subNav', 'description');
            //--Checking The Validation--//

            $validator = $this->isValid(['input' => $request->all(), 'for' => 'saveNestedNav', 'id' => 0, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {

                $nestedNav = new NestedNav();
                $nestedNav->name = $values['name'];
                $nestedNav->icon = $values['icon'];
                $nestedNav->navTypeId = decrypt($values['navType']);
                $nestedNav->mainNavId = decrypt($values['mainNav']);
                $nestedNav->subNavId = decrypt($values['subNav']);
                $nestedNav->description = ($values['description'] == '') ? 'NA' : $values['description'];
                $nestedNav->uniqueId = $this->generateCode(['preString' => 'NN', 'length' => 6, 'model' => NestedNav::class, 'field' => '']);
                $nestedNav->status = Config::get('constants.status')['active'];
                $nestedNav->position = NestedNav::max('position') + 1;
                $nestedNav->route = strtolower(str_replace(" ", "-", MainNav::where('id', decrypt($values['mainNav']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", SubNav::where('id', decrypt($values['subNav']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $nestedNav->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($nestedNav->save()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nested nav", 'msg' => __('messages.saveMsg', ['type' => 'Nested nav'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nested nav", 'msg' => __('messages.saveMsg', ['type' => 'Nested nav'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nested nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function updateNestedNav(Request $request)
    {
        $values = $request->only('id', 'name', 'icon', 'navType', 'mainNav', 'subNav', 'description');

        try {
            $id = decrypt($values['id']);
        } catch (DecryptException $e) {
            return Response()->Json(['status' => 0,  'type' => "error", 'title' => "Nested nav", 'msg' => config('constants.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }

        try {
            $validator = $this->isValid(['input' => $request->all(), 'for' => 'updateNestedNav', 'id' => $id, 'platform' => $this->platform]);
            if ($validator->fails()) {
                return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Validation", 'msg' => __('messages.vErrMsg'), 'errors' => $validator->errors()], Config::get('constants.errorCode.ok'));
            } else {
                $nestedNav = NestedNav::find($id);

                $nestedNav->name = $values['name'];
                $nestedNav->icon = $values['icon'];
                $nestedNav->navTypeId = decrypt($values['navType']);
                $nestedNav->mainNavId = decrypt($values['mainNav']);
                $nestedNav->subNavId = decrypt($values['subNav']);
                $nestedNav->description = ($values['description'] == '') ? 'NA' : $values['description'];;
                $nestedNav->route = strtolower(str_replace(" ", "-", MainNav::where('id', decrypt($values['mainNav']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", SubNav::where('id', decrypt($values['subNav']))->value('name'))) . '/' . strtolower(str_replace(" ", "-", $values['name']));
                $nestedNav->lastSegment = strtolower(str_replace(" ", "-", $values['name']));

                if ($nestedNav->update()) {
                    return Response()->Json(['status' => 1, 'type' => "success", 'title' => "Nested nav", 'msg' => __('messages.updateMsg', ['type' => 'Nested nav'])['success']], Config::get('constants.errorCode.ok'));
                } else {
                    return Response()->Json(['status' => 0, 'type' => "warning", 'title' => "Nested nav", 'msg' => __('messages.updateMsg', ['type' => 'Nested nav'])['failed']], Config::get('constants.errorCode.ok'));
                }
            }
        } catch (Exception $e) {
            return Response()->Json(['status' => 0, 'type' => "error", 'title' => "Nested nav", 'msg' => __('messages.serverErrMsg')], Config::get('constants.errorCode.ok'));
        }
    }

    public function accessNestedNav(Request $request)
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
                $nestedNav = NestedNav::find($id);
                $nestedNav->access = $getNavAccessList['access'];
                if ($nestedNav->update()) {
                    $setPermission = ManagePermissionHelper::setPermission([
                        [
                            'checkFirst' => [
                                'type' => [Config::get('constants.typeCheck.helperCommon.set.pfn')],
                                'for' => Config::get('constants.typeCheck.helperCommon.privilege.sp'),
                            ],
                            'otherDataPasses' => [
                                'getNavAccessList' => $getNavAccessList,
                                'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type'),
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

    public function statusNestedNav($id)
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

    public function deleteNestedNav($id)
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
}

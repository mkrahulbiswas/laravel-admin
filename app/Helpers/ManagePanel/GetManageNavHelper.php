<?php

namespace App\Helpers\ManagePanel;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use App\Models\AdminRelated\NavigationAccess\ManageSideNav\NavType;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\MainNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\SubNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\NestedNav;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class GetManageNavHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';

    public static function getList($params, $platform = '')
    {
        // try {
        $finalData = array();
        foreach ($params as $tempOne) {
            if (Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') == $tempOne['getList']['for']) {
                $data = array();

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.inf'), $tempOne['getList']['type'])) {
                    $navType = array();

                    foreach (NavType::get() as $tempTwo) {
                        $navType[] = [
                            'id' => $tempTwo->id,
                            'name' => $tempTwo->name
                        ];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.inf')] = [
                        'list' => $navType
                    ];
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                    $navType = array();
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                    }

                    if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'position')) {
                            $position = $tempOne['otherDataPasses']['orderBy']['position'];
                            if (!empty($position)) {
                                $orderByRaw = "`position` " . $position;
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                            $id = $tempOne['otherDataPasses']['orderBy']['id'];
                            if (!empty($id)) {
                                $orderByRaw = "`id` " . $id;
                            }
                        }
                    }

                    foreach (NavType::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                        $navType[] = GetManageNavHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($tempTwo->id)
                                ],
                            ],
                        ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                        'list' => $navType
                    ];

                    if (isset($tempOne['otherDataPasses']['filterData'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                    }

                    if (isset($tempOne['otherDataPasses']['orderBy'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                    }
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.ryf'), $tempOne['getList']['type'])) {
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'id')) {
                            $id = $tempOne['otherDataPasses']['filterData']['id'];
                            if (!empty($id)) {
                                $whereRaw .= " and `id` = " . decrypt($id);
                            }
                        }
                    }

                    if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'position')) {
                            $position = $tempOne['otherDataPasses']['orderBy']['position'];
                            if (!empty($position)) {
                                $orderByRaw = "`position` " . $position;
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                            $id = $tempOne['otherDataPasses']['orderBy']['id'];
                            if (!empty($id)) {
                                $orderByRaw = "`id` " . $id;
                            }
                        }
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.ryf')] = [
                        'list' => NavType::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get()
                    ];

                    if (isset($tempOne['otherDataPasses']['filterData'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.ryf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                    }

                    if (isset($tempOne['otherDataPasses']['orderBy'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.ryf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                    }
                }

                $finalData[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')] = $data;
            }

            if (Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type') == $tempOne['getList']['for']) {
                $data = array();

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.inf'), $tempOne['getList']['type'])) {
                    $navMain = array();

                    foreach (MainNav::get() as $tempTwo) {
                        $navMain[] = [
                            'id' => $tempTwo->id,
                            'name' => $tempTwo->name
                        ];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.inf')] = [
                        'list' => $navMain
                    ];
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                    $navMain = array();
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navTypeId')) {
                            $navTypeId = $tempOne['otherDataPasses']['filterData']['navTypeId'];
                            if (!empty($navTypeId)) {
                                $whereRaw .= " and `navTypeId` = " . decrypt($navTypeId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'access')) {
                            $access = $tempOne['otherDataPasses']['filterData']['access'];
                            if (!empty($access)) {
                                $whereRaw .= " and `access` is not null";
                            }
                        }
                    }

                    if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'position')) {
                            $position = $tempOne['otherDataPasses']['orderBy']['position'];
                            if (!empty($position)) {
                                $orderByRaw = "`position` " . $position;
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                            $id = $tempOne['otherDataPasses']['orderBy']['id'];
                            if (!empty($id)) {
                                $orderByRaw = "`id` " . $id;
                            }
                        }
                    }

                    foreach (MainNav::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                        $navMain[] = [
                            ...GetManageNavHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                        ];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                        'list' => $navMain
                    ];

                    if (isset($tempOne['otherDataPasses']['filterData'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                    }

                    if (isset($tempOne['otherDataPasses']['orderBy'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                    }
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                    $navMain = array();
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navTypeId')) {
                            $navTypeId = $tempOne['otherDataPasses']['filterData']['navTypeId'];
                            if (!empty($navTypeId)) {
                                $whereRaw .= " and `navTypeId` = " . decrypt($navTypeId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'access')) {
                            $access = $tempOne['otherDataPasses']['filterData']['access'];
                            if (!empty($access)) {
                                $whereRaw .= " and `access` is not null";
                            }
                        }
                    }

                    if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'position')) {
                            $position = $tempOne['otherDataPasses']['orderBy']['position'];
                            if (!empty($position)) {
                                $orderByRaw = "`position` " . $position;
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                            $id = $tempOne['otherDataPasses']['orderBy']['id'];
                            if (!empty($id)) {
                                $orderByRaw = "`id` " . $id;
                            }
                        }
                    }

                    foreach (MainNav::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                        $navMain[] = [
                            ...GetManageNavHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd'), Config::get('constants.typeCheck.helperCommon.detail.yd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => GetManageNavHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->navTypeId)
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                        ];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.dyf')] = [
                        'list' => $navMain
                    ];

                    if (isset($tempOne['otherDataPasses']['filterData'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                    }

                    if (isset($tempOne['otherDataPasses']['orderBy'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                    }
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.ryf'), $tempOne['getList']['type'])) {
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navTypeId')) {
                            $navTypeId = $tempOne['otherDataPasses']['filterData']['navTypeId'];
                            if (!empty($navTypeId)) {
                                $whereRaw .= " and `navTypeId` = " . decrypt($navTypeId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'id')) {
                            $id = $tempOne['otherDataPasses']['filterData']['id'];
                            if (!empty($id)) {
                                $whereRaw .= " and `id` = " . decrypt($id);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'access')) {
                            $access = $tempOne['otherDataPasses']['filterData']['access'];
                            if (!empty($access)) {
                                $whereRaw .= " and `access` is not null";
                            }
                        }
                    }

                    if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'position')) {
                            $position = $tempOne['otherDataPasses']['orderBy']['position'];
                            if (!empty($position)) {
                                $orderByRaw = "`position` " . $position;
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                            $id = $tempOne['otherDataPasses']['orderBy']['id'];
                            if (!empty($id)) {
                                $orderByRaw = "`id` " . $id;
                            }
                        }
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.ryf')] = [
                        'list' => MainNav::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get()
                    ];

                    if (isset($tempOne['otherDataPasses']['filterData'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.ryf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                    }

                    if (isset($tempOne['otherDataPasses']['orderBy'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.ryf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                    }
                }

                $finalData[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')] = $data;
            }

            if (Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type') == $tempOne['getList']['for']) {
                $data = array();

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.inf'), $tempOne['getList']['type'])) {
                    $navSub = array();

                    foreach (SubNav::get() as $tempTwo) {
                        $navSub[] = [
                            'id' => $tempTwo->id,
                            'name' => $tempTwo->name
                        ];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.inf')] = [
                        'list' => $navSub
                    ];
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                    $navSub = array();
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navTypeId')) {
                            $navTypeId = $tempOne['otherDataPasses']['filterData']['navTypeId'];
                            if (!empty($navTypeId)) {
                                $whereRaw .= " and `navTypeId` = " . decrypt($navTypeId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainNavId')) {
                            $mainNavId = $tempOne['otherDataPasses']['filterData']['mainNavId'];
                            if (!empty($mainNavId)) {
                                $whereRaw .= " and `mainNavId` = " . decrypt($mainNavId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'access')) {
                            $access = $tempOne['otherDataPasses']['filterData']['access'];
                            if (!empty($access)) {
                                $whereRaw .= " and `access` is not null";
                            }
                        }
                    }

                    if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'position')) {
                            $position = $tempOne['otherDataPasses']['orderBy']['position'];
                            if (!empty($position)) {
                                $orderByRaw = "`position` " . $position;
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                            $id = $tempOne['otherDataPasses']['orderBy']['id'];
                            if (!empty($id)) {
                                $orderByRaw = "`id` " . $id;
                            }
                        }
                    }

                    foreach (SubNav::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                        $navSub[] = [
                            ...GetManageNavHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                        ];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                        'list' => $navSub
                    ];

                    if (isset($tempOne['otherDataPasses']['filterData'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                    }

                    if (isset($tempOne['otherDataPasses']['orderBy'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                    }
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                    $navSub = array();
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navTypeId')) {
                            $navTypeId = $tempOne['otherDataPasses']['filterData']['navTypeId'];
                            if (!empty($navTypeId)) {
                                $whereRaw .= " and `navTypeId` = " . decrypt($navTypeId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainNavId')) {
                            $mainNavId = $tempOne['otherDataPasses']['filterData']['mainNavId'];
                            if (!empty($mainNavId)) {
                                $whereRaw .= " and `mainNavId` = " . decrypt($mainNavId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'access')) {
                            $access = $tempOne['otherDataPasses']['filterData']['access'];
                            if (!empty($access)) {
                                $whereRaw .= " and `access` is not null";
                            }
                        }
                    }

                    if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'position')) {
                            $position = $tempOne['otherDataPasses']['orderBy']['position'];
                            if (!empty($position)) {
                                $orderByRaw = "`position` " . $position;
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                            $id = $tempOne['otherDataPasses']['orderBy']['id'];
                            if (!empty($id)) {
                                $orderByRaw = "`id` " . $id;
                            }
                        }
                    }

                    foreach (SubNav::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                        $navSub[] = [
                            ...GetManageNavHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => GetManageNavHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->navTypeId)
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type') => GetManageNavHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->mainNavId)
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                        ];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.dyf')] = [
                        'list' => $navSub
                    ];

                    if (isset($tempOne['otherDataPasses']['filterData'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                    }

                    if (isset($tempOne['otherDataPasses']['orderBy'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                    }
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.ryf'), $tempOne['getList']['type'])) {
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navTypeId')) {
                            $navTypeId = $tempOne['otherDataPasses']['filterData']['navTypeId'];
                            if (!empty($navTypeId)) {
                                $whereRaw .= " and `navTypeId` = " . decrypt($navTypeId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainNavId')) {
                            $mainNavId = $tempOne['otherDataPasses']['filterData']['mainNavId'];
                            if (!empty($mainNavId)) {
                                $whereRaw .= " and `mainNavId` = " . decrypt($mainNavId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'id')) {
                            $id = $tempOne['otherDataPasses']['filterData']['id'];
                            if (!empty($id)) {
                                $whereRaw .= " and `id` = " . decrypt($id);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'access')) {
                            $access = $tempOne['otherDataPasses']['filterData']['access'];
                            if (!empty($access)) {
                                $whereRaw .= " and `access` is not null";
                            }
                        }
                    }

                    if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'position')) {
                            $position = $tempOne['otherDataPasses']['orderBy']['position'];
                            if (!empty($position)) {
                                $orderByRaw = "`position` " . $position;
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                            $id = $tempOne['otherDataPasses']['orderBy']['id'];
                            if (!empty($id)) {
                                $orderByRaw = "`id` " . $id;
                            }
                        }
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.ryf')] = [
                        'list' => SubNav::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get()
                    ];

                    if (isset($tempOne['otherDataPasses']['filterData'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.ryf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                    }

                    if (isset($tempOne['otherDataPasses']['orderBy'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.ryf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                    }
                }

                $finalData[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')] = $data;
            }

            if (Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type') == $tempOne['getList']['for']) {
                $data = array();

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.inf'), $tempOne['getList']['type'])) {
                    $navNested = array();

                    foreach (NestedNav::get() as $tempTwo) {
                        $navNested[] = [
                            'id' => $tempTwo->id,
                            'name' => $tempTwo->name
                        ];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.inf')] = [
                        'list' => $navNested
                    ];
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                    $navNested = array();
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navTypeId')) {
                            $navTypeId = $tempOne['otherDataPasses']['filterData']['navTypeId'];
                            if (!empty($navTypeId)) {
                                $whereRaw .= " and `navTypeId` = " . decrypt($navTypeId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainNavId')) {
                            $mainNavId = $tempOne['otherDataPasses']['filterData']['mainNavId'];
                            if (!empty($mainNavId)) {
                                $whereRaw .= " and `mainNavId` = " . decrypt($mainNavId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'subNavId')) {
                            $subNavId = $tempOne['otherDataPasses']['filterData']['subNavId'];
                            if (!empty($subNavId)) {
                                $whereRaw .= " and `subNavId` = " . decrypt($subNavId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'access')) {
                            $access = $tempOne['otherDataPasses']['filterData']['access'];
                            if (!empty($access)) {
                                $whereRaw .= " and `access` is not null";
                            }
                        }
                    }

                    if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'position')) {
                            $position = $tempOne['otherDataPasses']['orderBy']['position'];
                            if (!empty($position)) {
                                $orderByRaw = "`position` " . $position;
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                            $id = $tempOne['otherDataPasses']['orderBy']['id'];
                            if (!empty($id)) {
                                $orderByRaw = "`id` " . $id;
                            }
                        }
                    }

                    foreach (NestedNav::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                        $navNested[] = [
                            ...GetManageNavHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                        ];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.byf')] = [
                        'list' => $navNested
                    ];

                    if (isset($tempOne['otherDataPasses']['filterData'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                    }

                    if (isset($tempOne['otherDataPasses']['orderBy'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                    }
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                    $navNested = array();
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navTypeId')) {
                            $navTypeId = $tempOne['otherDataPasses']['filterData']['navTypeId'];
                            if (!empty($navTypeId)) {
                                $whereRaw .= " and `navTypeId` = " . decrypt($navTypeId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainNavId')) {
                            $mainNavId = $tempOne['otherDataPasses']['filterData']['mainNavId'];
                            if (!empty($mainNavId)) {
                                $whereRaw .= " and `mainNavId` = " . decrypt($mainNavId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'subNavId')) {
                            $subNavId = $tempOne['otherDataPasses']['filterData']['subNavId'];
                            if (!empty($subNavId)) {
                                $whereRaw .= " and `subNavId` = " . decrypt($subNavId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'access')) {
                            $access = $tempOne['otherDataPasses']['filterData']['access'];
                            if (!empty($access)) {
                                $whereRaw .= " and `access` is not null";
                            }
                        }
                    }

                    if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'position')) {
                            $position = $tempOne['otherDataPasses']['orderBy']['position'];
                            if (!empty($position)) {
                                $orderByRaw = "`position` " . $position;
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                            $id = $tempOne['otherDataPasses']['orderBy']['id'];
                            if (!empty($id)) {
                                $orderByRaw = "`id` " . $id;
                            }
                        }
                    }

                    foreach (NestedNav::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                        $navNested[] = [
                            ...GetManageNavHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->id)
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => GetManageNavHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->navTypeId)
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type') => GetManageNavHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->mainNavId)
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type') => GetManageNavHelper::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($tempTwo->subNavId)
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                        ];
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.dyf')] = [
                        'list' => $navNested
                    ];

                    if (isset($tempOne['otherDataPasses']['filterData'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                    }

                    if (isset($tempOne['otherDataPasses']['orderBy'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.dyf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                    }
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.get.ryf'), $tempOne['getList']['type'])) {
                    $whereRaw = "`created_at` is not null";
                    $orderByRaw = "`id` DESC";

                    if (Arr::exists($tempOne['otherDataPasses'], 'filterData')) {
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'status')) {
                            $status = $tempOne['otherDataPasses']['filterData']['status'];
                            if (!empty($status)) {
                                $whereRaw .= " and `status` = '" . $status . "'";
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navTypeId')) {
                            $navTypeId = $tempOne['otherDataPasses']['filterData']['navTypeId'];
                            if (!empty($navTypeId)) {
                                $whereRaw .= " and `navTypeId` = " . decrypt($navTypeId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'mainNavId')) {
                            $mainNavId = $tempOne['otherDataPasses']['filterData']['mainNavId'];
                            if (!empty($mainNavId)) {
                                $whereRaw .= " and `mainNavId` = " . decrypt($mainNavId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'subNavId')) {
                            $subNavId = $tempOne['otherDataPasses']['filterData']['subNavId'];
                            if (!empty($subNavId)) {
                                $whereRaw .= " and `subNavId` = " . decrypt($subNavId);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'id')) {
                            $id = $tempOne['otherDataPasses']['filterData']['id'];
                            if (!empty($id)) {
                                $whereRaw .= " and `id` = " . decrypt($id);
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'access')) {
                            $access = $tempOne['otherDataPasses']['filterData']['access'];
                            if (!empty($access)) {
                                $whereRaw .= " and `access` is not null";
                            }
                        }
                    }

                    if (Arr::exists($tempOne['otherDataPasses'], 'orderBy')) {
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'position')) {
                            $position = $tempOne['otherDataPasses']['orderBy']['position'];
                            if (!empty($position)) {
                                $orderByRaw = "`position` " . $position;
                            }
                        }
                        if (Arr::exists($tempOne['otherDataPasses']['orderBy'], 'id')) {
                            $id = $tempOne['otherDataPasses']['orderBy']['id'];
                            if (!empty($id)) {
                                $orderByRaw = "`id` " . $id;
                            }
                        }
                    }

                    $data[Config::get('constants.typeCheck.helperCommon.get.ryf')] = [
                        'list' => NestedNav::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get()
                    ];

                    if (isset($tempOne['otherDataPasses']['filterData'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.ryf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                    }

                    if (isset($tempOne['otherDataPasses']['orderBy'])) {
                        $data[Config::get('constants.typeCheck.helperCommon.get.ryf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                    }
                }

                $finalData[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')] = $data;
            }
        }
        return $finalData;
        // } catch (Exception $e) {
        //     return false;
        // }
    }

    public static function getDetail($params, $platform = '')
    {
        // try {
        $finalData = array();
        foreach ($params as $tempOne) {

            [
                'otherDataPasses' => [
                    'id' => $id,
                ],
                'getDetail' => [
                    'type' => $type,
                    'for' => $for,
                ]
            ] = $tempOne;

            if (Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') == $for) {
                $data = array();
                $navType = NavType::where('id', decrypt($id))->first();

                if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                    $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                        'id' => encrypt($navType->id),
                        'name' => $navType->name,
                        'icon' => $navType->icon,
                        'position' => $navType->position,
                        'description' => $navType->description,
                        'status' => $navType->status,
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $navType->uniqueId]),
                        'customizeInText' => CommonTrait::customizeInText([
                            [
                                'type' => 'status',
                                'value' => $navType->status
                            ]
                        ]),
                        'extraData' => [
                            'hasNavMain' => MainNav::where('navTypeId', $navType->id)->count(),
                            'navMainRoute' => route('admin.show.mainNav'),
                        ]
                    ];
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.detail.rnd'), $type)) {
                    $data[Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'] = [
                        'id' => encrypt($navType->id),
                        'name' => $navType->name,
                        'icon' => $navType->icon,
                        'position' => $navType->position,
                        'status' => $navType->status,
                        'uniqueId' => $navType->uniqueId
                    ];
                }

                $finalData[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')] = $data;
            }

            if (Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type') == $for) {
                $navMain = MainNav::where('id', decrypt($id))->first();
                $hasNavSub = SubNav::where('mainNavId', $navMain->id)->count();
                $data = array();

                if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                    $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                        'id' => encrypt($navMain->id),
                        'name' => $navMain->name,
                        'icon' => $navMain->icon,
                        'route' => $navMain->route,
                        'position' => $navMain->position,
                        'description' => $navMain->description,
                        'status' => $navMain->status,
                        'access' => json_decode($navMain->access, true),
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $navMain->uniqueId]),
                        'customizeInText' => CommonTrait::customizeInText([
                            [
                                'type' => 'status',
                                'value' => $navMain->status
                            ],
                            [
                                'type' => 'access',
                                'value' => json_decode($navMain->access, true)
                            ],
                            [
                                'type' => 'hasChild',
                                'value' => $hasNavSub
                            ]
                        ]),
                        'extraData' => [
                            'hasNavSub' => $hasNavSub,
                            'navSubRoute' => route('admin.show.subNav'),
                        ]
                    ];
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                    $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                        'id' => encrypt($navMain->id),
                        'name' => $navMain->name,
                        'icon' => $navMain->icon,
                        'route' => $navMain->route,
                        'position' => $navMain->position,
                        'description' => $navMain->description,
                        'status' => $navMain->status,
                        'access' => json_decode($navMain->access, true),
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $navMain->uniqueId]),
                        'customizeInText' => CommonTrait::customizeInText([
                            [
                                'type' => 'status',
                                'value' => $navMain->status
                            ],
                            [
                                'type' => 'access',
                                'value' => json_decode($navMain->access, true)
                            ],
                            [
                                'type' => 'hasChild',
                                'value' => $hasNavSub
                            ]
                        ]),
                        Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => GetManageNavHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($navMain->navTypeId)
                                ],
                            ]
                        ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                        'extraData' => [
                            'hasNavSub' => $hasNavSub,
                            'navSubRoute' => route('admin.show.subNav'),
                        ]
                    ];
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.detail.rnd'), $type)) {
                    $data[Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'] = [
                        'id' => encrypt($navMain->id),
                        'name' => $navMain->name,
                        'icon' => $navMain->icon,
                        'route' => $navMain->route,
                        'position' => $navMain->position,
                        'description' => $navMain->description,
                        'status' => $navMain->status,
                        'uniqueId' => $navMain->uniqueId,
                        'lastSegment' => $navMain->lastSegment,
                    ];
                }

                $finalData[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')] = $data;
            }

            if (Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type') == $for) {
                $navSub = SubNav::where('id', decrypt($id))->first();
                $hasNavNested = NestedNav::where('subNavId', $navSub->id)->count();
                $data = array();

                if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                    $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                        'id' => encrypt($navSub->id),
                        'name' => $navSub->name,
                        'icon' => $navSub->icon,
                        'route' => $navSub->route,
                        'position' => $navSub->position,
                        'description' => $navSub->description,
                        'status' => $navSub->status,
                        'access' => json_decode($navSub->access, true),
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $navSub->uniqueId]),
                        'customizeInText' => CommonTrait::customizeInText([
                            [
                                'type' => 'status',
                                'value' => $navSub->status
                            ],
                            [
                                'type' => 'access',
                                'value' => json_decode($navSub->access, true)
                            ],
                            [
                                'type' => 'hasChild',
                                'value' => $hasNavNested
                            ]
                        ]),
                        'extraData' => [
                            'hasNavNested' => $hasNavNested,
                            'navNestedRoute' => route('admin.show.nestedNav'),
                        ]
                    ];
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                    $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                        'id' => encrypt($navSub->id),
                        'name' => $navSub->name,
                        'icon' => $navSub->icon,
                        'route' => $navSub->route,
                        'position' => $navSub->position,
                        'description' => $navSub->description,
                        'status' => $navSub->status,
                        'access' => json_decode($navSub->access, true),
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $navSub->uniqueId]),
                        'customizeInText' => CommonTrait::customizeInText([
                            [
                                'type' => 'status',
                                'value' => $navSub->status
                            ],
                            [
                                'type' => 'access',
                                'value' => json_decode($navSub->access, true)
                            ],
                            [
                                'type' => 'hasChild',
                                'value' => $hasNavNested
                            ]
                        ]),
                        Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => GetManageNavHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($navSub->navTypeId)
                                ],
                            ]
                        ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                        Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type') => GetManageNavHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($navSub->mainNavId)
                                ],
                            ]
                        ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                        'extraData' => [
                            'hasNavNested' => $hasNavNested,
                            'navNestedRoute' => route('admin.show.nestedNav'),
                        ]
                    ];
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.detail.rnd'), $type)) {
                    $data[Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'] = [
                        'id' => encrypt($navSub->id),
                        'name' => $navSub->name,
                        'icon' => $navSub->icon,
                        'route' => $navSub->route,
                        'position' => $navSub->position,
                        'description' => $navSub->description,
                        'status' => $navSub->status,
                        'lastSegment' => $navSub->lastSegment,
                        'uniqueId' => $navSub->uniqueId
                    ];
                }

                $finalData[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')] = $data;
            }

            if (Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type') == $for) {
                $navNested = NestedNav::where('id', decrypt($id))->first();
                $data = array();

                if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                    $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                        'id' => encrypt($navNested->id),
                        'name' => $navNested->name,
                        'icon' => $navNested->icon,
                        'route' => $navNested->route,
                        'position' => $navNested->position,
                        'description' => $navNested->description,
                        'status' => $navNested->status,
                        'access' => json_decode($navNested->access, true),
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $navNested->uniqueId]),
                        'customizeInText' => CommonTrait::customizeInText([
                            [
                                'type' => 'status',
                                'value' => $navNested->status
                            ],
                            [
                                'type' => 'access',
                                'value' => json_decode($navNested->access, true)
                            ]
                        ]),
                    ];
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                    $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                        'id' => encrypt($navNested->id),
                        'name' => $navNested->name,
                        'icon' => $navNested->icon,
                        'route' => $navNested->route,
                        'position' => $navNested->position,
                        'description' => $navNested->description,
                        'status' => $navNested->status,
                        'access' => json_decode($navNested->access, true),
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $navNested->uniqueId]),
                        'customizeInText' => CommonTrait::customizeInText([
                            [
                                'type' => 'status',
                                'value' => $navNested->status
                            ],
                            [
                                'type' => 'access',
                                'value' => json_decode($navNested->access, true)
                            ]
                        ]),
                        Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => GetManageNavHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($navNested->navTypeId)
                                ],
                            ]
                        ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                        Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type') => GetManageNavHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($navNested->mainNavId)
                                ],
                            ]
                        ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                        Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type') => GetManageNavHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($navNested->subNavId)
                                ],
                            ]
                        ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail']
                    ];
                }

                if (in_array(Config::get('constants.typeCheck.helperCommon.detail.rnd'), $type)) {
                    $data[Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'] = [
                        'id' => encrypt($navNested->id),
                        'name' => $navNested->name,
                        'icon' => $navNested->icon,
                        'route' => $navNested->route,
                        'position' => $navNested->position,
                        'description' => $navNested->description,
                        'status' => $navNested->status,
                        'lastSegment' => $navNested->lastSegment,
                        'uniqueId' => $navNested->uniqueId
                    ];
                }

                $finalData[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')] = $data;
            }
        }
        return $finalData;
        // } catch (Exception $e) {
        //     return false;
        // }
    }

    public static function getNav($params, $platform = '')
    {
        // try {
        $finalData = array();

        foreach ($params as $tempOne) {

            [
                'type' => $type,
                'otherDataPasses' => [
                    'filterData' => $filterData,
                    'orderBy' => $orderBy,
                ]
            ] = $tempOne;

            if (in_array(Config::get('constants.typeCheck.helperCommon.nav.sn'), $type)) {
                $navList = $nav1 = $nav2 = $nav3 = [];

                $navType = GetManageNavHelper::getList([
                    [
                        'getList' => [
                            'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                            'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                        ],
                        'otherDataPasses' => [
                            'filterData' => [
                                'status' => $filterData['status']
                            ],
                            'orderBy' => [
                                'position' => $orderBy['position']
                            ]
                        ],
                    ],
                ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.ryf')]['list'];

                foreach ($navType as $keyOne => $tempTwo) {
                    $navMain = GetManageNavHelper::getList([
                        [
                            'getList' => [
                                'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                                'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                            ],
                            'otherDataPasses' => [
                                'filterData' => [
                                    'status' => $filterData['status'],
                                    'navTypeId' => encrypt($tempTwo['id']),
                                    // 'access' => $tempTwo['id']
                                ],
                                'orderBy' => [
                                    'position' => $orderBy['position']
                                ]
                            ],
                        ],
                    ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.get.ryf')]['list'];
                    if (sizeof($navMain) > 0) {
                        foreach ($navMain as $keyTwo => $tempThree) {
                            $navSub = GetManageNavHelper::getList([
                                [
                                    'getList' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'filterData' => [
                                            'status' => $filterData['status'],
                                            'mainNavId' => encrypt($tempThree['id']),
                                            // 'access' => $tempThree['id']
                                        ],
                                        'orderBy' => [
                                            'position' => $orderBy['position']
                                        ]
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')][Config::get('constants.typeCheck.helperCommon.get.ryf')]['list'];
                            if (sizeof($navSub) > 0) {
                                foreach ($navSub as $keyThree => $tempFour) {
                                    $navNested = GetManageNavHelper::getList([
                                        [
                                            'getList' => [
                                                'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                                                'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type'),
                                            ],
                                            'otherDataPasses' => [
                                                'filterData' => [
                                                    'status' => $filterData['status'],
                                                    'subNavId' => encrypt($tempFour['id']),
                                                    // 'access' => $tempFour['id']
                                                ],
                                                'orderBy' => [
                                                    'position' => $orderBy['position']
                                                ]
                                            ],
                                        ],
                                    ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')][Config::get('constants.typeCheck.helperCommon.get.ryf')]['list'];
                                    if (sizeof($navNested) > 0) {
                                        foreach ($navNested as $keyFour => $tempFive) {
                                            $nav3[] = [
                                                ...GetManageNavHelper::getDetail([
                                                    [
                                                        'getDetail' => [
                                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.rnd')],
                                                            'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type'),
                                                        ],
                                                        'otherDataPasses' => [
                                                            'id' => encrypt($tempFive['id'])
                                                        ],
                                                    ],
                                                ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')][Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail']
                                            ];
                                        }
                                    } else {
                                        $nav3 = [];
                                    }
                                    $nav2[] = [
                                        ...GetManageNavHelper::getDetail([
                                            [
                                                'getDetail' => [
                                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.rnd')],
                                                    'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                                                ],
                                                'otherDataPasses' => [
                                                    'id' => encrypt($tempFour['id'])
                                                ],
                                            ],
                                        ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')][Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'],
                                        'navNested' => $nav3,
                                    ];
                                    $nav3 = [];
                                }
                            } else {
                                $nav2 = [];
                            }
                            $nav1[] = [
                                ...GetManageNavHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.rnd')],
                                            'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($tempThree['id'])
                                        ],
                                    ],
                                ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'],
                                'navSub' => $nav2,
                            ];
                            $nav2 = [];
                        }
                    } else {
                        $nav1 = [];
                    }
                    $navList[] = [
                        ...GetManageNavHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.rnd')],
                                    'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($tempTwo['id'])
                                ],
                            ],
                        ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'],
                        'navMain' => $nav1
                    ];
                    $nav1 = [];
                }

                $finalData[Config::get('constants.typeCheck.helperCommon.nav.sn')] = $navList;
            }

            if (in_array(Config::get('constants.typeCheck.helperCommon.nav.np'), $type)) {
                $navList = $nav1 = $nav2 = $nav3 = [];
                $navTypeId = $mainNavId = $subNavId = $nestedNavId = '';

                if (isset($filterData['navTypeId'])) {
                    if ($filterData['navTypeId'] != '') {
                        $navTypeId = $filterData['navTypeId'];
                    }
                }

                if (isset($filterData['mainNavId'])) {
                    if ($filterData['mainNavId'] != '') {
                        $mainNavId = $filterData['mainNavId'];
                    }
                }

                if (isset($filterData['subNavId'])) {
                    if ($filterData['subNavId'] != '') {
                        $subNavId = $filterData['subNavId'];
                    }
                }

                if (isset($filterData['nestedNavId'])) {
                    if ($filterData['nestedNavId'] != '') {
                        $nestedNavId = $filterData['nestedNavId'];
                    }
                }


                $navType = GetManageNavHelper::getList([
                    [
                        'getList' => [
                            'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                            'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                        ],
                        'otherDataPasses' => [
                            'filterData' => [
                                'status' => $filterData['status'],
                                'id' => $navTypeId,
                            ],
                            'orderBy' => [
                                'position' => $orderBy['position']
                            ]
                        ],
                    ],
                ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.ryf')]['list'];
                foreach ($navType as $keyOne => $tempTwo) {
                    $navMain = GetManageNavHelper::getList([
                        [
                            'getList' => [
                                'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                                'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                            ],
                            'otherDataPasses' => [
                                'filterData' => [
                                    'status' => $filterData['status'],
                                    'id' => $mainNavId,
                                    'navTypeId' => ($navTypeId != '')  ? $navTypeId : encrypt($tempTwo['id']),
                                    // 'access' => $tempTwo['id']
                                ],
                                'orderBy' => [
                                    'position' => $orderBy['position']
                                ]
                            ],
                        ],
                    ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.get.ryf')]['list'];
                    if (sizeof($navMain) > 0) {
                        foreach ($navMain as $keyTwo => $tempThree) {
                            $navSub = GetManageNavHelper::getList([
                                [
                                    'getList' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'filterData' => [
                                            'status' => $filterData['status'],
                                            'id' => $subNavId,
                                            'navTypeId' => ($navTypeId != '')  ? $navTypeId : encrypt($tempTwo['id']),
                                            'mainNavId' => ($mainNavId != '')  ? $mainNavId : encrypt($tempThree['id']),
                                            // 'access' => $tempThree['id']
                                        ],
                                        'orderBy' => [
                                            'position' => $orderBy['position']
                                        ]
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')][Config::get('constants.typeCheck.helperCommon.get.ryf')]['list'];
                            if (sizeof($navSub) > 0) {
                                foreach ($navSub as $keyThree => $tempFour) {
                                    $navNested = GetManageNavHelper::getList([
                                        [
                                            'getList' => [
                                                'type' => [Config::get('constants.typeCheck.helperCommon.get.ryf')],
                                                'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type'),
                                            ],
                                            'otherDataPasses' => [
                                                'filterData' => [
                                                    'status' => $filterData['status'],
                                                    'id' => $nestedNavId,
                                                    'navTypeId' => ($navTypeId != '')  ? $navTypeId : encrypt($tempTwo['id']),
                                                    'mainNavId' => ($mainNavId != '')  ? $mainNavId : encrypt($tempThree['id']),
                                                    'subNavId' => ($subNavId != '')  ? $subNavId : encrypt($tempFour['id']),
                                                    // 'access' => $tempFour['id']
                                                ],
                                                'orderBy' => [
                                                    'position' => $orderBy['position']
                                                ]
                                            ],
                                        ],
                                    ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')][Config::get('constants.typeCheck.helperCommon.get.ryf')]['list'];
                                    if (sizeof($navNested) > 0) {
                                        foreach ($navNested as $keyFour => $tempFive) {
                                            $nav3[] = [
                                                ...GetManageNavHelper::getDetail([
                                                    [
                                                        'getDetail' => [
                                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                                            'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type'),
                                                        ],
                                                        'otherDataPasses' => [
                                                            'id' => encrypt($tempFive['id'])
                                                        ],
                                                    ],
                                                ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail']
                                            ];
                                        }
                                    } else {
                                        $nav3 = [];
                                    }
                                    $nav2[] = [
                                        ...GetManageNavHelper::getDetail([
                                            [
                                                'getDetail' => [
                                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                                    'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                                                ],
                                                'otherDataPasses' => [
                                                    'id' => encrypt($tempFour['id'])
                                                ],
                                            ],
                                        ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                                        'navNested' => $nav3,
                                    ];
                                    $nav3 = [];
                                }
                            } else {
                                $nav2 = [];
                            }
                            $nav1[] = [
                                ...GetManageNavHelper::getDetail([
                                    [
                                        'getDetail' => [
                                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                            'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                                        ],
                                        'otherDataPasses' => [
                                            'id' => encrypt($tempThree['id'])
                                        ],
                                    ],
                                ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                                'navSub' => $nav2,
                            ];
                            $nav2 = [];
                        }
                    } else {
                        $nav1 = [];
                    }
                    $navList[] = [
                        ...GetManageNavHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => encrypt($tempTwo['id'])
                                ],
                            ],
                        ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                        'navMain' => $nav1
                    ];
                    $nav1 = [];
                }

                $finalData[Config::get('constants.typeCheck.helperCommon.nav.np')] = $navList;
            }
        }

        return $finalData;
        // } catch (Exception $e) {
        //     return false;
        // }
    }
}

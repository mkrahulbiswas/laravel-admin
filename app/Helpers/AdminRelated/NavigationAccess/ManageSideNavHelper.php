<?php

namespace App\Helpers\AdminRelated\NavigationAccess;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use App\Models\AdminRelated\NavigationAccess\ManageSideNav\NavType;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\MainNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\SubNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\NestedNav;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class ManageSideNavHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';

    public static function getList($params, $platform = '')
    {
        try {
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
                            $navType[] = self::getDetail([
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
                        $mainNav = array();

                        foreach (MainNav::get() as $tempTwo) {
                            $mainNav[] = [
                                'id' => $tempTwo->id,
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.inf')] = [
                            'list' => $mainNav
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                        $mainNav = array();
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
                            $mainNav[] = [
                                ...self::getDetail([
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
                            'list' => $mainNav
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                        $mainNav = array();
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
                            $mainNav[] = [
                                ...self::getDetail([
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
                                Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => self::getDetail([
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
                            'list' => $mainNav
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
                        $subNav = array();

                        foreach (SubNav::get() as $tempTwo) {
                            $subNav[] = [
                                'id' => $tempTwo->id,
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.inf')] = [
                            'list' => $subNav
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                        $subNav = array();
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
                            $subNav[] = [
                                ...self::getDetail([
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
                            'list' => $subNav
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                        $subNav = array();
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
                            $subNav[] = [
                                ...self::getDetail([
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
                                Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => self::getDetail([
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
                                Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type') => self::getDetail([
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
                            'list' => $subNav
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
                        $nestedNav = array();

                        foreach (NestedNav::get() as $tempTwo) {
                            $nestedNav[] = [
                                'id' => $tempTwo->id,
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.inf')] = [
                            'list' => $nestedNav
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.byf'), $tempOne['getList']['type'])) {
                        $nestedNav = array();
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
                            $nestedNav[] = [
                                ...self::getDetail([
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
                            'list' => $nestedNav
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data[Config::get('constants.typeCheck.helperCommon.get.byf')]['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.dyf'), $tempOne['getList']['type'])) {
                        $nestedNav = array();
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
                            $nestedNav[] = [
                                ...self::getDetail([
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
                                Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => self::getDetail([
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
                                Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type') => self::getDetail([
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
                                Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type') => self::getDetail([
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
                            'list' => $nestedNav
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
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getDetail($params, $platform = '')
    {
        try {
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
                                    'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                    'value' => $navType->status
                                ]
                            ]),
                            'extraData' => [
                                'hasMainNav' => MainNav::where('navTypeId', $navType->id)->count(),
                                'mainNavRoute' => route('admin.show.mainNav'),
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
                    $mainNav = MainNav::where('id', decrypt($id))->first();
                    $hasSubNav = SubNav::where('mainNavId', $mainNav->id)->count();
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                            'id' => encrypt($mainNav->id),
                            'name' => $mainNav->name,
                            'icon' => $mainNav->icon,
                            'route' => $mainNav->route,
                            'position' => $mainNav->position,
                            'description' => $mainNav->description,
                            'status' => $mainNav->status,
                            'access' => json_decode($mainNav->access, true),
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $mainNav->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                    'value' => $mainNav->status
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.access'),
                                    'value' => json_decode($mainNav->access, true)
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.child'),
                                    'value' => $hasSubNav
                                ]
                            ]),
                            'extraData' => [
                                'hasSubNav' => $hasSubNav,
                                'subNavRoute' => route('admin.show.subNav'),
                            ]
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                            'id' => encrypt($mainNav->id),
                            'name' => $mainNav->name,
                            'icon' => $mainNav->icon,
                            'route' => $mainNav->route,
                            'position' => $mainNav->position,
                            'description' => $mainNav->description,
                            'status' => $mainNav->status,
                            'access' => json_decode($mainNav->access, true),
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $mainNav->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                    'value' => $mainNav->status
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.access'),
                                    'value' => json_decode($mainNav->access, true)
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.child'),
                                    'value' => $hasSubNav
                                ]
                            ]),
                            Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => self::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($mainNav->navTypeId)
                                    ],
                                ]
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            'extraData' => [
                                'hasSubNav' => $hasSubNav,
                                'subNavRoute' => route('admin.show.subNav'),
                            ]
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.rnd'), $type)) {
                        $data[Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'] = [
                            'id' => encrypt($mainNav->id),
                            'name' => $mainNav->name,
                            'icon' => $mainNav->icon,
                            'route' => $mainNav->route,
                            'position' => $mainNav->position,
                            'description' => $mainNav->description,
                            'status' => $mainNav->status,
                            'uniqueId' => $mainNav->uniqueId,
                            'lastSegment' => $mainNav->lastSegment,
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')] = $data;
                }

                if (Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type') == $for) {
                    $subNav = SubNav::where('id', decrypt($id))->first();
                    $hasNestedNav = NestedNav::where('subNavId', $subNav->id)->count();
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                            'id' => encrypt($subNav->id),
                            'name' => $subNav->name,
                            'icon' => $subNav->icon,
                            'route' => $subNav->route,
                            'position' => $subNav->position,
                            'description' => $subNav->description,
                            'status' => $subNav->status,
                            'access' => json_decode($subNav->access, true),
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $subNav->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                    'value' => $subNav->status
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.access'),
                                    'value' => json_decode($subNav->access, true)
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.child'),
                                    'value' => $hasNestedNav
                                ]
                            ]),
                            'extraData' => [
                                'hasNestedNav' => $hasNestedNav,
                                'nestedNavRoute' => route('admin.show.nestedNav'),
                            ]
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                            'id' => encrypt($subNav->id),
                            'name' => $subNav->name,
                            'icon' => $subNav->icon,
                            'route' => $subNav->route,
                            'position' => $subNav->position,
                            'description' => $subNav->description,
                            'status' => $subNav->status,
                            'access' => json_decode($subNav->access, true),
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $subNav->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                    'value' => $subNav->status
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.access'),
                                    'value' => json_decode($subNav->access, true)
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.child'),
                                    'value' => $hasNestedNav
                                ]
                            ]),
                            Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => self::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($subNav->navTypeId)
                                    ],
                                ]
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type') => self::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($subNav->mainNavId)
                                    ],
                                ]
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            'extraData' => [
                                'hasNestedNav' => $hasNestedNav,
                                'nestedNavRoute' => route('admin.show.nestedNav'),
                            ]
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.rnd'), $type)) {
                        $data[Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'] = [
                            'id' => encrypt($subNav->id),
                            'name' => $subNav->name,
                            'icon' => $subNav->icon,
                            'route' => $subNav->route,
                            'position' => $subNav->position,
                            'description' => $subNav->description,
                            'status' => $subNav->status,
                            'lastSegment' => $subNav->lastSegment,
                            'uniqueId' => $subNav->uniqueId
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')] = $data;
                }

                if (Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type') == $for) {
                    $nestedNav = NestedNav::where('id', decrypt($id))->first();
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $type)) {
                        $data[Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'] = [
                            'id' => encrypt($nestedNav->id),
                            'name' => $nestedNav->name,
                            'icon' => $nestedNav->icon,
                            'route' => $nestedNav->route,
                            'position' => $nestedNav->position,
                            'description' => $nestedNav->description,
                            'status' => $nestedNav->status,
                            'access' => json_decode($nestedNav->access, true),
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $nestedNav->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                    'value' => $nestedNav->status
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.access'),
                                    'value' => json_decode($nestedNav->access, true)
                                ]
                            ]),
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $type)) {
                        $data[Config::get('constants.typeCheck.helperCommon.detail.yd')]['detail'] = [
                            'id' => encrypt($nestedNav->id),
                            'name' => $nestedNav->name,
                            'icon' => $nestedNav->icon,
                            'route' => $nestedNav->route,
                            'position' => $nestedNav->position,
                            'description' => $nestedNav->description,
                            'status' => $nestedNav->status,
                            'access' => json_decode($nestedNav->access, true),
                            'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $nestedNav->uniqueId]),
                            'customizeInText' => CommonTrait::customizeInText([
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.status'),
                                    'value' => $nestedNav->status
                                ],
                                [
                                    'type' => Config::get('constants.typeCheck.customizeInText.access'),
                                    'value' => json_decode($nestedNav->access, true)
                                ]
                            ]),
                            Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type') => self::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($nestedNav->navTypeId)
                                    ],
                                ]
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type') => self::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($nestedNav->mainNavId)
                                    ],
                                ]
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'],
                            Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type') => self::getDetail([
                                [
                                    'getDetail' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                        'for' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'id' => encrypt($nestedNav->subNavId)
                                    ],
                                ]
                            ])[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail']
                        ];
                    }

                    if (in_array(Config::get('constants.typeCheck.helperCommon.detail.rnd'), $type)) {
                        $data[Config::get('constants.typeCheck.helperCommon.detail.rnd')]['detail'] = [
                            'id' => encrypt($nestedNav->id),
                            'name' => $nestedNav->name,
                            'icon' => $nestedNav->icon,
                            'route' => $nestedNav->route,
                            'position' => $nestedNav->position,
                            'description' => $nestedNav->description,
                            'status' => $nestedNav->status,
                            'lastSegment' => $nestedNav->lastSegment,
                            'uniqueId' => $nestedNav->uniqueId
                        ];
                    }

                    $finalData[Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getNav($params, $platform = '')
    {
        try {
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

                    $navType = self::getList([
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
                        $mainNav = self::getList([
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
                        if (sizeof($mainNav) > 0) {
                            foreach ($mainNav as $keyTwo => $tempThree) {
                                $subNav = self::getList([
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
                                if (sizeof($subNav) > 0) {
                                    foreach ($subNav as $keyThree => $tempFour) {
                                        $nestedNav = self::getList([
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
                                        if (sizeof($nestedNav) > 0) {
                                            foreach ($nestedNav as $keyFour => $tempFive) {
                                                $nav3[] = [
                                                    ...self::getDetail([
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
                                            ...self::getDetail([
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
                                            'nestedNav' => $nav3,
                                        ];
                                        $nav3 = [];
                                    }
                                } else {
                                    $nav2 = [];
                                }
                                $nav1[] = [
                                    ...self::getDetail([
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
                                    'subNav' => $nav2,
                                ];
                                $nav2 = [];
                            }
                        } else {
                            $nav1 = [];
                        }
                        $navList[] = [
                            ...self::getDetail([
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
                            'mainNav' => $nav1
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


                    $navType = self::getList([
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
                        $mainNav = self::getList([
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
                        if (sizeof($mainNav) > 0) {
                            foreach ($mainNav as $keyTwo => $tempThree) {
                                $subNav = self::getList([
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
                                if (sizeof($subNav) > 0) {
                                    foreach ($subNav as $keyThree => $tempFour) {
                                        $nestedNav = self::getList([
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
                                        if (sizeof($nestedNav) > 0) {
                                            foreach ($nestedNav as $keyFour => $tempFive) {
                                                $nav3[] = [
                                                    ...self::getDetail([
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
                                            ...self::getDetail([
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
                                            'nestedNav' => $nav3,
                                        ];
                                        $nav3 = [];
                                    }
                                } else {
                                    $nav2 = [];
                                }
                                $nav1[] = [
                                    ...self::getDetail([
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
                                    'subNav' => $nav2,
                                ];
                                $nav2 = [];
                            }
                        } else {
                            $nav1 = [];
                        }
                        $navList[] = [
                            ...self::getDetail([
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
                            'mainNav' => $nav1
                        ];
                        $nav1 = [];
                    }

                    $finalData[Config::get('constants.typeCheck.helperCommon.nav.np')] = $navList;
                }
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

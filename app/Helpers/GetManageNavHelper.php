<?php

namespace App\Helpers;

use App\Traits\FileTrait;
use App\Traits\CommonTrait;

use App\Models\ManagePanel\ManageNav\NavMain;
use App\Models\ManagePanel\ManageNav\NavNested;
use App\Models\ManagePanel\ManageNav\NavSub;
use App\Models\ManagePanel\ManageNav\NavType;

use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class GetManageNavHelper
{
    use FileTrait, CommonTrait;
    public $platform = 'backend';

    public static function getList($params, $platform = '')
    {
        try {
            $finalData = array();
            foreach ($params as $tempOne) {
                if (Config::get('constants.typeCheck.manageNav.navType.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.bnf'), $tempOne['getList']['type'])) {
                        $navType = array();

                        foreach (NavType::get() as $tempTwo) {
                            $navType[] = [
                                'id' => $tempTwo->id,
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.bnf')] = [
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
                            $navType[] = GetManageNavHelper::getNavTypeDetail([
                                'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                'otherDataPasses' => [
                                    'id' => $tempTwo->id
                                ]
                            ])[Config::get('constants.typeCheck.helperCommon.detail.nd')]['navTypeDetail'];
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

                    $finalData[Config::get('constants.typeCheck.manageNav.navType.type')] = $data;
                }

                if (Config::get('constants.typeCheck.manageNav.navMain.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.bnf'), $tempOne['getList']['type'])) {
                        $navMain = array();

                        foreach (NavMain::get() as $tempTwo) {
                            $navMain[] = [
                                'id' => $tempTwo->id,
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.bnf')] = [
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
                                    $whereRaw .= " and `navTypeId` = '" . decrypt($navTypeId) . "'";
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

                        foreach (NavMain::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $navMain[] = [
                                ...GetManageNavHelper::getNavMainDetail([
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->id
                                    ]
                                ])[Config::get('constants.typeCheck.helperCommon.detail.nd')]['navMainDetail'],
                                Config::get('constants.typeCheck.manageNav.navType.type') => GetManageNavHelper::getNavTypeDetail([
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->navTypeId
                                    ]
                                ])[Config::get('constants.typeCheck.helperCommon.detail.nd')]['navTypeDetail'],
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

                    $finalData[Config::get('constants.typeCheck.manageNav.navMain.type')] = $data;
                }

                if (Config::get('constants.typeCheck.manageNav.navSub.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.bnf'), $tempOne['getList']['type'])) {
                        $navSub = array();

                        foreach (NavSub::get() as $tempTwo) {
                            $navSub[] = [
                                'id' => $tempTwo->id,
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.bnf')] = [
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
                                    $whereRaw .= " and `navTypeId` = '" . decrypt($navTypeId) . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navMainId')) {
                                $navMainId = $tempOne['otherDataPasses']['filterData']['navMainId'];
                                if (!empty($navMainId)) {
                                    $whereRaw .= " and `navMainId` = '" . decrypt($navMainId) . "'";
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

                        foreach (NavSub::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $navSub[] = [
                                ...GetManageNavHelper::getNavSubDetail([
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->id
                                    ]
                                ])[Config::get('constants.typeCheck.helperCommon.detail.nd')]['navSubDetail'],
                                Config::get('constants.typeCheck.manageNav.navMain.type') => GetManageNavHelper::getNavMainDetail([
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->navMainId
                                    ]
                                ])[Config::get('constants.typeCheck.helperCommon.detail.nd')]['navMainDetail'],
                                Config::get('constants.typeCheck.manageNav.navType.type') => GetManageNavHelper::getNavTypeDetail([
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->navTypeId
                                    ]
                                ])[Config::get('constants.typeCheck.helperCommon.detail.nd')]['navTypeDetail'],
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

                    $finalData[Config::get('constants.typeCheck.manageNav.navSub.type')] = $data;
                }

                if (Config::get('constants.typeCheck.manageNav.navNested.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array(Config::get('constants.typeCheck.helperCommon.get.bnf'), $tempOne['getList']['type'])) {
                        $navNested = array();

                        foreach (NavNested::get() as $tempTwo) {
                            $navNested[] = [
                                'id' => $tempTwo->id,
                                'name' => $tempTwo->name
                            ];
                        }

                        $data[Config::get('constants.typeCheck.helperCommon.get.bnf')] = [
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
                                    $whereRaw .= " and `navTypeId` = '" . decrypt($navTypeId) . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navMainId')) {
                                $navMainId = $tempOne['otherDataPasses']['filterData']['navMainId'];
                                if (!empty($navMainId)) {
                                    $whereRaw .= " and `navMainId` = '" . decrypt($navMainId) . "'";
                                }
                            }
                            if (Arr::exists($tempOne['otherDataPasses']['filterData'], 'navSubId')) {
                                $navSubId = $tempOne['otherDataPasses']['filterData']['navSubId'];
                                if (!empty($navSubId)) {
                                    $whereRaw .= " and `navSubId` = '" . decrypt($navSubId) . "'";
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

                        foreach (NavNested::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $tempTwo) {
                            $navNested[] = [
                                ...GetManageNavHelper::getNavNestedDetail([
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->id
                                    ]
                                ])[Config::get('constants.typeCheck.helperCommon.detail.nd')]['navNestedDetail'],
                                Config::get('constants.typeCheck.manageNav.navSub.type') => GetManageNavHelper::getNavSubDetail([
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->navSubId
                                    ]
                                ])[Config::get('constants.typeCheck.helperCommon.detail.nd')]['navSubDetail'],
                                Config::get('constants.typeCheck.manageNav.navMain.type') => GetManageNavHelper::getNavMainDetail([
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->navMainId
                                    ]
                                ])[Config::get('constants.typeCheck.helperCommon.detail.nd')]['navMainDetail'],
                                Config::get('constants.typeCheck.manageNav.navType.type') => GetManageNavHelper::getNavTypeDetail([
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->navTypeId
                                    ]
                                ])[Config::get('constants.typeCheck.helperCommon.detail.nd')]['navTypeDetail'],
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

                    $finalData[Config::get('constants.typeCheck.manageNav.navNested.type')] = $data;
                }
            }
            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getNavTypeDetail($params, $platform = '')
    {
        try {
            $finalData = array();

            if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $params['type'])) {
                $navType = NavType::where('id', $params['otherDataPasses']['id'])->first();
                $data = [
                    'navTypeDetail' => [
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
                        // 'uniqueId2' => CommonTrait::hyperLinkInText(['targetId' => $navType->id, 'targetRoute' => 'admin.details.product', 'type' => 'uniqueId', 'value' => $navType->uniqueId]),
                    ]
                ];

                $finalData[Config::get('constants.typeCheck.helperCommon.detail.nd')] = $data;
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getNavMainDetail($params, $platform = '')
    {
        try {
            $finalData = array();

            if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $params['type'])) {
                $navMain = NavMain::where('id', $params['otherDataPasses']['id'])->first();
                $data = [
                    'navMainDetail' => [
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
                            ]
                        ]),
                    ]
                ];

                $finalData[Config::get('constants.typeCheck.helperCommon.detail.nd')] = $data;
            }

            if (in_array(Config::get('constants.typeCheck.helperCommon.detail.yd'), $params['type'])) {
                $navMain = NavMain::where('id', $params['otherDataPasses']['id'])->first();
                $data = [
                    'navMainDetail' => [
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
                            ]
                        ]),
                        Config::get('constants.typeCheck.manageNav.navType.type') => GetManageNavHelper::getNavTypeDetail([
                            'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                            'otherDataPasses' => [
                                'id' => $navMain->navTypeId
                            ]
                        ])[Config::get('constants.typeCheck.helperCommon.detail.nd')]['navTypeDetail']
                    ]
                ];

                $finalData[Config::get('constants.typeCheck.helperCommon.detail.yd')] = $data;
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getNavSubDetail($params, $platform = '')
    {
        try {
            $finalData = array();

            if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $params['type'])) {
                $navSub = NavSub::where('id', $params['otherDataPasses']['id'])->first();
                $data = [
                    'navSubDetail' => [
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
                            ]
                        ]),
                    ]
                ];

                $finalData[Config::get('constants.typeCheck.helperCommon.detail.nd')] = $data;
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getNavNestedDetail($params, $platform = '')
    {
        try {
            $finalData = array();

            if (in_array(Config::get('constants.typeCheck.helperCommon.detail.nd'), $params['type'])) {
                $navNested = NavNested::where('id', $params['otherDataPasses']['id'])->first();
                $data = [
                    'navNestedDetail' => [
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
                    ]
                ];

                $finalData[Config::get('constants.typeCheck.helperCommon.detail.nd')] = $data;
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

            if (in_array('all', $params['type'])) {
                $navList = $nav1 = $nav2 = $nav3 = [];
                $navType = GetManageNavHelper::getList([
                    [
                        'getList' => [
                            'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                            'for' => Config::get('constants.typeCheck.manageNav.navType.type'),
                        ],
                        'otherDataPasses' => [
                            'filterData' => [
                                'status' => $params['otherDataPasses']['filterData']['status']
                            ],
                            'orderBy' => [
                                'position' => $params['otherDataPasses']['orderBy']['position']
                            ]
                        ],
                    ],
                ])[Config::get('constants.typeCheck.manageNav.navType.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];
                foreach ($navType as $keyOne => $tempOne) {
                    $navMain = GetManageNavHelper::getList([
                        [
                            'getList' => [
                                'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                                'for' => Config::get('constants.typeCheck.manageNav.navMain.type'),
                            ],
                            'otherDataPasses' => [
                                'filterData' => [
                                    'status' => $params['otherDataPasses']['filterData']['status'],
                                    'navTypeId' => $tempOne['id'],
                                    'access' => $tempOne['id']
                                ],
                                'orderBy' => [
                                    'position' => $params['otherDataPasses']['orderBy']['position']
                                ]
                            ],
                        ],
                    ])[Config::get('constants.typeCheck.manageNav.navMain.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];
                    if (sizeof($navMain) > 0) {
                        foreach ($navMain as $keyTwo => $tempTwo) {
                            $navSub = GetManageNavHelper::getList([
                                [
                                    'getList' => [
                                        'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                                        'for' => Config::get('constants.typeCheck.manageNav.navSub.type'),
                                    ],
                                    'otherDataPasses' => [
                                        'filterData' => [
                                            'status' => $params['otherDataPasses']['filterData']['status'],
                                            'navMainId' => $tempTwo['id'],
                                            'access' => $tempOne['id']
                                        ],
                                        'orderBy' => [
                                            'position' => $params['otherDataPasses']['orderBy']['position']
                                        ]
                                    ],
                                ],
                            ])[Config::get('constants.typeCheck.manageNav.navSub.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];
                            if (sizeof($navSub) > 0) {
                                foreach ($navSub as $keyThree => $tempThree) {
                                    $navNested = GetManageNavHelper::getList([
                                        [
                                            'getList' => [
                                                'type' => [Config::get('constants.typeCheck.helperCommon.get.byf')],
                                                'for' => Config::get('constants.typeCheck.manageNav.navNested.type'),
                                            ],
                                            'otherDataPasses' => [
                                                'filterData' => [
                                                    'status' => $params['otherDataPasses']['filterData']['status'],
                                                    'navSubId' => $tempThree['id'],
                                                    'access' => $tempOne['id']
                                                ],
                                                'orderBy' => [
                                                    'position' => $params['otherDataPasses']['orderBy']['position']
                                                ]
                                            ],
                                        ],
                                    ])[Config::get('constants.typeCheck.manageNav.navNested.type')][Config::get('constants.typeCheck.helperCommon.get.byf')]['list'];
                                    if (sizeof($navNested) > 0) {
                                        foreach ($navNested as $keyFour => $tempFour) {
                                            $nav3[] = [
                                                'name' => $tempFour['name'],
                                                'icon' => $tempFour['icon'],
                                                'route' => $tempFour['route'],
                                                'uniqueId' => $tempFour['uniqueId']['raw'],
                                            ];
                                        }
                                    } else {
                                        $nav3 = [];
                                    }
                                    $nav2[] = [
                                        'name' => $tempThree['name'],
                                        'icon' => $tempThree['icon'],
                                        'route' => $tempThree['route'],
                                        'uniqueId' => $tempThree['uniqueId']['raw'],
                                        Config::get('constants.typeCheck.manageNav.navNested.type') => $nav3,
                                    ];
                                    $nav3 = [];
                                }
                            } else {
                                $nav2 = [];
                            }
                            $nav1[] = [
                                'name' => $tempTwo['name'],
                                'icon' => $tempTwo['icon'],
                                'route' => $tempTwo['route'],
                                'uniqueId' => $tempTwo['uniqueId']['raw'],
                                Config::get('constants.typeCheck.manageNav.navSub.type') => $nav2,
                            ];
                            $nav2 = [];
                        }
                    } else {
                        $nav1 = [];
                    }
                    $navList[] = [
                        'name' => $tempOne['name'],
                        'icon' => $tempOne['icon'],
                        'uniqueId' => $tempOne['uniqueId']['raw'],
                        Config::get('constants.typeCheck.manageNav.navMain.type') => $nav1
                    ];
                    $nav1 = [];
                }
                $finalData['all'] = $navList;
            }

            return $finalData;
        } catch (Exception $e) {
            return false;
        }
    }
}

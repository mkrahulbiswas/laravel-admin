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

            if (in_array(Config::get('constants.typeCheck.manageNav.navType.type'), $params['type'])) {
                $navType = array();

                $whereRaw = "`created_at` is not null";
                $orderByRaw = "`id` DESC";
                if (Arr::exists($params['otherDataPasses'], 'filterData')) {
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'status')) {
                        $status = $params['otherDataPasses']['filterData']['status'];
                        if (!empty($status)) {
                            $whereRaw .= " and `status` = '" . $status . "'";
                        }
                    }
                }

                if (Arr::exists($params['otherDataPasses'], 'orderBy')) {
                    if (Arr::exists($params['otherDataPasses']['orderBy'], 'position')) {
                        $position = $params['otherDataPasses']['orderBy']['position'];
                        if (!empty($position)) {
                            $orderByRaw = "`position` " . $position;
                        }
                    }
                    if (Arr::exists($params['otherDataPasses']['orderBy'], 'id')) {
                        $id = $params['otherDataPasses']['orderBy']['id'];
                        if (!empty($id)) {
                            $orderByRaw = "`id` " . $id;
                        }
                    }
                }

                foreach (NavType::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $temp) {
                    $navType[] = GetManageNavHelper::getNavTypeDetail([
                        'type' => ['basic'],
                        'otherDataPasses' => [
                            'id' => $temp->id
                        ]
                    ])['basic']['navTypeDetail'];
                }

                $data = [
                    'navType' => $navType
                ];

                if (isset($params['otherDataPasses']['filterData'])) {
                    $data['filterData'] = $params['otherDataPasses']['filterData'];
                }

                if (isset($params['otherDataPasses']['orderBy'])) {
                    $data['orderBy'] = $params['otherDataPasses']['orderBy'];
                }

                $finalData['navType'] = $data;
            }

            if (in_array(Config::get('constants.typeCheck.manageNav.navMain.type'), $params['type'])) {
                $navMain = array();

                $whereRaw = "`created_at` is not null";
                $orderByRaw = "`id` DESC";
                if (Arr::exists($params['otherDataPasses'], 'filterData')) {
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'status')) {
                        $status = $params['otherDataPasses']['filterData']['status'];
                        if (!empty($status)) {
                            $whereRaw .= " and `status` = '" . $status . "'";
                        }
                    }
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'navTypeId')) {
                        $navTypeId = $params['otherDataPasses']['filterData']['navTypeId'];
                        if (!empty($navTypeId)) {
                            $whereRaw .= " and `navTypeId` = '" . decrypt($navTypeId) . "'";
                        }
                    }
                }

                if (Arr::exists($params['otherDataPasses'], 'orderBy')) {
                    if (Arr::exists($params['otherDataPasses']['orderBy'], 'position')) {
                        $position = $params['otherDataPasses']['orderBy']['position'];
                        if (!empty($position)) {
                            $orderByRaw = "`position` " . $position;
                        }
                    }
                    if (Arr::exists($params['otherDataPasses']['orderBy'], 'id')) {
                        $id = $params['otherDataPasses']['orderBy']['id'];
                        if (!empty($id)) {
                            $orderByRaw = "`id` " . $id;
                        }
                    }
                }

                foreach (NavMain::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $temp) {
                    $navMain[] = [
                        ...GetManageNavHelper::getNavMainDetail([
                            'type' => ['basic'],
                            'otherDataPasses' => [
                                'id' => $temp->id
                            ]
                        ])['basic']['navMainDetail'],
                        'navType' => GetManageNavHelper::getNavTypeDetail([
                            'type' => ['basic'],
                            'otherDataPasses' => [
                                'id' => $temp->navTypeId
                            ]
                        ])['basic']['navTypeDetail'],
                    ];
                }

                $data = [
                    'navMain' => $navMain
                ];

                if (isset($params['otherDataPasses']['filterData'])) {
                    $data['filterData'] = $params['otherDataPasses']['filterData'];
                }

                if (isset($params['otherDataPasses']['orderBy'])) {
                    $data['orderBy'] = $params['otherDataPasses']['orderBy'];
                }

                $finalData['navMain'] = $data;
            }

            if (in_array(Config::get('constants.typeCheck.manageNav.navSub.type'), $params['type'])) {
                $navSub = array();

                $whereRaw = "`created_at` is not null";
                $orderByRaw = "`id` DESC";
                if (Arr::exists($params['otherDataPasses'], 'filterData')) {
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'status')) {
                        $status = $params['otherDataPasses']['filterData']['status'];
                        if (!empty($status)) {
                            $whereRaw .= " and `status` = '" . $status . "'";
                        }
                    }
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'navTypeId')) {
                        $navTypeId = $params['otherDataPasses']['filterData']['navTypeId'];
                        if (!empty($navTypeId)) {
                            $whereRaw .= " and `navTypeId` = '" . decrypt($navTypeId) . "'";
                        }
                    }
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'navMainId')) {
                        $navMainId = $params['otherDataPasses']['filterData']['navMainId'];
                        if (!empty($navMainId)) {
                            $whereRaw .= " and `navMainId` = '" . decrypt($navMainId) . "'";
                        }
                    }
                }

                if (Arr::exists($params['otherDataPasses'], 'orderBy')) {
                    if (Arr::exists($params['otherDataPasses']['orderBy'], 'position')) {
                        $position = $params['otherDataPasses']['orderBy']['position'];
                        if (!empty($position)) {
                            $orderByRaw = "`position` " . $position;
                        }
                    }
                    if (Arr::exists($params['otherDataPasses']['orderBy'], 'id')) {
                        $id = $params['otherDataPasses']['orderBy']['id'];
                        if (!empty($id)) {
                            $orderByRaw = "`id` " . $id;
                        }
                    }
                }

                foreach (NavSub::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $temp) {
                    $navSub[] = [
                        ...GetManageNavHelper::getNavSubDetail([
                            'type' => ['basic'],
                            'otherDataPasses' => [
                                'id' => $temp->id
                            ]
                        ])['basic']['navSubDetail'],
                        'navMain' => GetManageNavHelper::getNavMainDetail([
                            'type' => ['basic'],
                            'otherDataPasses' => [
                                'id' => $temp->navMainId
                            ]
                        ])['basic']['navMainDetail'],
                        'navType' => GetManageNavHelper::getNavTypeDetail([
                            'type' => ['basic'],
                            'otherDataPasses' => [
                                'id' => $temp->navTypeId
                            ]
                        ])['basic']['navTypeDetail'],
                    ];
                }

                $data = [
                    'navSub' => $navSub
                ];

                if (isset($params['otherDataPasses']['filterData'])) {
                    $data['filterData'] = $params['otherDataPasses']['filterData'];
                }

                if (isset($params['otherDataPasses']['orderBy'])) {
                    $data['orderBy'] = $params['otherDataPasses']['orderBy'];
                }

                $finalData['navSub'] = $data;
            }

            if (in_array(Config::get('constants.typeCheck.manageNav.navNested.type'), $params['type'])) {
                $navNested = array();

                $whereRaw = "`created_at` is not null";
                $orderByRaw = "`id` DESC";
                if (Arr::exists($params['otherDataPasses'], 'filterData')) {
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'status')) {
                        $status = $params['otherDataPasses']['filterData']['status'];
                        if (!empty($status)) {
                            $whereRaw .= " and `status` = '" . $status . "'";
                        }
                    }
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'navTypeId')) {
                        $navTypeId = $params['otherDataPasses']['filterData']['navTypeId'];
                        if (!empty($navTypeId)) {
                            $whereRaw .= " and `navTypeId` = '" . decrypt($navTypeId) . "'";
                        }
                    }
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'navMainId')) {
                        $navMainId = $params['otherDataPasses']['filterData']['navMainId'];
                        if (!empty($navMainId)) {
                            $whereRaw .= " and `navMainId` = '" . decrypt($navMainId) . "'";
                        }
                    }
                    if (Arr::exists($params['otherDataPasses']['filterData'], 'navSubId')) {
                        $navSubId = $params['otherDataPasses']['filterData']['navSubId'];
                        if (!empty($navSubId)) {
                            $whereRaw .= " and `navSubId` = '" . decrypt($navSubId) . "'";
                        }
                    }
                }

                if (Arr::exists($params['otherDataPasses'], 'orderBy')) {
                    if (Arr::exists($params['otherDataPasses']['orderBy'], 'position')) {
                        $position = $params['otherDataPasses']['orderBy']['position'];
                        if (!empty($position)) {
                            $orderByRaw = "`position` " . $position;
                        }
                    }
                    if (Arr::exists($params['otherDataPasses']['orderBy'], 'id')) {
                        $id = $params['otherDataPasses']['orderBy']['id'];
                        if (!empty($id)) {
                            $orderByRaw = "`id` " . $id;
                        }
                    }
                }

                foreach (NavNested::whereRaw($whereRaw)->orderByRaw($orderByRaw)->get() as $temp) {
                    $navNested[] = [
                        ...GetManageNavHelper::getNavNestedDetail([
                            'type' => ['basic'],
                            'otherDataPasses' => [
                                'id' => $temp->id
                            ]
                        ])['basic']['navNestedDetail'],
                        'navSub' => GetManageNavHelper::getNavSubDetail([
                            'type' => ['basic'],
                            'otherDataPasses' => [
                                'id' => $temp->navSubId
                            ]
                        ])['basic']['navSubDetail'],
                        'navMain' => GetManageNavHelper::getNavMainDetail([
                            'type' => ['basic'],
                            'otherDataPasses' => [
                                'id' => $temp->navMainId
                            ]
                        ])['basic']['navMainDetail'],
                        'navType' => GetManageNavHelper::getNavTypeDetail([
                            'type' => ['basic'],
                            'otherDataPasses' => [
                                'id' => $temp->navTypeId
                            ]
                        ])['basic']['navTypeDetail'],
                    ];
                }

                $data = [
                    'navNested' => $navNested
                ];

                if (isset($params['otherDataPasses']['filterData'])) {
                    $data['filterData'] = $params['otherDataPasses']['filterData'];
                }

                if (isset($params['otherDataPasses']['orderBy'])) {
                    $data['orderBy'] = $params['otherDataPasses']['orderBy'];
                }

                $finalData['navNested'] = $data;
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

            if (in_array('basic', $params['type'])) {
                $navType = NavType::where('id', $params['otherDataPasses']['id'])->first();
                $data = [
                    'navTypeDetail' => [
                        'id' => encrypt($navType->id),
                        'name' => $navType->name,
                        'icon' => $navType->icon,
                        'position' => $navType->position,
                        'description' => $navType->description,
                        'access' => json_decode($navType->access, true),
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $navType->uniqueId]),
                        'status' => CommonTrait::customizeInText(['type' => 'status', 'value' => $navType->status]),
                        // 'uniqueId2' => CommonTrait::hyperLinkInText(['targetId' => $navType->id, 'targetRoute' => 'admin.details.product', 'type' => 'uniqueId', 'value' => $navType->uniqueId]),
                    ]
                ];

                $finalData['basic'] = $data;
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

            if (in_array('basic', $params['type'])) {
                $navMain = NavMain::where('id', $params['otherDataPasses']['id'])->first();
                $data = [
                    'navMainDetail' => [
                        'id' => encrypt($navMain->id),
                        'name' => $navMain->name,
                        'icon' => $navMain->icon,
                        'route' => $navMain->route,
                        'position' => $navMain->position,
                        'description' => $navMain->description,
                        'access' => json_decode($navMain->access, true),
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $navMain->uniqueId]),
                        'status' => CommonTrait::customizeInText(['type' => 'status', 'value' => $navMain->status]),
                    ]
                ];

                $finalData['basic'] = $data;
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

            if (in_array('basic', $params['type'])) {
                $navSub = NavSub::where('id', $params['otherDataPasses']['id'])->first();
                $data = [
                    'navSubDetail' => [
                        'id' => encrypt($navSub->id),
                        'name' => $navSub->name,
                        'icon' => $navSub->icon,
                        'route' => $navSub->route,
                        'position' => $navSub->position,
                        'description' => $navSub->description,
                        'access' => json_decode($navSub->access, true),
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $navSub->uniqueId]),
                        'status' => CommonTrait::customizeInText(['type' => 'status', 'value' => $navSub->status]),
                    ]
                ];

                $finalData['basic'] = $data;
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

            if (in_array('basic', $params['type'])) {
                $navNested = NavNested::where('id', $params['otherDataPasses']['id'])->first();
                $data = [
                    'navNestedDetail' => [
                        'id' => encrypt($navNested->id),
                        'name' => $navNested->name,
                        'icon' => $navNested->icon,
                        'route' => $navNested->route,
                        'position' => $navNested->position,
                        'description' => $navNested->description,
                        'access' => json_decode($navNested->access, true),
                        'uniqueId' => CommonTrait::hyperLinkInText(['type' => 'uniqueId', 'value' => $navNested->uniqueId]),
                        'status' => CommonTrait::customizeInText(['type' => 'status', 'value' => $navNested->status]),
                    ]
                ];

                $finalData['basic'] = $data;
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
                    'type' => [Config::get('constants.typeCheck.manageNav.navType.type')],
                    'otherDataPasses' => [
                        'filterData' => [
                            'status' => $params['otherDataPasses']['filterData']['status']
                        ],
                        'orderBy' => [
                            'position' => $params['otherDataPasses']['orderBy']['position']
                        ]
                    ],
                ])['navType']['navType'];
                foreach ($navType as $keyOne => $tempOne) {
                    $navMain = GetManageNavHelper::getList([
                        'type' => [Config::get('constants.typeCheck.manageNav.navMain.type')],
                        'otherDataPasses' => [
                            'filterData' => [
                                'status' => $params['otherDataPasses']['filterData']['status'],
                                'navTypeId' => $tempOne['id'],
                            ],
                            'orderBy' => [
                                'position' => $params['otherDataPasses']['orderBy']['position']
                            ]
                        ],
                    ])['navMain']['navMain'];
                    if (sizeof($navMain) > 0) {
                        foreach ($navMain as $keyTwo => $tempTwo) {
                            $navSub = GetManageNavHelper::getList([
                                'type' => [Config::get('constants.typeCheck.manageNav.navSub.type')],
                                'otherDataPasses' => [
                                    'filterData' => [
                                        'status' => $params['otherDataPasses']['filterData']['status'],
                                        'navMainId' => $tempTwo['id'],
                                    ],
                                    'orderBy' => [
                                        'position' => $params['otherDataPasses']['orderBy']['position']
                                    ]
                                ],
                            ])['navSub']['navSub'];
                            if (sizeof($navSub) > 0) {
                                foreach ($navSub as $keyThree => $tempThree) {
                                    $navNested = GetManageNavHelper::getList([
                                        'type' => [Config::get('constants.typeCheck.manageNav.navNested.type')],
                                        'otherDataPasses' => [
                                            'filterData' => [
                                                'status' => $params['otherDataPasses']['filterData']['status'],
                                                'navSubId' => $tempThree['id'],
                                            ],
                                            'orderBy' => [
                                                'position' => $params['otherDataPasses']['orderBy']['position']
                                            ]
                                        ],
                                    ])['navNested']['navNested'];
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
                                        'navNested' => $nav3,
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
                                'navSub' => $nav2,
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
                        'navMain' => $nav1
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

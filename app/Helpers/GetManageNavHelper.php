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

                    if (in_array('basicWithoutFilter', $tempOne['getList']['type'])) {
                        $navType = array();

                        foreach (NavType::get() as $tempTwo) {
                            $navType[] = [
                                'id' => $tempTwo->id,
                                'name' => $tempTwo->name
                            ];
                        }

                        $data['basicWithoutFilter'] = [
                            'list' => $navType
                        ];
                    }

                    if (in_array('basicWithFilter', $tempOne['getList']['type'])) {
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
                                'type' => ['basic'],
                                'otherDataPasses' => [
                                    'id' => $tempTwo->id
                                ]
                            ])['basic']['navTypeDetail'];
                        }

                        $data['basicWithFilter'] = [
                            'list' => $navType
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data['basicWithFilter']['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data['basicWithFilter']['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData['navType'] = $data;
                }

                if (Config::get('constants.typeCheck.manageNav.navMain.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array('basicWithoutFilter', $tempOne['getList']['type'])) {
                        $navMain = array();

                        foreach (NavMain::get() as $tempTwo) {
                            $navMain[] = [
                                'id' => $tempTwo->id,
                                'name' => $tempTwo->name
                            ];
                        }

                        $data['basicWithoutFilter'] = [
                            'list' => $navMain
                        ];
                    }

                    if (in_array('basicWithFilter', $tempOne['getList']['type'])) {
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
                                    'type' => ['basic'],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->id
                                    ]
                                ])['basic']['navMainDetail'],
                                'navType' => GetManageNavHelper::getNavTypeDetail([
                                    'type' => ['basic'],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->navTypeId
                                    ]
                                ])['basic']['navTypeDetail'],
                            ];
                        }

                        $data['basicWithFilter'] = [
                            'list' => $navMain
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data['basicWithFilter']['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data['basicWithFilter']['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData['navMain'] = $data;
                }

                if (Config::get('constants.typeCheck.manageNav.navSub.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array('basicWithoutFilter', $tempOne['getList']['type'])) {
                        $navSub = array();

                        foreach (NavSub::get() as $tempTwo) {
                            $navSub[] = [
                                'id' => $tempTwo->id,
                                'name' => $tempTwo->name
                            ];
                        }

                        $data['basicWithoutFilter'] = [
                            'list' => $navSub
                        ];
                    }

                    if (in_array('basicWithFilter', $tempOne['getList']['type'])) {
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
                                    'type' => ['basic'],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->id
                                    ]
                                ])['basic']['navSubDetail'],
                                'navMain' => GetManageNavHelper::getNavMainDetail([
                                    'type' => ['basic'],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->navMainId
                                    ]
                                ])['basic']['navMainDetail'],
                                'navType' => GetManageNavHelper::getNavTypeDetail([
                                    'type' => ['basic'],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->navTypeId
                                    ]
                                ])['basic']['navTypeDetail'],
                            ];
                        }

                        $data['basicWithFilter'] = [
                            'list' => $navSub
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data['basicWithFilter']['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data['basicWithFilter']['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData['navSub'] = $data;
                }

                if (Config::get('constants.typeCheck.manageNav.navNested.type') == $tempOne['getList']['for']) {
                    $data = array();

                    if (in_array('basicWithoutFilter', $tempOne['getList']['type'])) {
                        $navNested = array();

                        foreach (NavNested::get() as $tempTwo) {
                            $navNested[] = [
                                'id' => $tempTwo->id,
                                'name' => $tempTwo->name
                            ];
                        }

                        $data['basicWithoutFilter'] = [
                            'list' => $navNested
                        ];
                    }

                    if (in_array('basicWithFilter', $tempOne['getList']['type'])) {
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
                                    'type' => ['basic'],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->id
                                    ]
                                ])['basic']['navNestedDetail'],
                                'navSub' => GetManageNavHelper::getNavSubDetail([
                                    'type' => ['basic'],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->navSubId
                                    ]
                                ])['basic']['navSubDetail'],
                                'navMain' => GetManageNavHelper::getNavMainDetail([
                                    'type' => ['basic'],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->navMainId
                                    ]
                                ])['basic']['navMainDetail'],
                                'navType' => GetManageNavHelper::getNavTypeDetail([
                                    'type' => ['basic'],
                                    'otherDataPasses' => [
                                        'id' => $tempTwo->navTypeId
                                    ]
                                ])['basic']['navTypeDetail'],
                            ];
                        }

                        $data['basicWithFilter'] = [
                            'list' => $navNested
                        ];

                        if (isset($tempOne['otherDataPasses']['filterData'])) {
                            $data['basicWithFilter']['filterData'] = $tempOne['otherDataPasses']['filterData'];
                        }

                        if (isset($tempOne['otherDataPasses']['orderBy'])) {
                            $data['basicWithFilter']['orderBy'] = $tempOne['otherDataPasses']['orderBy'];
                        }
                    }

                    $finalData['navNested'] = $data;
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

            if (in_array('basic', $params['type'])) {
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

                $finalData['basic'] = $data;
            }

            if (in_array('detailWithDepended', $params['type'])) {
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
                        'navType' => GetManageNavHelper::getNavTypeDetail([
                            'type' => ['basic'],
                            'otherDataPasses' => [
                                'id' => $navMain->navTypeId
                            ]
                        ])['basic']['navTypeDetail']
                    ]
                ];

                $finalData['detailWithDepended'] = $data;
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
                    [
                        'getList' => [
                            'type' => ['basicWithFilter'],
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
                ])['navType']['basicWithFilter']['list'];
                foreach ($navType as $keyOne => $tempOne) {
                    $navMain = GetManageNavHelper::getList([
                        [
                            'getList' => [
                                'type' => ['basicWithFilter'],
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
                    ])['navMain']['basicWithFilter']['list'];
                    if (sizeof($navMain) > 0) {
                        foreach ($navMain as $keyTwo => $tempTwo) {
                            $navSub = GetManageNavHelper::getList([
                                [
                                    'getList' => [
                                        'type' => ['basicWithFilter'],
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
                            ])['navSub']['basicWithFilter']['list'];
                            if (sizeof($navSub) > 0) {
                                foreach ($navSub as $keyThree => $tempThree) {
                                    $navNested = GetManageNavHelper::getList([
                                        [
                                            'getList' => [
                                                'type' => ['basicWithFilter'],
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
                                    ])['navNested']['basicWithFilter']['list'];
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

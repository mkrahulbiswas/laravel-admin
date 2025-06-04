<?php
$baseUrl = 'http://localhost/LARAVEL/AdminSetup/';
// $baseUrl = 'https://unicorncomputech.com/';

return [
    'baseUrl' => $baseUrl,

    //Image
    'image' => 'public/assets/media/image/admin',
    'bannerPic' => 'public/assets/media/image/admin/banner/',
    'bigLogoPic' => 'public/assets/media/image/admin/logo/big_logo/',
    'smallLogoPic' => 'public/assets/media/image/admin/logo/small_logo/',
    'favIconPic' => 'public/assets/media/image/admin/logo/fav_icon/',
    'avatar' => 'public/assets/media/image/admin/avatar/',
    'webIcon' => 'public/assets/media/image/admin/webIcon/',
    'cmsPagesPic' => 'public/assets/media/image/admin/cms_pages/',

    'storage' => [
        'adminUsers' => [
            'type' => 'adminUsers',
            'for' => ['public'],
            'path' => 'media/image/admin/manage_users/admin_users/'
        ],
        'bigLogo' => [
            'type' => 'bigLogo',
            'for' => ['public'],
            'path' => 'media/image/admin/manage_panel/quick_settings/big_logo/'
        ],
        'smallLogo' => [
            'type' => 'smallLogo',
            'for' => ['public'],
            'path' => 'media/image/admin/manage_panel/quick_settings/small_logo/'
        ],
        'favicon' => [
            'type' => 'favicon',
            'for' => ['public'],
            'path' => 'media/image/admin/manage_panel/quick_settings/favicon/'
        ]
    ],

    //Status Type
    'statusAll' => 3,
    'statusMultiple' => 2,
    'statusSingle' => 1,

    //Loader Type
    'loaderRaw' => 'Html, Css, Js Combine Loader',
    'loaderImage' => 'Image Type Loader',
    'loaderVideo' => 'Video Type Loader',

    'superAdminCheck' => [
        'roleMain' => 'RM-500077',
        'admin' => 'AU-500077'
    ],

    //--Banner For
    'bannerFor' => [
        'home' => 'HOME',
    ],

    //--Type Check
    'typeCheck' => [
        'manageNav' => [
            'navType' => [
                'type' => 'navType'
            ],
            'navMain' => [
                'type' => 'navMain'
            ],
            'navSub' => [
                'type' => 'navSub'
            ],
            'navNested' => [
                'type' => 'navNested'
            ],
        ],
        'propertyRelated' => [
            'type' => 'propertyRelated',
            'propertyAttribute' => [
                'type' => 'propertyAttribute',
                'attributes' => [
                    'amenities' => [
                        'type' => 'amenities',
                        'name' => 'Amenities'
                    ],
                    'propertyFeatures' => [
                        'type' => 'propertyFeatures',
                        'name' => 'Property Features'
                    ],
                    'societyFeatures' => [
                        'type' => 'societyFeatures',
                        'name' => 'Society Features'
                    ],
                    'typeOfFloorings' => [
                        'type' => 'typeOfFloorings',
                        'name' => 'Type Of Floorings'
                    ],
                    'parkingTypes' => [
                        'type' => 'parkingTypes',
                        'name' => 'Parking Types'
                    ],
                    'locatedNear' => [
                        'type' => 'locatedNear',
                        'name' => 'Located Near'
                    ],
                    'locationAdvantages' => [
                        'type' => 'locationAdvantages',
                        'name' => 'Location Advantages'
                    ],
                ]
            ],
            'propertyType' => [
                'type' => 'propertyType',
            ],
            'manageBroad' => [
                'type' => 'manageBroad',
                'broadType' => [
                    'type' => 'broadType'
                ],
                'assignBroad' => [
                    'type' => 'assignBroad'
                ]
            ],
            'propertyCategory' => [
                'type' => 'propertyCategory',
                'manageCategory' => [
                    'type' => 'manageCategory'
                ],
                'assignCategory' => [
                    'type' => 'assignCategory'
                ],
            ]
        ],
        'manageAccess' => [
            'roleMain' => [
                'type' => 'roleMain'
            ],
            'roleSub' => [
                'type' => 'roleSub'
            ],
            'permission' => [
                'type' => 'permission'
            ],
        ],
        'quickSettings' => [
            'logo' => [
                'type' => "logo"
            ]
        ],
        'manageUsers' => [
            'adminUsers' => [
                'type' => 'adminUsers'
            ],
        ],
        'helperCommon' => [
            'get' => [
                'inf' => 'insideNoFilter',
                'iyf' => 'insideYesFilter',
                'bnf' => 'basicNoFilter',
                'byf' => 'basicYesFilter',
                'dyf' => 'dependedYesFilter',
                'ryf' => 'rawYesFilter',
            ],
            'detail' => [
                'yd' => 'yesDepended',
                'nd' => 'noDepended',
                'rnd' => 'rawNoDepended',
            ],
            'set' => [
                'pfn' => 'permissionFromNav',
                'pfr' => 'permissionFromRole',
            ],
            'nav' => [
                'sn' => 'sideNav',
                'np' => 'navPermission',
            ],
            'privilege' => [
                'np' => 'navPrivilege',
                'sp' => 'setPermission',
                'gp' => 'getPermission'
            ],
            'access' => [
                'al' => 'allYes',
                'an' => 'allNo',
                'bm' => [
                    'fns' => 'fromNavSide',
                    'frs' => 'fromRoleSide'
                ],
            ],
        ],
        'customizeInText' => [
            'status' => 'status',
            'type' => 'type',
            'default' => 'default',
            'access' => 'access',
            'child' => 'hasChild',
            'permission' => 'hasPermission',
        ]
    ],

    'rolePermission' => [
        'accessType' => [
            'set',
            'add',
            'edit',
            'status',
            'delete',
            'info',
            'detail',
            'default',
            'filter',
            'reload',
            'reset',
            'search',
            'other',
            'permission',
            'access',
            'back',
            'close',
            'save',
            'update',
        ],
    ],

    //--Action Type
    'action' => [
        'status' => [
            'smsfa' => 'SINGLE_MODEL_SINGLE_FIELD_ALL',
            'smsfs' => 'SINGLE_MODEL_SINGLE_FIELD_SELECTED',
            'smsf' => 'SINGLE_MODEL_SINGLE_FIELD',
            'smmf' => 'SINGLE_MODEL_MULTIPLE_FIELD',
            'mmsf' => 'MULTIPLE_MODEL_SINGLE_FIELD',
            'mmmf' => 'MULTIPLE_MODEL_MULTIPLE_FIELD',
        ],
        'nn' => 'noNested',
        'yn' => 'YesNested',
    ],

    //--Status For
    'status' => [
        '0' => '0',
        '1' => '1',
        'active' => 'ACTIVE',
        'inactive' => 'INACTIVE',
        'yes' => 'YES',
        'no' => 'NO',
        'main' => 'MAIN',
        'sub' => 'SUB',
        'nested' => 'NESTED',
        'default' => 'DEFAULT',
    ],

    //--User Type
    'userType' => [
        'admin' => 'ADMIN',
        'na' => 'NA'
    ],


    //Admin Role
    'superAdmin' => 1,
    'subAdmin' => 2,

    //Device Type
    'android' => 'Android',
    'ios' => 'Ios',

    //Pagination Data Per Page
    'perPage1' => 1,
    'perPage10' => 10,
    'perPage20' => 20,

    //Common Message for api response
    'vErrMsg' => 'Validation failed.',
    'blockMsg' => 'You are blocked by admin.',
    'serverErrMsg' => 'Something went wrong.',
    'successMsg' => 'Success.',

    //HTTP Status for api response
    'errorCode' => [
        'ok' => 200,
        'server' => 500,
        'validation' => 422,
        'block' => 403,
    ],

    //Implode OR Explode Key----
    'keyImpExp' => '-(SeP)-',

    'companyEmail' => 'appcoderandroid2@gmail.com',

    //FCM Authorization Key
    'fcmKey' => 'Authorization: key=AAAAL5HljVw:APA91bErRZ-B7MmT83EWnHU0lcvI2E7kpkSThaOculNTAv9pO47KgETJ-qrehXOwZum0lar2rsn4uuSQP78ERtt8ySfNNeVnlTCFfsGHgiawyA2Z-JlKI8wv5QkP586DQa0dq86uOZkR',

    //SMS Gateway Base Url
    'smsGateway' => 'http://web.poweredsms.com/submitsms.jsp?',
];

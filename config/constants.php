<?php
$baseUrl = 'http://localhost/LARAVEL/AdminSetup/';
// $baseUrl = 'https://unicorncomputech.com/';

return [
    'baseUrl' => $baseUrl,
    'tempFilePath' => 'public/assets/media/temp',

    //Image
    'image' => 'public/assets/media/image/admin',
    'bannerPic' => 'public/assets/media/image/admin/banner/',
    'avatar' => 'public/assets/media/image/admin/avatar/',
    'webIcon' => 'public/assets/media/image/admin/webIcon/',
    'cmsPagesPic' => 'public/assets/media/image/admin/cms_pages/',

    'storage' => [
        'adminUsers' => [
            'type' => 'adminUsers',
            'for' => ['public'],
            'path' => 'media/image/admin/manage_users/admin_users/'
        ],
        'appUsers' => [
            'type' => 'appUsers',
            'for' => ['public'],
            'path' => 'media/image/admin/manage_users/app_users/'
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
        ],
        'testFile' => [
            'type' => 'testFile',
            'for' => ['s3'],
            'path' => 'media/image/admin/test/'
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
        'mainRole' => 'RM-500077',
        'admin' => 'AU-390101'
    ],

    //--Banner For
    'bannerFor' => [
        'home' => 'HOME',
    ],

    //--Type Check
    'typeCheck' => [
        'adminRelated' => [
            'type' => 'adminRelated',
            'rolePermission' => [
                'type' => 'rolePermission',
                'manageRole' => [
                    'type' => 'manageRole',
                    'mainRole' => [
                        'type' => 'mainRole'
                    ],
                    'subRole' => [
                        'type' => 'subRole'
                    ],
                    'permission' => [
                        'type' => 'permission'
                    ],
                ],
                'managePermission' => [
                    'type' => 'managePermission',
                    'permission' => [
                        'type' => 'permission'
                    ],
                ],
            ],
            'navigationAccess' => [
                'type' => 'navigationAccess',
                'manageSideNav' => [
                    'type' => 'manageSideNav',
                    'navType' => [
                        'type' => 'navType'
                    ],
                    'mainNav' => [
                        'type' => 'mainNav'
                    ],
                    'subNav' => [
                        'type' => 'subNav'
                    ],
                    'nestedNav' => [
                        'type' => 'nestedNav'
                    ],
                ],
            ],
            'quickSetting' => [
                'type' => 'quickSetting',
                'siteSetting' => [
                    'type' => "siteSetting",
                    'logo' => [
                        'type' => "logo"
                    ]
                ],
                'customizedAlert' => [
                    'type' => "customizedAlert",
                    'alertType' => [
                        'type' => "alertType"
                    ],
                    'alertFor' => [
                        'type' => "alertFor"
                    ],
                    'alertTemplate' => [
                        'type' => "alertTemplate"
                    ],
                ]
            ],
        ],
        'propertyRelated' => [
            'type' => 'propertyRelated',
            'propertyInstance' => [
                'type' => 'propertyInstance',
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
                        'propertyFacing' => [
                            'type' => 'propertyFacing',
                            'name' => 'propertyFacing'
                        ],
                        'uploadedPhotoType' => [
                            'type' => 'uploadedPhotoType',
                            'name' => 'Uploaded Photo Type'
                        ],
                        'typesOfUsers' => [
                            'type' => 'typesOfUsers',
                            'name' => 'Types Of Users'
                        ],
                        'ownership' => [
                            'type' => 'ownership',
                            'name' => 'Ownership'
                        ],
                        'measurementsUnits' => [
                            'type' => 'measurementsUnits',
                            'name' => 'Measurements Units'
                        ],
                        'qualityRating' => [
                            'type' => 'qualityRating',
                            'name' => 'Quality Rating'
                        ],
                        'otherRooms' => [
                            'type' => 'otherRooms',
                            'name' => 'Other Rooms'
                        ],
                        'availabilityStatus' => [
                            'type' => 'availabilityStatus',
                            'name' => 'Availability Status'
                        ],
                        'furnishing' => [
                            'type' => 'furnishing',
                            'name' => 'Furnishing'
                        ],
                        'propertyProvided' => [
                            'type' => 'propertyProvided',
                            'name' => 'Property provided'
                        ],
                        'yourApartment' => [
                            'type' => 'yourApartment',
                            'name' => 'Your Apartment is'
                        ],
                        'additionalFeature' => [
                            'type' => 'additionalFeature',
                            'name' => 'Additional Feature'
                        ],
                        'suitableType' => [
                            'type' => 'suitableType',
                            'name' => 'Suitable type'
                        ],
                        'washroomDetails' => [
                            'type' => 'washroomDetails',
                            'name' => 'Washroom details'
                        ],
                        'facilityAvailable' => [
                            'type' => 'facilityAvailable',
                            'name' => 'Facility Available'
                        ],
                        'ageOfProperty' => [
                            'type' => 'ageOfProperty',
                            'name' => 'Age of property'
                        ],
                        'waterSource' => [
                            'type' => 'waterSource',
                            'name' => 'Water Source'
                        ],
                        'overlooking' => [
                            'type' => 'overlooking',
                            'name' => 'Overlooking'
                        ],
                        'otherFeature' => [
                            'type' => 'otherFeature',
                            'name' => 'Other Feature'
                        ],
                        'powerBackup' => [
                            'type' => 'powerBackup',
                            'name' => 'Power Backup'
                        ],
                        'constructionDone' => [
                            'type' => 'constructionDone',
                            'name' => 'construction done'
                        ],
                        'propertyApproved' => [
                            'type' => 'propertyApproved',
                            'name' => 'property approved'
                        ],
                        'locationInside' => [
                            'type' => 'locationInside',
                            'name' => 'Location Inside'
                        ],
                        'zoneType' => [
                            'type' => 'zoneType',
                            'name' => 'Zone Type'
                        ],
                        'constructionStatus' => [
                            'type' => 'constructionStatus',
                            'name' => 'Construction Status'
                        ],
                        'fireSafety' => [
                            'type' => 'fireSafety',
                            'name' => 'Fire safety'
                        ],
                        'previouslyUsed' => [
                            'type' => 'previouslyUsed',
                            'name' => 'Previously used for'
                        ],
                        'approvedType' => [
                            'type' => 'approvedType',
                            'name' => 'Approved type'
                        ],
                        'buildingFeature' => [
                            'type' => 'buildingFeature',
                            'name' => 'Building feature'
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
            ]
        ],
        'usersRelated' => [
            'type' => 'usersRelated',
            'manageUsers' => [
                'type' => 'manageUsers',
                'adminUsers' => [
                    'type' => 'adminUsers'
                ],
                'appUsers' => [
                    'type' => 'appUsers'
                ],
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
                'ay' => 'allYes',
                'an' => 'allNo',
                'fns' => 'fromNavSide',
                'frs' => 'fromRoleSide'
            ],
        ],
        'customizeInText' => [
            'status' => 'status',
            'type' => 'type',
            'default' => 'default',
            'access' => 'access',
            'child' => 'hasChild',
            'permission' => 'hasPermission',
            'variable' => 'variable',
            'userType' => 'userType',
        ],
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
            'verify',
            'send',
        ],
    ],

    //--Action Type
    'action' => [
        'status' => [
            'smsfa' => 'SINGLE_MODEL_SINGLE_FIELD_ALL',
            'smsfs' => 'SINGLE_MODEL_SINGLE_FIELD_SELECTED',
            'smsfw' => 'SINGLE_MODEL_SINGLE_FIELD_WITH',
            'smsf' => 'SINGLE_MODEL_SINGLE_FIELD',
            'smmf' => 'SINGLE_MODEL_MULTIPLE_FIELD',
            'mmsf' => 'MULTIPLE_MODEL_SINGLE_FIELD',
            'mmmf' => 'MULTIPLE_MODEL_MULTIPLE_FIELD',
        ],
        'nn' => 'noNested',
        'yn' => 'YesNested',
        'default' => [
            'smyon' => 'singleModelYesOtherNo',
            'smyn' => 'singleModelYesNo',
        ],
    ],

    //--Status For
    'status' => [
        '0' => '0',
        '1' => '1',
        'active' => 'ACTIVE',
        'inactive' => 'INACTIVE',
        'incomplete' => 'INCOMPLETE',
        'default' => 'DEFAULT',
        'yes' => 'YES',
        'no' => 'NO',
        'category' => [
            'main' => 'MAIN',
            'sub' => 'SUB',
            'nested' => 'NESTED',
        ]
    ],

    //--OTP For
    'otpFor' => [
        'login' => 'LOGIN',
        'register' => 'REGISTER',
        'reset' => [
            'password' => 'RESET PASSWORD'
        ],
        'change' => [
            'phone' => 'CHANGE PHONE',
            'email' => 'CHANGE EMAIL',
        ],
    ],

    //--User Type
    'userType' => [
        'admin' => 'ADMIN',
        'agent' => 'AGENT',
        'user' => 'USER',
        'na' => 'NA'
    ],

    //--Generate Your Choice Type
    'generateType' => [
        'uniqueId' => 'uniqueId',
        'route' => 'route',
        'lastSegment' => 'lastSegment',
        'slug' => 'slug',
        'alpNum' => 'alphaNumerical',
        'number' => 'number',
    ],


    //Admin Role
    'superAdmin' => 1,
    'subAdmin' => 2,

    //Device Type
    'deviceType' => [
        'android' => 'ANDROID',
        'ios' => 'IOS',
        'web' => 'WEB',
    ],


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
        'validation' => 400,
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

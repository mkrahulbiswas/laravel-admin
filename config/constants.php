<?php
$baseUrl = 'http://localhost/LARAVEL/AdminSetup/';
// $baseUrl = 'https://unicorncomputech.com/';

return [
    'baseUrl' => $baseUrl,

    //Image
    'image' => 'public/assets/media/image/admin',

    'adminPic' => 'public/assets/media/image/admin/users/admin/',
    'clientPic' => 'public/assets/media/image/admin/users/client/',
    'bannerPic' => 'public/assets/media/image/admin/banner/',
    'bigLogoPic' => 'public/assets/media/image/admin/logo/big_logo/',
    'smallLogoPic' => 'public/assets/media/image/admin/logo/small_logo/',
    'favIconPic' => 'public/assets/media/image/admin/logo/fav_icon/',
    'avatar' => 'public/assets/media/image/admin/avatar/',
    'webIcon' => 'public/assets/media/image/admin/webIcon/',
    'productPic' => 'public/assets/media/image/admin/product/',
    'cmsPagesPic' => 'public/assets/media/image/admin/cms_pages/',
    'aboutPic' => 'public/assets/media/image/admin/about_us/',

    //Status Type
    'statusAll' => 3,
    'statusMultiple' => 2,
    'statusSingle' => 1,

    //Loader Type
    'loaderRaw' => 'Html, Css, Js Combine Loader',
    'loaderImage' => 'Image Type Loader',
    'loaderVideo' => 'Video Type Loader',

    //--Banner For
    'bannerFor' => [
        'home' => 'HOME',
    ],

    //--Action Type
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
        'manageAccess' => [
            'roleMain' => [
                'type' => 'roleMain'
            ],
            'roleSub' => [
                'type' => 'roleSub'
            ],
        ],
    ],

    'rolePermission' => [
        'accessType' => [
            'add',
            'edit',
            'status',
            'delete',
            'info',
            'detail',
            'filter',
            'reload',
            'reset',
            'search',
            'other',
            'permission',
            'access',
        ]
    ],

    //--Action Type
    'actionFor' => [
        'statusType' => [
            'smsf' => 'SINGLE_MODEL_SINGLE_FIELD',
            'smmf' => 'SINGLE_MODEL_MULTIPLE_FIELD',
            'mmsf' => 'MULTIPLE_MODEL_SINGLE_FIELD',
            'mmmf' => 'MULTIPLE_MODEL_MULTIPLE_FIELD',
        ],
        'deleteType' => [
            'smsr' => 'SINGLE_MODEL_SINGLE_ROW',
            'smmr' => 'SINGLE_MODEL_MULTIPLE_ROW',
        ]
    ],

    //--Status For
    'status' => [
        '0' => '0',
        '1' => '1',
        'active' => 'ACTIVE',
        'inactive' => 'INACTIVE',
    ],

    //--User Type
    'userType' => [
        'superAdmin' => 'SUPER_ADMIN',
        'subAdmin' => 'SUB_ADMIN',
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
    'ok' => 200,
    'serverErr' => 500,
    'vErr' => 420,

    //Implode OR Explode Key----
    'keyImpExp' => '-(SeP)-',

    ////Company Email////
    'companyEmail' => 'appcoderandroid2@gmail.com',

    //FCM Authorization Key
    'fcmKey' => 'Authorization: key=AAAAL5HljVw:APA91bErRZ-B7MmT83EWnHU0lcvI2E7kpkSThaOculNTAv9pO47KgETJ-qrehXOwZum0lar2rsn4uuSQP78ERtt8ySfNNeVnlTCFfsGHgiawyA2Z-JlKI8wv5QkP586DQa0dq86uOZkR',

    //SMS Gateway Base Url
    'smsGateway' => 'http://web.poweredsms.com/submitsms.jsp?',
];

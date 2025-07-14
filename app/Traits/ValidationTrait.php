<?php

namespace app\Traits;


use App\Helpers\AdminRelated\RolePermission\ManageRoleHelper;

use App\Models\PropertyRelated\PropertyType;
use App\Models\PropertyRelated\ManageBroad\BroadType;
use App\Models\PropertyRelated\PropertyCategory\ManageCategory;
use App\Models\AdminRelated\QuickSetting\CustomizedAlert\AlertType;
use App\Models\User;
use App\Models\UsersRelated\ManageUsers\AdminUsers;

use App\Rules\AdminRelated\NavigationAccess\ManageSideNavRules;
use App\Rules\AdminRelated\QuickSetting\CustomizedAlertRules;
use App\Rules\AdminRelated\RolePermission\ManageRoleRules;
use App\Rules\PropertyRelated\UniquePropertyAttribute;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

trait ValidationTrait
{
    public function isValid($data)
    {
        if ($data['platform'] == 'backend') {
            $response = $this->vRulesBackend($data);
            $validator = Validator::make($data['input'], $response['rules'], $response['messages']);
            return $validator;
        } elseif ($data['platform'] == 'web') {
            $response = $this->vRulesWeb($data);
            $validator = Validator::make($data['input'], $response['rules'], $response['messages']);
            return $validator;
        } elseif ($data['platform'] == 'app') {
            $response = $this->vRulesApp($data);
            $validator = Validator::make($data['input'], $response['rules'], $response['messages']);
            return $validator;
        } else {
        }
        //$validation->setAttributeNames(static::$niceNames);
    }

    public function vRulesBackend($data)
    {
        $rules = [];
        $messages = [];

        switch ($data['for']) {

            //AuthController
            case 'checkLogin':
                $rules = [
                    'password' => 'required',
                    'phone' => 'required',
                    // 'email' => 'required|email|max:100',
                ];
                break;

            case 'saveForgotPassword':
                $rules = [
                    'email' => 'required|email|max:100',
                ];
                break;

            case 'updateResetPassword':
                $rules = [
                    'otp' => 'required|digits:6',
                    'password' => 'required|min:6',
                    'confirmPassword' => 'required|same:password|min:6',
                ];
                break;


            case 'updateAuthProfile':
                $rules = [
                    'name' => 'required|max:255',
                    'pinCode' => 'required|max:7',
                    'state' => 'required|max:50',
                    'country' => 'required|max:50',
                    'address' => 'required|max:150',
                    'about' => 'max:500',
                ];
                break;

            case 'changeAuthPassword':
                $rules = [
                    'oldPassword' => 'required',
                    'newPassword' => 'min:6|max:20|different:oldPassword|required_with:confirmPassword',
                    'confirmPassword' => 'min:6|max:20|same:newPassword',
                ];
                break;

            case 'changeAuthPin':
                $rules = [
                    'oldPin' => 'required',
                    'newPin' => 'min:6|max:10|different:oldPin|required_with:confirmPin',
                    'confirmPin' => 'min:6|max:10|same:newPin',
                ];
                break;

            case 'resetAuthVerify':
                $rules = [
                    'otp' => 'required|digits:6',
                ];
                break;

            case 'resetAuthPassword':
                $rules = [
                    'newPassword' => 'min:6|max:20|different:oldPassword|required_with:confirmPassword',
                    'confirmPassword' => 'min:6|max:20|same:newPassword',
                ];
                break;

            case 'changeAuthSend':
                if ($data['input']['type'] == 'email') {
                    $rules['email'] = 'required|email|max:100|unique:' . AdminUsers::class . ',email';
                } else {
                    $rules['phone'] = 'required|max:100|digits:10|unique:' . AdminUsers::class . ',phone';
                }
                break;

            case 'changeAuthVerify':
                $rules = [
                    'otp' => 'required|digits:6',
                ];
                break;

            case 'resetAuthPin':
                $rules = [
                    'newPin' => 'min:6|max:10|different:oldPin|required_with:confirmPin',
                    'confirmPin' => 'min:6|max:10|same:newPin',
                ];
                break;

            case 'changeAuthImage':
                $rules = [
                    'file' => 'image|mimes:jpeg,jpg,png',
                ];
                break;


            /*------ ( Role & Permission START ) ------*/
            //---- ( Main Role )
            case 'saveMainRole':
                $rules = [
                    'name' => ['required', 'max:20', new ManageRoleRules([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                    ])],
                    'description' => 'required',
                ];
                break;

            case 'updateMainRole':
                $rules = [
                    'name' => ['required', 'max:20', new ManageRoleRules([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                    ])],
                    'description' => 'required',
                ];
                break;

            //---- ( Sub Role )
            case 'saveSubRole':
                $rules = [
                    'name' => ['required', 'max:20', new ManageRoleRules([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                        'mainRoleId' => $data['input']['mainRole']
                    ])],
                    'mainRole' => 'required',
                    'description' => 'required',
                ];
                break;

            case 'updateSubRole':
                $rules = [
                    'name' => ['required', 'max:20', new ManageRoleRules([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                        'mainRoleId' => $data['input']['mainRole']
                    ])],
                    'mainRole' => 'required',
                    'description' => 'required',
                ];
                break;
            /*------ ( Role & Permission END ) ------*/


            /*------ ( Navigation & Access START ) ------*/
            //---- ( Nav Type )
            case 'saveNavType':
                $rules = [
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:30', new ManageSideNavRules([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                    ])],
                    'description' => 'max:500',
                ];
                break;

            case 'updateNavType':
                $rules = [
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:30', new ManageSideNavRules([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.navType.type'),
                    ])],
                    'description' => 'max:500',
                ];
                break;

            //---- ( Main Nav )
            case 'saveMainNav':
                $rules = [
                    'navType' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new ManageSideNavRules([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                        'navTypeId' => $data['input']['navType']
                    ])],
                    'description' => 'max:500',
                ];
                break;

            case 'updateMainNav':
                $rules = [
                    'navType' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new ManageSideNavRules([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.mainNav.type'),
                        'navTypeId' => $data['input']['navType']
                    ])],
                    'description' => 'max:500',
                ];
                break;

            //---- ( Sub Nav )
            case 'saveSubNav':
                $rules = [
                    'navType' => 'required',
                    'mainNav' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new ManageSideNavRules([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                        'navTypeId' => $data['input']['navType'],
                        'mainNavId' => $data['input']['mainNav']
                    ])],
                    'description' => 'max:500',
                ];
                break;

            case 'updateSubNav':
                $rules = [
                    'navType' => 'required',
                    'mainNav' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new ManageSideNavRules([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.subNav.type'),
                        'navTypeId' => $data['input']['navType'],
                        'mainNavId' => $data['input']['mainNav']
                    ])],
                    'description' => 'max:500',
                ];
                break;

            //---- ( Nested Nav )
            case 'saveNestedNav':
                $rules = [
                    'navType' => 'required',
                    'mainNav' => 'required',
                    'subNav' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new ManageSideNavRules([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type'),
                        'navTypeId' => $data['input']['navType'],
                        'mainNavId' => $data['input']['mainNav'],
                        'subNavId' => $data['input']['subNav'],
                    ])],
                    'description' => 'max:500',
                ];
                break;

            case 'updateNestedNav':
                $rules = [
                    'navType' => 'required',
                    'mainNav' => 'required',
                    'subNav' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new ManageSideNavRules([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.navigationAccess.manageSideNav.nestedNav.type'),
                        'navTypeId' => $data['input']['navType'],
                        'mainNavId' => $data['input']['mainNav'],
                        'subNavId' => $data['input']['subNav'],
                    ])],
                    'description' => 'max:500',
                ];
                break;
            /*------ ( Navigation & Access END ) ------*/


            /*------ ( Quick Setting START ) ------*/
            //---- ( Logo )
            case 'saveLogo':
                $rules = [
                    'bigLogo' => 'required|image|mimes:jpeg,jpg,png',
                    'smallLogo' => 'required|image|mimes:jpeg,jpg,png',
                    'favicon' => 'required|image|mimes:jpeg,jpg,png',
                ];
                break;

            case 'updateLogo':
                $rules = [
                    'bigLogo' => 'image|mimes:jpeg,jpg,png',
                    'smallLogo' => 'image|mimes:jpeg,jpg,png',
                    'favicon' => 'image|mimes:jpeg,jpg,png',
                ];
                break;

            //---- ( Alert Type )
            case 'saveAlertType':
                $rules = [
                    'name' => 'required|max:30|unique:' . AlertType::class . ',name',
                ];
                break;

            case 'updateAlertType':
                $rules = [
                    'name' => 'required|max:30|unique:' . AlertType::class . ',name,' . $data['id'],
                ];
                break;

            //---- ( Alert For )
            case 'saveAlertFor':
                $rules = [
                    'alertType' => 'required',
                    'name' => ['required', 'max:50', new CustomizedAlertRules([
                        'targetId' => $data['id'],
                        'alertType' => $data['input']['alertType'],
                        'type' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type'),
                    ])],
                ];
                break;

            case 'updateAlertFor':
                $rules = [
                    'alertType' => 'required',
                    'name' => ['required', 'max:50', new CustomizedAlertRules([
                        'targetId' => $data['id'],
                        'alertType' => $data['input']['alertType'],
                        'type' => Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type'),
                    ])],
                ];
                break;

            //---- ( Alert Template )
            case 'saveAlertTemplate':
                $rules = [
                    'alertType' => 'required',
                    'alertFor' => 'required',
                    'heading' => 'required|max:150',
                    'content' => 'required',
                ];
                break;

            case 'updateAlertTemplate':
                $rules = [
                    'alertType' => 'required',
                    'alertFor' => 'required',
                    'heading' => 'required|max:150',
                    'content' => 'required',
                ];
                break;
            /*------ ( Quick Setting End ) ------*/


            /*------ ( Manage Users Start ) ------*/
            //---- ( Admin )
            case 'saveAdminUsers':
                $rules = [
                    'file' => 'image|mimes:jpeg,jpg,png',
                    'email' => 'required|email|max:100|unique:' . AdminUsers::class . '',
                    'phone' => 'required|max:100|unique:' . AdminUsers::class . ',phone|digits:10',
                    'name' => 'required|max:255',
                    'mainRole' => 'required',
                    'pinCode' => 'required|max:7',
                    'state' => 'required|max:50',
                    'country' => 'required|max:50',
                    'address' => 'required|max:150',
                    'about' => 'max:500',
                ];
                if ($data['input']['mainRole'] != '') {
                    $getDetail = ManageRoleHelper::getDetail([
                        [
                            'getDetail' => [
                                'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                            ],
                            'otherDataPasses' => [
                                'id' => $data['input']['mainRole']
                            ]
                        ],
                    ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                    if ($getDetail['extraData']['hasSubRole'] > 0) {
                        $rules['subRole'] = 'required';
                    }
                }
                break;

            case 'updateAdminUsers':
                $rules = [
                    'file' => 'image|mimes:jpeg,jpg,png',
                    'email' => 'required|email|max:100|unique:' . AdminUsers::class . ',email,' . $data['id'],
                    'phone' => 'required|max:100|digits:10|unique:' . AdminUsers::class . ',phone,' . $data['id'],
                    'name' => 'required|max:255',
                    'pinCode' => 'required|max:7',
                    'state' => 'required|max:50',
                    'country' => 'required|max:50',
                    'address' => 'required|max:150',
                    'about' => 'max:500',
                ];
                if ($data['input']['uniqueId'] != Config::get('constants.superAdminCheck.admin')) {
                    $rules['mainRole'] = 'required';
                    if ($data['input']['mainRole'] != '') {
                        $getDetail = ManageRoleHelper::getDetail([
                            [
                                'getDetail' => [
                                    'type' => [Config::get('constants.typeCheck.helperCommon.detail.nd')],
                                    'for' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                                ],
                                'otherDataPasses' => [
                                    'id' => $data['input']['mainRole']
                                ]
                            ],
                        ])[Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')][Config::get('constants.typeCheck.helperCommon.detail.nd')]['detail'];
                        if ($getDetail['extraData']['hasSubRole'] > 0) {
                            $rules['subRole'] = 'required';
                        }
                    }
                }
                break;
            /*------ ( Manage Users End ) ------*/


            /*------ ( Property Related Start ) ------*/
            //---- ( Property Attribute )
            case 'savePropertyAttribute':
                $rules = [
                    'type' => 'required',
                    'name' => ['required', 'max:255', new UniquePropertyAttribute([
                        'targetId' => $data['id'],
                        'type' => $data['input']['type']
                    ])],
                    'about' => 'max:500',
                ];
                break;
            case 'updatePropertyAttribute':
                $rules = [
                    'type' => 'required',
                    'name' => ['required', 'max:255', new UniquePropertyAttribute([
                        'targetId' => $data['id'],
                        'type' => $data['input']['type']
                    ])],
                    'about' => 'max:500',
                ];
                break;

            //---- ( Property Type )
            case 'savePropertyType':
                $rules = [
                    'name' => 'required|max:255|unique:' . PropertyType::class . ',name',
                    'about' => 'max:500',
                ];
                break;
            case 'updatePropertyType':
                $rules = [
                    'name' => 'required|max:255|unique:' . PropertyType::class . ',name,' . $data['id'],
                    'about' => 'max:500',
                ];
                break;

            //---- ( Broad Type )
            case 'saveBroadType':
                $rules = [
                    'name' => 'required|max:255|unique:' . BroadType::class . ',name',
                    'about' => 'max:500',
                ];
                break;
            case 'updateBroadType':
                $rules = [
                    'name' => 'required|max:255|unique:' . BroadType::class . ',name,' . $data['id'],
                    'about' => 'max:500',
                ];
                break;

            //---- ( Assign Broad )
            case 'saveAssignBroad':
                $rules = [
                    'propertyType' => 'required',
                    'broadType' => 'required',
                    'about' => 'max:500',
                ];
                break;
            case 'updateAssignBroad':
                $rules = [
                    'propertyType' => 'required',
                    'broadType' => 'required',
                    'about' => 'max:500',
                ];
                break;

            //---- ( Manage Category )
            case 'saveManageCategory':
                $rules = [
                    'name' => 'required|max:255|unique:' . ManageCategory::class . ',name',
                    'about' => 'max:500',
                ];
                if ($data['input']['type'] == Config::get('constants.status.category.sub')) {
                    $rules['mainCategory'] = 'required';
                } elseif ($data['input']['type'] == Config::get('constants.status.category.nested')) {
                    $rules['mainCategory'] = 'required';
                    $rules['subCategory'] = 'required';
                }
                $messages = [
                    'mainCategory.required' => 'You must select main category',
                    'subCategory.required' => 'You must select sub category'
                ];
                break;

            case 'updateManageCategory':
                $rules = [
                    'name' => 'required|max:255|unique:' . ManageCategory::class . ',name,' . $data['id'],
                    'about' => 'max:500',
                ];
                if ($data['input']['type'] == Config::get('constants.status.category.sub')) {
                    $rules['mainCategory'] = 'required';
                } elseif ($data['input']['type'] == Config::get('constants.status.category.nested')) {
                    $rules['mainCategory'] = 'required';
                    $rules['subCategory'] = 'required';
                }
                $messages = [
                    'mainCategory.required' => 'You must select main category',
                    'subCategory.required' => 'You must select sub category lol'
                ];
                break;

            //---- ( Assign Category )
            case 'saveAssignCategory':
                $rules = [
                    'mainCategory' => 'required',
                    'propertyType' => 'required',
                    'assignBroad' => 'required',
                    'about' => 'max:500',
                ];
                break;
            case 'updateAssignCategory':
                $rules = [
                    'mainCategory' => 'required',
                    'propertyType' => 'required',
                    'assignBroad' => 'required',
                    'about' => 'max:500',
                ];
                break;
            /*------ ( Property Related End ) ------*/

            case 'emailLogin':
            default:
                $rules = [
                    'email' => [
                        'required',
                        // Rule::exists('tbl_user', 'username')->where(function ($query) {
                        //  $query->where('is_email_verified', '=', 'Yes')
                        //          ->where('is_phone_verified', '=', 'Yes');
                        // }),
                    ],
                    'password' => 'required',
                ];
                break;
        }

        return ['rules' => $rules, 'messages' => $messages];
    }

    public function vRulesWeb($data)
    {
        $rules = [];
        $messages = [];
        switch ($data['for']) {
            case 'checkUser':
                if ($data['input']['checkBy'] == 'phone') {
                    $rules = [
                        'phone' => 'required|digits:10',
                    ];
                } else if ($data['input']['checkBy'] == 'email') {
                    $rules = [
                        'email' => 'required|email',
                    ];
                } else {
                    $rules = [
                        'checkBy' => 'required',
                        'email' => 'required|email',
                        'phone' => 'required|digits:10',
                    ];
                }
                break;

            case 'verifyUser':
                $rules = [
                    'id' => 'required',
                    'isUserFound' => 'required|boolean',
                    'checkBy' => 'required',
                    'otpFor' => 'required',
                    'otp' => 'required|digits:6',
                ];
                break;

            case 'registerUser':
                $rules = [
                    'id' => 'required',
                    'name' => 'required|max:80',
                    'dialCode' => 'required|integer',
                    'phone' => 'required|integer|unique:' . User::class . ',phone,' . $data['id'],
                    'email' => 'required|max:150|unique:' . User::class . ',email,' . $data['id'],
                    'password' => 'required|min:6',
                    'confirmPassword' => 'required|same:password|min:6',
                    'userType' => 'required',
                    'checkBy' => 'required',
                ];
                break;

            case 'loginUser':
                if ($data['input']['checkBy'] == '') {
                    $rules = [
                        'password' => 'required|min:6',
                        'checkBy' => 'required',
                    ];
                } else {
                    if ($data['input']['checkBy'] == 'phone') {
                        $rules['dialCode'] = 'required|integer';
                        $rules['phone'] = 'required|integer';
                    } else if ($data['input']['checkBy'] == 'email') {
                        $rules['email'] = 'required|email';
                    }
                }
                break;
            case 'updateDeviceToken':
                $rules = [
                    'deviceType' => 'required',
                    'deviceToken' => 'required',
                ];
                break;
            case 'changePassword':
                $rules = [
                    'oldPassword' => 'required',
                    'newPassword' => 'min:6|max:20|different:oldPassword|required_with:confirmPassword',
                    'confirmPassword' => 'min:6|max:20|same:newPassword',
                ];
                break;
            case 'updateProfilePic':
                $rules = [
                    'file' => 'image|mimes:jpeg,jpg,png'
                ];
                break;
            case 'resetSendOtp':
                if ($data['input']['checkBy'] == '') {
                    $rules = [
                        'checkBy' => 'required',
                    ];
                } else {
                    if ($data['input']['checkBy'] == 'phone') {
                        $rules['dialCode'] = 'required|integer';
                        $rules['phone'] = 'required|integer';
                    } else if ($data['input']['checkBy'] == 'email') {
                        $rules['email'] = 'required|email';
                    }
                }
                break;
            case 'resetVerifyOtp':
                $rules = [
                    'otp' => 'required|digits:6',
                    'id' => 'required',
                ];
                break;
            case 'resetChangePassword':
                $rules = [
                    'password' => 'min:6|max:20|required_with:confirmPassword',
                    'confirmPassword' => 'min:6|max:20|same:password',
                    'id' => 'required',
                ];
                break;
            case 'changeSendOtp':
                if ($data['input']['checkBy'] == '') {
                    $rules = [
                        'checkBy' => 'required',
                    ];
                } else {
                    if ($data['input']['checkBy'] == 'phone') {
                        $rules['dialCode'] = 'required|integer';
                        $rules['phone'] = 'required|integer|unique:' . User::class . ',phone,' . $data['id'];
                    } else if ($data['input']['checkBy'] == 'email') {
                        $rules['email'] = 'required|email|unique:' . User::class . ',email,' . $data['id'];
                    }
                }
                break;
            case 'changeVerifyOtp':
                $rules = [
                    'otp' => 'required|digits:6',
                    'checkBy' => 'required',
                ];
                if ($data['input']['checkBy'] != '') {
                    if ($data['input']['checkBy'] == 'phone') {
                        $rules['dialCode'] = 'required|integer';
                        $rules['phone'] = 'required|integer|unique:' . User::class . ',phone,' . $data['id'];
                    } else if ($data['input']['checkBy'] == 'email') {
                        $rules['email'] = 'required|email|unique:' . User::class . ',email,' . $data['id'];
                    }
                }
                break;

            case 'emailLogin':
            default:
                $rules = [
                    'email' => [
                        'required',
                        // Rule::exists('tbl_user', 'username')->where(function ($query) {
                        //  $query->where('is_email_verified', '=', 'Yes')
                        //          ->where('is_phone_verified', '=', 'Yes');
                        // }),
                    ],
                    'password' => 'required',
                ];
                break;
        }
        return ['rules' => $rules, 'messages' => $messages];
    }

    public function vRulesApp($data)
    {
        $rules = [];
        $messages = [];

        switch ($data['for']) {
            case 'checkUser':
                if ($data['input']['checkBy'] == 'phone') {
                    $rules = [
                        'phone' => 'required|digits:10',
                    ];
                } else if ($data['input']['checkBy'] == 'email') {
                    $rules = [
                        'email' => 'required|email',
                    ];
                } else {
                    $rules = [
                        'checkBy' => 'required',
                        'email' => 'required|email',
                        'phone' => 'required|digits:10',
                    ];
                }
                break;

            case 'verifyUser':
                $rules = [
                    'id' => 'required',
                    'isUserFound' => 'required|boolean',
                    'checkBy' => 'required',
                    'otpFor' => 'required',
                    'otp' => 'required|digits:6',
                ];
                break;

            case 'registerUser':
                $rules = [
                    'id' => 'required',
                    'name' => 'required|max:80',
                    'dialCode' => 'required|integer',
                    'phone' => 'required|integer|unique:' . User::class . ',phone,' . $data['id'],
                    'email' => 'required|max:150|unique:' . User::class . ',email,' . $data['id'],
                    'password' => 'required|min:6',
                    'confirmPassword' => 'required|same:password|min:6',
                    'userType' => 'required',
                    'checkBy' => 'required',
                ];
                break;

            case 'loginUser':
                if ($data['input']['checkBy'] == '') {
                    $rules = [
                        'password' => 'required|min:6',
                        'checkBy' => 'required',
                    ];
                } else {
                    if ($data['input']['checkBy'] == 'phone') {
                        $rules['dialCode'] = 'required|integer';
                        $rules['phone'] = 'required|integer';
                    } else if ($data['input']['checkBy'] == 'email') {
                        $rules['email'] = 'required|email';
                    }
                }
                break;
            case 'updateDeviceToken':
                $rules = [
                    'deviceType' => 'required',
                    'deviceToken' => 'required',
                ];
                break;
            case 'changePassword':
                $rules = [
                    'oldPassword' => 'required',
                    'newPassword' => 'min:6|max:20|different:oldPassword|required_with:confirmPassword',
                    'confirmPassword' => 'min:6|max:20|same:newPassword',
                ];
                break;
            case 'updateProfilePic':
                $rules = [
                    'file' => 'image|mimes:jpeg,jpg,png'
                ];
                break;
            case 'resetSendOtp':
                if ($data['input']['checkBy'] == '') {
                    $rules = [
                        'checkBy' => 'required',
                    ];
                } else {
                    if ($data['input']['checkBy'] == 'phone') {
                        $rules['dialCode'] = 'required|integer';
                        $rules['phone'] = 'required|integer';
                    } else if ($data['input']['checkBy'] == 'email') {
                        $rules['email'] = 'required|email';
                    }
                }
                break;
            case 'resetVerifyOtp':
                $rules = [
                    'otp' => 'required|digits:6',
                    'id' => 'required',
                ];
                break;
            case 'resetChangePassword':
                $rules = [
                    'password' => 'min:6|max:20|required_with:confirmPassword',
                    'confirmPassword' => 'min:6|max:20|same:password',
                    'id' => 'required',
                ];
                break;
            case 'changeSendOtp':
                if ($data['input']['checkBy'] == '') {
                    $rules = [
                        'checkBy' => 'required',
                    ];
                } else {
                    if ($data['input']['checkBy'] == 'phone') {
                        $rules['dialCode'] = 'required|integer';
                        $rules['phone'] = 'required|integer|unique:' . User::class . ',phone,' . $data['id'];
                    } else if ($data['input']['checkBy'] == 'email') {
                        $rules['email'] = 'required|email|unique:' . User::class . ',email,' . $data['id'];
                    }
                }
                break;
            case 'changeVerifyOtp':
                $rules = [
                    'otp' => 'required|digits:6',
                    'checkBy' => 'required',
                ];
                if ($data['input']['checkBy'] != '') {
                    if ($data['input']['checkBy'] == 'phone') {
                        $rules['dialCode'] = 'required|integer';
                        $rules['phone'] = 'required|integer|unique:' . User::class . ',phone,' . $data['id'];
                    } else if ($data['input']['checkBy'] == 'email') {
                        $rules['email'] = 'required|email|unique:' . User::class . ',email,' . $data['id'];
                    }
                }
                break;

            case 'login':
            default:
                $rules = [
                    'email' => [
                        'required',
                        // Rule::exists('tbl_user', 'username')->where(function ($query) {
                        //  $query->where('is_email_verified', '=', 'Yes')
                        //          ->where('is_phone_verified', '=', 'Yes');
                        // }),
                    ],
                    'password' => 'required',
                ];
                break;
        }

        return ['rules' => $rules, 'messages' => $messages];
    }

    public function getVErrorMessages($vErrors)
    {
        $ret = [];
        $messages = $vErrors->getMessages();
        if (is_array($messages) && count($messages) > 0) {
            foreach ($messages as $k => $v) {
                if (is_array($v) && array_key_exists(0, $v)) {
                    $ret[$k] = $v[0];
                    // return $v[0];
                }
            }
        }
        return $ret;
    }
}

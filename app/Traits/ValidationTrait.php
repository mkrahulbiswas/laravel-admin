<?php

namespace app\Traits;

use App\Helpers\AdminRelated\RolePermission\ManageRoleHelper;

use App\Rules\ManagePanel\UniqueManageNav;
use App\Rules\PropertyRelated\UniquePropertyAttribute;
use App\Rules\AdminRelated\RolePermission\UniqueManageRole;

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
            $validator = Validator::make($data['input'], $this->vRulesWeb($data['input'], $data['for'], $data['id'], 'rule'), $this->vRulesWeb($data['input'], $data['for'], $data['id'], 'message'));
            return $validator;
        } elseif ($data['platform'] == 'app') {
            $validator = Validator::make($data['input'], $this->vRulesApp($data['input'], $data['for'], $data['id'], 'rule'), $this->vRulesApp($data['input'], $data['for'], $data['id'], 'message'));
            if ($validator->passes()) {
                return true;
            }
            $this->vErrors = $validator->messages();
            return false;
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


            case 'updateProfile':
                $rules = [
                    'file' => 'image|mimes:jpeg,jpg,png',
                    'name' => 'required|max:255|unique:admins,name,' . $data['id'],
                    'phone' => 'required|digits:10|unique:admins,phone,' . $data['id'],
                    'email' => 'required|email|max:100|unique:admins,email,' . $data['id'],
                ];
                break;

            case 'changePassword':
                $rules = [
                    'currentPassword' => 'required',
                    'password_confirmation' => 'required',
                    'password' => 'required|min:6|max:20|confirmed',
                ];
                break;


            /*------ ( Manage Panel Start ) ------*/
            //---- ( Main Role )
            case 'saveMainRole':
                $rules = [
                    'name' => ['required', 'max:20', new UniqueManageRole([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                    ])],
                    'description' => 'required',
                ];
                break;

            case 'updateMainRole':
                $rules = [
                    'name' => ['required', 'max:20', new UniqueManageRole([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type'),
                    ])],
                    'description' => 'required',
                ];
                break;

            //---- ( Sub Role )
            case 'saveSubRole':
                $rules = [
                    'name' => ['required', 'max:20', new UniqueManageRole([
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
                    'name' => ['required', 'max:20', new UniqueManageRole([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type'),
                        'mainRoleId' => $data['input']['mainRole']
                    ])],
                    'mainRole' => 'required',
                    'description' => 'required',
                ];
                break;

            //---- ( Nav Type )
            case 'saveNavType':
                $rules = [
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:30', new UniqueManageNav([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageNav.navType.type'),
                    ])],
                    'description' => 'max:500',
                ];
                break;

            case 'updateNavType':
                $rules = [
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:30', new UniqueManageNav([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageNav.navType.type'),
                    ])],
                    'description' => 'max:500',
                ];
                break;

            //---- ( Main Nav )
            case 'saveNavMain':
                $rules = [
                    'navType' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new UniqueManageNav([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageNav.navMain.type'),
                        'navTypeId' => $data['input']['navType']
                    ])],
                    'description' => 'max:500',
                ];
                break;

            case 'updateNavMain':
                $rules = [
                    'navType' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new UniqueManageNav([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageNav.navMain.type'),
                        'navTypeId' => $data['input']['navType']
                    ])],
                    'description' => 'max:500',
                ];
                break;

            //---- ( Sub Nav )
            case 'saveNavSub':
                $rules = [
                    'navType' => 'required',
                    'navMain' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new UniqueManageNav([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageNav.navSub.type'),
                        'navTypeId' => $data['input']['navType'],
                        'mainNavId' => $data['input']['navMain']
                    ])],
                    'description' => 'max:500',
                ];
                break;

            case 'updateNavSub':
                $rules = [
                    'navType' => 'required',
                    'navMain' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new UniqueManageNav([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageNav.navSub.type'),
                        'navTypeId' => $data['input']['navType'],
                        'mainNavId' => $data['input']['navMain']
                    ])],
                    'description' => 'max:500',
                ];
                break;

            //---- ( Nested Nav )
            case 'saveNavNested':
                $rules = [
                    'navType' => 'required',
                    'navMain' => 'required',
                    'navSub' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new UniqueManageNav([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageNav.navNested.type'),
                        'navTypeId' => $data['input']['navType'],
                        'mainNavId' => $data['input']['navMain'],
                        'subNavId' => $data['input']['navSub'],
                    ])],
                    'description' => 'max:500',
                ];
                break;

            case 'updateNavNested':
                $rules = [
                    'navType' => 'required',
                    'navMain' => 'required',
                    'navSub' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new UniqueManageNav([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageNav.navNested.type'),
                        'navTypeId' => $data['input']['navType'],
                        'mainNavId' => $data['input']['navMain'],
                        'subNavId' => $data['input']['navSub'],
                    ])],
                    'description' => 'max:500',
                ];
                break;

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
            /*------ ( Manage Panel End ) ------*/


            /*------ ( Manage Users Start ) ------*/
            //---- ( Admin )
            case 'saveAdminUsers':
                $rules = [
                    'file' => 'image|mimes:jpeg,jpg,png',
                    'email' => 'required|email|max:100|unique:admins',
                    'phone' => 'required|max:100|unique:admins,phone|digits:10',
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
                    'email' => 'required|email|max:100|unique:admins,email,' . $data['id'],
                    'phone' => 'required|max:100|digits:10|unique:admins,phone,' . $data['id'],
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
                    'name' => 'required|max:255|unique:property_type,name',
                    'about' => 'max:500',
                ];
                break;
            case 'updatePropertyType':
                $rules = [
                    'name' => 'required|max:255|unique:property_type,name,' . $data['id'],
                    'about' => 'max:500',
                ];
                break;

            //---- ( Broad Type )
            case 'saveBroadType':
                $rules = [
                    'name' => 'required|max:255|unique:broad_type,name',
                    'about' => 'max:500',
                ];
                break;
            case 'updateBroadType':
                $rules = [
                    'name' => 'required|max:255|unique:broad_type,name,' . $data['id'],
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
                    'name' => 'required|max:255|unique:manage_category,name',
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
                    'name' => 'required|max:255|unique:manage_category,name,' . $data['id'],
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

    public function vRulesWeb($input, $case = 'create', $id = 0, $type)
    {
        $rules = [];
        $messages = [];

        switch ($case) {
            case 'saveContactUs':
                $rules = [
                    'name' => 'required|max:150',
                    'email' => 'required|email|max:255',
                    'phone' => 'required|digits:10',
                    'message' => 'required|max:1000',
                ];
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

        if ($type == 'rule') {
            return $rules;
        } else {
            return $messages;
        }
    }

    public function vRulesApp($input, $case = 'create', $id = 0, $type)
    {
        $rules = [];
        $messages = [];

        switch ($case) {

            case 'login':
                $rules = [
                    'phone' => 'required|digits:10',
                    'password' => 'required',
                ];
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

        if ($type == 'rule') {
            return $rules;
        } else {
            return $messages;
        }
    }

    public function getVErrorMessages($vErrors)
    {
        $ret = [];
        $messages = $vErrors->getMessages();
        if (is_array($messages) && count($messages) > 0) {
            foreach ($messages as $k => $v) {
                if (is_array($v) && array_key_exists(0, $v)) {
                    //$ret[$k] = $v[0];
                    return $v[0];
                }
            }
        }
        //return $ret;
    }
}

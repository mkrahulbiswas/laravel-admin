<?php

namespace app\Traits;

use App\Rules\UniquePhone;
use App\Rules\UniqueEmail;
use App\Rules\UniqueManageAccess;
use App\Rules\UniqueManageNav;
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
            //-------Role Main
            case 'saveRoleMain':
                $rules = [
                    'name' => ['required', 'max:20', new UniqueManageAccess([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageAccess.roleMain.type'),
                    ])],
                    'description' => 'required',
                ];
                break;

            case 'updateRoleMain':
                $rules = [
                    'name' => ['required', 'max:20', new UniqueManageAccess([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageAccess.roleMain.type'),
                    ])],
                    'description' => 'required',
                ];
                break;

            //-------Role Sub
            case 'saveRoleSub':
                $rules = [
                    'name' => ['required', 'max:20', new UniqueManageAccess([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                        'roleMainId' => $data['input']['roleMain']
                    ])],
                    'roleMain' => 'required',
                    'description' => 'required',
                ];
                break;

            case 'updateRoleSub':
                $rules = [
                    'name' => ['required', 'max:20', new UniqueManageAccess([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageAccess.roleSub.type'),
                        'roleMainId' => $data['input']['roleMain']
                    ])],
                    'roleMain' => 'required',
                    'description' => 'required',
                ];
                break;

            //-------Nav Type
            case 'saveNavType':
                $rules = [
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new UniqueManageNav([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageNav.navType.type'),
                    ])],
                    'description' => 'max:500',
                ];
                break;

            case 'updateNavType':
                $rules = [
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new UniqueManageNav([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageNav.navType.type'),
                    ])],
                    'description' => 'max:500',
                ];
                break;

            //-------Nav Main
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

            //-------Nav Sub
            case 'saveNavSub':
                $rules = [
                    'navType' => 'required',
                    'navMain' => 'required',
                    'icon' => 'required|max:150',
                    'name' => ['required', 'max:20', new UniqueManageNav([
                        'targetId' => $data['id'],
                        'type' => Config::get('constants.typeCheck.manageNav.navSub.type'),
                        'navTypeId' => $data['input']['navType'],
                        'navMainId' => $data['input']['navMain']
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
                        'navMainId' => $data['input']['navMain']
                    ])],
                    'description' => 'max:500',
                ];
                break;

            //-------Nav Nested
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
                        'navMainId' => $data['input']['navMain'],
                        'navSubId' => $data['input']['navSub'],
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
                        'navMainId' => $data['input']['navMain'],
                        'navSubId' => $data['input']['navSub'],
                    ])],
                    'description' => 'max:500',
                ];
                break;
            /*------ ( Manage Panel End ) ------*/


            /*------ ( Users Start ) ------*/
            // ---- Admin
            case 'saveAdmin':
                $rules = [
                    'file' => 'image|mimes:jpeg,jpg,png',
                    // 'email' => 'required|email|max:100|unique:admins',
                    'phone' => 'required|max:100|unique:admins,phone|digits:10',
                    'name' => 'required|max:255',
                    'password' => 'required|max:255',
                    'confirmPassword' => 'required|max:255|required_with:password|same:password',
                    'role' => 'required',
                ];
                break;

            case 'updateAdmin':
                $rules = [
                    'file' => 'image|mimes:jpeg,jpg,png',
                    // 'email' => 'required|email|max:100|unique:admins,email,' . $id,
                    'phone' => 'required|max:100|digits:10|unique:admins,phone,' . $data['id'],
                    'name' => 'required|max:255',
                    'orgName' => 'required|max:255',
                    'orgAddress' => 'required|max:255',
                    'password' => 'max:255',
                    'confirmPassword' => 'max:255|required_with:password|same:password',
                    'role' => 'required',
                ];
                break;

            // ---- updateClient
            case 'saveClient':
                $rules = [
                    'name' => 'required',
                    'phone' => ['required', 'digits:10', new UniquePhone($data['id'], config('constants.userType')['client'], '')],
                    'email' => [new UniqueEmail($data['id'], config('constants.userType')['client'], '')],
                    // 'email' => ['required', 'email', new UniqueEmail($id, config('constants.userType')['client'], '')],
                    'businessName' => 'required|max:100',
                    'businessEmail' => 'required|email|unique:users,businessEmail',
                    'businessAddress' => 'required',
                    'address' => 'required',
                    'file' => 'image|mimes:jpeg,jpg,png',
                ];
                break;

            case 'updateClient':
                $rules = [
                    'name' => 'required|max:100',
                    'phone' => ['required', 'digits:10', new UniquePhone($data['id'], config('constants.userType')['client'], '')],
                    'email' => [new UniqueEmail($data['id'], config('constants.userType')['client'], '')],
                    // 'email' => ['required', 'email', new UniqueEmail($id, config('constants.userType')['client'], '')],
                    'businessName' => 'required|max:100',
                    'businessEmail' => 'required|email|unique:users,businessEmail,' . $data['id'],
                    'businessAddress' => 'required',
                    'address' => 'required',
                    'file' => 'image|mimes:jpeg,jpg,png',
                ];
                break;
            /*------ ( Users End ) ------*/


            /*------ ( CMS Start ) ------*/
            //---Logo
            case 'saveLogo':
                $rules = [
                    'bigLogo' => 'required|mimes:jpeg,jpg,png,ico',
                    'smallLogo' => 'mimes:jpeg,jpg,png,ico',
                    'favIcon' => 'mimes:jpeg,jpg,png,ico',
                ];
                break;

            case 'updateLogo':
                $rules = [
                    'bigLogo' => 'mimes:jpeg,jpg,png,ico',
                    'smallLogo' => 'mimes:jpeg,jpg,png,ico',
                    'favIcon' => 'mimes:jpeg,jpg,png,ico',
                ];
                break;
            /*------ ( CMS End ) ------*/

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

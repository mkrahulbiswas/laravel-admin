<?php

namespace App\Rules\ManagePanel;

use App\Models\AdminRelated\NavigationAccess\ManageSideNav\MainNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\NavType;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\NestedNav;
use App\Models\AdminRelated\NavigationAccess\ManageSideNav\SubNav;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Config;

class UniqueManageNav implements ValidationRule
{
    private $data;

    public function __construct($data, public string $message = 'The :attribute is already taken.')
    {
        $this->data = $data;
    }

    public function validate(string $attribute, mixed $value, Closure $fail, array $parameters = []): void
    {
        if ($this->data['type'] == Config::get('constants.adminRelated.navigationAccess.manageSideNav.navType.type')) {
            if ($this->data['targetId'] == '') {
                $isExist = NavType::where('name', $value)->get();
            } else {
                $isExist = NavType::where([
                    ['name', $value],
                    ['id', '!=', $this->data['targetId']]
                ])->get();
            }
            if ($isExist->count() > 0) {
                $fail($this->message);
            }
        }

        if ($this->data['type'] == Config::get('constants.adminRelated.navigationAccess.manageSideNav.mainNav.type')) {
            if ($this->data['targetId'] == '') {
                $isExist = MainNav::where([
                    ['name', $value],
                    ['navTypeId', decrypt($this->data['navTypeId'])],
                ])->get();
            } else {
                $isExist = MainNav::where([
                    ['name', $value],
                    ['navTypeId', decrypt($this->data['navTypeId'])],
                    ['id', '!=', $this->data['targetId']]
                ])->get();
            }
            if ($isExist->count() > 0) {
                $fail($this->message);
            }
        }

        if ($this->data['type'] == Config::get('constants.adminRelated.navigationAccess.manageSideNav.subNav.type')) {
            if ($this->data['targetId'] == '') {
                $isExist = SubNav::where([
                    ['name', $value],
                    ['navTypeId', decrypt($this->data['navTypeId'])],
                    ['mainNavId', decrypt($this->data['mainNavId'])],
                ])->get();
            } else {
                $isExist = SubNav::where([
                    ['name', $value],
                    ['navTypeId', decrypt($this->data['navTypeId'])],
                    ['mainNavId', decrypt($this->data['mainNavId'])],
                    ['id', '!=', $this->data['targetId']]
                ])->get();
            }
            if ($isExist->count() > 0) {
                $fail($this->message);
            }
        }

        if ($this->data['type'] == Config::get('constants.adminRelated.navigationAccess.manageSideNav.nestedNav.type')) {
            if ($this->data['targetId'] == '') {
                $isExist = NestedNav::where([
                    ['name', $value],
                    ['navTypeId', decrypt($this->data['navTypeId'])],
                    ['mainNavId', decrypt($this->data['mainNavId'])],
                    ['subNavId', decrypt($this->data['subNavId'])],
                ])->get();
            } else {
                $isExist = NestedNav::where([
                    ['name', $value],
                    ['navTypeId', decrypt($this->data['navTypeId'])],
                    ['mainNavId', decrypt($this->data['mainNavId'])],
                    ['subNavId', decrypt($this->data['subNavId'])],
                    ['id', '!=', $this->data['targetId']]
                ])->get();
            }
            if ($isExist->count() > 0) {
                $fail($this->message);
            }
        }
    }
}

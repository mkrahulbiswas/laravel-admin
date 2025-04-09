<?php

namespace App\Rules;

use App\Models\AdminSetting\Nav\NavMain;
use App\Models\AdminSetting\Nav\NavNested;
use App\Models\AdminSetting\Nav\NavSub;
use App\Models\AdminSetting\Nav\NavType;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueManageNav implements Rule
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function passes($attribute, $value)
    {
        if ($this->data['type'] == 'navType') {
            if ($this->data['targetId'] == '') {
                $isExist = NavType::where('name', $value)->get();
            } else {
                $isExist = NavType::where([
                    ['name', $value],
                    ['id', '!=', $this->data['targetId']]
                ])->get();
            }
            if ($isExist->count() > 0) {
                return false;
            } else {
                return true;
            }
        }

        if ($this->data['type'] == 'navMain') {
            if ($this->data['targetId'] == '') {
                $isExist = NavMain::where([
                    ['name', $value],
                    ['navTypeId', decrypt($this->data['navTypeId'])],
                ])->get();
            } else {
                $isExist = NavMain::where([
                    ['name', $value],
                    ['navTypeId', decrypt($this->data['navTypeId'])],
                    ['id', '!=', $this->data['targetId']]
                ])->get();
            }
            if ($isExist->count() > 0) {
                return false;
            } else {
                return true;
            }
        }

        if ($this->data['type'] == 'navSub') {
            if ($this->data['targetId'] == '') {
                $isExist = NavSub::where([
                    ['name', $value],
                    ['navTypeId', decrypt($this->data['navTypeId'])],
                    ['navMainId', decrypt($this->data['navMainId'])],
                ])->get();
            } else {
                $isExist = NavSub::where([
                    ['name', $value],
                    ['navTypeId', decrypt($this->data['navTypeId'])],
                    ['navMainId', decrypt($this->data['navMainId'])],
                    ['id', '!=', $this->data['targetId']]
                ])->get();
            }
            if ($isExist->count() > 0) {
                return false;
            } else {
                return true;
            }
        }

        if ($this->data['type'] == 'navNested') {
            if ($this->data['targetId'] == '') {
                $isExist = NavNested::where([
                    ['name', $value],
                    ['navTypeId', decrypt($this->data['navTypeId'])],
                    ['navMainId', decrypt($this->data['navMainId'])],
                    ['navSubId', decrypt($this->data['navSubId'])],
                ])->get();
            } else {
                $isExist = NavNested::where([
                    ['name', $value],
                    ['navTypeId', decrypt($this->data['navTypeId'])],
                    ['navMainId', decrypt($this->data['navMainId'])],
                    ['navSubId', decrypt($this->data['navSubId'])],
                    ['id', '!=', $this->data['targetId']]
                ])->get();
            }
            if ($isExist->count() > 0) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function message()
    {
        if ($this->data['type'] == 'navType') {
            return 'Nav type :attribute is already taken';
        }
        if ($this->data['type'] == 'navMain') {
            return 'Nav main :attribute is already taken';
        }
        if ($this->data['type'] == 'navSub') {
            return 'Nav sub :attribute is already taken';
        }
        if ($this->data['type'] == 'navNested') {
            return 'Nav nested :attribute is already taken';
        }
    }
}

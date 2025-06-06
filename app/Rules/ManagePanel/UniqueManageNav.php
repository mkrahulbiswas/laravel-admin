<?php

namespace App\Rules\ManagePanel;

use App\Models\ManagePanel\ManageNav\NavMain;
use App\Models\ManagePanel\ManageNav\NavNested;
use App\Models\ManagePanel\ManageNav\NavSub;
use App\Models\ManagePanel\ManageNav\NavType;

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
        if ($this->data['type'] == Config::get('constants.typeCheck.manageNav.navType.type')) {
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

        if ($this->data['type'] == Config::get('constants.typeCheck.manageNav.navMain.type')) {
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
                $fail($this->message);
            }
        }

        if ($this->data['type'] == Config::get('constants.typeCheck.manageNav.navSub.type')) {
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
                $fail($this->message);
            }
        }

        if ($this->data['type'] == Config::get('constants.typeCheck.manageNav.navNested.type')) {
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
                $fail($this->message);
            }
        }
    }
}

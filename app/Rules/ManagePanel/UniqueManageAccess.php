<?php

namespace App\Rules\ManagePanel;

use App\Models\ManagePanel\ManageAccess\RoleMain;
use App\Models\ManagePanel\ManageAccess\RoleSub;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Config;

class UniqueManageAccess implements ValidationRule
{
    private $data;

    public function __construct($data, public string $message = 'The :attribute is already taken.')
    {
        $this->data = $data;
    }

    public function validate(string $attribute, mixed $value, Closure $fail, array $parameters = []): void
    {
        if ($this->data['type'] == Config::get('constants.typeCheck.manageAccess.roleMain.type')) {
            if ($this->data['targetId'] == '') {
                $isExist = RoleMain::where('name', $value)->get();
            } else {
                $isExist = RoleMain::where([
                    ['name', $value],
                    ['id', '!=', $this->data['targetId']]
                ])->get();
            }
            if ($isExist->count() > 0) {
                $fail($this->message);
            }
        }

        if ($this->data['type'] == Config::get('constants.typeCheck.manageAccess.roleSub.type')) {
            if ($this->data['targetId'] == '') {
                $isExist = RoleSub::where('name', $value)->get();
            } else {
                $isExist = RoleSub::where([
                    ['name', $value],
                    ['roleMainId', decrypt($this->data['roleMainId'])],
                    ['id', '!=', $this->data['targetId']]
                ])->get();
            }
            if ($isExist->count() > 0) {
                $fail($this->message);
            }
        }
    }
}

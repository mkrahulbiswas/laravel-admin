<?php

namespace App\Rules\ManagePanel;

use Closure;
use App\Models\AdminRelated\RolePermission\ManageRole\MainRole;
use App\Models\AdminRelated\RolePermission\ManageRole\SubRole;
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
        if ($this->data['type'] == Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.mainRole.type')) {
            if ($this->data['targetId'] == '') {
                $isExist = MainRole::where('name', $value)->get();
            } else {
                $isExist = MainRole::where([
                    ['name', $value],
                    ['id', '!=', $this->data['targetId']]
                ])->get();
            }
            if ($isExist->count() > 0) {
                $fail($this->message);
            }
        }

        if ($this->data['type'] == Config::get('constants.typeCheck.adminRelated.rolePermission.manageRole.subRole.type')) {
            if ($this->data['targetId'] == '') {
                $isExist = SubRole::where('name', $value)->get();
            } else {
                $isExist = SubRole::where([
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

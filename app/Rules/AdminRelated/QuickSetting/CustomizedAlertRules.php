<?php

namespace App\Rules\AdminRelated\QuickSetting;

use Closure;
use App\Models\AdminRelated\QuickSetting\CustomizedAlert\AlertFor;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Config;

class CustomizedAlertRules implements ValidationRule
{
    private $data;

    public function __construct($data, public string $message = 'The :attribute is already taken.')
    {
        $this->data = $data;
    }

    public function validate(string $attribute, mixed $value, Closure $fail, array $parameters = []): void
    {
        if ($this->data['type'] == Config::get('constants.typeCheck.adminRelated.quickSetting.customizedAlert.alertFor.type')) {
            if ($this->data['targetId'] == '') {
                $isExist = AlertFor::where([
                    ['name', $value],
                    ['alertTypeId', decrypt($this->data['alertType'])],
                ])->get();
            } else {
                $isExist = AlertFor::where([
                    ['name', $value],
                    ['alertTypeId', decrypt($this->data['alertType'])],
                    ['id', '!=', $this->data['targetId']]
                ])->get();
            }
            if ($isExist->count() > 0) {
                $fail($this->message);
            }
        }
    }
}

<?php

namespace App\Rules;

use App\Models\User;

use Illuminate\Contracts\Validation\Rule;

class UniquePhone implements Rule
{
    private $id;
    private $userType;
    private $provider;

    public function __construct($id, $userType, $provider)
    {
        $this->id = $id;
        $this->userType = $userType;
        $this->provider = $provider;
    }

    public function passes($attribute, $value)
    {
        if (empty($this->provider)) {
            if ($this->id == 0) {
                $isPhoneExist = User::where([
                    ['phone', $value],
                    ['userType', $this->userType]
                ])->get();
            } else {
                $isPhoneExist = User::where([
                    ['phone', $value],
                    ['userType', $this->userType]
                ])->where('id', '!=', $this->id)->get();
            }
            if ($isPhoneExist->count() > 0) {
                return false;
            }
            return true;
        } else {
            return true;
        }
    }

    public function message()
    {
        return 'The :attribute number has already been taken.';
    }
}

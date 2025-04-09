<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;


class UniqueEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

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
                    ['email', $value],
                    ['userType', $this->userType]
                ])->get();
            } else {
                $isPhoneExist = User::where([
                    ['email', $value],
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
        return 'The :attribute has already been taken.';
    }
}

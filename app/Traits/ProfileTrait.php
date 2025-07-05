<?php

namespace app\Traits;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Models\User;
use Exception;

trait ProfileTrait
{
    use CommonTrait, FileTrait;


    public function getProfileInfo($userId, $platform)
    {
        try {
            $user = User::findOrFail($userId);
            $data = array(
                'userId' => $user->id,
                'email' => $user->email,
                'phone' => $user->phone,
                'dialCode' => $user->dialCode,
                'name' => $user->name,
            );
            return $data;
        } catch (Exception $e) {
            return false;
        }
    }
}

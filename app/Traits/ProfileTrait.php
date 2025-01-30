<?php

namespace app\Traits;

use Illuminate\Support\Facades\Auth;

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
            if ($user->userType == config('constants.userType')['customers']) {
                $data = array(
                    'userId' => $user->id,
                    'image' => $this->picUrl($user->image, 'customersPic', $this->platform),
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'name' => $user->name,
                );
            } else {
                $data = array(
                    'userId' => $user->id,
                    'image' => $this->picUrl($user->image, 'deliveryBoyPic', $this->platform),
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'name' => $user->name,
                );
            }
            return $data;
        } catch (Exception $e) {
            return false;
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'postalCode',
        'deviceToken',
        'deviceType',
        'profilePic',
        'role_id',
        'status',
        'isPwChange'
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];
}

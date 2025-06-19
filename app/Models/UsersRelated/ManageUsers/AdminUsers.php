<?php

namespace App\Models\UsersRelated\ManageUsers;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUsers extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'admins';
    protected $fillable = ['name', 'email', 'phone', 'image', 'status'];
    protected $hidden = ['password', 'remember_token'];
}

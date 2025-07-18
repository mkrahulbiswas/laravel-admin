<?php

namespace App\Models\UsersRelated;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersInfo extends Model
{
    use SoftDeletes;
    protected $table = 'users_info';
    protected $fillable = array('userType');
}

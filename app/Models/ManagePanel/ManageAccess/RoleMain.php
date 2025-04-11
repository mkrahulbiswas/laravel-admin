<?php

namespace App\Models\ManagePanel\ManageAccess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleMain extends Model
{
    use SoftDeletes;
    protected $table = 'role_main';
    protected $fillable = array(
        'status',
    );
}

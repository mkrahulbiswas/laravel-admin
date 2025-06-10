<?php

namespace App\Models\AdminRelated\RolePermission\ManageRole;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainRole extends Model
{
    use SoftDeletes;
    protected $table = 'main_role';
    protected $fillable = array(
        'status',
    );
}

<?php

namespace App\Models\AdminRelated\RolePermission\ManagePermission;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;
    protected $table = 'permission';
    protected $fillable = array(
        'status',
    );
}

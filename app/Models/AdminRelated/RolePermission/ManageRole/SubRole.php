<?php

namespace App\Models\AdminRelated\RolePermission\ManageRole;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubRole extends Model
{
    use SoftDeletes;
    protected $table = 'sub_role';
    protected $fillable = array(
        'status',
    );
}

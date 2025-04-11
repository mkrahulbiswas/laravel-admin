<?php

namespace App\Models\ManagePanel\ManageAccess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleSub extends Model
{
    use SoftDeletes;
    protected $table = 'role_sub';
    protected $fillable = array(
        'status',
    );
}

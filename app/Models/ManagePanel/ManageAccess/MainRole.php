<?php

namespace App\Models\ManageAccess\ManageNav;

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

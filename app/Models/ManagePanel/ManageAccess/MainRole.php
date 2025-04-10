<?php

namespace App\Models\ManageAccess\ManageNav;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainRole extends Model
{
    use SoftDeletes;
    protected $table = 'nav_main';
    protected $fillable = array(
        'status',
    );
}

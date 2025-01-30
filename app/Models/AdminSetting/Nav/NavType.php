<?php

namespace App\Models\AdminSetting\Nav;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NavType extends Model
{
    use SoftDeletes;
    protected $table = 'nav_type';
    protected $fillable = array(
        'status',
    );
}

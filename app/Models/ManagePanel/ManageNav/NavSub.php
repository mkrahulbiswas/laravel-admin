<?php

namespace App\Models\ManagePanel\ManageNav;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NavSub extends Model
{
    use SoftDeletes;
    protected $table = 'nav_sub';
    protected $fillable = array(
        'status',
    );
}

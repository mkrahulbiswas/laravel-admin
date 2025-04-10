<?php

namespace App\Models\ManagePanel\ManageNav;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NavMain extends Model
{
    use SoftDeletes;
    protected $table = 'nav_main';
    protected $fillable = array(
        'status',
    );
}

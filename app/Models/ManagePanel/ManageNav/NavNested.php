<?php

namespace App\Models\ManagePanel\ManageNav;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NavNested extends Model
{
    use SoftDeletes;
    protected $table = 'nav_nested';
    protected $fillable = array(
        'status',
    );
}

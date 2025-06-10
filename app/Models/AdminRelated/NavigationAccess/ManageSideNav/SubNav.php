<?php

namespace App\Models\AdminRelated\NavigationAccess\ManageSideNav;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubNav extends Model
{
    use SoftDeletes;
    protected $table = 'sub_nav';
    protected $fillable = array(
        'status',
    );
}

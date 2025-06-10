<?php

namespace App\Models\AdminRelated\NavigationAccess\ManageSideNav;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainNav extends Model
{
    use SoftDeletes;
    protected $table = 'main_nav';
    protected $fillable = array(
        'status',
    );
}

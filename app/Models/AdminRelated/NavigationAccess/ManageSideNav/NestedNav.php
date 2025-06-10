<?php

namespace App\Models\AdminRelated\NavigationAccess\ManageSideNav;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NestedNav extends Model
{
    use SoftDeletes;
    protected $table = 'nested_nav';
    protected $fillable = array(
        'status',
    );
}

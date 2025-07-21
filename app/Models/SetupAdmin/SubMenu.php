<?php

namespace App\Models\SetupAdmin;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $table = 'sub_module';
    protected $fillable = array(
        'module_id',
        'name',
        'link',
        'last_segment',
        'add_action',
        'edit_action',
        'details_action',
        'delete_action',
        'status_action',
        'other_action',
        'status'
    );
}

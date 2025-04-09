<?php

namespace App\Models\SetupAdmin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $fillable = array('role', 'description', 'status');
}

<?php

namespace App\Models\SetupAdmin;

use Illuminate\Database\Eloquent\Model;

class MainMenu extends Model
{
    protected $table = 'module';
    protected $fillable = array('name', 'icon', 'status');
}

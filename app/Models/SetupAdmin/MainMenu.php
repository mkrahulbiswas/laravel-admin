<?php

namespace App\Models\SetupAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainMenu extends Model
{
    use HasFactory;

    protected $table = 'module';
    protected $fillable = array('name', 'icon', 'status');
}
<?php

namespace App\Models\PropertyRelated\PropertyInstance\PropertyCategory;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ManageCategory extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'manage_category';
    protected $fillable = ['status'];
}

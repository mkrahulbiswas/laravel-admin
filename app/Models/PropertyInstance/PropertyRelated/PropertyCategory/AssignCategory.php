<?php

namespace App\Models\PropertyInstance\PropertyRelated\PropertyCategory;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AssignCategory extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'assign_category';
    protected $fillable = ['status'];
}

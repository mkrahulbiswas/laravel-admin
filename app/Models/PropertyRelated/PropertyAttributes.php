<?php

namespace App\Models\PropertyRelated;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PropertyAttributes extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'property_attributes';
    protected $fillable = ['status'];
}

<?php

namespace App\Models\PropertyRelated\PropertyInstance;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PropertyType extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'property_type';
    protected $fillable = ['status'];
}

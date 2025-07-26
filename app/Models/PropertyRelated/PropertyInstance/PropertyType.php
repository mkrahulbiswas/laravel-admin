<?php

namespace App\Models\PropertyRelated\PropertyInstance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyType extends Model
{
    use SoftDeletes;

    protected $table = 'property_type';
    protected $fillable = ['status'];
}

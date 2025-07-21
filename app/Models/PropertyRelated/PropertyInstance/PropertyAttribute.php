<?php

namespace App\Models\PropertyRelated\PropertyInstance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyAttribute extends Model
{
    use SoftDeletes;

    protected $table = 'property_attribute';
    protected $fillable = ['status'];
}

<?php

namespace App\Models\PropertyRelated\PropertyInstance\PropertyCategory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignCategory extends Model
{
    use SoftDeletes;

    protected $table = 'assign_category';
    protected $fillable = ['status'];
}

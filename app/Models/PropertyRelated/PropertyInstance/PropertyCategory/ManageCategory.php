<?php

namespace App\Models\PropertyRelated\PropertyInstance\PropertyCategory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManageCategory extends Model
{
    use SoftDeletes;

    protected $table = 'manage_category';
    protected $fillable = ['status'];
}

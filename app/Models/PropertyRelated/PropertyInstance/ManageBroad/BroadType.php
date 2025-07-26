<?php

namespace App\Models\PropertyRelated\PropertyInstance\ManageBroad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BroadType extends Model
{
    use SoftDeletes;

    protected $table = 'broad_type';
    protected $fillable = ['status'];
}

<?php

namespace App\Models\PropertyRelated\PropertyInstance\ManageBroad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignBroad extends Model
{
    use SoftDeletes;

    protected $table = 'assign_broad';
    protected $fillable = ['status'];
}

<?php

namespace App\Models\PropertyRelated\PropertyCategory;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AssignBroad extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'assign_broad';
    protected $fillable = ['status'];
}

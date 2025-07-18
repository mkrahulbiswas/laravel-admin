<?php

namespace App\Models\PropertyRelated\PropertyInstance\ManageBroad;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BroadType extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'broad_type';
    protected $fillable = ['status'];
}

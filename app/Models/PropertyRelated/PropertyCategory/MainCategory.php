<?php

namespace App\Models\PropertyRelated\PropertyCategory;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MainCategory extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'main_category';
    protected $fillable = ['status'];
}

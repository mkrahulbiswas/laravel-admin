<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Units extends Model
{
    use SoftDeletes;
    protected $table = 'units';
    protected $fillable = array('name', 'status');
}

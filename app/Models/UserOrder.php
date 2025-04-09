<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $table = 'userOrder';
    protected $fillable = array('userId', 'status');
}

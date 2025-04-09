<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeZone extends Model
{
    protected $table = 'time_zone';
    protected $fillable = array(
        'zoneUtc',
        'zoneName'
    );
}

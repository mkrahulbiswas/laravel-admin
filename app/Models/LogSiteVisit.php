<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogSiteVisit extends Model
{
    protected $table = 'logSiteVisit';
    protected $fillable = array('state');
}

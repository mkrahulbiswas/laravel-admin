<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogSiteVisit extends Model
{
    protected $table = 'log_site_visit';
    protected $fillable = array('state');
}

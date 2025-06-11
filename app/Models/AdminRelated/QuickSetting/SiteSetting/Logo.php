<?php

namespace App\Models\AdminRelated\QuickSetting\SiteSetting;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $table = 'logo';
    protected $fillable = array('bigLogo', 'smallLogo', 'favicon');
}

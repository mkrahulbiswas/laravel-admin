<?php

namespace App\Models\ManagePanel\QuickSettings;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $table = 'logo';
    protected $fillable = array('bigLogo', 'smallLogo', 'favicon');
}

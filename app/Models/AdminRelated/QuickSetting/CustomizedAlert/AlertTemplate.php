<?php

namespace App\Models\AdminRelated\QuickSetting\CustomizedAlert;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlertTemplate extends Model
{
    use SoftDeletes;
    protected $table = 'alert_template';
    protected $fillable = array(
        'default',
    );
}

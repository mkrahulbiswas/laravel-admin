<?php

namespace App\Models\AdminRelated\QuickSetting\CustomizedAlert;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlertFor extends Model
{
    use SoftDeletes;
    protected $table = 'alert_for';
    protected $fillable = array(
        'status',
    );
}

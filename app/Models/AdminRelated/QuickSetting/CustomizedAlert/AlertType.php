<?php

namespace App\Models\AdminRelated\QuickSetting\CustomizedAlert;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlertType extends Model
{
    use SoftDeletes;
    protected $table = 'alert_type';
    protected $fillable = array(
        'status',
    );
}

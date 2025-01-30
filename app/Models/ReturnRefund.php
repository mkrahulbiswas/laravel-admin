<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRefund extends Model
{
    protected $table = 'return_refund';
    protected $fillable = array(
        'return',
        'refund'
    );
}

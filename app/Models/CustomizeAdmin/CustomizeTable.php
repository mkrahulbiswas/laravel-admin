<?php

namespace App\Models\CustomizeAdmin;

use Illuminate\Database\Eloquent\Model;

class CustomizeTable extends Model
{
    protected $table = 'table';
    protected $fillable = array(
        'headBackColor',
        'headTextColor',
        'headHoverBackColor',
        'headHoverTextColor',
        'bodyBackColor',
        'bodyTextColor',
        'bodyHoverBackColor',
        'bodyHoverTextColor',
        'headTableStyle',
        'bodyTableStyle',
        'status'
    );
}

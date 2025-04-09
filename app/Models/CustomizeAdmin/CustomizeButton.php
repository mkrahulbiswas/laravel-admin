<?php

namespace App\Models\CustomizeAdmin;

use Illuminate\Database\Eloquent\Model;

class CustomizeButton extends Model
{
    protected $table = 'button';
    protected $fillable = array('btnIcon', 'backColor', 'textColor', 'backHoverColor', 'textHoverColor', 'btnFor', 'status');
}

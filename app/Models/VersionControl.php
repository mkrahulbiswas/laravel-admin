<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VersionControl extends Model
{
    protected $table = 'version_control';
    protected $fillable = array(
        'appVersion',
    );
}

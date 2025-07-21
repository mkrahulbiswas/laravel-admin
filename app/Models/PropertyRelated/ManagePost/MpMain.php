<?php

namespace App\Models\PropertyRelated\ManagePost;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MpMain extends Model
{
    use SoftDeletes;

    protected $table = 'mp_main';
    protected $fillable = ['status'];
}

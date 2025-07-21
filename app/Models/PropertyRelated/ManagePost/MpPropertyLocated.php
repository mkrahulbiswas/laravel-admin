<?php

namespace App\Models\PropertyRelated\ManagePost;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MpPropertyLocated extends Model
{
    use SoftDeletes;

    protected $table = 'mp_property_located';
    protected $fillable = ['mpMainId'];
}

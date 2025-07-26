<?php

namespace App\Models\PropertyRelated\ManagePost;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MpAboutProperty extends Model
{
    use SoftDeletes;

    protected $table = 'mp_about_property';
    protected $fillable = ['mpMainId'];
}

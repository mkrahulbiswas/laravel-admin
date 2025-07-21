<?php

namespace App\Models\PropertyRelated\ManagePost;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MpBasicDetails extends Model
{
    use SoftDeletes;

    protected $table = 'mp_basic_details';
    protected $fillable = ['mpMainId'];
}

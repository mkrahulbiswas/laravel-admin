<?php

namespace App\Models\CustomizeAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loader extends Model
{
    use HasFactory;

    protected $table = 'loader';
    protected $fillable = array(
        'raw',
        'image',
        'loaderType',
        'pageLoader',
        'internalLoader'
    );
}

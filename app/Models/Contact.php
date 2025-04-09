<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';
    protected $fillable = array(
        'officeType',
        'officeHeading',
        'address',
        'country',
        'state',
        'district',
        'pin',
        'city',
        'email',
        'phone'
    );
}

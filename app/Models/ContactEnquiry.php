<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactEnquiry extends Model
{
    protected $table = 'contact_enquiry';
    protected $fillable = array(
        'phone'
    );
}

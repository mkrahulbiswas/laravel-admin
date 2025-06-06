<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassword extends Mailable
{

    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {

        $this->data = $data;
    }


    public function build()
    {
        $datas = array(
            'name' => $this->data['name'],
            'password' => $this->data['password']
        );
        return $this->from(config('constants.companyEmail'))
            ->subject('OTP')
            ->view('admin.mail.mailOtp')
            ->with($datas);
    }
}

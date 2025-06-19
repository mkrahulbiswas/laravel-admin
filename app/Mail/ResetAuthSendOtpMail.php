<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class ResetAuthSendOtpMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'],
            from: new Address(env('MAIL_FROM_ADDRESS', 'hello@example.com'), env('MAIL_FROM_NAME', 'Example')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin.mail.reset_otp_mail',
            with: $this->data,
        );
    }

    public function attachments(): array
    {
        return [];
    }

    public function headers(): Headers
    {
        return new Headers();
    }
}

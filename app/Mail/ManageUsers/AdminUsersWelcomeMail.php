<?php

namespace App\Mail\ManageUsers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class AdminUsersWelcomeMail extends Mailable
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
            subject: 'Admin Users Welcome Mail',
            // from: new Address(env('MAIL_FROM_ADDRESS', 'hello@example.com'), env('MAIL_FROM_NAME', 'Example')),
            // replyTo: [
            //     new Address('taylor@example.com', 'Taylor Otwell'),
            // ],
            // tags: ['shipment'],
            // metadata: [
            //     'order_id' => 'ssss',
            // ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin.mail.admin_users_welcome_mail', //For Complex Html
            // text: 'admin.mail.admin_users_welcome_mail' //For Simple Text
            // with: [
            //     'orderName' => 'Rahul',
            //     'orderPrice' => '100',
            // ],
        );
    }

    public function attachments(): array
    {
        return [];
    }

    public function headers(): Headers
    {
        return new Headers(
            // messageId: 'custom-message-id@example.com',
            // references: ['previous-message@example.com'],
            // text: [
            //     'X-Custom-Header' => 'Custom Value',
            // ],
        );
    }
}

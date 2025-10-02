<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('messages.confirmation_email_subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user-confirmation',
            with: ['data' => $this->data]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
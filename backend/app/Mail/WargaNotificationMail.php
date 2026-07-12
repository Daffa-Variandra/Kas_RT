<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WargaNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $messageContent;
    public $userName;

    public function __construct($subjectLine, $messageContent, $userName)
    {
        $this->subjectLine = $subjectLine;
        $this->messageContent = $messageContent;
        $this->userName = $userName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.warga-notification',
            with: [
                'userName' => $this->userName,
                'messageContent' => $this->messageContent,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

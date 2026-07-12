<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LetterStatusUpdated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $letter;

    public function __construct($letter)
    {
        $this->letter = $letter;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $status = $this->letter->status === 'approved' ? 'disetujui' : 'ditolak';
        return [
            'title' => 'Status Surat ' . ucfirst($status),
            'message' => 'Permohonan ' . $this->letter->letter_type . ' Anda telah ' . $status . '.',
            'url' => route('warga.letters.index'),
            'icon' => $this->letter->status === 'approved' ? 'check-circle' : 'x-circle'
        ];
    }
}

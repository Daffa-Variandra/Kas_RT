<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComplaintStatusUpdated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $complaint;

    public function __construct($complaint)
    {
        $this->complaint = $complaint;
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
        return [
            'title' => 'Status Aspirasi Diperbarui',
            'message' => 'Laporan "' . $this->complaint->title . '" Anda sekarang berstatus ' . $this->complaint->status . '.',
            'url' => route('warga.complaints.index'),
            'icon' => 'information-circle'
        ];
    }
}

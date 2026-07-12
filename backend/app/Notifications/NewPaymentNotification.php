<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewPaymentNotification extends Notification
{
    use Queueable;

    protected $payment;

    /**
     * Create a new notification instance.
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
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
            'title' => 'Pembayaran Baru Masuk',
            'message' => $this->payment->user->name . ' telah melakukan pembayaran ' . $this->payment->contribution->nama_iuran . ' sebesar Rp ' . number_format($this->payment->jumlah_bayar, 0, ',', '.') . '. Mohon segera diverifikasi.',
            'status' => 'pending',
            'payment_id' => $this->payment->id
        ];
    }
}

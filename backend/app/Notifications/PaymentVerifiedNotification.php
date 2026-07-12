<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentVerifiedNotification extends Notification
{
    use Queueable;

    protected $payment;
    protected $status;

    public function __construct($payment, $status)
    {
        $this->payment = $payment;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $statusText = $this->status == 'success' ? 'Berhasil Divalidasi' : 'Ditolak';
        $iuranName = $this->payment->contribution->nama_iuran ?? 'Iuran';

        return [
            'payment_id' => $this->payment->id,
            'title' => "Pembayaran $statusText",
            'message' => "Pembayaran untuk $iuranName sejumlah Rp " . number_format($this->payment->jumlah_bayar, 0, ',', '.') . " telah " . strtolower($statusText) . ".",
            'status' => $this->status,
        ];
    }
}

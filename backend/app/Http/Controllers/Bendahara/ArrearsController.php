<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Resident;
use App\Services\EmailNotificationService;

class ArrearsController extends Controller
{
    public function index()
    {
        $arrears = Payment::with(['user', 'contribution'])
            ->where('status', 'unpaid')
            ->orderBy('created_at', 'asc')
            ->get();
            
        return view('bendahara.arrears', compact('arrears'));
    }

    public function sendReminder(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        
        $resident = Resident::where('family_id', $payment->user->family->id ?? 0)
                    ->where('status_keluarga', 'Kepala Keluarga')
                    ->first();

        $subject = "Pengingat Tagihan: " . ($payment->contribution->nama_iuran ?? 'Iuran Warga');
        $msg = "Kami ingin mengingatkan bahwa tagihan **{$payment->contribution->nama_iuran}** sebesar **Rp " . number_format($payment->jumlah_bayar, 0, ',', '.') . "** masih berstatus **BELUM DIBAYAR**.\n\n";
        $msg .= "Mohon segera melakukan pembayaran via aplikasi Smart RW agar status tagihan Anda dapat segera diperbarui. Terima kasih atas kerjasamanya.";
        
        // Try sending email
        $sent = EmailNotificationService::send($payment->user, $subject, $msg);
        
        if ($sent) {
            return redirect()->back()->with('success', "Pesan pengingat email berhasil dikirim ke {$payment->user->name}.");
        } else {
            return redirect()->back()->with('success', "Proses selesai, namun email gagal dikirim ke {$payment->user->name}. Pastikan Konfigurasi SMTP di .env sudah benar.");
        }
    }
}

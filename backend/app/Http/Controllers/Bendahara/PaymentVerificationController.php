<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Resident;
use Illuminate\Http\Request;
use App\Services\WhatsAppService;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'contribution'])
                    ->orderByRaw("FIELD(status, 'pending', 'success', 'failed')")
                    ->latest()
                    ->get();

        return view('bendahara.verification', compact('payments'));
    }

    public function updateStatus(Request $request, $id, WhatsAppService $waService)
    {
        $payment = Payment::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:success,failed'
        ]);

        $payment->update([
            'status' => $request->status
        ]);

        // Send Notification to Warga (In App)
        $payment->user->notify(new \App\Notifications\PaymentVerifiedNotification($payment, $request->status));

        // Send WA Notification
        $resident = Resident::where('family_id', $payment->user->family->id ?? 0)
                    ->where('status_keluarga', 'Kepala Keluarga')
                    ->first();

        if ($resident && $resident->no_hp) {
            if ($request->status == 'success') {
                $msg = "Terima kasih, Bpk/Ibu {$resident->nama}.\n\n";
                $msg .= "Pembayaran *{$payment->contribution->nama_iuran}* sebesar Rp " . number_format($payment->jumlah_bayar, 0, ',', '.') . " telah berhasil diverifikasi.\n\n";
                $msg .= "Struk digital ini sah sebagai bukti pembayaran Smart RW.";
            } else {
                $msg = "Mohon maaf Bpk/Ibu {$resident->nama},\n\n";
                $msg .= "Verifikasi pembayaran *{$payment->contribution->nama_iuran}* Anda ditolak oleh Bendahara.\n";
                $msg .= "Mohon cek ulang bukti transfer Anda di aplikasi Smart RW.";
            }
            $waService->sendMessage($resident->no_hp, $msg);
        }

        $pesan = $request->status == 'success' ? 'Pembayaran berhasil disetujui!' : 'Pembayaran ditolak!';
        
        return redirect()->route('bendahara.verification.index')->with('success', $pesan);
    }
}
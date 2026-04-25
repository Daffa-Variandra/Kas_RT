<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

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

    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:success,failed'
        ]);

        $payment->update([
            'status' => $request->status
        ]);

        $pesan = $request->status == 'success' ? 'Pembayaran berhasil disetujui!' : 'Pembayaran ditolak!';
        
        return redirect()->back()->with('success', $pesan);
    }
}
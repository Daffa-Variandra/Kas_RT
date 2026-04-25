<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        $contributions = Contribution::all();
        $payments = Payment::where('user_id', auth()->id())->latest()->get();
        
        return view('warga.payments', compact('contributions', 'payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contribution_id' => 'required|exists:contributions,id',
            'jumlah_bayar' => 'required|numeric|min:1',
            'tanggal_bayar' => 'required|date',
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        
        $buktiPath = $request->file('bukti_bayar')->store('bukti_bayar', 'public');

        Payment::create([
            'user_id' => auth()->id(),
            'contribution_id' => $request->contribution_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'bukti_bayar' => $buktiPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil dikirim! Menunggu konfirmasi Bendahara.');
    }
}
<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\TrashBankDeposit;
use App\Models\Cooperative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrashBankController extends Controller
{
    public function index()
    {
        $deposits = TrashBankDeposit::where('client_id', Auth::user()->client_id)
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
            
        // Ambil data koperasi untuk melihat total saldo simpanan (yang mana hasil sampah masuk ke sini)
        $coop = Cooperative::where('client_id', Auth::user()->client_id)
            ->where('user_id', Auth::id())
            ->first();

        return view('warga.trashbank.index', compact('deposits', 'coop'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_sampah' => 'required|string|max:255',
            'estimasi_berat' => 'nullable|numeric|min:0.1',
            'keterangan' => 'nullable|string'
        ]);

        TrashBankDeposit::create([
            'client_id' => Auth::user()->client_id,
            'user_id' => Auth::id(),
            'jenis_sampah' => $request->jenis_sampah,
            'berat_kg' => $request->estimasi_berat,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu Jemput'
        ]);

        return back()->with('success', 'Permintaan setoran sampah berhasil dikirim. Petugas akan segera memproses.');
    }
}

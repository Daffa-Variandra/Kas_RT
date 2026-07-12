<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Cooperative;
use App\Models\CooperativeLoan;
use App\Models\CooperativeTransaction;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CooperativeController extends Controller
{
    public function index()
    {
        $clientId = Auth::user()->client_id;
        $client = Client::findOrFail($clientId);
        
        $coop = Cooperative::firstOrCreate(
            ['client_id' => $clientId, 'user_id' => Auth::id()],
            ['saldo_simpanan' => 0, 'saldo_pinjaman' => 0]
        );

        $loans = CooperativeLoan::where('client_id', $clientId)
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
            
        $transactions = CooperativeTransaction::where('client_id', $clientId)
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('warga.cooperative.index', compact('coop', 'loans', 'transactions', 'client'));
    }

    public function storeLoan(Request $request)
    {
        $request->validate([
            'pokok_pinjaman' => 'required|numeric|min:10000',
            'tenor_bulan' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255'
        ]);

        $clientId = Auth::user()->client_id;
        $client = Client::findOrFail($clientId);
        
        $skema = $client->koperasi_skema;
        $marginPersen = $client->koperasi_margin_persen;
        $pokok = $request->pokok_pinjaman;
        $tenor = $request->tenor_bulan;
        
        $totalPinjaman = $pokok;
        
        if ($skema === 'margin' && $marginPersen > 0) {
            // Asumsi margin persen adalah bunga flat dari pokok (misal 5% total)
            $marginAmount = $pokok * ($marginPersen / 100);
            $totalPinjaman = $pokok + $marginAmount;
        }
        
        $angsuranPerBulan = $totalPinjaman / $tenor;

        CooperativeLoan::create([
            'client_id' => $clientId,
            'user_id' => Auth::id(),
            'pokok_pinjaman' => $pokok,
            'tenor_bulan' => $tenor,
            'skema' => $skema,
            'margin_persen' => $skema === 'margin' ? $marginPersen : 0,
            'total_pinjaman' => $totalPinjaman,
            'angsuran_per_bulan' => $angsuranPerBulan,
            'sisa_pinjaman' => $totalPinjaman,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu'
        ]);

        return back()->with('success', 'Pengajuan pinjaman berhasil dikirim. Menunggu persetujuan Admin.');
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'jenis_transaksi' => 'required|in:Simpanan Pokok,Simpanan Wajib,Tarik Simpanan,Bayar Angsuran',
            'jumlah' => 'required|numeric|min:1000',
            'keterangan' => 'nullable|string',
            'bukti_bayar' => 'nullable|image|max:2048',
            'cooperative_loan_id' => 'nullable|exists:cooperative_loans,id'
        ]);

        $path = null;
        if ($request->hasFile('bukti_bayar')) {
            $path = $request->file('bukti_bayar')->store('cooperative/receipts', 'public');
        }

        CooperativeTransaction::create([
            'client_id' => Auth::user()->client_id,
            'user_id' => Auth::id(),
            'jenis_transaksi' => $request->jenis_transaksi,
            'jumlah' => $request->jumlah,
            'bukti_bayar' => $path,
            'keterangan' => $request->keterangan,
            'cooperative_loan_id' => $request->cooperative_loan_id,
            'status' => 'Menunggu'
        ]);

        return back()->with('success', 'Transaksi berhasil diajukan dan menunggu verifikasi Admin.');
    }
}

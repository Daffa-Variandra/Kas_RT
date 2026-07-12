<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::where('client_id', Auth::user()->client_id)->latest()->get();
        $myLoans = AssetLoan::with('asset')
            ->where('client_id', Auth::user()->client_id)
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
            
        return view('warga.assets.index', compact('assets', 'myLoans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255'
        ]);

        $asset = Asset::where('client_id', Auth::user()->client_id)->findOrFail($request->asset_id);
        
        if ($request->jumlah > $asset->jumlah) {
            return back()->withErrors(['jumlah' => 'Jumlah pinjaman melebihi stok yang ada.']);
        }

        AssetLoan::create([
            'client_id' => Auth::user()->client_id,
            'asset_id' => $asset->id,
            'user_id' => Auth::id(),
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu'
        ]);

        return back()->with('success', 'Pengajuan pinjaman berhasil dikirim.');
    }
}

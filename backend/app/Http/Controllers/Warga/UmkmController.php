<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmController extends Controller
{
    public function index()
    {
        $umkms = Umkm::with('user')->where('client_id', Auth::user()->client_id)->latest()->get();
        $myUmkm = Umkm::where('client_id', Auth::user()->client_id)->where('user_id', Auth::id())->first();
        
        return view('warga.umkm.index', compact('umkms', 'myUmkm'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'nomor_whatsapp' => 'required|string|max:20'
        ]);

        $existing = Umkm::where('client_id', Auth::user()->client_id)->where('user_id', Auth::id())->first();
        if ($existing) {
            $existing->update($request->only(['nama_usaha', 'kategori', 'deskripsi', 'nomor_whatsapp']));
            return back()->with('success', 'Profil UMKM Anda berhasil diperbarui.');
        }

        Umkm::create([
            'client_id' => Auth::user()->client_id,
            'user_id' => Auth::id(),
            'nama_usaha' => $request->nama_usaha,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'nomor_whatsapp' => $request->nomor_whatsapp
        ]);

        return back()->with('success', 'Usaha berhasil didaftarkan di direktori warga.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::where('client_id', Auth::user()->client_id)->latest()->get();
        return view('admin.assets.index', compact('assets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|in:Elektronik,Furnitur,Tenda,Lainnya',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        Asset::create([
            'client_id' => Auth::user()->client_id,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'kondisi' => $request->kondisi,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Aset berhasil ditambahkan.');
    }

    public function update(Request $request, Asset $asset)
    {
        if ($asset->client_id !== Auth::user()->client_id) {
            abort(403);
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|in:Elektronik,Furnitur,Tenda,Lainnya',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        $asset->update($request->only(['nama_barang', 'kategori', 'kondisi', 'jumlah', 'keterangan']));

        return back()->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        if ($asset->client_id !== Auth::user()->client_id) {
            abort(403);
        }
        $asset->delete();
        return back()->with('success', 'Aset berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PosyanduRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosyanduController extends Controller
{
    public function index()
    {
        $clientId = Auth::user()->client_id;
        $records = PosyanduRecord::with('user')->where('client_id', $clientId)->latest()->get();
        $users = User::where('client_id', $clientId)->where('role', 'warga')->get();
        
        return view('admin.posyandu.index', compact('records', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_pasien' => 'required|string|max:255',
            'kategori' => 'required|in:Balita,Ibu Hamil,Lansia',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'keterangan' => 'nullable|string'
        ]);

        PosyanduRecord::create([
            'client_id' => Auth::user()->client_id,
            'user_id' => $request->user_id,
            'nama_pasien' => $request->nama_pasien,
            'kategori' => $request->kategori,
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $request->tinggi_badan,
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Data Posyandu berhasil ditambahkan.');
    }

    public function update(Request $request, PosyanduRecord $posyandu)
    {
        if ($posyandu->client_id !== Auth::user()->client_id) abort(403);

        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'kategori' => 'required|in:Balita,Ibu Hamil,Lansia',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'keterangan' => 'nullable|string'
        ]);

        $posyandu->update($request->only(['nama_pasien', 'kategori', 'berat_badan', 'tinggi_badan', 'keterangan']));

        return back()->with('success', 'Data Posyandu berhasil diperbarui.');
    }

    public function destroy(PosyanduRecord $posyandu)
    {
        if ($posyandu->client_id !== Auth::user()->client_id) abort(403);
        $posyandu->delete();
        return back()->with('success', 'Data Posyandu berhasil dihapus.');
    }
}

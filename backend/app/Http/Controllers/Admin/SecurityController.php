<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecuritySchedule;
use App\Models\GuestLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    public function index()
    {
        $schedules = SecuritySchedule::where('client_id', Auth::user()->client_id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->get();
            
        $guests = GuestLog::where('client_id', Auth::user()->client_id)->latest()->get();
            
        return view('admin.security.index', compact('schedules', 'guests'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'petugas' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        SecuritySchedule::updateOrCreate(
            ['client_id' => Auth::user()->client_id, 'hari' => $request->hari],
            ['petugas' => $request->petugas, 'keterangan' => $request->keterangan]
        );

        return back()->with('success', 'Regu ronda berhasil disimpan.');
    }
    
    public function destroySchedule(SecuritySchedule $schedule)
    {
        if ($schedule->client_id !== Auth::user()->client_id) abort(403);
        $schedule->delete();
        return back()->with('success', 'Regu ronda dihapus.');
    }

    public function storeGuest(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'waktu_masuk' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        GuestLog::create([
            'client_id' => Auth::user()->client_id,
            'nama_tamu' => $request->nama_tamu,
            'tujuan' => $request->tujuan,
            'waktu_masuk' => $request->waktu_masuk,
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Buku tamu berhasil diisi.');
    }

    public function updateGuestOut(GuestLog $guest)
    {
        if ($guest->client_id !== Auth::user()->client_id) abort(403);
        
        $guest->update(['waktu_keluar' => now()]);
        return back()->with('success', 'Waktu keluar tamu dicatat.');
    }
}

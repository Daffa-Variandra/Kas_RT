<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\Family;
use Illuminate\Http\Request;

class ResidentController extends Controller
{    
    public function store(Request $request)
    {
        $request->validate([
            'family_id' => 'required|exists:families,id',
            'nik' => 'required|string|size:16|unique:residents,nik',
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'status_keluarga' => 'required|in:Kepala Keluarga,Istri,Anak,Lainnya',
        ]);
      
        $resident = Resident::create($request->only('family_id', 'nik', 'nama', 'no_hp', 'status_keluarga'));

        // Update the family user's name if this is the Head of Family and user's name is still the placeholder or just to keep it synced.
        if ($resident->status_keluarga === 'Kepala Keluarga') {
            $user = $resident->family->user;
            $user->name = $resident->nama;
            $user->save();
        }

        return redirect()->back()->with('success', 'Anggota keluarga berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
            
        $request->validate([
            'nik' => 'required|string|size:16|unique:residents,nik,' . $resident->id,
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'status_keluarga' => 'required|in:Kepala Keluarga,Istri,Anak,Lainnya',
        ]);
    
        $resident->update($request->only('nik', 'nama', 'no_hp', 'status_keluarga'));

        if ($resident->status_keluarga === 'Kepala Keluarga') {
            $user = $resident->family->user;
            $user->name = $resident->nama;
            $user->save();
        }

        return redirect()->back()->with('success', 'Data Warga berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);       
        $resident->delete();

        return redirect()->back()->with('success', 'Anggota keluarga berhasil dihapus!');
    }
}
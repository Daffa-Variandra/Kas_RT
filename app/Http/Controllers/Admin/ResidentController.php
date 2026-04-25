<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResidentController extends Controller
{    
   public function residentindex()
    {
        $users = User::where('role', 'warga')->with('resident')->get();
        
        return view('admin.residents', compact('users'));
    }
   
    public function residentcreate()
    {
        return view('admin.residents_create');
    }
   
    public function residentstore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
      
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'warga',
        ]);

        return redirect()->route('admin.residents.index')->with('success', 'Akun warga berhasil dibuat! Berikan email & password ke warga terkait.');
    }

    public function residentupdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
            
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nik' => 'required|string|size:16|unique:residents,nik,' . ($user->resident->id ?? 0),
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'status_hunian' => 'required|in:Tetap,Kontrak',
            'password' => 'nullable|min:8',
        ]);
    
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $user->save();
        
        $user->resident()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nik' => $request->nik,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'status_hunian' => $request->status_hunian,
            ]
        );

        return redirect()->back()->with('success', 'Data Bio Warga berhasil diperbarui sepenuhnya!');
    }
    
    public function residentdestroy($id)
    {
        $user = User::findOrFail($id);       
        $user->delete();

        return redirect()->route('admin.residents.index')->with('success', 'Warga dan semua data terkait berhasil dihapus!');
    }
}
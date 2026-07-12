<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\Resident;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function wargaEdit(): View
    {
        return view('warga.profile', [
            'user' => auth()->user(),
            'family' => auth()->user()->family,
            'resident' => auth()->user()->family?->residents()->where('status_keluarga', 'Kepala Keluarga')->first()
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function wargaUpdate(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $family = $user->family;
        $resident = $family->residents()->where('status_keluarga', 'Kepala Keluarga')->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_kk' => 'required|string|size:16|unique:families,no_kk,' . $family->id,
            'nik' => 'required|string|size:16|unique:residents,nik,' . $resident->id,
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'status_hunian' => 'required|in:Tetap,Kontrak',
            'password' => 'nullable|confirmed|min:8',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $user, $family, $resident) {
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            }
            $user->save();

            $family->update([
                'no_kk' => $request->no_kk,
                'alamat' => $request->alamat,
                'status_hunian' => $request->status_hunian,
            ]);

            $resident->update([
                'nik' => $request->nik,
                'nama' => $request->name,
                'no_hp' => $request->no_hp,
            ]);
        });

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function complete(): View | RedirectResponse
    {
        if (Auth::user()->family) {
            return redirect()->route('dashboard');
        }

        return view('profile.complete');
    }


    public function storeProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:residents',
            'no_kk' => 'required|string|size:16|unique:families',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'status_hunian' => 'required|in:Tetap,Kontrak',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            $family = \App\Models\Family::create([
                'user_id' => Auth::id(),
                'no_kk' => $request->no_kk,
                'alamat' => $request->alamat,
                'status_hunian' => $request->status_hunian,
            ]);

            Resident::create([
                'family_id' => $family->id,
                'nik' => $request->nik,
                'nama' => Auth::user()->name,
                'no_hp' => $request->no_hp,
                'status_keluarga' => 'Kepala Keluarga',
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Profil berhasil dilengkapi! Selamat datang di sistem Smart RW.');
    }
  
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

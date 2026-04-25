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
            'resident' => auth()->user()->resident
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
        $resident = $user->resident;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'status_hunian' => 'required|in:Tetap,Kontrak',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $user->save();

        $resident->update([
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status_hunian' => $request->status_hunian,
        ]);

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function complete(): View | RedirectResponse
    {
        if (Auth::user()->resident) {
            return redirect()->route('dashboard');
        }

        return view('profile.complete');
    }


    public function storeProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:residents',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'status_hunian' => 'required|in:Tetap,Kontrak',
        ]);

        Resident::create([
            'user_id' => Auth::id(),
            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status_hunian' => $request->status_hunian,
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil berhasil dilengkapi! Selamat datang di sistem RT 003.');
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

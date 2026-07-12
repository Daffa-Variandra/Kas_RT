<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    /**
     * Show the landing page.
     */
    public function index()
    {
        // If user is already logged in, redirect them to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('landing');
    }

    /**
     * Show the registration form for new RW / Clients.
     */
    public function registerRw()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('register-rw');
    }

    /**
     * Handle the registration of a new RW / Client.
     */
    public function storeRw(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_address' => 'required|string',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|string|email|max:255|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // Generate a unique code for the client automatically
            // e.g., RW-12345
            $uniqueCode = 'RW-' . strtoupper(substr(uniqid(), -5));
            
            // Ensure uniqueness
            while (Client::where('code', $uniqueCode)->exists()) {
                $uniqueCode = 'RW-' . strtoupper(substr(uniqid(), -5));
            }

            $client = Client::create([
                'name' => $request->client_name,
                'code' => $uniqueCode,
                'address' => $request->client_address,
                'is_active' => true, // Auto active or we could set it to false for manual approval
            ]);

            $user = User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'role' => 'admin',
                'client_id' => $client->id,
            ]);

            DB::commit();

            // Auto-login the new admin
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Selamat datang! Akun Pengurus RW Anda berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat pendaftaran: ' . $e->getMessage());
        }
    }
}

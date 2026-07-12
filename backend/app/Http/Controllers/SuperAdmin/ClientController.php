<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->get();
        return view('superadmin.clients.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:clients,code',
            'address' => 'required|string',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|string|email|max:255|unique:users,email',
            'admin_password' => 'required|string|min:8',
        ]);

        DB::beginTransaction();
        try {
            $client = Client::create([
                'name' => $request->name,
                'code' => $request->code,
                'address' => $request->address,
                'is_active' => true,
                'is_auto_billing_enabled' => true, // default for new clients
            ]);

            User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'role' => 'admin',
                'client_id' => $client->id,
            ]);

            DB::commit();
            return redirect()->route('superadmin.clients.index')->with('success', 'Klien / RW berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:clients,code,' . $client->id,
            'address' => 'required|string',
            'is_active' => 'required|boolean',
            'is_auto_billing_enabled' => 'required|boolean',
            'is_email_notification_active' => 'required|boolean',
        ]);

        $client->update([
            'name' => $request->name,
            'code' => $request->code,
            'address' => $request->address,
            'is_active' => $request->is_active,
            'is_auto_billing_enabled' => $request->is_auto_billing_enabled,
            'is_email_notification_active' => $request->is_email_notification_active,
        ]);

        return redirect()->route('superadmin.clients.index')->with('success', 'Data Klien berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete(); // This will cascade delete users, families, etc. based on migration

        return redirect()->route('superadmin.clients.index')->with('success', 'Klien dan semua datanya berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = User::whereIn('role', ['admin', 'bendahara'])->get();
        return view('admin.staff.index', compact('staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['admin', 'bendahara'])],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Pengurus berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $staff = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($staff->id)],
            'password' => 'nullable|string|min:8',
            'role' => ['required', Rule::in(['admin', 'bendahara'])],
        ]);

        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->role = $request->role;
        
        if ($request->filled('password')) {
            $staff->password = Hash::make($request->password);
        }

        $staff->save();

        return redirect()->route('admin.staff.index')->with('success', 'Data Pengurus berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        
        if (auth()->id() == $staff->id) {
            return redirect()->route('admin.staff.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Pengurus berhasil dihapus.');
    }
}

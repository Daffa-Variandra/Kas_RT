<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FamilyController extends Controller
{
    public function index()
    {
        $families = Family::with('user', 'residents')->get();
        return view('admin.families.index', compact('families'));
    }

    public function create()
    {
        return view('admin.families.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'no_kk' => 'required|string|size:16|unique:families',
            'alamat' => 'required|string',
            'status_hunian' => 'required|in:Tetap,Kontrak',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => 'Kepala Keluarga ' . $request->no_kk, // Placeholder name
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'warga',
            ]);

            Family::create([
                'user_id' => $user->id,
                'no_kk' => $request->no_kk,
                'alamat' => $request->alamat,
                'status_hunian' => $request->status_hunian,
            ]);
        });

        return redirect()->route('admin.families.index')->with('success', 'Keluarga berhasil ditambahkan. Silakan kelola anggota keluarga.');
    }

    public function show($id)
    {
        $family = Family::with('residents', 'user')->findOrFail($id);
        return view('admin.families.show', compact('family'));
    }

    public function edit($id)
    {
        $family = Family::with('user')->findOrFail($id);
        return view('admin.families.edit', compact('family'));
    }

    public function update(Request $request, $id)
    {
        $family = Family::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $family->user_id,
            'no_kk' => 'required|string|size:16|unique:families,no_kk,' . $family->id,
            'alamat' => 'required|string',
            'status_hunian' => 'required|in:Tetap,Kontrak',
            'password' => 'nullable|min:8',
        ]);

        DB::transaction(function () use ($request, $family) {
            $family->user->email = $request->email;
            if ($request->filled('password')) {
                $family->user->password = Hash::make($request->password);
            }
            $family->user->save();

            $family->update([
                'no_kk' => $request->no_kk,
                'alamat' => $request->alamat,
                'status_hunian' => $request->status_hunian,
            ]);
        });

        return redirect()->route('admin.families.index')->with('success', 'Data Keluarga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $family = Family::findOrFail($id);
        $user = $family->user;
        $user->delete(); 

        return redirect()->route('admin.families.index')->with('success', 'Keluarga dan anggotanya berhasil dihapus.');
    }

    public function template()
    {
        $fileName = 'template_data_warga.xlsx';
        $writer = \Spatie\SimpleExcel\SimpleExcelWriter::streamDownload($fileName);

        // Add a dummy row to serve as a clear template
        $writer->addRow([
            'No KK' => '3270012345678901',
            'Kepala Keluarga' => 'Budi Santoso',
            'NIK' => '3270012345678902',
            'Email Login' => 'budi@gmail.com',
            'No HP' => '081234567890',
            'Alamat' => 'Jl. Taman Elok Blok A No 1',
            'Status Hunian' => 'Tetap',
        ]);

        return $writer->toBrowser();
    }

    public function export()
    {
        $families = Family::with('user', 'residents')->get();
        $fileName = 'data_warga_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = \Spatie\SimpleExcel\SimpleExcelWriter::streamDownload($fileName);

        foreach ($families as $family) {
            $kepalaKeluarga = $family->residents->where('status_keluarga', 'Kepala Keluarga')->first();
            $writer->addRow([
                'No KK' => $family->no_kk,
                'Kepala Keluarga' => $kepalaKeluarga ? $kepalaKeluarga->nama : $family->user->name,
                'NIK' => $kepalaKeluarga ? $kepalaKeluarga->nik : '',
                'Email Login' => $family->user->email,
                'No HP' => $kepalaKeluarga ? $kepalaKeluarga->no_hp : '',
                'Alamat' => $family->alamat,
                'Status Hunian' => $family->status_hunian,
                'Total Anggota' => $family->residents->count(),
            ]);
        }

        return $writer->toBrowser();
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,txt'
        ]);

        $file = $request->file('file');
        
        $rows = \Spatie\SimpleExcel\SimpleExcelReader::create($file->getPathname(), $file->getClientOriginalExtension())->getRows();

        $imported = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            try {
                DB::transaction(function () use ($row) {
                    $no_kk = $row['no_kk'] ?? $row['No KK'] ?? null;
                    $email = $row['email'] ?? $row['Email Login'] ?? null;
                    $nama = $row['nama'] ?? $row['Kepala Keluarga'] ?? null;
                    $nik = $row['nik'] ?? $row['NIK'] ?? null;
                    $no_hp = $row['no_hp'] ?? $row['No HP'] ?? null;
                    $alamat = $row['alamat'] ?? $row['Alamat'] ?? null;
                    $status_hunian = $row['status_hunian'] ?? $row['Status Hunian'] ?? 'Tetap';

                    $missingFields = [];
                    if (!$no_kk) $missingFields[] = 'No KK';
                    if (!$email) $missingFields[] = 'Email Login';
                    if (!$nama) $missingFields[] = 'Kepala Keluarga';
                    if (!$nik) $missingFields[] = 'NIK';
                    if (!$alamat) $missingFields[] = 'Alamat';

                    if (count($missingFields) > 0) {
                        throw new \Exception('Kolom wajib kosong: ' . implode(', ', $missingFields));
                    }

                    if (User::where('email', $email)->exists()) {
                        throw new \Exception('Email ' . $email . ' sudah terdaftar');
                    }
                    if (Family::where('no_kk', $no_kk)->exists()) {
                        throw new \Exception('No KK ' . $no_kk . ' sudah terdaftar');
                    }

                    $password = \Illuminate\Support\Str::random(8);

                    $user = User::create([
                        'name' => $nama,
                        'email' => $email,
                        'password' => Hash::make($password),
                        'role' => 'warga',
                    ]);

                    $family = Family::create([
                        'user_id' => $user->id,
                        'no_kk' => $no_kk,
                        'alamat' => $alamat,
                        'status_hunian' => $status_hunian,
                    ]);

                    \App\Models\Resident::create([
                        'family_id' => $family->id,
                        'nik' => $nik,
                        'nama' => $nama,
                        'no_hp' => $no_hp,
                        'status_keluarga' => 'Kepala Keluarga',
                    ]);
                });
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
            }
        }

        $msg = "$imported data berhasil diimport. (Password akun digenerate acak 8 karakter, warga dapat menggunakan fitur Lupa Password atau direset Admin).";
        if (count($errors) > 0) {
            $msg .= " Namun ada " . count($errors) . " error: " . implode(", ", array_slice($errors, 0, 3)) . (count($errors) > 3 ? '...' : '');
        }

        return redirect()->route('admin.families.index')->with('success', $msg);
    }
}

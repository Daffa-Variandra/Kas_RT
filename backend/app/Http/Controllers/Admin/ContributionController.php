<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    public function index()
    {
        $contributions = Contribution::all();
        return view('admin.contributions', compact('contributions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_iuran' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        Contribution::create($request->all());

        return redirect()->route('admin.contributions.index')->with('success', 'Jenis Iuran baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_iuran' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $contribution = Contribution::findOrFail($id);
        $contribution->update($request->all());

        return redirect()->route('admin.contributions.index')->with('success', 'Jenis Iuran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Contribution::findOrFail($id)->delete();
        return redirect()->route('admin.contributions.index')->with('success', 'Jenis Iuran berhasil dihapus!');
    }
}
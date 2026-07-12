<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetLoanController extends Controller
{
    public function index()
    {
        $loans = AssetLoan::with(['asset', 'user'])->where('client_id', Auth::user()->client_id)->latest()->get();
        return view('admin.assets.loans', compact('loans'));
    }

    public function update(Request $request, AssetLoan $loan)
    {
        if ($loan->client_id !== Auth::user()->client_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:Menunggu,Dipinjam,Selesai,Ditolak',
        ]);

        $loan->update(['status' => $request->status]);

        return back()->with('success', 'Status peminjaman berhasil diperbarui.');
    }
}

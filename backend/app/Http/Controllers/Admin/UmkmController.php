<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmController extends Controller
{
    public function index()
    {
        $umkms = Umkm::with('user')->where('client_id', Auth::user()->client_id)->latest()->get();
        return view('admin.umkm.index', compact('umkms'));
    }

    public function destroy(Umkm $umkm)
    {
        if ($umkm->client_id !== Auth::user()->client_id) {
            abort(403);
        }
        $umkm->delete();
        return back()->with('success', 'Usaha berhasil dihapus dari direktori.');
    }
}

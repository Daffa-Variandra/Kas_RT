<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Letter;
use Illuminate\Support\Facades\Auth;

class LetterController extends Controller
{
    public function index()
    {
        $letters = Letter::where('user_id', Auth::id())->latest()->get();
        return view('warga.letters.index', compact('letters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'letter_type' => 'required|string|max:255',
            'purpose' => 'required|string',
        ]);

        Letter::create([
            'user_id' => Auth::id(),
            'letter_type' => $request->letter_type,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Permohonan surat berhasil dikirim dan menunggu persetujuan Pengurus.');
    }
}

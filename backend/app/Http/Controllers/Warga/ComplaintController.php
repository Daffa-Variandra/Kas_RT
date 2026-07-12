<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::where('user_id', Auth::id())->latest()->get();
        return view('warga.complaints.index', compact('complaints'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:5120',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        Complaint::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'photo_path' => $photoPath,
            'status' => 'menunggu',
        ]);

        return redirect()->back()->with('success', 'Aspirasi / Pengaduan Anda berhasil dikirim.');
    }
}

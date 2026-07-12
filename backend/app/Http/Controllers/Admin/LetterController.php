<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Letter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class LetterController extends Controller
{
    public function index()
    {
        $letters = Letter::with('user.family')->latest()->get();
        return view('admin.letters.index', compact('letters'));
    }

    public function update(Request $request, Letter $letter)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $letter->status = $request->status;
        $letter->admin_notes = $request->admin_notes;

        if ($request->status === 'approved') {
            // Generate Reference Number
            $letter->reference_number = 'WH/' . date('Y/m/') . str_pad($letter->id, 3, '0', STR_PAD_LEFT);
            
            // In a real app we might generate PDF here or on the fly
        }

        $letter->save();

        $letter->user->notify(new \App\Notifications\LetterStatusUpdated($letter));

        return redirect()->back()->with('success', 'Status surat pengantar berhasil diperbarui.');
    }

    public function print(Letter $letter)
    {
        if ($letter->status !== 'approved') {
            abort(403, 'Surat belum disetujui.');
        }

        $pdf = Pdf::loadView('admin.letters.pdf', compact('letter'));
        return $pdf->stream('Surat_Pengantar_'.$letter->user->name.'.pdf');
    }
}

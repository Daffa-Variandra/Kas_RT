<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'contribution', 'user.resident'])
                        ->where('status', 'success');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_bayar', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }

        $reports = $query->latest('tanggal_bayar')->get();
        $totalKas = $reports->sum('jumlah_bayar');

        return view('bendahara.reports', compact('reports', 'totalKas'));
    }
}
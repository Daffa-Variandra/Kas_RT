<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $clientId = Auth::user()->client_id;
        
        $query = Payment::with(['user', 'contribution'])
                        ->where('client_id', $clientId)
                        ->where('status', 'success');

        $expenseQuery = Expense::where('client_id', $clientId);

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_bayar', $request->bulan);
            $expenseQuery->whereMonth('expense_date', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_bayar', $request->tahun);
            $expenseQuery->whereYear('expense_date', $request->tahun);
        }

        $reports = $query->latest('tanggal_bayar')->get();
        $totalKasMasuk = $reports->sum('jumlah_bayar');

        $expenses = $expenseQuery->latest('expense_date')->get();
        $totalKasKeluar = $expenses->sum('amount');
        
        $saldoAkhir = $totalKasMasuk - $totalKasKeluar;

        return view('bendahara.reports', compact('reports', 'totalKasMasuk', 'expenses', 'totalKasKeluar', 'saldoAkhir'));
    }

    public function exportPdf(Request $request)
    {
        $clientId = Auth::user()->client_id;

        $query = Payment::with(['user', 'contribution'])
                        ->where('client_id', $clientId)
                        ->where('status', 'success');

        $expenseQuery = Expense::where('client_id', $clientId);

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_bayar', $request->bulan);
            $expenseQuery->whereMonth('expense_date', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_bayar', $request->tahun);
            $expenseQuery->whereYear('expense_date', $request->tahun);
        }

        $reports = $query->latest('tanggal_bayar')->get();
        $totalKasMasuk = $reports->sum('jumlah_bayar');

        $expenses = $expenseQuery->latest('expense_date')->get();
        $totalKasKeluar = $expenses->sum('amount');
        
        $saldoAkhir = $totalKasMasuk - $totalKasKeluar;
        
        $client = auth()->user()->client;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bendahara.reports-pdf', [
            'reports' => $reports,
            'totalKasMasuk' => $totalKasMasuk,
            'expenses' => $expenses,
            'totalKasKeluar' => $totalKasKeluar,
            'saldoAkhir' => $saldoAkhir,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'client' => $client
        ]);

        return $pdf->download('laporan_kas_' . date('Y_m_d_H_i') . '.pdf');
    }
}
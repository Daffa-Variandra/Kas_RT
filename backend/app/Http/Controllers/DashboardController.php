<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resident;
use App\Models\Payment;
use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }

        // KHUSUS WARGA: Cek profil dulu, kalau belum ada lempar ke halaman lengkapi profil
        if ($user->role == 'warga' && !$user->family) {
            return redirect()->route('profile.complete');
        }

        if ($user->role == 'admin') {
            return $this->adminDashboard();
        } elseif ($user->role == 'bendahara') {
            return $this->bendaharaDashboard();
        } else {
            return $this->wargaDashboard($user);
        }
    }

    private function adminDashboard()
    {
        $data = [
            'total_warga' => Resident::count(),
            'total_keluarga' => \App\Models\Family::count(),
            'surat_pending' => \App\Models\Letter::where('status', 'pending')->count(),
            'aspirasi_pending' => \App\Models\Complaint::where('status', 'pending')->count(),
            'aset_dipinjam' => \App\Models\AssetLoan::where('status', 'Dipinjam')->count(),
            // Keuangan Kas
            'total_kas' => Payment::where('status', 'success')->sum('jumlah_bayar'),
            // Bank Sampah
            'sampah_terkumpul' => \App\Models\TrashBankDeposit::where('status', 'Selesai')->sum('berat_kg'),
            'saldo_sampah' => \App\Models\TrashBankDeposit::where('status', 'Selesai')->sum('nominal_rupiah'),
            // Koperasi
            'simpanan_koperasi' => \App\Models\Cooperative::sum('saldo_simpanan'),
            'pinjaman_koperasi' => \App\Models\Cooperative::sum('saldo_pinjaman'),
            // Posyandu
            'data_posyandu' => \App\Models\PosyanduRecord::count(),
        ];

        // Chart Demografi
        $families = \App\Models\Family::selectRaw('status_hunian, COUNT(*) as total')
            ->groupBy('status_hunian')
            ->get();
        $chartDemoLabels = $families->pluck('status_hunian');
        $chartDemoValues = $families->pluck('total');

        // Chart Aktivitas (Surat & Pengaduan 6 Bulan Terakhir)
        $sixMonthsAgo = \Carbon\Carbon::now()->subMonths(5)->startOfMonth();
        
        $letters = \App\Models\Letter::where('created_at', '>=', $sixMonthsAgo)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->get();

        $complaints = \App\Models\Complaint::where('created_at', '>=', $sixMonthsAgo)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->get();

        $chartActivityLabels = [];
        $chartLettersValues = [];
        $chartComplaintsValues = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $chartActivityLabels[] = $date->translatedFormat('M Y');
            $chartLettersValues[] = $letters->where('year', $year)->where('month', $month)->first()->total ?? 0;
            $chartComplaintsValues[] = $complaints->where('year', $year)->where('month', $month)->first()->total ?? 0;
        }

        return view('admin.dashboard', compact('data', 'chartDemoLabels', 'chartDemoValues', 'chartActivityLabels', 'chartLettersValues', 'chartComplaintsValues'));
    }

    private function bendaharaDashboard()
    {


        $totalKas = Payment::where('status', 'success')->sum('jumlah_bayar');
        $totalPengeluaran = \App\Models\Expense::sum('amount');
        
        $data = [
            'total_kas' => $totalKas,
            'total_pengeluaran' => $totalPengeluaran,
            'saldo_akhir' => $totalKas - $totalPengeluaran,
            'pemasukan_bulan_ini' => Payment::where('status', 'success')
                                    ->whereMonth('tanggal_bayar', date('m'))
                                    ->whereYear('tanggal_bayar', date('Y'))
                                    ->sum('jumlah_bayar'),
            'perlu_verifikasi' => Payment::where('status', 'pending')->count(),
        ];

        // Total Tunggakan Bulan Ini
        $currentMonth = date('m');
        $currentYear = date('Y');
        
        // Asumsi: Semua keluarga aktif diharapkan membayar iuran bulanan
        $totalFamilies = \App\Models\Family::count();
        $paidFamilies = Payment::where('status', 'success')
            ->whereMonth('tanggal_bayar', $currentMonth)
            ->whereYear('tanggal_bayar', $currentYear)
            ->distinct('user_id')
            ->count();
        $data['tunggakan_bulan_ini'] = max(0, $totalFamilies - $paidFamilies);

        // Chart Pemasukan 6 Bulan Terakhir
        $sixMonthsAgo = \Carbon\Carbon::now()->subMonths(5)->startOfMonth();
        $payments = Payment::where('status', 'success')
            ->where('tanggal_bayar', '>=', $sixMonthsAgo)
            ->selectRaw('YEAR(tanggal_bayar) as year, MONTH(tanggal_bayar) as month, SUM(jumlah_bayar) as total')
            ->groupBy('year', 'month')
            ->get();

        $chartIncomeLabels = [];
        $chartIncomeValues = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $chartIncomeLabels[] = $date->translatedFormat('M Y');
            $chartIncomeValues[] = $payments->where('year', $year)->where('month', $month)->first()->total ?? 0;
        }

        // Chart Komposisi Pemasukan (Iuran vs Kas Lain)
        $komposisi = Payment::where('status', 'success')
            ->join('contributions', 'payments.contribution_id', '=', 'contributions.id')
            ->selectRaw('contributions.nama_iuran as jenis, SUM(payments.jumlah_bayar) as total')
            ->groupBy('contributions.nama_iuran')
            ->get();

        $chartCompositionLabels = $komposisi->pluck('jenis');
        $chartCompositionValues = $komposisi->pluck('total');

        return view('bendahara.dashboard', compact('data', 'chartIncomeLabels', 'chartIncomeValues', 'chartCompositionLabels', 'chartCompositionValues'));
    }

    private function wargaDashboard($user)
    {
        $data = [
            'status_bulan_ini' => Payment::where('user_id', $user->id)
                                ->whereMonth('tanggal_bayar', date('m'))
                                ->whereYear('tanggal_bayar', date('Y'))
                                ->first(),
            'surat_diajukan' => \App\Models\Letter::where('user_id', $user->id)->count(),
            'aset_dipinjam' => \App\Models\AssetLoan::where('user_id', $user->id)->where('status', 'Dipinjam')->count(),
        ];

        // Chart Riwayat Pembayaran (6 Bulan Terakhir)
        $sixMonthsAgo = \Carbon\Carbon::now()->subMonths(5)->startOfMonth();
        $payments = Payment::where('user_id', $user->id)
            ->where('status', 'success')
            ->where('tanggal_bayar', '>=', $sixMonthsAgo)
            ->selectRaw('YEAR(tanggal_bayar) as year, MONTH(tanggal_bayar) as month, SUM(jumlah_bayar) as total')
            ->groupBy('year', 'month')
            ->get();

        $chartHistoryLabels = [];
        $chartHistoryValues = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $chartHistoryLabels[] = $date->translatedFormat('M Y');
            $chartHistoryValues[] = $payments->where('year', $year)->where('month', $month)->first()->total ?? 0;
        }

        return view('warga.dashboard', compact('data', 'chartHistoryLabels', 'chartHistoryValues'));
    }
}
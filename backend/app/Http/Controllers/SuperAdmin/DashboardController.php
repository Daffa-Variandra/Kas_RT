<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();
        $activeClients = Client::where('is_active', true)->count();
        $totalUsers = User::count();

        // Chart Pertumbuhan Klien (6 Bulan Terakhir)
        $sixMonthsAgo = \Carbon\Carbon::now()->subMonths(5)->startOfMonth();
        $clients = Client::where('created_at', '>=', $sixMonthsAgo)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->get();

        $chartLabels = [];
        $chartValues = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $chartLabels[] = $date->translatedFormat('M Y');
            $chartValues[] = $clients->where('year', $year)->where('month', $month)->first()->total ?? 0;
        }

        return view('superadmin.dashboard', compact('totalClients', 'activeClients', 'totalUsers', 'chartLabels', 'chartValues'));
    }
}

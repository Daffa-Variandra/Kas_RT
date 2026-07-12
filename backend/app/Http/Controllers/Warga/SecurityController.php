<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\SecuritySchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    public function index()
    {
        $daysIndo = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $today = $daysIndo[date('l')];
        
        $todaySchedule = SecuritySchedule::where('client_id', Auth::user()->client_id)
            ->where('hari', $today)
            ->first();

        $allSchedules = SecuritySchedule::where('client_id', Auth::user()->client_id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->get();

        return view('warga.security.index', compact('todaySchedule', 'allSchedules', 'today'));
    }
}

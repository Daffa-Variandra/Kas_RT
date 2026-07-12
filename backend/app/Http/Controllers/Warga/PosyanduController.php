<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\PosyanduRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosyanduController extends Controller
{
    public function index()
    {
        $records = PosyanduRecord::where('client_id', Auth::user()->client_id)
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'asc') // Untuk grafik pertumbuhan
            ->get();
            
        return view('warga.posyandu.index', compact('records'));
    }
}

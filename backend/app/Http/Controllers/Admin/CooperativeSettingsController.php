<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;

class CooperativeSettingsController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'koperasi_skema' => 'required|in:flat,margin',
            'koperasi_margin_persen' => 'required|numeric|min:0|max:100'
        ]);

        $client = Client::findOrFail(Auth::user()->client_id);
        
        $client->update([
            'koperasi_skema' => $request->koperasi_skema,
            'koperasi_margin_persen' => $request->koperasi_margin_persen
        ]);

        return back()->with('success', 'Pengaturan skema koperasi berhasil diperbarui.');
    }
}

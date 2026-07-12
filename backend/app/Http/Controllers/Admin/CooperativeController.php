<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cooperative;
use App\Models\CooperativeLoan;
use App\Models\CooperativeTransaction;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CooperativeController extends Controller
{
    public function index()
    {
        $clientId = Auth::user()->client_id;
        $client = Client::findOrFail($clientId);
        
        $loans = CooperativeLoan::with('user')->where('client_id', $clientId)->latest()->get();
        
        $transactions = CooperativeTransaction::with('user')
            ->where('client_id', $clientId)
            ->latest()
            ->get();
            
        $totalSimpanan = Cooperative::where('client_id', $clientId)->sum('saldo_simpanan');
        $totalPinjaman = Cooperative::where('client_id', $clientId)->sum('saldo_pinjaman');

        return view('admin.cooperative.index', compact('client', 'loans', 'transactions', 'totalSimpanan', 'totalPinjaman'));
    }

    public function updateLoanStatus(Request $request, CooperativeLoan $loan)
    {
        if ($loan->client_id !== Auth::user()->client_id) abort(403);
        
        $request->validate(['status' => 'required|in:Berjalan,Ditolak']);
        
        $emailSent = false;
        DB::transaction(function () use ($request, $loan, &$emailSent) {
            $loan->update(['status' => $request->status]);
            
            if ($request->status === 'Berjalan') {
                $coop = Cooperative::firstOrCreate(
                    ['client_id' => $loan->client_id, 'user_id' => $loan->user_id],
                    ['saldo_simpanan' => 0, 'saldo_pinjaman' => 0]
                );
                
                $coop->increment('saldo_pinjaman', $loan->total_pinjaman);
                
                // Buat transaksi pencairan
                CooperativeTransaction::create([
                    'client_id' => $loan->client_id,
                    'user_id' => $loan->user_id,
                    'jenis_transaksi' => 'Pencairan Pinjaman',
                    'jumlah' => $loan->pokok_pinjaman,
                    'status' => 'Disetujui',
                    'cooperative_loan_id' => $loan->id,
                    'keterangan' => 'Pencairan dana pinjaman'
                ]);

                // Kirim Notifikasi Email
                $subject = "Pengajuan Pinjaman Disetujui - Koperasi";
                $msg = "Selamat! Pengajuan pinjaman koperasi Anda sebesar **Rp " . number_format($loan->pokok_pinjaman, 0, ',', '.') . "** telah **DISETUJUI** dan dana telah dicairkan.\n\n";
                $msg .= "Status pinjaman Anda kini berstatus Berjalan. Jangan lupa untuk melakukan pembayaran angsuran tepat waktu.";
                $emailSent = \App\Services\EmailNotificationService::send($loan->user, $subject, $msg);
            } elseif ($request->status === 'Ditolak') {
                $subject = "Pengajuan Pinjaman Ditolak - Koperasi";
                $msg = "Mohon maaf, pengajuan pinjaman koperasi Anda sebesar **Rp " . number_format($loan->pokok_pinjaman, 0, ',', '.') . "** telah **DITOLAK** oleh pengurus.\n\n";
                $msg .= "Silakan hubungi pengurus Koperasi untuk informasi lebih lanjut.";
                $emailSent = \App\Services\EmailNotificationService::send($loan->user, $subject, $msg);
            }
        });

        $notifMsg = 'Status pinjaman berhasil diperbarui.';
        if ($loan->user->client->is_email_notification_active ?? false) {
            $notifMsg .= $emailSent ? ' (Email notifikasi berhasil dikirim).' : ' (Gagal mengirim email, periksa konfigurasi SMTP).';
        }

        return back()->with('success', $notifMsg);
    }

    public function updateTransactionStatus(Request $request, CooperativeTransaction $transaction)
    {
        if ($transaction->client_id !== Auth::user()->client_id) abort(403);
        
        $request->validate(['status' => 'required|in:Disetujui,Ditolak']);
        
        DB::transaction(function () use ($request, $transaction) {
            $transaction->update(['status' => $request->status]);
            
            if ($request->status === 'Disetujui') {
                $coop = Cooperative::firstOrCreate(
                    ['client_id' => $transaction->client_id, 'user_id' => $transaction->user_id],
                    ['saldo_simpanan' => 0, 'saldo_pinjaman' => 0]
                );

                if (in_array($transaction->jenis_transaksi, ['Simpanan Pokok', 'Simpanan Wajib'])) {
                    $coop->increment('saldo_simpanan', $transaction->jumlah);
                } elseif ($transaction->jenis_transaksi === 'Tarik Simpanan') {
                    $coop->decrement('saldo_simpanan', $transaction->jumlah);
                } elseif ($transaction->jenis_transaksi === 'Bayar Angsuran' && $transaction->cooperative_loan_id) {
                    $loan = CooperativeLoan::find($transaction->cooperative_loan_id);
                    if ($loan) {
                        $loan->decrement('sisa_pinjaman', $transaction->jumlah);
                        $loan->increment('angsuran_ke');
                        
                        if ($loan->sisa_pinjaman <= 0) {
                            $loan->update(['status' => 'Lunas', 'sisa_pinjaman' => 0]);
                        }
                        
                        $coop->decrement('saldo_pinjaman', $transaction->jumlah);
                    }
                }
            }
        });

        return back()->with('success', 'Status transaksi koperasi berhasil diperbarui.');
    }
}

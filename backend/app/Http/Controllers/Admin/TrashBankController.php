<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrashBankDeposit;
use App\Models\Cooperative;
use App\Models\CooperativeTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrashBankController extends Controller
{
    public function index()
    {
        $deposits = TrashBankDeposit::with('user')
            ->where('client_id', Auth::user()->client_id)
            ->latest()
            ->get();
            
        return view('admin.trashbank.index', compact('deposits'));
    }

    public function process(Request $request, TrashBankDeposit $deposit)
    {
        if ($deposit->client_id !== Auth::user()->client_id) abort(403);

        $request->validate([
            'status' => 'required|in:Selesai,Ditolak',
            'berat_kg' => 'required_if:status,Selesai|numeric|min:0.1',
            'nominal_rupiah' => 'required_if:status,Selesai|numeric|min:100',
        ]);

        try {
            DB::beginTransaction();

            $deposit->update([
                'status' => $request->status,
                'berat_kg' => $request->berat_kg ?? $deposit->berat_kg,
                'nominal_rupiah' => $request->nominal_rupiah ?? 0,
            ]);

            // Jika selesai, masukkan ke Koperasi Warga (Simpanan Sampah)
            if ($request->status === 'Selesai' && $request->nominal_rupiah > 0) {
                // Cari atau buat akun Koperasi warga tersebut
                $coop = Cooperative::firstOrCreate(
                    ['user_id' => $deposit->user_id, 'client_id' => $deposit->client_id],
                    ['saldo_simpanan' => 0, 'saldo_pinjaman' => 0]
                );

                // Buat transaksi Koperasi
                CooperativeTransaction::create([
                    'client_id' => $deposit->client_id,
                    'user_id' => $deposit->user_id,
                    'jenis_transaksi' => 'Simpanan Wajib', // Anggap hasil sampah adalah simpanan
                    'jumlah' => $request->nominal_rupiah,
                    'keterangan' => 'Hasil Bank Sampah: ' . $deposit->jenis_sampah,
                    'status' => 'Disetujui' // Langsung setuju karena admin yang memproses
                ]);

                // Tambahkan saldo simpanan
                $coop->increment('saldo_simpanan', $request->nominal_rupiah);

                // Kirim Email Notifikasi
                $subject = "Setoran Bank Sampah Berhasil";
                $msg = "Setoran Bank Sampah Anda berupa **{$deposit->jenis_sampah}** seberat **{$request->berat_kg} Kg** telah selesai ditimbang.\n\n";
                $msg .= "Dana sebesar **Rp " . number_format($request->nominal_rupiah, 0, ',', '.') . "** telah otomatis ditambahkan ke Saldo Simpanan Koperasi Anda.\n\n";
                $msg .= "Terima kasih atas partisipasi Anda dalam menjaga lingkungan!";
                $emailSent = \App\Services\EmailNotificationService::send($deposit->user, $subject, $msg);
            }

            DB::commit();

            $notifMsg = 'Setoran sampah berhasil diproses.';
            if (isset($emailSent) && ($deposit->user->client->is_email_notification_active ?? false)) {
                $notifMsg .= $emailSent ? ' (Email notifikasi berhasil dikirim).' : ' (Gagal mengirim email, periksa konfigurasi SMTP).';
            }

            return back()->with('success', $notifMsg);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client;
use App\Models\Family;
use App\Models\Contribution;
use App\Models\Payment;
use App\Models\Resident;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class GenerateMonthlyBills extends Command
{
    protected $signature = 'bills:generate';
    protected $description = 'Generate monthly bills for all active families';

    public function handle(WhatsAppService $waService)
    {
        $this->info('Mulai membuat tagihan bulanan...');
        $currentMonth = Carbon::now()->startOfMonth();

        // Ambil semua jenis iuran yang bulanan untuk klien yang mengaktifkan auto-billing
        $contributions = Contribution::whereHas('client', function($q) {
            $q->where('is_auto_billing_enabled', true)
              ->where('is_active', true);
        })->get();

        $count = 0;
        foreach ($contributions as $contribution) {
            $families = Family::where('client_id', $contribution->client_id)->get();
            
            foreach ($families as $family) {
                // Pastikan belum ada tagihan untuk bulan ini
                $existingBill = Payment::where('user_id', $family->user_id)
                    ->where('contribution_id', $contribution->id)
                    ->whereYear('created_at', $currentMonth->year)
                    ->whereMonth('created_at', $currentMonth->month)
                    ->first();

                if (!$existingBill) {
                    $payment = Payment::create([
                        'client_id' => $contribution->client_id,
                        'user_id' => $family->user_id,
                        'contribution_id' => $contribution->id,
                        'jumlah_bayar' => $contribution->nominal,
                        'tanggal_bayar' => null, // Belum dibayar
                        'status' => 'unpaid',
                        'created_at' => $currentMonth, // Dianggap terbit tanggal 1
                        'updated_at' => Carbon::now(),
                    ]);
                    $count++;
                    
                    // Trigger WA Notification to Kepala Keluarga
                    $kepala = Resident::where('family_id', $family->id)
                                ->where('status_keluarga', 'Kepala Keluarga')
                                ->first();
                                
                    if ($kepala && $kepala->no_hp) {
                        $msg = "Halo Bpk/Ibu {$kepala->nama},\n\n";
                        $msg .= "Tagihan *{$contribution->nama_iuran}* untuk bulan " . $currentMonth->format('M Y') . " telah terbit.\n";
                        $msg .= "Total Tagihan: *Rp " . number_format($contribution->nominal, 0, ',', '.') . "*\n\n";
                        $msg .= "Silakan login ke sistem Smart RW untuk melakukan pembayaran. Terima kasih.";
                        
                        $waService->sendMessage($kepala->no_hp, $msg);
                    }
                }
            }
        }

        $this->info("Berhasil membuat $count tagihan baru untuk bulan ini.");
    }
}

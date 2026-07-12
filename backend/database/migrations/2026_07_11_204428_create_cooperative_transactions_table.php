<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cooperative_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('jenis_transaksi', ['Simpanan Pokok', 'Simpanan Wajib', 'Tarik Simpanan', 'Bayar Angsuran', 'Pencairan Pinjaman']);
            $table->decimal('jumlah', 15, 2);
            $table->string('bukti_bayar')->nullable();
            $table->string('keterangan')->nullable();
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            // Link ke loan jika ini angsuran
            $table->foreignId('cooperative_loan_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cooperative_transactions');
    }
};

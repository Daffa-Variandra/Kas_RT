<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trash_bank_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('jenis_sampah');
            $table->decimal('berat_kg', 8, 2)->nullable();
            $table->decimal('nominal_rupiah', 15, 2)->nullable();
            $table->string('keterangan')->nullable();
            $table->enum('status', ['Menunggu Jemput', 'Menunggu Timbang', 'Selesai', 'Ditolak'])->default('Menunggu Jemput');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trash_bank_deposits');
    }
};

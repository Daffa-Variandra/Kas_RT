<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cooperative_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('pokok_pinjaman', 15, 2);
            $table->integer('tenor_bulan');
            $table->enum('skema', ['flat', 'margin']);
            $table->decimal('margin_persen', 5, 2)->default(0);
            $table->decimal('total_pinjaman', 15, 2);
            $table->decimal('angsuran_per_bulan', 15, 2);
            $table->decimal('sisa_pinjaman', 15, 2);
            $table->integer('angsuran_ke')->default(0);
            $table->string('keterangan')->nullable();
            $table->enum('status', ['Menunggu', 'Berjalan', 'Lunas', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cooperative_loans');
    }
};

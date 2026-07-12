<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posyandu_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_pasien');
            $table->enum('kategori', ['Balita', 'Ibu Hamil', 'Lansia']);
            $table->decimal('berat_badan', 5, 2)->nullable(); // kg
            $table->decimal('tinggi_badan', 5, 2)->nullable(); // cm
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posyandu_records');
    }
};

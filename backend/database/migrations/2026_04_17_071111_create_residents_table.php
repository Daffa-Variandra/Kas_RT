<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->cascadeOnDelete();
            $table->foreignId('family_id')->constrained()->onDelete('cascade');
            $table->string('nik', 16);
            $table->string('nama');
            $table->string('no_hp', 15)->nullable();
            $table->enum('status_keluarga', ['Kepala Keluarga', 'Istri', 'Anak', 'Lainnya'])->default('Lainnya');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};

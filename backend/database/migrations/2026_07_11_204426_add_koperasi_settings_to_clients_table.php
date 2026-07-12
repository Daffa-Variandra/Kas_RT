<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->enum('koperasi_skema', ['flat', 'margin'])->default('flat');
            $table->decimal('koperasi_margin_persen', 5, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['koperasi_skema', 'koperasi_margin_persen']);
        });
    }
};

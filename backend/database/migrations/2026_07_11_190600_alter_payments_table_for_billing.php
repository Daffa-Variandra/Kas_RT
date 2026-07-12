<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, modifying ENUM requires raw queries or string approach depending on doctrine/dbal.
        // It's safer to use raw DB statement for ENUM modification in MySQL if doctrine isn't fully set up for it.
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('unpaid', 'pending', 'success', 'failed') DEFAULT 'unpaid'");
        
        Schema::table('payments', function (Blueprint $table) {
            $table->date('tanggal_bayar')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending', 'success', 'failed') DEFAULT 'pending'");
        Schema::table('payments', function (Blueprint $table) {
            $table->date('tanggal_bayar')->nullable(false)->change();
        });
    }
};

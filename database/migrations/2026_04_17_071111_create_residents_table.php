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
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nik', 16)->unique();
        $table->string('no_hp', 15);
        $table->text('alamat');
        $table->enum('status_hunian', ['Tetap', 'Kontrak']);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};

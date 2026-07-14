<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('sensor_logs', function (Blueprint $table) {
        $table->id();
        // Menghubungkan log ke tabel sectors
        $table->foreignId('sector_id')->constrained()->onDelete('cascade'); 
        $table->integer('kelembaban');
        $table->string('status_pompa');
        $table->timestamps(); // Ini otomatis mencatat tanggal & jam pengecekan!
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_logs');
    }
};

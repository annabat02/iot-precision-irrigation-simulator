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
    Schema::create('sectors', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('tanaman');
        $table->integer('ambang_batas'); 
        $table->integer('frekuensi_ideal');
        $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sectors');
    }
};

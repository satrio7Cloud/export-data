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
        Schema::create('libur', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique(); // Tanggal libur (unik)
            $table->string('keterangan')->nullable(); // Deskripsi atau alasan libur
            $table->foreignId('id_karyawan')->constrained('karyawan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libur');
    }
};

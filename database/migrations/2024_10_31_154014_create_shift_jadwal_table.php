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
        Schema::create('shift_jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_karyawan')->constrained('karyawan')->onDelete('cascade'); // Relasi dengan tabel karyawan
            $table->string('shift_nama'); // Nama atau deskripsi shift (misalnya, "Pagi", "Sore")
            $table->time('jam_masuk'); // Jam masuk shift
            $table->time('jam_keluar'); // Jam keluar shift
            $table->string('hari'); // Hari kerja yang berlaku untuk shift ini, misal "Senin", "Selasa", dll.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_jadwal');
    }
};

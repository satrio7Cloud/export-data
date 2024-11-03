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
        Schema::create('tbl_anggota', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']); // L untuk Laki-laki, P untuk Perempuan
            $table->date('tgl_lahir');
            $table->string('alamat');
            $table->string('kota');
            $table->string('notelp')->nullable();
            $table->boolean('aktif')->default(true); // Status keaktifan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_anggota');
    }
};

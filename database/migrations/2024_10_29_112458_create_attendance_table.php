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
        // Schema::create('attendance', function (Blueprint $table) {
        //     $table->id(); // Primary key
        //     $table->foreignId('id_karyawan')->constrained('karyawan')->onDelete('cascade'); // Foreign key to karyawan table
        //     $table->date('tanggal'); // Date of attendance
        //     $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha']); // Attendance status
        //     $table->timestamps(); // Created at and updated at timestamps
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};

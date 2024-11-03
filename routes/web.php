<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DataAnggotaController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LiburController;
use App\Http\Controllers\ShiftJadwalController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ========= difference designed =========

Route::resource('tasks', TasksController::class);

// ========= difference designed =========

// bertanggung jawab untuk mengenerate dan mengunduh file Excel yang berisi data anggota.
Route::get('anggota/export-excel', [DataAnggotaController::class, 'exportExcel'])->name('anggota.exportExcel');
// menangani file Excel yang diunggah dan memprosesnya untuk menyimpan data anggota ke dalam database.
Route::post('anggota/import-excel', [DataAnggotaController::class, 'importExcel'])->name('anggota.importExcel');

Route::resource('anggota', DataAnggotaController::class);

// Route untuk mencetak PDF
Route::get('anggota/{id}/print', [DataAnggotaController::class, 'print'])->name('anggota.print');

// ========= difference designed =========

// Rute untuk Karyawan
Route::post('/karyawan/import-excel', [KaryawanController::class, 'importExcel'])->name('karyawan.import.excel');
Route::post('/karyawan/import-pdf', [KaryawanController::class, 'importPDF'])->name('karyawan.import.pdf');
Route::resource('karyawan', KaryawanController::class);

// Rute untuk Absensi
Route::resource('absensi', AbsensiController::class);
Route::get('/absensi/status', [AbsensiController::class, 'checkStatus'])->name('absensi.checkStatus');


// Rute untuk Izin
Route::resource('izin', IzinController::class);

// Route for Attendance Chart
Route::get('attendance/report', [AttendanceController::class, 'index'])->name('attendance.report');

// Route untuk menghasilkan laporan dalam format PDF dan Excel
Route::get('attendance/report/pdf', [AttendanceController::class, 'generatePdf'])->name('attendance.report.pdf');
Route::get('attendance/report/excel', [AttendanceController::class, 'generateExcel'])->name('attendance.report.excel');

Route::resource('cuti', CutiController::class);
Route::resource('libur', LiburController::class);

use App\Http\Controllers\ShiftController; // Ganti dengan namespace yang sesuai

Route::post('/shift/import-excel', [ShiftJadwalController::class, 'importExcel'])->name('shift.import.excel');
Route::post('/shift/import-pdf', [ShiftJadwalController::class, 'importPdf'])->name('shift.import.pdf');
Route::resource('shift', ShiftJadwalController::class);


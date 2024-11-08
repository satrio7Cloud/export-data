<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DataAnggotaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LiburController;
use App\Http\Controllers\ShiftJadwalController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk menampilkan form login
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');

// Route untuk menampilkan form registrasi
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');

// Route untuk login (POST request untuk autentikasi)
Route::post('login', [AuthController::class, 'login']);

// Route untuk registrasi (POST request untuk pendaftaran)
Route::post('register', [AuthController::class, 'register']);

// Rute halaman utama setelah login (hanya bisa diakses oleh pengguna yang sudah login)
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Route untuk logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Grup route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::resource('tasks', TasksController::class);

    // Rute untuk eksport dan import anggota
    Route::get('anggota/export-excel', [DataAnggotaController::class, 'exportExcel'])->name('anggota.exportExcel');
    Route::post('anggota/import-excel', [DataAnggotaController::class, 'importExcel'])->name('anggota.importExcel');
    Route::resource('anggota', DataAnggotaController::class);

    // Route untuk mencetak PDF
    Route::get('anggota/{id}/print', [DataAnggotaController::class, 'print'])->name('anggota.print');

    // Rute untuk Karyawan
    Route::post('/karyawan/import-excel', [KaryawanController::class, 'importExcel'])->name('karyawan.import.excel');
    Route::resource('karyawan', KaryawanController::class);

    // Rute untuk Absensi
    Route::resource('absensi', AbsensiController::class);
    Route::get('/absensi/status', [AbsensiController::class, 'checkStatus'])->name('absensi.checkStatus');

    // Rute untuk Izin
    Route::resource('izin', IzinController::class);

    // Route for Attendance Chart
    Route::get('attendance/report', [AttendanceController::class, 'index'])->name('attendance.report');
    Route::get('attendance/report/pdf', [AttendanceController::class, 'generatePdf'])->name('attendance.report.pdf');
    Route::get('attendance/report/excel', [AttendanceController::class, 'generateExcel'])->name('attendance.report.excel');

    Route::resource('cuti', CutiController::class);
    Route::resource('libur', LiburController::class);

    Route::post('/shift/import-excel', [ShiftJadwalController::class, 'importExcel'])->name('shift.import.excel');
    Route::post('/shift/import-pdf', [ShiftJadwalController::class, 'importPdf'])->name('shift.import.pdf');
    Route::resource('shift', ShiftJadwalController::class);
});

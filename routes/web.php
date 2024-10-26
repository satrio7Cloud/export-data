<?php

use App\Http\Controllers\DataAnggotaController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tasks', TasksController::class);

Route::resource('anggota', DataAnggotaController::class);


// Route untuk mencetak PDF
Route::get('anggota/{id}/print', [DataAnggotaController::class, 'print'])->name('anggota.print');


// bertanggung jawab untuk mengenerate dan mengunduh file Excel yang berisi data anggota.
Route::get('anggota/export-excel', [DataAnggotaController::class, 'exportExcel'])->name('anggota.exportExcel');
// menangani file Excel yang diunggah dan memprosesnya untuk menyimpan data anggota ke dalam database.
Route::post('anggota/import-excel', [DataAnggotaController::class, 'importExcel'])->name('anggota.importExcel');


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

// Route export Excel (HARUS di atas resource)
Route::get('/mahasiswa/export', [MahasiswaController::class, 'export'])->name('mahasiswa.export');

// Route cetak PDF (HARUS di atas resource juga)
Route::get('/mahasiswa/cetak-pdf', [MahasiswaController::class, 'cetakPdf'])->name('mahasiswa.cetakPdf');

// Route utama CRUD mahasiswa
Route::resource('/mahasiswa', MahasiswaController::class);

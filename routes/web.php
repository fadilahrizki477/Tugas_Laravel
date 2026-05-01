<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KrsController;

Route::get('/', function () {
    return redirect('/dosen');
});

// DOSEN
Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
Route::get('/dosen/create', [DosenController::class, 'create'])->name('dosen.create');
Route::post('/dosen/store', [DosenController::class, 'store'])->name('dosen.store');
Route::get('/dosen/{nidn}/detail', [DosenController::class, 'show'])->name('dosen.detail');
Route::get('/dosen/{nidn}/edit', [DosenController::class, 'edit'])->name('dosen.edit');
Route::put('/dosen/{nidn}/update', [DosenController::class, 'update'])->name('dosen.update');

// MAHASISWA
Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
Route::post('/mahasiswa/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
Route::get('/mahasiswa/{npm}/detail', [MahasiswaController::class, 'show'])->name('mahasiswa.detail');
Route::get('/mahasiswa/{npm}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
Route::put('/mahasiswa/{npm}/update', [MahasiswaController::class, 'update'])->name('mahasiswa.update');

// MATAKULIAH
Route::get('/matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah.index');
Route::get('/matakuliah/create', [MatakuliahController::class, 'create'])->name('matakuliah.create');
Route::post('/matakuliah/store', [MatakuliahController::class, 'store'])->name('matakuliah.store');
Route::get('/matakuliah/{kode}/detail', [MatakuliahController::class, 'show'])->name('matakuliah.detail');
Route::get('/matakuliah/{kode}/edit', [MatakuliahController::class, 'edit'])->name('matakuliah.edit');
Route::put('/matakuliah/{kode}/update', [MatakuliahController::class, 'update'])->name('matakuliah.update');

// JADWAL
Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
Route::get('/jadwal/{id}/detail', [JadwalController::class, 'show'])->name('jadwal.detail');
Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
Route::put('/jadwal/{id}/update', [JadwalController::class, 'update'])->name('jadwal.update');

// KRS
Route::get('/krs', [KrsController::class, 'index'])->name('krs.index');
Route::get('/krs/create', [KrsController::class, 'create'])->name('krs.create');
Route::post('/krs/store', [KrsController::class, 'store'])->name('krs.store');
Route::get('/krs/{id}/detail', [KrsController::class, 'show'])->name('krs.detail');
Route::get('/krs/{id}/edit', [KrsController::class, 'edit'])->name('krs.edit');
Route::put('/krs/{id}/update', [KrsController::class, 'update'])->name('krs.update');
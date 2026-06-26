<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KrsController;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin' ? redirect('/dosen') : redirect('/jadwal');
    }
    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::put('/dashboard/password', [DashboardController::class, 'updatePassword'])->middleware(['auth'])->name('dashboard.password');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ==================== ROUTE DARURAT (DEVELOPER ONLY) ====================
Route::get('/reset-admin-darurat', [\App\Http\Controllers\DeveloperController::class, 'resetAdminPassword']);

// ==================== DOSEN (Admin only) ====================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
    Route::get('/dosen/create', [DosenController::class, 'create'])->name('dosen.create');
    Route::post('/dosen/store', [DosenController::class, 'store'])->name('dosen.store');
    Route::get('/dosen/{nidn}/detail', [DosenController::class, 'show'])->name('dosen.detail');
    Route::get('/dosen/{nidn}/edit', [DosenController::class, 'edit'])->name('dosen.edit');
    Route::put('/dosen/{nidn}/update', [DosenController::class, 'update'])->name('dosen.update');
    Route::delete('/dosen/{nidn}/delete', [DosenController::class, 'destroy'])->name('dosen.delete');
});

// ==================== MAHASISWA (Admin only - data management) ====================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('/mahasiswa/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::get('/mahasiswa/{npm}/detail', [MahasiswaController::class, 'show'])->name('mahasiswa.detail');
    Route::get('/mahasiswa/{npm}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::put('/mahasiswa/{npm}/update', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::put('/mahasiswa/{npm}/reset-password', [MahasiswaController::class, 'resetPassword'])->name('mahasiswa.reset-password');
    Route::delete('/mahasiswa/{npm}/delete', [MahasiswaController::class, 'destroy'])->name('mahasiswa.delete');
});

// ==================== MATAKULIAH (Admin only) ====================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah.index');
    Route::get('/matakuliah/create', [MatakuliahController::class, 'create'])->name('matakuliah.create');
    Route::post('/matakuliah/store', [MatakuliahController::class, 'store'])->name('matakuliah.store');
    Route::get('/matakuliah/{kode}/detail', [MatakuliahController::class, 'show'])->name('matakuliah.detail');
    Route::get('/matakuliah/{kode}/edit', [MatakuliahController::class, 'edit'])->name('matakuliah.edit');
    Route::put('/matakuliah/{kode}/update', [MatakuliahController::class, 'update'])->name('matakuliah.update');
    Route::delete('/matakuliah/{kode}/delete', [MatakuliahController::class, 'destroy'])->name('matakuliah.delete');
});

// ==================== JADWAL (Admin kelola, Mahasiswa lihat saja) ====================
Route::middleware(['auth', 'role:admin,mahasiswa'])->group(function () {
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/{id}/detail', [JadwalController::class, 'show'])->name('jadwal.detail');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{id}/update', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{id}/delete', [JadwalController::class, 'destroy'])->name('jadwal.delete');
});

// ==================== KRS (Admin & Mahasiswa boleh akses) ====================
Route::middleware(['auth', 'role:admin,mahasiswa'])->group(function () {
    Route::get('/krs', [KrsController::class, 'index'])->name('krs.index');
    Route::get('/krs/export-pdf', [KrsController::class, 'exportPdf'])->name('krs.export-pdf');
    Route::get('/krs/export-excel', [KrsController::class, 'exportExcel'])->name('krs.export-excel');
    Route::get('/krs/create', [KrsController::class, 'create'])->name('krs.create');
    Route::post('/krs/store', [KrsController::class, 'store'])->name('krs.store');
    Route::get('/krs/{id}/detail', [KrsController::class, 'show'])->name('krs.detail');
    Route::get('/krs/{id}/edit', [KrsController::class, 'edit'])->name('krs.edit');
    Route::put('/krs/{id}/update', [KrsController::class, 'update'])->name('krs.update');
    Route::delete('/krs/{id}/delete', [KrsController::class, 'destroy'])->name('krs.delete');
});
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard - semua role bisa akses
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // KARYAWAN ROUTES - HANYA SUPERVISOR (bisa lihat semua)
    Route::middleware(['role:supervisor'])->group(function () {
        Route::resource('karyawan', KaryawanController::class);
    });

    // PRODUK ROUTES - HANYA SUPERVISOR (bisa lihat semua)
    Route::middleware(['role:supervisor'])->group(function () {
        Route::resource('produk', ProdukController::class);
    });

    // ABSENSI ROUTES - HANYA SUPERVISOR (bisa lihat semua)
    Route::middleware(['role:supervisor'])->group(function () {
        Route::resource('absensi', AbsensiController::class);
    });

    // Profile - semua role
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes untuk Karyawan
Route::prefix('karyawan')->group(function () {
    Route::get('/', [KaryawanController::class, 'index'])->name('karyawan.index'); // List karyawan
    Route::get('/create', [KaryawanController::class, 'create'])->name('karyawan.create'); // Form tambah
    Route::post('/store', [KaryawanController::class, 'store'])->name('karyawan.store'); // Simpan data
    Route::get('/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit'); // Form edit
    Route::put('/{id}/update', [KaryawanController::class, 'update'])->name('karyawan.update'); // Update data
    Route::delete('/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy'); // Hapus data
});

require __DIR__ . '/auth.php';

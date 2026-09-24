<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

// Route Publik (Frontend Pengguna)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan.index');
Route::get('/layanan/{id}', [HomeController::class, 'detailLayanan'])->name('layanan.detail');
Route::get('/dekorasi', [HomeController::class, 'dekorasi'])->name('dekorasi.index');

// Route Admin (Dashboard & Verifikasi)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/booking/{id}/verifikasi', [AdminController::class, 'verifikasiPembayaran'])->name('admin.verifikasi');
});

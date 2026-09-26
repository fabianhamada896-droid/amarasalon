<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;

// Route Publik (Frontend Pengguna)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan.index');
Route::get('/layanan/{id}', [HomeController::class, 'detailLayanan'])->name('layanan.detail');
Route::get('/dekorasi', [HomeController::class, 'dekorasi'])->name('dekorasi.index');

// Route Booking (Form & Simpan Pesanan)
Route::get('/booking/{id}', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
Route::get('/riwayat-pesanan', [BookingController::class, 'index'])->name('booking.riwayat');

// Route Admin (Dashboard & Verifikasi)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/booking/{id}/verifikasi', [AdminController::class, 'verifikasiPembayaran'])->name('admin.verifikasi');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;

// Route Publik (Frontend Pengguna)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan.index');
Route::get('/layanan/{id}', [HomeController::class, 'detailLayanan'])->name('layanan.detail');
Route::get('/dekorasi', [HomeController::class, 'dekorasi'])->name('dekorasi.index');

// Route Guest (Hanya bisa diakses jika belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout (Bisa diakses jika sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Route Booking (Membutuhkan Login)
Route::middleware('auth')->group(function () {
    Route::get('/booking/{id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/riwayat-pesanan', [BookingController::class, 'index'])->name('booking.riwayat');
    Route::post('/booking/{id}/upload-pembayaran', [BookingController::class, 'uploadPembayaran'])->name('booking.uploadPembayaran');
});

// Route Admin (Dashboard, Verifikasi, & Manajemen Katalog)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/pembayaran', [AdminController::class, 'pembayaranIndex'])->name('admin.pembayaran.index');
    Route::post('/pembayaran/{id}/verifikasi', [AdminController::class, 'verifikasiPembayaran'])->name('admin.pembayaran.verifikasi');

    // --- TAMBAHAN ROUTE CRUD KATALOG (LAYANAN & DEKORASI) ---
    Route::get('/katalog', [AdminController::class, 'katalogIndex'])->name('admin.katalog.index');
    
    // Layanan
    Route::post('/layanan', [AdminController::class, 'storeLayanan'])->name('admin.layanan.store');
    Route::delete('/layanan/{id}', [AdminController::class, 'destroyLayanan'])->name('admin.layanan.destroy');
    
    // Dekorasi
    Route::post('/dekorasi', [AdminController::class, 'storeDekorasi'])->name('admin.dekorasi.store');
    Route::delete('/dekorasi/{id}', [AdminController::class, 'destroyDekorasi'])->name('admin.dekorasi.destroy');
});
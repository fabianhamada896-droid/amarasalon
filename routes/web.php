<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;


// ==========================================================
// ROUTE PUBLIK
// ==========================================================

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/layanan', [HomeController::class, 'layanan'])
    ->name('layanan.index');

Route::get('/layanan/{id}', [HomeController::class, 'detailLayanan'])
    ->name('layanan.detail');

Route::get('/dekorasi', [HomeController::class, 'dekorasi'])
    ->name('dekorasi.index');


// ==========================================================
// ROUTE GUEST
// ==========================================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);
});


// ==========================================================
// LOGOUT
// ==========================================================

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


// ==========================================================
// ROUTE BOOKING
// ==========================================================

Route::middleware('auth')->group(function () {

    // ======================================================
    // FORM BOOKING
    // ======================================================

    Route::get('/booking/{id}', [BookingController::class, 'create'])
        ->name('booking.create');


    // ======================================================
    // SIMPAN BOOKING
    // ======================================================

    Route::post('/booking/store', [BookingController::class, 'store'])
        ->name('booking.store');


    // ======================================================
    // RIWAYAT PESANAN
    // ======================================================

    Route::get('/riwayat-pesanan', [BookingController::class, 'index'])
        ->name('booking.riwayat');


    // ======================================================
    // QRIS
    // ======================================================

    Route::get('/qris/{id}', [BookingController::class, 'qris'])
        ->name('booking.qris');


    // ======================================================
    // UPLOAD BUKTI PEMBAYARAN
    // ======================================================

    Route::post(
        '/booking/{id}/upload-pembayaran',
        [BookingController::class, 'uploadPembayaran']
    )->name('booking.uploadPembayaran');
});


// ==========================================================
// ROUTE ADMIN
// ==========================================================

Route::prefix('admin')->middleware('auth')->group(function () {

    // ======================================================
    // DASHBOARD
    // ======================================================

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');


    // ======================================================
    // PEMBAYARAN
    // ======================================================

    Route::get('/pembayaran', [AdminController::class, 'pembayaranIndex'])
        ->name('admin.pembayaran.index');


    // Lihat bukti pembayaran

    Route::get(
        '/pembayaran/bukti/{filename}',
        [AdminController::class, 'lihatBuktiPembayaran']
    )->name('admin.pembayaran.bukti');


    // Verifikasi pembayaran

    Route::post(
        '/pembayaran/{id}/verifikasi',
        [AdminController::class, 'verifikasiPembayaran']
    )->name('admin.pembayaran.verifikasi');


    // ======================================================
    // KATALOG
    // ======================================================

    Route::get('/katalog', [AdminController::class, 'katalogIndex'])
        ->name('admin.katalog.index');


    // ======================================================
    // LAYANAN
    // ======================================================

    Route::post(
        '/layanan',
        [AdminController::class, 'storeLayanan']
    )->name('admin.layanan.store');

    Route::delete(
        '/layanan/{id}',
        [AdminController::class, 'destroyLayanan']
    )->name('admin.layanan.destroy');


    // ======================================================
    // DEKORASI
    // ======================================================

    Route::post(
        '/dekorasi',
        [AdminController::class, 'storeDekorasi']
    )->name('admin.dekorasi.store');

    Route::delete(
        '/dekorasi/{id}',
        [AdminController::class, 'destroyDekorasi']
    )->name('admin.dekorasi.destroy');
});

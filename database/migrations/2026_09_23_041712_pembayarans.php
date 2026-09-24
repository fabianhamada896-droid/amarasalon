<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_booking')->constrained('bookings', 'id_booking')->onDelete('cascade');
            $table->decimal('jumlah_bayar', 12, 2);
            $table->string('metode_pembayaran', 30)->default('QRIS');
            $table->string('jenis_pembayaran', 30)->default('DP'); // DP atau Pelunasan
            $table->string('bukti_pembayaran', 255); // Menyimpan nama file gambar bukti transfer
            $table->dateTime('tanggal_bayar');
            $table->string('status_pembayaran', 30)->default('Pending'); // Pending, Valid, Ditolak
            $table->unsignedBigInteger('id_admin')->nullable(); // ID admin yang memverifikasi
            $table->text('catatan')->nullable(); // Catatan jika ditolak/valid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
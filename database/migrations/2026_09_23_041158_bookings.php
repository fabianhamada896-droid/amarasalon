<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('id_booking');
            $table->string('kode_booking', 20)->unique();
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->date('tanggal_booking');
            $table->time('jam_booking');
            $table->decimal('total_harga', 12, 2);
            $table->decimal('jumlah_dp', 12, 2);
            $table->decimal('sisa_pembayaran', 12, 2);
            $table->string('status_booking', 30)->default('Menunggu'); // Menunggu, Dikonfirmasi, Ditolak, Selesai
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
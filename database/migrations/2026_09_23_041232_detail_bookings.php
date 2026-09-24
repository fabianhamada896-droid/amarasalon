<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_bookings', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_booking')->constrained('bookings', 'id_booking')->onDelete('cascade');
            $table->foreignId('id_layanan')->constrained('layanans', 'id_layanan')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_bookings');
    }
};
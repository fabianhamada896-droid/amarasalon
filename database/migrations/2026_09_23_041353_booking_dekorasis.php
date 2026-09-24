<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_dekorasis', function (Blueprint $table) {
            $table->id('id_booking_dekorasi');
            $table->foreignId('id_booking')->constrained('bookings', 'id_booking')->onDelete('cascade');
            $table->foreignId('id_dekorasi')->constrained('dekorasis', 'id_dekorasi')->onDelete('cascade');
            $table->decimal('harga', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_dekorasis');
    }
};
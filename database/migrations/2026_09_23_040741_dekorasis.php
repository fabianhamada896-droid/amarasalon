<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dekorasis', function (Blueprint $table) {
            $table->id('id_dekorasi');
            $table->string('nama_paket', 100);
            $table->string('jenis_dekorasi', 50); // Indoor / Outdoor / Minimalis
            $table->decimal('harga', 12, 2);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dekorasis');
    }
};
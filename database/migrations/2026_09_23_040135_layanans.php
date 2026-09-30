<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id('id_layanan');
            $table->string('nama_layanan', 100);
            $table->string('kategori', 50); 
            $table->decimal('harga', 12, 2);
            $table->integer('durasi')->nullable(); 
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable(); // <-- Kolom foto
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};

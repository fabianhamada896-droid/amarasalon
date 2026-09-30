<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;
use App\Models\Dekorasi;

class AmaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Daftar list layanan salon (tambahkan 'foto')
        Layanan::create([
            'nama_layanan' => 'Makeup Akad',
            'kategori' => 'Makeup',
            'deskripsi' => 'Free Softlens.',
            'harga' => 1000000,
            'durasi' => 120,
            'foto' => 'uploads/layanan/layanan1.png', // Sesuaikan dengan nama file di storage/app/public/layanan/
        ]);

        Layanan::create([
            'nama_layanan' => 'Hairdo & Styling Modern',
            'kategori' => 'Hair',
            'deskripsi' => 'Penataan rambut profesional untuk acara wisuda, pesta, atau kondangan dengan hasil tahan lama.',
            'harga' => 200000,
            'durasi' => 60,
            'foto' => 'uploads/layanan/layanan2.png',
        ]);

        // 2. Daftar list dekorasi (tambahkan 'foto')
        Dekorasi::create([
            'nama_paket' => 'Paket Engagment',
            'jenis_dekorasi' => 'Repsesi',
            'deskripsi' => 'Dekorasi
            Makeup.',
            'harga' => 1000000,
            'foto' => 'uploads/dekorasi/dekorasi2.png', // Sesuaikan dengan nama file di storage/app/public/dekorasi/
        ]);

        Dekorasi::create([
            'nama_paket' => 'Paket Minimalis',
            'jenis_dekorasi' => 'Akad Nikah',
            'deskripsi' => 'Dekorasi Minimalis
            Makeup
            Satu Set Alat Parasmanan.',
            'harga' => 2000000,
            'foto' => 'uploads/dekorasi/dekorasi2.png',
        ]);

         Dekorasi::create([
            'nama_paket' => 'Paket Standar',
            'jenis_dekorasi' => 'Akad Nikah',
            'deskripsi' => 'Dekorasi,Pelaminan 6meter,Makeup Pengantin,Satu Pasang Baju Akad,Siger Aksesoris Melati,Set Alat Parasmanan dan Alat Makan 100,Hena dan Nail Art,Free Softlens.',
            'harga' => 2000000,
            'foto' => 'uploads/dekorasi/dekorasi2.png',
        ]);
    }
}
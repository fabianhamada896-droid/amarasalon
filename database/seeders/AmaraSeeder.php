<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;
use App\Models\Dekorasi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AmaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat User dummy agar relasi id_user (foreign key) aman saat booking
        User::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Maman',
                'email' => 'maman@example.com',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Daftar list layanan salon
        Layanan::create([
            'nama_layanan' => 'Makeup Pengantin Tradisional',
            'kategori' => 'Makeup',
            'deskripsi' => 'Riasan pengantin tradisional lengkap dengan paes atau sunting berkualitas tinggi dan tahan seharian.',
            'harga' => 2500000,
            'durasi' => 120,
        ]);

        Layanan::create([
            'nama_layanan' => 'Hairdo & Styling Modern',
            'kategori' => 'Hair',
            'deskripsi' => 'Penataan rambut profesional untuk acara wisuda, pesta, atau kondangan dengan hasil tahan lama.',
            'harga' => 350000,
            'durasi' => 60,
        ]);

        Layanan::create([
            'nama_layanan' => 'Dekorasi Akad Nikah Minimalis',
            'kategori' => 'Dekorasi',
            'deskripsi' => 'Paket dekorasi pelaminan modern minimalis untuk acara akad nikah di rumah atau gedung.',
            'harga' => 4500000,
            'durasi' => 180,
        ]);

        // 3. Daftar list dekorasi
        Dekorasi::create([
            'nama_paket' => 'Paket Akad Minimalis',
            'jenis_dekorasi' => 'Akad Nikah',
            'deskripsi' => 'Paket pelaminan modern minimalis untuk acara akad di rumah maupun gedung.',
            'harga' => 4500000,
        ]);

        Dekorasi::create([
            'nama_paket' => 'Paket Resepsi Rustic',
            'jenis_dekorasi' => 'Resepsi',
            'deskripsi' => 'Konsep dekorasi pelaminan gaya rustic dengan sentuhan kayu dan bunga segar.',
            'harga' => 8500000,
        ]);
    }
}
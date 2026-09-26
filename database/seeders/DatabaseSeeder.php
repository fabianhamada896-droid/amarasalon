<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder kamu di sini supaya otomatis ikut ke-seed
        $this->call([
            AmaraSeeder::class,
        ]);
    }
}
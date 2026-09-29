<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Amara',
            'email' => 'admin@gmail.com',
            'no_hp' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'name' => 'Maman',
            'email' => 'maman@example.com',
            'no_hp' => '089876543210',
            'role' => 'customer',
            'password' => Hash::make('password123'),
        ]);
    }
}
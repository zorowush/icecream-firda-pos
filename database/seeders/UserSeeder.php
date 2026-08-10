<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@firda.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'is_active' => true,
            ]
        );

        // Kasir
        User::updateOrCreate(
            ['email' => 'kasir@firda.com'],
            [
                'name' => 'Kasir',
                'password' => Hash::make('kasir123'),
                'role' => 'kasir',
                'phone' => '081234567891',
                'is_active' => true,
            ]
        );
    }
}
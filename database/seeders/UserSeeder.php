<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Data Admin
        User::create([
            'name' => 'Pak RT (Admin)',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Data Bendahara
        User::create([
            'name' => 'Ibu Bendahara',
            'email' => 'bendahara@gmail.com',
            'password' => Hash::make('bendahara123'),
            'role' => 'bendahara',
        ]);

        // Data Warga
        User::create([
            'name' => 'Bapak Warga',
            'email' => 'warga@gmail.com',
            'password' => Hash::make('warga123'),
            'role' => 'warga',
        ]);
    }
}
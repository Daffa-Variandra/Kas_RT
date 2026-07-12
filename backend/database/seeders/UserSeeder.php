<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Data SuperAdmin (SaaS Owner)
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@kasrt.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'client_id' => null, // Superadmin is not bound to a client
        ]);

        // Create a Dummy Client
        $client = \App\Models\Client::create([
            'name' => 'RW 05 Taman Elok',
            'code' => 'RW05TE',
            'address' => 'Perumahan Taman Elok RW 05',
            'is_active' => true,
        ]);

        // Data Admin
        User::create([
            'name' => 'Admin RT',
            'email' => 'admin@rt005.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'client_id' => $client->id,
        ]);

        // Data Bendahara
        User::create([
            'name' => 'Bendahara RT',
            'email' => 'bendahara@rt005.com',
            'password' => Hash::make('password'),
            'role' => 'bendahara',
            'client_id' => $client->id,
        ]);
    }
}
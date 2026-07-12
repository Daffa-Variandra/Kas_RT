<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;
use App\Models\Family;
use App\Models\Resident;
use App\Models\Contribution;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $client = Client::first();
        if (!$client) {
            $client = Client::create([
                'name' => 'RW 05 Taman Elok',
                'code' => 'RW05TE',
                'address' => 'Perumahan Taman Elok RW 05',
                'is_active' => true,
            ]);
        }

        // 1. Jenis Iuran (5 Data)
        $iurans = [
            ['nama_iuran' => 'Iuran Kebersihan', 'nominal' => 25000, 'deskripsi' => 'Biaya pengangkutan sampah rutin bulanan'],
            ['nama_iuran' => 'Iuran Keamanan', 'nominal' => 30000, 'deskripsi' => 'Biaya operasional security lingkungan'],
            ['nama_iuran' => 'Kas RT Bulanan', 'nominal' => 15000, 'deskripsi' => 'Iuran wajib bulanan kas operasional RT'],
            ['nama_iuran' => 'Dana Sosial & Kematian', 'nominal' => 10000, 'deskripsi' => 'Sumbangan wajib untuk menjenguk orang sakit atau dana santunan kematian'],
            ['nama_iuran' => 'Dana Pembangunan Gapura', 'nominal' => 100000, 'deskripsi' => 'Iuran insidentil untuk pembangunan gapura utama kompleks'],
        ];

        foreach ($iurans as $i) {
            Contribution::firstOrCreate([
                'client_id' => $client->id,
                'nama_iuran' => $i['nama_iuran'],
            ], [
                'nominal' => $i['nominal'],
                'deskripsi' => $i['deskripsi'],
            ]);
        }

        // 2. Data Keluarga & Warga (100 Keluarga, masing-masing 2-3 warga)
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 1; $i <= 100; $i++) {
            $email = $faker->unique()->safeEmail;
            if (!User::where('email', $email)->exists()) {
                $user = User::create([
                    'client_id' => $client->id,
                    'name' => 'Keluarga ' . $faker->name,
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'role' => 'warga',
                ]);

                $family = Family::create([
                    'client_id' => $client->id,
                    'user_id' => $user->id,
                    'no_kk' => $faker->numerify('3271############'),
                    'alamat' => 'Blok ' . $faker->randomLetter . ' No. ' . rand(1, 100),
                    'status_hunian' => $faker->randomElement(['Tetap', 'Kontrak']),
                ]);

                // Kepala Keluarga (Pasti ada)
                Resident::create([
                    'client_id' => $client->id,
                    'family_id' => $family->id,
                    'nik' => $faker->numerify('3271############'),
                    'nama' => $faker->name('male'),
                    'no_hp' => '0812' . rand(10000000, 99999999),
                    'status_keluarga' => 'Kepala Keluarga',
                ]);

                // Istri
                Resident::create([
                    'client_id' => $client->id,
                    'family_id' => $family->id,
                    'nik' => $faker->numerify('3271############'),
                    'nama' => $faker->name('female'),
                    'no_hp' => '0812' . rand(10000000, 99999999),
                    'status_keluarga' => 'Istri',
                ]);

                // Anak (Random 0 atau 1)
                if (rand(0, 1) === 1) {
                    Resident::create([
                        'client_id' => $client->id,
                        'family_id' => $family->id,
                        'nik' => $faker->numerify('3271############'),
                        'nama' => $faker->name,
                        'no_hp' => '0812' . rand(10000000, 99999999),
                        'status_keluarga' => 'Anak',
                    ]);
                }
            }
        }

        // 3. Inventaris & Aset (10 Data)
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Asset::create([
                'client_id' => $client->id,
                'nama_barang' => 'Aset RT ' . $i . ' - ' . $faker->word,
                'kategori' => $faker->randomElement(['Elektronik', 'Furnitur', 'Tenda', 'Lainnya']),
                'jumlah' => rand(1, 10),
                'kondisi' => $faker->randomElement(['Baik', 'Rusak Ringan', 'Rusak Berat']),
                'keterangan' => 'Gudang RT',
            ]);
        }

        // 4. UMKM (15 Data)
        // Get a random user for UMKM owner
        $randomUser = User::where('role', 'warga')->first();
        for ($i = 1; $i <= 15; $i++) {
            \App\Models\Umkm::create([
                'client_id' => $client->id,
                'user_id' => $randomUser ? $randomUser->id : 1, // Fallback to 1 if no user
                'nama_usaha' => 'Toko ' . $faker->company,
                'kategori' => $faker->randomElement(['Makanan', 'Minuman', 'Jasa', 'Kerajinan', 'Pakaian']),
                'deskripsi' => $faker->sentence,
                'nomor_whatsapp' => '0812' . rand(10000000, 99999999),
                'is_active' => true,
            ]);
        }
    }
}

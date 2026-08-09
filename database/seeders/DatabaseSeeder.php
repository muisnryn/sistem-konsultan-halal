<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@halal.com'],
            [
                'name'     => 'Admin KHI',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // 2. Akun Keuangan
        User::updateOrCreate(
            ['email' => 'keuangan@halal.com'],
            [
                'name'     => 'Manager Keuangan',
                'password' => Hash::make('password'),
                'role'     => 'keuangan',
            ]
        );

        // 3. Akun Klien
        $klien = User::updateOrCreate(
            ['email' => 'klien@halal.com'],
            [
                'name'     => 'Adelia Putri',
                'password' => Hash::make('password'),
                'role'     => 'klien',
            ]
        );

        // Profil Perusahaan Klien (Lokasi: Bandung)
        CompanyProfile::updateOrCreate(
            ['user_id' => $klien->id],
            [
                'nama_perusahaan'      => 'PT Dapur Halal Nusantara',
                'skala_perusahaan'     => 'menengah',
                'jenis_kelompok_usaha' => 'Makanan dan Minuman',
                'pic_nama'             => 'Adelia Putri',
                'pic_email'            => 'klien@kateringhalal.com',
                'pic_phone'            => '085722288968',
                'latitude'             => -6.914744,
                'longitude'            => 107.609810,
            ]
        );

        // 4. Panggil Seeder Master SPK & Proyek
        $this->call([
            CriteriaSeeder::class,
            ConsultantSeeder::class,
            ProjectSeeder::class,
            ServiceTypeSeeder::class,
        ]);
    }
}

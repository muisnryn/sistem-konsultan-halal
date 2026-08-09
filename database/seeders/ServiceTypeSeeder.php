<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'kode_layanan'          => 'SKALA_KECIL',
                'nama_layanan'          => 'Layanan Pendampingan - Skala Kecil (UMKM)',
                'biaya'                 => 5000000,
                'biaya_tambahan_menu'   => 500000,  // Rp 500.000 / 30 menu (>50)
                'biaya_tambahan_outlet' => 1000000, // Rp 1.000.000 / outlet (>1)
                'deskripsi'             => 'Paket pendampingan sertifikasi halal untuk pelaku usaha mikro dan skala kecil.',
            ],
            [
                'kode_layanan'          => 'SKALA_MENENGAH',
                'nama_layanan'          => 'Layanan Pendampingan - Skala Menengah',
                'biaya'                 => 10000000,
                'biaya_tambahan_menu'   => 1000000, // Rp 1.000.000 / 30 menu (>50)
                'biaya_tambahan_outlet' => 1000000, // Rp 1.000.000 / outlet (>1)
                'deskripsi'             => 'Paket pendampingan sertifikasi halal untuk badan usaha / pabrik manufaktur skala menengah.',
            ],
            [
                'kode_layanan'          => 'SKALA_BESAR',
                'nama_layanan'          => 'Layanan Pendampingan - Skala Besar',
                'biaya'                 => 15000000,
                'biaya_tambahan_menu'   => 1500000, // Rp 1.500.000 / 30 menu (>50)
                'biaya_tambahan_outlet' => 1000000, // Rp 1.000.000 / outlet (>1)
                'deskripsi'             => 'Paket pendampingan sertifikasi halal untuk perusahaan korporasi / industri skala besar.',
            ],
        ];

        foreach ($services as $service) {
            ServiceType::updateOrCreate(
                ['kode_layanan' => $service['kode_layanan']],
                $service
            );
        }
    }
}

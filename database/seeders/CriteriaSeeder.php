<?php

namespace Database\Seeders;

use App\Models\Criteria;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $criterias = [
            [
                'kode'            => 'C1',
                'nama_kriteria'   => 'Spesialisasi Industri',
                'bobot'           => 0.25,
                'tren'            => 'max',
                'tipe_preferensi' => 'usual', // Tipe I (Usual)
                'param_p'         => null,
                'param_q'         => null,
                'param_s'         => null,
            ],
            [
                'kode'            => 'C2',
                'nama_kriteria'   => 'Pengalaman Proyek Sejenis',
                'bobot'           => 0.20,
                'tren'            => 'max',
                'tipe_preferensi' => 'v_shape', // Tipe III (V-Shape)
                'param_p'         => 10.00,       // p = 10
                'param_q'         => null,
                'param_s'         => null,
            ],
            [
                'kode'            => 'C3',
                'nama_kriteria'   => 'Jumlah Proyek Aktif',
                'bobot'           => 0.15,
                'tren'            => 'min',
                'tipe_preferensi' => 'u_shape', // Tipe II (U-Shape)
                'param_p'         => null,
                'param_q'         => 2.00,        // q = 2
                'param_s'         => null,
            ],
            [
                'kode'            => 'C4',
                'nama_kriteria'   => 'Jarak Geografis Lokasi Audit',
                'bobot'           => 0.15,
                'tren'            => 'min',
                'tipe_preferensi' => 'linear',  // Tipe V (Linear)
                'param_p'         => 100.00,     // p = 100
                'param_q'         => 10.00,      // q = 10
                'param_s'         => null,
            ],
            [
                'kode'            => 'C5',
                'nama_kriteria'   => 'Performa Pendampingan',
                'bobot'           => 0.15,
                'tren'            => 'max',
                'tipe_preferensi' => 'gaussian', // Tipe VI (Gaussian)
                'param_p'         => null,
                'param_q'         => null,
                'param_s'         => 5.00,        // s (sigma) = 5
            ],
            [
                'kode'            => 'C6',
                'nama_kriteria'   => 'Ketersediaan Jadwal',
                'bobot'           => 0.10,
                'tren'            => 'max',
                'tipe_preferensi' => 'usual', // Tipe I (Usual)
                'param_p'         => null,
                'param_q'         => null,
                'param_s'         => null,
            ],
        ];

        foreach ($criterias as $c) {
            Criteria::updateOrCreate(['kode' => $c['kode']], $c);
        }
    }
}

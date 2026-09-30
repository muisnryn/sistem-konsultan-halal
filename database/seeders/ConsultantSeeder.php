<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Consultant;
use App\Models\ConsultantEvaluation;
use App\Models\Criteria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ConsultantSeeder extends Seeder
{
    public function run(): void
    {
        $consultants = [
            [
                'email'                 => 'prima@halal.com',
                'nama_konsultan'        => 'Prima Sukmana Resma',
                'sertifikasi_no'        => 'HALAL-CONS-2026-001',
                'no_hp'                 => '087873765355',
                'domisili'              => 'Kabupaten Bogor (Ciawi)',
                'spesialisasi_industri' => 'Makanan dan Minuman',
                'latitude'              => -6.64500000,
                'longitude'             => 106.83500000,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 12.0, // Pengalaman (12 proyek)
                    'C3' => 2.0,  // Beban Kerja (2 proyek)
                    'C5' => 88.0, // Performa (88)
                    'C6' => 1.0,  // Jadwal Tersedia (1)
                ]
            ],
            [
                'email'                 => 'tubagus@halal.com',
                'nama_konsultan'        => 'Tubagus Ishak',
                'sertifikasi_no'        => 'HALAL-CONS-2026-004',
                'no_hp'                 => '082298567213',
                'domisili'              => 'Bogor Kota (Tengah)',
                'spesialisasi_industri' => 'Jasa Penyedia Makanan & Minuman',
                'latitude'              => -6.59710000,
                'longitude'             => 106.79490000,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 15.0, // Pengalaman (15 proyek)
                    'C3' => 1.0,  // Beban Kerja (1 proyek)
                    'C5' => 92.0, // Performa (92)
                    'C6' => 1.0,  // Jadwal Tersedia (1)
                ]
            ],
            [
                'email'                 => 'siti@halal.com',
                'nama_konsultan'        => 'Siti Aisyah',
                'sertifikasi_no'        => 'HALAL-CONS-2026-005',
                'no_hp'                 => '083800278747',
                'domisili'              => 'Bogor Kota (Utara)',
                'spesialisasi_industri' => 'Makanan dan Minuman',
                'latitude'              => -6.52000000,
                'longitude'             => 106.72000000,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 5.0,  // Pengalaman (5 proyek)
                    'C3' => 6.0,  // Beban Kerja (6 proyek)
                    'C5' => 80.0, // Performa (80)
                    'C6' => 0.0,  // Jadwal Bentrok (0)
                ]
            ],
            [
                'email'                 => 'exien@halal.com',
                'nama_konsultan'        => 'Exien Setiorini',
                'sertifikasi_no'        => 'HALAL-CONS-2026-002',
                'no_hp'                 => '085695153557',
                'domisili'              => 'Jakarta Selatan',
                'spesialisasi_industri' => 'Kosmetik dan Obat-Obatan',
                'latitude'              => -6.26149300,
                'longitude'             => 106.81060000,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 8.0,
                    'C3' => 2.0,
                    'C5' => 88.0,
                    'C6' => 1.0,
                ]
            ],
            [
                'email'                 => 'iqbal@halal.com',
                'nama_konsultan'        => 'Muhamad Iqbal',
                'sertifikasi_no'        => 'HALAL-CONS-2026-003',
                'no_hp'                 => '087882169077',
                'domisili'              => 'Jakarta Pusat',
                'spesialisasi_industri' => 'Makanan dan Minuman',
                'latitude'              => -6.18648600,
                'longitude'             => 106.83409100,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 6.0,
                    'C3' => 0.0,
                    'C5' => 85.0,
                    'C6' => 1.0,
                ]
            ],
            [
                'email'                 => 'vina@halal.com',
                'nama_konsultan'        => 'Vina Alfi Rohma',
                'sertifikasi_no'        => 'HALAL-CONS-2026-006',
                'no_hp'                 => '089682089815',
                'domisili'              => 'Jawa Timur',
                'spesialisasi_industri' => 'Makanan dan Minuman',
                'latitude'              => -7.24630000,
                'longitude'             => 112.73780000,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 10.0,
                    'C3' => 0.0,
                    'C5' => 98.0,
                    'C6' => 1.0,
                ]
            ],
            [
                'email'                 => 'vera@halal.com',
                'nama_konsultan'        => 'Vera Indriasanti',
                'sertifikasi_no'        => 'HALAL-CONS-2026-007',
                'no_hp'                 => '081290886747',
                'domisili'              => 'Jakarta Barat',
                'spesialisasi_industri' => 'Barang Gunaan dan Kimia',
                'latitude'              => -6.16832900,
                'longitude'             => 106.75884900,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 4.0,
                    'C3' => 3.0,
                    'C5' => 80.0,
                    'C6' => 0.0,
                ]
            ],
        ];

        $criterias = Criteria::all()->keyBy('kode');

        foreach ($consultants as $data) {
            $evaluationsData = $data['evaluations'];
            $email = $data['email'];

            unset($data['evaluations'], $data['email']);

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'     => $data['nama_konsultan'],
                    'password' => Hash::make('password'),
                    'role'     => 'konsultan',
                ]
            );

            $data['user_id'] = $user->id;

            $consultant = Consultant::updateOrCreate(
                ['sertifikasi_no' => $data['sertifikasi_no']],
                $data
            );

            foreach ($evaluationsData as $kode => $nilai) {
                if (isset($criterias[$kode])) {
                    ConsultantEvaluation::updateOrCreate(
                        [
                            'consultant_id' => $consultant->id,
                            'criteria_id'   => $criterias[$kode]->id,
                        ],
                        [
                            'nilai' => $nilai
                        ]
                    );
                }
            }
        }
    }
}

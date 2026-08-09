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
                'domisili'              => 'Bogor',
                'spesialisasi_industri' => 'Makanan dan Minuman',
                'latitude'              => -6.597147,
                'longitude'             => 106.806039,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 7.5,
                    'C3' => 1.0,
                    'C5' => 9.0,
                    'C6' => 5.0,
                ]
            ],
            [
                'email'                 => 'exien@halal.com',
                'nama_konsultan'        => 'Exien Setiorini',
                'sertifikasi_no'        => 'HALAL-CONS-2026-002',
                'no_hp'                 => '085695153557',
                'domisili'              => 'Jakarta',
                'spesialisasi_industri' => 'Kosmetik dan Obat-Obatan',
                'latitude'              => -6.208800,
                'longitude'             => 106.845600,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 8.0,
                    'C3' => 2.0,
                    'C5' => 8.8,
                    'C6' => 4.0,
                ]
            ],
            [
                'email'                 => 'iqbal@halal.com',
                'nama_konsultan'        => 'Muhamad Iqbal',
                'sertifikasi_no'        => 'HALAL-CONS-2026-003',
                'no_hp'                 => '087882169077',
                'domisili'              => 'Jakarta',
                'spesialisasi_industri' => 'Makanan dan Minuman',
                'latitude'              => -6.175110,
                'longitude'             => 106.865030,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 6.0,
                    'C3' => 0.0,
                    'C5' => 8.5,
                    'C6' => 5.0,
                ]
            ],
            [
                'email'                 => 'tubagus@halal.com',
                'nama_konsultan'        => 'Tubagus Ishak',
                'sertifikasi_no'        => 'HALAL-CONS-2026-004',
                'no_hp'                 => '082298567213',
                'domisili'              => 'Bogor',
                'spesialisasi_industri' => 'Jasa Penyediaan Makanan & Minuman',
                'latitude'              => -6.595000,
                'longitude'             => 106.790000,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 5.0,
                    'C3' => 1.0,
                    'C5' => 8.2,
                    'C6' => 4.0,
                ]
            ],
            [
                'email'                 => 'siti@halal.com',
                'nama_konsultan'        => 'Siti Aisyah',
                'sertifikasi_no'        => 'HALAL-CONS-2026-005',
                'no_hp'                 => '083800278747',
                'domisili'              => 'Bogor',
                'spesialisasi_industri' => 'Makanan dan Minuman',
                'latitude'              => -6.600000,
                'longitude'             => 106.800000,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 9.0,
                    'C3' => 1.0,
                    'C5' => 9.5,
                    'C6' => 5.0,
                ]
            ],
            [
                'email'                 => 'vina@halal.com',
                'nama_konsultan'        => 'Vina Alfi Rohma',
                'sertifikasi_no'        => 'HALAL-CONS-2026-006',
                'no_hp'                 => '089682089815',
                'domisili'              => 'Jawa Timur',
                'spesialisasi_industri' => 'Makanan dan Minuman',
                'latitude'              => -7.257472,
                'longitude'             => 112.752088,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 10.0,
                    'C3' => 0.0,
                    'C5' => 9.8,
                    'C6' => 5.0,
                ]
            ],
            [
                'email'                 => 'vera@halal.com',
                'nama_konsultan'        => 'Vera Indriasanti',
                'sertifikasi_no'        => 'HALAL-CONS-2026-007',
                'no_hp'                 => '081290886747',
                'domisili'              => 'Jakarta',
                'spesialisasi_industri' => 'Barang Gunaan dan Kimia',
                'latitude'              => -6.220000,
                'longitude'             => 106.820000,
                'is_active'             => true,
                'evaluations'           => [
                    'C2' => 4.0,
                    'C3' => 3.0,
                    'C5' => 8.0,
                    'C6' => 3.0,
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
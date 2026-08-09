<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;
use App\Models\Consultant;
use App\Models\ConsultantEvaluation;
use App\Models\User;
use App\Models\Project;
use App\Models\CompanyProfile;
use App\Enums\ProjectStatus;

class SpkTestingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CLEAR EXISTING DATA
        ConsultantEvaluation::query()->delete();
        Criteria::query()->delete();
        Consultant::query()->delete();

        // 2. SEED KRITERIA (C1 - C6)
        $c1 = Criteria::create(['kode' => 'C1', 'nama_kriteria' => 'Spesialisasi Industri', 'bobot' => 0.25, 'tren' => 'max', 'tipe_preferensi' => 'usual']);
        $c2 = Criteria::create(['kode' => 'C2', 'nama_kriteria' => 'Pengalaman Kerja', 'bobot' => 0.20, 'tren' => 'max', 'tipe_preferensi' => 'v_shape', 'param_p' => 10]);
        $c3 = Criteria::create(['kode' => 'C3', 'nama_kriteria' => 'Jumlah Proyek Aktif', 'bobot' => 0.15, 'tren' => 'min', 'tipe_preferensi' => 'usual']);
        $c4 = Criteria::create(['kode' => 'C4', 'nama_kriteria' => 'Jarak Geografis', 'bobot' => 0.20, 'tren' => 'min', 'tipe_preferensi' => 'linear', 'param_q' => 5, 'param_p' => 40]);
        $c5 = Criteria::create(['kode' => 'C5', 'nama_kriteria' => 'Performa Kerja', 'bobot' => 0.10, 'tren' => 'max', 'tipe_preferensi' => 'usual']);
        $c6 = Criteria::create(['kode' => 'C6', 'nama_kriteria' => 'Ketersediaan Jadwal', 'bobot' => 0.10, 'tren' => 'max', 'tipe_preferensi' => 'usual']);

        // 3. SEED KONSULTAN DUMMY
        $k1 = Consultant::create([
            'nama_konsultan' => 'Budi Santoso, S.Tp.',
            'sertifikasi_no' => 'CERT-HALAL-001',
            'no_hp' => '081234567890',
            'domisili' => 'Cimahi',
            'spesialisasi_industri' => 'Makanan & Minuman',
            'latitude' => -6.87220000,
            'longitude' => 107.54220000,
            'is_active' => true,
        ]);

        $k2 = Consultant::create([
            'nama_konsultan' => 'Siti Rahma, M.Si.',
            'sertifikasi_no' => 'CERT-HALAL-002',
            'no_hp' => '081298765432',
            'domisili' => 'Lembang',
            'spesialisasi_industri' => 'Makanan & Minuman',
            'latitude' => -6.81682000,
            'longitude' => 107.61662000,
            'is_active' => true,
        ]);

        $k3 = Consultant::create([
            'nama_konsultan' => 'Agus Pratama, S.Si.',
            'sertifikasi_no' => 'CERT-HALAL-003',
            'no_hp' => '081311223344',
            'domisili' => 'Sumedang',
            'spesialisasi_industri' => 'Kosmetik',
            'latitude' => -6.85852000,
            'longitude' => 107.92092000,
            'is_active' => true,
        ]);

        // 4. SEED EVALUASI HISTORI KONSULTAN (C2, C3, C5, C6)
        // K1
        ConsultantEvaluation::create(['consultant_id' => $k1->id, 'criteria_id' => $c2->id, 'nilai' => 8.0]);
        ConsultantEvaluation::create(['consultant_id' => $k1->id, 'criteria_id' => $c3->id, 'nilai' => 2.0]);
        ConsultantEvaluation::create(['consultant_id' => $k1->id, 'criteria_id' => $c5->id, 'nilai' => 9.0]);
        ConsultantEvaluation::create(['consultant_id' => $k1->id, 'criteria_id' => $c6->id, 'nilai' => 1.0]);

        // K2
        ConsultantEvaluation::create(['consultant_id' => $k2->id, 'criteria_id' => $c2->id, 'nilai' => 5.0]);
        ConsultantEvaluation::create(['consultant_id' => $k2->id, 'criteria_id' => $c3->id, 'nilai' => 1.0]);
        ConsultantEvaluation::create(['consultant_id' => $k2->id, 'criteria_id' => $c5->id, 'nilai' => 8.5]);
        ConsultantEvaluation::create(['consultant_id' => $k2->id, 'criteria_id' => $c6->id, 'nilai' => 1.0]);

        // K3
        ConsultantEvaluation::create(['consultant_id' => $k3->id, 'criteria_id' => $c2->id, 'nilai' => 12.0]);
        ConsultantEvaluation::create(['consultant_id' => $k3->id, 'criteria_id' => $c3->id, 'nilai' => 4.0]);
        ConsultantEvaluation::create(['consultant_id' => $k3->id, 'criteria_id' => $c5->id, 'nilai' => 9.5]);
        ConsultantEvaluation::create(['consultant_id' => $k3->id, 'criteria_id' => $c6->id, 'nilai' => 0.5]);
    }
}

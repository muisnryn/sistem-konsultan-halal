<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;
use App\Models\Consultant;
use App\Models\ConsultantEvaluation;

class SpkTestingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. CLEANUP DATA
        ConsultantEvaluation::query()->delete();
        Criteria::query()->delete();
        Consultant::query()->delete();

        // 2. SEED KRITERIA SESUAI SUB-BAB 3.3.3
        $c1 = Criteria::create([
            'kode' => 'C1', 'nama_kriteria' => 'Spesialisasi Industri',
            'bobot' => 0.25, 'tren' => 'max', 'tipe_preferensi' => 'usual'
        ]);
        $c2 = Criteria::create([
            'kode' => 'C2', 'nama_kriteria' => 'Pengalaman Kerja',
            'bobot' => 0.20, 'tren' => 'max', 'tipe_preferensi' => 'v_shape', 'param_p' => 10.00
        ]);
        $c3 = Criteria::create([
            'kode' => 'C3', 'nama_kriteria' => 'Beban Kerja (Jumlah Proyek Aktif)',
            'bobot' => 0.15, 'tren' => 'min', 'tipe_preferensi' => 'u_shape', 'param_q' => 2.00
        ]);
        $c4 = Criteria::create([
            'kode' => 'C4', 'nama_kriteria' => 'Jarak Spasial Lokasi Audit',
            'bobot' => 0.15, 'tren' => 'min', 'tipe_preferensi' => 'linear', 'param_q' => 10.00, 'param_p' => 100.00
        ]);
        $c5 = Criteria::create([
            'kode' => 'C5', 'nama_kriteria' => 'Rating / Performa Pendampingan',
            'bobot' => 0.15, 'tren' => 'max', 'tipe_preferensi' => 'gaussian', 'param_s' => 5.00
        ]);
        $c6 = Criteria::create([
            'kode' => 'C6', 'nama_kriteria' => 'Ketersediaan Jadwal',
            'bobot' => 0.10, 'tren' => 'max', 'tipe_preferensi' => 'usual'
        ]);

        // 3. SEED ALTERNATIF KONSULTAN (A1, A2, A3)
        $a1 = Consultant::create([
            'nama_konsultan' => 'Prima Sukmana Resma',
            'sertifikasi_no' => 'CERT-HALAL-001',
            'no_hp' => '081234567891',
            'domisili' => 'Kabupaten Bogor (Ciawi)',
            'spesialisasi_industri' => 'Makanan dan Minuman',
            'latitude' => -6.64500000,
            'longitude' => 106.83500000,
            'is_active' => true,
        ]);

        $a2 = Consultant::create([
            'nama_konsultan' => 'Tubagus Ishak',
            'sertifikasi_no' => 'CERT-HALAL-002',
            'no_hp' => '081234567892',
            'domisili' => 'Bogor Kota (Tengah)',
            'spesialisasi_industri' => 'Jasa Penyedia Makanan & Minuman',
            'latitude' => -6.59710000,
            'longitude' => 106.79490000,
            'is_active' => true,
        ]);

        $a3 = Consultant::create([
            'nama_konsultan' => 'Siti Aisyah',
            'sertifikasi_no' => 'CERT-HALAL-003',
            'no_hp' => '081234567893',
            'domisili' => 'Bogor Kota (Utara)',
            'spesialisasi_industri' => 'Makanan dan Minuman',
            'latitude' => -6.52000000,
            'longitude' => 106.72000000,
            'is_active' => true,
        ]);

        // 4. SEED EVALUASI HISTORIS (C2, C3, C5, C6)
        // A1 (Prima Sukmana Resma)
        ConsultantEvaluation::create(['consultant_id' => $a1->id, 'criteria_id' => $c2->id, 'nilai' => 12.0]);
        ConsultantEvaluation::create(['consultant_id' => $a1->id, 'criteria_id' => $c3->id, 'nilai' => 2.0]);
        ConsultantEvaluation::create(['consultant_id' => $a1->id, 'criteria_id' => $c5->id, 'nilai' => 88.0]);
        ConsultantEvaluation::create(['consultant_id' => $a1->id, 'criteria_id' => $c6->id, 'nilai' => 1.0]);

        // A2 (Tubagus Ishak)
        ConsultantEvaluation::create(['consultant_id' => $a2->id, 'criteria_id' => $c2->id, 'nilai' => 15.0]);
        ConsultantEvaluation::create(['consultant_id' => $a2->id, 'criteria_id' => $c3->id, 'nilai' => 1.0]);
        ConsultantEvaluation::create(['consultant_id' => $a2->id, 'criteria_id' => $c5->id, 'nilai' => 92.0]);
        ConsultantEvaluation::create(['consultant_id' => $a2->id, 'criteria_id' => $c6->id, 'nilai' => 1.0]);

        // A3 (Siti Aisyah)
        ConsultantEvaluation::create(['consultant_id' => $a3->id, 'criteria_id' => $c2->id, 'nilai' => 5.0]);
        ConsultantEvaluation::create(['consultant_id' => $a3->id, 'criteria_id' => $c3->id, 'nilai' => 6.0]);
        ConsultantEvaluation::create(['consultant_id' => $a3->id, 'criteria_id' => $c5->id, 'nilai' => 80.0]);
        ConsultantEvaluation::create(['consultant_id' => $a3->id, 'criteria_id' => $c6->id, 'nilai' => 0.0]);
    }
}

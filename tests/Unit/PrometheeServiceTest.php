<?php

namespace Tests\Unit;

use App\Enums\JenisPengajuan;
use App\Enums\ProjectStatus;
use App\Models\CompanyProfile;
use App\Models\Consultant;
use App\Models\ConsultantEvaluation;
use App\Models\Criteria;
use App\Models\Project;
use App\Models\User;
use App\Services\PrometheeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class PrometheeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PrometheeService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PrometheeService();
    }

    public function test_it_returns_ranked_consultants_for_valid_project(): void
    {
        $this->seedSpkTestData();

        $project = Project::query()->first();

        $result = $this->service->hitungRekomendasi($project);

        $this->assertIsArray($result);
        $this->assertGreaterThanOrEqual(2, count($result));
        $this->assertSame(
            array_keys($result),
            array_keys($result)
        );

        $this->assertNotEmpty($result[0]['consultant']['nama']);
        $this->assertArrayHasKey('net_flow', $result[0]);
        $this->assertArrayHasKey('leaving_flow', $result[0]);
        $this->assertArrayHasKey('entering_flow', $result[0]);

        $this->assertTrue($result[0]['net_flow'] >= $result[1]['net_flow']);
    }

    public function test_it_throws_when_project_coordinates_are_missing(): void
    {
        $this->seedSpkTestData();

        $project = Project::query()->first();
        $project->latitude = null;
        $project->longitude = null;
        $project->klien->companyProfile->latitude = null;
        $project->klien->companyProfile->longitude = null;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Koordinat lokasi Klien belum diisi');

        $this->service->hitungRekomendasi($project);
    }

    public function test_it_returns_empty_for_less_than_two_active_consultants(): void
    {
        $klien = User::create([
            'name' => 'Klien Test',
            'email' => 'klien@example.com',
            'password' => bcrypt('secret'),
            'role' => 'klien',
        ]);

        CompanyProfile::create([
            'user_id' => $klien->id,
            'nama_perusahaan' => 'PT Test',
            'jenis_kelompok_usaha' => 'Makanan dan Minuman',
            'latitude' => -6.60000000,
            'longitude' => 106.80000000,
        ]);

        $consultant = Consultant::create([
            'nama_konsultan' => 'Solo Consultant',
            'sertifikasi_no' => 'CERT-HALAL-010',
            'domisili' => 'Bogor',
            'spesialisasi_industri' => 'Makanan dan Minuman',
            'latitude' => -6.59000000,
            'longitude' => 106.79000000,
            'is_active' => true,
        ]);

        $project = Project::create([
            'klien_id' => $klien->id,
            'nama_paket' => 'Paket Demo',
            'jumlah_produk' => 10,
            'jumlah_outlet' => 2,
            'nama_merek_dagang' => 'Merek Demo',
            'status_proyek' => ProjectStatus::PAYMENT_T1_VERIFIED->value,
            'latitude' => -6.60000000,
            'longitude' => 106.80000000,
        ]);

        $result = $this->service->hitungRekomendasi($project);

        $this->assertSame([], $result);
    }

    protected function seedSpkTestData(): void
    {
        $klien = User::create([
            'name' => 'Klien SPK',
            'email' => 'klien-spk@example.com',
            'password' => bcrypt('secret'),
            'role' => 'klien',
        ]);

        CompanyProfile::create([
            'user_id' => $klien->id,
            'nama_perusahaan' => 'PT Makanan Halal',
            'jenis_kelompok_usaha' => 'Makanan dan Minuman',
            'latitude' => -6.64000000,
            'longitude' => 106.83000000,
        ]);

        $c1 = Criteria::create([
            'kode' => 'C1',
            'nama_kriteria' => 'Spesialisasi Industri',
            'bobot' => 0.25,
            'tren' => 'max',
            'tipe_preferensi' => 'usual',
        ]);
        $c2 = Criteria::create([
            'kode' => 'C2',
            'nama_kriteria' => 'Pengalaman Kerja',
            'bobot' => 0.20,
            'tren' => 'max',
            'tipe_preferensi' => 'v_shape',
            'param_p' => 10.00,
        ]);
        $c3 = Criteria::create([
            'kode' => 'C3',
            'nama_kriteria' => 'Beban Kerja',
            'bobot' => 0.15,
            'tren' => 'min',
            'tipe_preferensi' => 'u_shape',
            'param_q' => 2.00,
        ]);
        $c4 = Criteria::create([
            'kode' => 'C4',
            'nama_kriteria' => 'Jarak Spasial',
            'bobot' => 0.15,
            'tren' => 'min',
            'tipe_preferensi' => 'linear',
            'param_q' => 10.00,
            'param_p' => 100.00,
        ]);
        $c5 = Criteria::create([
            'kode' => 'C5',
            'nama_kriteria' => 'Rating',
            'bobot' => 0.15,
            'tren' => 'max',
            'tipe_preferensi' => 'gaussian',
            'param_s' => 5.00,
        ]);
        $c6 = Criteria::create([
            'kode' => 'C6',
            'nama_kriteria' => 'Ketersediaan Jadwal',
            'bobot' => 0.10,
            'tren' => 'max',
            'tipe_preferensi' => 'usual',
        ]);

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

        ConsultantEvaluation::create(['consultant_id' => $a1->id, 'criteria_id' => $c2->id, 'nilai' => 12.0]);
        ConsultantEvaluation::create(['consultant_id' => $a1->id, 'criteria_id' => $c3->id, 'nilai' => 2.0]);
        ConsultantEvaluation::create(['consultant_id' => $a1->id, 'criteria_id' => $c5->id, 'nilai' => 88.0]);
        ConsultantEvaluation::create(['consultant_id' => $a1->id, 'criteria_id' => $c6->id, 'nilai' => 1.0]);

        ConsultantEvaluation::create(['consultant_id' => $a2->id, 'criteria_id' => $c2->id, 'nilai' => 15.0]);
        ConsultantEvaluation::create(['consultant_id' => $a2->id, 'criteria_id' => $c3->id, 'nilai' => 1.0]);
        ConsultantEvaluation::create(['consultant_id' => $a2->id, 'criteria_id' => $c5->id, 'nilai' => 92.0]);
        ConsultantEvaluation::create(['consultant_id' => $a2->id, 'criteria_id' => $c6->id, 'nilai' => 1.0]);

        ConsultantEvaluation::create(['consultant_id' => $a3->id, 'criteria_id' => $c2->id, 'nilai' => 5.0]);
        ConsultantEvaluation::create(['consultant_id' => $a3->id, 'criteria_id' => $c3->id, 'nilai' => 6.0]);
        ConsultantEvaluation::create(['consultant_id' => $a3->id, 'criteria_id' => $c5->id, 'nilai' => 80.0]);
        ConsultantEvaluation::create(['consultant_id' => $a3->id, 'criteria_id' => $c6->id, 'nilai' => 0.0]);

        Project::create([
            'klien_id' => $klien->id,
            'nama_paket' => 'Paket Demo',
            'jenis_pengajuan' => JenisPengajuan::BARU->value,
            'jumlah_produk' => 10,
            'jumlah_outlet' => 3,
            'nama_merek_dagang' => 'Merek Demo',
            'status_proyek' => ProjectStatus::PAYMENT_T1_VERIFIED->value,
            'latitude' => -6.64000000,
            'longitude' => 106.83000000,
        ]);
    }
}

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

    public function test_pemeringkatan_dengan_3_konsultan_aktif(): void
    {
        $project = $this->createProject();
        $experience = $this->createCriteria('C2', 'max', 'usual', 0.75);
        $workload = $this->createCriteria('C3', 'min', 'usual', 0.25);

        $best = $this->createConsultant('Best Consultant');
        $middle = $this->createConsultant('Middle Consultant');
        $other = $this->createConsultant('Other Consultant');
        $this->evaluate($best, $experience, 10);
        $this->evaluate($best, $workload, 1);
        $this->evaluate($middle, $experience, 5);
        $this->evaluate($middle, $workload, 1);
        $this->evaluate($other, $experience, 1);
        $this->evaluate($other, $workload, 3);

        $result = $this->service->hitungRekomendasi($project);

        $this->assertSame(3, Consultant::query()->where('is_active', true)->count());
        $this->assertCount(3, $result);
        $this->assertSame('Best Consultant', $result[0]['consultant']['nama']);
        $this->assertSame('Middle Consultant', $result[1]['consultant']['nama']);
        $this->assertSame('Other Consultant', $result[2]['consultant']['nama']);
        $this->assertGreaterThan($result[1]['net_flow'], $result[0]['net_flow']);
        $this->assertGreaterThan($result[2]['net_flow'], $result[1]['net_flow']);
        $this->assertGreaterThan(0, $result[0]['net_flow']);
        $this->assertEquals(0.0, array_sum(array_column($result, 'net_flow')));
    }

    public function test_klien_tanpa_ketersediaan_data_koordinat_lokasi(): void
    {
        $project = $this->createProject(withCompanyProfile: false, projectLatitude: null, projectLongitude: null);
        $this->createConsultant('Consultant One');
        $this->createConsultant('Consultant Two');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Koordinat lokasi Klien belum diisi');

        $this->service->hitungRekomendasi($project);
    }

    public function test_jumlah_konsultan_aktif_kurang_dari_dua_menghasilkan_empty(): void
    {
        $project = $this->createProject();
        $this->createConsultant('Active Consultant');
        $this->createConsultant('Inactive Consultant', isActive: false);

        $this->assertSame([], $this->service->hitungRekomendasi($project));
    }

    private function createProject(
        bool $withCompanyProfile = true,
        ?float $projectLatitude = -6.64,
        ?float $projectLongitude = 106.83,
        ?float $profileLatitude = -6.64,
        ?float $profileLongitude = 106.83,
        string $industry = 'Makanan dan Minuman'
    ): Project {
        $client = User::create([
            'name' => 'Client Test',
            'email' => 'client@example.com',
            'password' => bcrypt('secret'),
            'role' => 'klien',
        ]);

        if ($withCompanyProfile) {
            CompanyProfile::create([
                'user_id' => $client->id,
                'nama_perusahaan' => 'PT Test',
                'jenis_kelompok_usaha' => $industry,
                'latitude' => $profileLatitude,
                'longitude' => $profileLongitude,
            ]);
        }

        return Project::create([
            'klien_id' => $client->id,
            'nama_paket' => 'Paket Test',
            'jenis_pengajuan' => JenisPengajuan::BARU->value,
            'jumlah_produk' => 1,
            'jumlah_outlet' => 1,
            'nama_merek_dagang' => 'Merek Test',
            'status_proyek' => ProjectStatus::PAYMENT_T1_VERIFIED->value,
            'latitude' => $projectLatitude,
            'longitude' => $projectLongitude,
        ]);
    }

    private function createCriteria(
        string $code,
        string $trend,
        string $preference,
        float $weight = 1,
        array $parameters = []
    ): Criteria {
        return Criteria::create(array_merge([
            'kode' => $code,
            'nama_kriteria' => $code,
            'bobot' => $weight,
            'tren' => $trend,
            'tipe_preferensi' => $preference,
        ], $parameters));
    }

    private function createConsultant(
        string $name,
        bool $isActive = true,
        string $specialization = 'Makanan dan Minuman',
        float $latitude = -6.645,
        float $longitude = 106.835
    ): Consultant {
        return Consultant::create([
            'nama_konsultan' => $name,
            'sertifikasi_no' => strtoupper(str_replace(' ', '-', $name)) . '-CERT',
            'domisili' => 'Bogor',
            'spesialisasi_industri' => $specialization,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'is_active' => $isActive,
        ]);
    }

    private function evaluate(Consultant $consultant, Criteria $criteria, float $value): void
    {
        ConsultantEvaluation::create([
            'consultant_id' => $consultant->id,
            'criteria_id' => $criteria->id,
            'nilai' => $value,
        ]);
    }
}

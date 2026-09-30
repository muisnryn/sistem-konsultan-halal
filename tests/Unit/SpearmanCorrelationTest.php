<?php

namespace Tests\Unit;

use App\Enums\ProjectStatus;
use App\Models\Consultant;
use App\Models\ConsultantEvaluation;
use App\Models\Criteria;
use App\Models\Project;
use App\Models\User;
use App\Services\PrometheeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpearmanCorrelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_promethee_ranking_matches_expert_ranking_by_spearman_correlation(): void
    {
        $client = User::create([
            'name' => 'Klien Spearman',
            'email' => 'klien-spearman@example.com',
            'password' => bcrypt('secret'),
            'role' => 'klien',
        ]);

        $project = Project::create([
            'klien_id' => $client->id,
            'nama_paket' => 'Proyek Uji Spearman',
            'jumlah_produk' => 1,
            'jumlah_outlet' => 1,
            'nama_merek_dagang' => 'Merek Uji',
            'status_proyek' => ProjectStatus::PAYMENT_T1_VERIFIED->value,
            'latitude' => -6.2,
            'longitude' => 106.8,
        ]);

        $criteria = Criteria::create([
            'kode' => 'C2',
            'nama_kriteria' => 'Pengalaman Kerja',
            'bobot' => 1.0,
            'tren' => 'max',
            'tipe_preferensi' => 'usual',
        ]);

        $consultants = collect([
            ['nama' => 'Konsultan A', 'nilai' => 90],
            ['nama' => 'Konsultan B', 'nilai' => 80],
            ['nama' => 'Konsultan C', 'nilai' => 70],
            ['nama' => 'Konsultan D', 'nilai' => 60],
        ])->map(function (array $data, int $index) use ($criteria) {
            $consultant = Consultant::create([
                'nama_konsultan' => $data['nama'],
                'sertifikasi_no' => sprintf('CERT-SPEARMAN-%03d', $index + 1),
                'domisili' => 'Bogor',
                'spesialisasi_industri' => 'Makanan dan Minuman',
                'latitude' => -6.2 + ($index * 0.01),
                'longitude' => 106.8 + ($index * 0.01),
                'is_active' => true,
            ]);

            ConsultantEvaluation::create([
                'consultant_id' => $consultant->id,
                'criteria_id' => $criteria->id,
                'nilai' => $data['nilai'],
            ]);

            return $consultant;
        });

        $rankingPakar = [
            'Konsultan A' => 1,
            'Konsultan B' => 3,
            'Konsultan C' => 2,
            'Konsultan D' => 4,
        ];

        $hasilSistem = (new PrometheeService())->hitungRekomendasi($project);
        $this->assertCount($consultants->count(), $hasilSistem);

        $sumDSquared = 0;
        $rows = [];

        foreach ($hasilSistem as $index => $hasil) {
            $nama = $hasil['consultant']['nama'];
            $rankSistem = $index + 1;
            $rankPakar = $rankingPakar[$nama];
            $d = $rankSistem - $rankPakar;
            $dSquared = $d ** 2;
            $sumDSquared += $dSquared;

            $rows[] = [$nama, $rankSistem, $rankPakar, $d, $dSquared];
        }

        $n = count($rows);
        $rho = 1 - ((6 * $sumDSquared) / ($n * (($n ** 2) - 1)));

        $output = "\nTabel Uji Spearman Rank Correlation\n";
        $output .= sprintf("%-16s %12s %12s %8s %10s\n", 'Konsultan', 'Rank Sistem', 'Rank Pakar', 'd_i', 'd_i^2');
        foreach ($rows as [$nama, $rankSistem, $rankPakar, $d, $dSquared]) {
            $output .= sprintf("%-16s %12d %12d %8d %10d\n", $nama, $rankSistem, $rankPakar, $d, $dSquared);
        }
        $output .= sprintf("Total sum d_i^2: %d\n", $sumDSquared);
        $output .= sprintf("Spearman rho: %.4f\n", $rho);
        fwrite(STDOUT, $output);

        $this->assertSame(2, $sumDSquared);
        $this->assertEqualsWithDelta(0.8, $rho, 0.0001);
    }
}

<?php

namespace App\Services;

use App\Models\Criteria;
use App\Models\Consultant;

class PrometheeService
{
    /**
     * Menghitung Perankingan SPK PROMETHEE II Terintegrasi Rumus Spasial Haversine
     */
    public function hitungRekomendasi($project)
    {
        $kriterias = Criteria::all();
        $consultants = Consultant::with('evaluations')->where('is_active', true)->get();

        // Guard: PROMETHEE II membutuhkan minimal 2 alternatif untuk perbandingan berpasangan
        if ($consultants->count() < 2) {
            return [];
        }

        // Hitung total bobot kriteria untuk normalisasi matematis
        $totalBobot = $kriterias->sum('bobot') ?: 1.0;

        // Ambil Kategori Produk dari Profile Perusahaan Klien (Kolom: jenis_kelompok_usaha)
        $kategoriProdukProject = $project->klien?->companyProfile?->jenis_kelompok_usaha ?? '';

        // 1. Matriks Keputusan Dinamis
        $matriks = [];
        foreach ($consultants as $c) {
            foreach ($kriterias as $crit) {

                if ($crit->kode === 'C1') {
                    // C1: Spesialisasi Industri (Cocok = 1.0, Tidak Cocok = 0.0)
                    $spec = trim(strtolower($c->spesialisasi_industri ?? ''));

                    $companyProfile = $project->klien?->companyProfile;
                    $rawJenis = trim($companyProfile?->jenis_kelompok_usaha ?? '');
                    
                    // Jika Klien memilih 'Lainnya', gunakan nilai dari jenis_kelompok_usaha_lainnya
                    if (strtolower($rawJenis) === 'lainnya' && !empty($companyProfile?->jenis_kelompok_usaha_lainnya)) {
                        $kategoriProdukProject = trim($companyProfile->jenis_kelompok_usaha_lainnya);
                    } else {
                        $kategoriProdukProject = $rawJenis;
                    }

                    $kategoriClean = trim(strtolower($kategoriProdukProject));

                    // Pencocokan Persis atau Partial Match
                    $isMatch = (!empty($spec) && !empty($kategoriClean) && ($spec === $kategoriClean || str_contains($spec, $kategoriClean) || str_contains($kategoriClean, $spec)));

                    $matriks[$c->id][$crit->id] = $isMatch ? 1.0 : 0.0;

                } elseif ($crit->kode === 'C4') {
                    // C4: Jarak Geografis Lokasi Audit (Formula Haversine)
                    // Failsafe koordinat Klien: Project -> CompanyProfile -> Default
                    $latKlien = $project->latitude
                        ?? $project->klien?->companyProfile?->latitude
                        ?? -6.9024812;
                    $lonKlien = $project->longitude
                        ?? $project->klien?->companyProfile?->longitude
                        ?? 107.6187889;

                    $matriks[$c->id][$crit->id] = $this->hitungJarakHaversine(
                        $latKlien, $lonKlien,
                        $c->latitude ?? -6.9024812, $c->longitude ?? 107.6187889
                    );

                } else {
                    // C2, C3, C5, C6: Diambil dari histori evaluasi konsultan (Tabel consultant_evaluations)
                    $eval = $c->evaluations->where('criteria_id', $crit->id)->first();
                    $matriks[$c->id][$crit->id] = $eval ? (float) $eval->nilai : 0.0;
                }
            }
        }

        $leavingFlow = [];
        $enteringFlow = [];
        $n = $consultants->count();

        foreach ($consultants as $c) {
            $leavingFlow[$c->id] = 0.0;
            $enteringFlow[$c->id] = 0.0;
        }

        // 2. Perbandingan Berpasangan (Pairwise Comparison)
        foreach ($consultants as $a) {
            foreach ($consultants as $b) {
                if ($a->id === $b->id) continue;

                $indeksPreferensiMultikriteria = 0.0;

                foreach ($kriterias as $crit) {
                    $nilaiA = $matriks[$a->id][$crit->id];
                    $nilaiB = $matriks[$b->id][$crit->id];

                    // Hitung selisih (d)
                    $d = ($crit->tren === 'max') ? ($nilaiA - $nilaiB) : ($nilaiB - $nilaiA);
                    $p = $this->hitungFungsiPreferensi($d, $crit);

                    $indeksPreferensiMultikriteria += ($p * $crit->bobot);
                }

                // Normalisasi Matematis terhadap total bobot
                $piNormalized = $indeksPreferensiMultikriteria / $totalBobot;

                $leavingFlow[$a->id] += $piNormalized;
                $enteringFlow[$b->id] += $piNormalized;
            }
        }

        // Ambil kriteria C1 & C4 secara aman
        $c1 = $kriterias->firstWhere('kode', 'C1');
        $c4 = $kriterias->firstWhere('kode', 'C4');

        // 3. Kalkulasi Aliran Flow PROMETHEE II & Output Formatting
        $hasilRanking = [];
        foreach ($consultants as $c) {
            $lf = $leavingFlow[$c->id] / ($n - 1);
            $ef = $enteringFlow[$c->id] / ($n - 1);
            $nf = $lf - $ef; // Rentang Net Flow [-1.0 s.d +1.0]

            $hasilRanking[] = [
                'consultant' => [
                    'id'               => $c->id,
                    'nama'             => $c->nama_konsultan,
                    'sertifikasi_no'   => $c->sertifikasi_no,
                    'domisili'         => $c->domisili ?? 'Lokal',
                    'spesialisasi'     => $c->spesialisasi_industri ?? 'Umum',
                    'pengalaman_tahun' => 3, // Default nilai matriks jika belum ada evaluasi
                    'total_proyek'     => 1,
                    'rating_performa'  => 8.5,
                    'ketersediaan'     => 'Tinggi',
                ],
                'leaving_flow'  => round($lf, 4),
                'entering_flow' => round($ef, 4),
                'net_flow'      => round($nf, 4),
                'nilai_dinamis' => [
                    'spesialisasi' => ($c1 && isset($matriks[$c->id][$c1->id]) && $matriks[$c->id][$c1->id] == 1) ? 'Cocok' : 'Tidak Cocok',
                    'jarak'        => ($c4 && isset($matriks[$c->id][$c4->id])) ? round($matriks[$c->id][$c4->id], 2) : 0
                ]
            ];
        }

        // 4. Urutkan berdasarkan Net Flow Tertinggi
        usort($hasilRanking, function ($a, $b) {
            return $b['net_flow'] <=> $a['net_flow'];
        });

        return $hasilRanking;
    }

    /**
     * Implementasi Rumus Spasial Haversine (Jarak Geografis dalam KM)
     */
    private function hitungJarakHaversine($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Jari-jari bumi (KM)

        $radLat1 = deg2rad((float)$lat1);
        $radLon1 = deg2rad((float)$lon1);
        $radLat2 = deg2rad((float)$lat2);
        $radLon2 = deg2rad((float)$lon2);

        $deltaLat = $radLat2 - $radLat1;
        $deltaLon = $radLon2 - $radLon1;

        $a = sin($deltaLat / 2) ** 2 + cos($radLat1) * cos($radLat2) * sin($deltaLon / 2) ** 2;
        $c = 2 * asin(sqrt($a));

        return $earthRadius * $c;
    }

    /**
     * Eksekutor 6 Tipe Preferensi PROMETHEE dengan Division By Zero Guard
     */
    private function hitungFungsiPreferensi($d, $crit)
    {
        if ($d <= 0) return 0;

        $p = (float) ($crit->param_p ?? 0);
        $q = (float) ($crit->param_q ?? 0);
        $s = (float) ($crit->param_s ?? 0);

        switch ($crit->tipe_preferensi) {
            case 'usual':
                return 1;

            case 'u_shape':
                return ($d > $q) ? 1 : 0;

            case 'v_shape':
                if ($p <= 0) return 1;
                return ($d > $p) ? 1 : ($d / $p);

            case 'level':
                return ($d <= $q) ? 0 : (($d > $p) ? 1 : 0.5);

            case 'linear':
                if ($p <= $q) return 1;
                return ($d <= $q) ? 0 : (($d > $p) ? 1 : (($d - $q) / ($p - $q)));

            case 'gaussian':
                if ($s <= 0) return 1;
                return 1 - exp(-($d ** 2) / (2 * ($s ** 2)));

            default:
                return 0;
        }
    }
}

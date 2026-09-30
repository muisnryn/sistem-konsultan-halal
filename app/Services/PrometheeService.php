<?php

namespace App\Services;

use App\Models\Criteria;
use App\Models\Consultant;
use InvalidArgumentException;

/**
 * Service Engine SPK PROMETHEE II Terintegrasi Rumus Spasial Haversine
 * Dibuat untuk Analisis Pemilihan Konsultan Pendamping Sertifikasi Halal
 */
class PrometheeService
{
    /**
     * Menghitung Perankingan SPK PROMETHEE II Terintegrasi Rumus Spasial Haversine
     *
     * @param object $project Data proyek pengajuan dari Klien
     * @return array Matrix ranking konsultan terurut berdasarkan Net Flow (Phi)
     * @throws InvalidArgumentException Jika koordinat GPS Klien/Konsultan tidak terdefinisi
     */
    public function hitungRekomendasi($project)
    {
        $kriterias = Criteria::all();
        $consultants = Consultant::with('evaluations')->where('is_active', true)->get();

        // Syarat minimal komputasi PROMETHEE II adalah 2 alternatif
        if ($consultants->count() < 2) {
            return [];
        }

        $totalBobot = $kriterias->sum('bobot') ?: 1.0;

        // Validasi Strict: Ambil dan Validasi Koordinat Klien
        $latKlien = $project->latitude ?? $project->klien?->companyProfile?->latitude;
        $lonKlien = $project->longitude ?? $project->klien?->companyProfile?->longitude;

        if (is_null($latKlien) || is_null($lonKlien)) {
            throw new InvalidArgumentException("Koordinat lokasi Klien belum diisi. Harap tentukan titik lokasi pada profil perusahaan.");
        }

        $kategoriProdukProject = $project->klien?->companyProfile?->jenis_kelompok_usaha ?? '';

        // 1. Matriks Keputusan Dinamis (Alternative Evaluation Matrix)
        $matriks = [];
        foreach ($consultants as $c) {
            // Validasi Strict: Validasi Koordinat Konsultan
            if (is_null($c->latitude) || is_null($c->longitude)) {
                throw new InvalidArgumentException("Koordinat domisili Konsultan {$c->nama_konsultan} belum diisi.");
            }

            foreach ($kriterias as $crit) {
                if ($crit->kode === 'C1') {
                    // C1: Kualitatif - Matching Spesialisasi Industri
                    $spec = trim(strtolower($c->spesialisasi_industri ?? ''));

                    $companyProfile = $project->klien?->companyProfile;
                    $rawJenis = trim($companyProfile?->jenis_kelompok_usaha ?? '');

                    if (strtolower($rawJenis) === 'lainnya' && !empty($companyProfile?->jenis_kelompok_usaha_lainnya)) {
                        $kategoriProdukProject = trim($companyProfile->jenis_kelompok_usaha_lainnya);
                    } else {
                        $kategoriProdukProject = $rawJenis;
                    }

                    $kategoriClean = trim(strtolower($kategoriProdukProject));

                    $isMatch = (!empty($spec) && !empty($kategoriClean) && ($spec === $kategoriClean || str_contains($spec, $kategoriClean) || str_contains($kategoriClean, $spec)));

                    $matriks[$c->id][$crit->id] = $isMatch ? 1.0 : 0.0;

                } elseif ($crit->kode === 'C4') {
                    // C4: Kuantitatif Spasial - Jarak Geografis Lokasi Audit (Formula Haversine Murni dalam KM)
                    $matriks[$c->id][$crit->id] = $this->hitungJarakHaversine(
                        $latKlien, $lonKlien,
                        $c->latitude, $c->longitude
                    );

                } else {
                    // C2, C3, C5, C6: Evaluasi Historis / Kuantitatif
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

        // 2. Perbandingan Berpasangan (Pairwise Comparison) & Indeks Preferensi Global (Pi)
        foreach ($consultants as $a) {
            foreach ($consultants as $b) {
                if ($a->id === $b->id) continue;

                $indeksPreferensiMultikriteria = 0.0;

                foreach ($kriterias as $crit) {
                    $nilaiA = $matriks[$a->id][$crit->id];
                    $nilaiB = $matriks[$b->id][$crit->id];

                    // Penentuan Deviasi berdasarkan Tren Kriteria (Benefit / Cost)
                    $d = ($crit->tren === 'max') ? ($nilaiA - $nilaiB) : ($nilaiB - $nilaiA);
                    $p = $this->hitungFungsiPreferensi($d, $crit);

                    $indeksPreferensiMultikriteria += ($p * $crit->bobot);
                }

                $piNormalized = $indeksPreferensiMultikriteria / $totalBobot;

                $leavingFlow[$a->id] += $piNormalized;
                $enteringFlow[$b->id] += $piNormalized;
            }
        }

        $c1 = $kriterias->firstWhere('kode', 'C1');
        $c4 = $kriterias->firstWhere('kode', 'C4');

        // 3. Kalkulasi Aliran Flow PROMETHEE II (Leaving, Entering, Net Flow)
        $hasilRanking = [];
        foreach ($consultants as $c) {
            $lf = $leavingFlow[$c->id] / ($n - 1); // Phi+
            $ef = $enteringFlow[$c->id] / ($n - 1); // Phi-
            $nf = $lf - $ef;                       // Net Flow (Phi)

            $hasilRanking[] = [
                'consultant' => [
                    'id'               => $c->id,
                    'nama'             => $c->nama_konsultan,
                    'sertifikasi_no'   => $c->sertifikasi_no,
                    'domisili'         => $c->domisili ?? 'Lokal',
                    'spesialisasi'     => $c->spesialisasi_industri ?? 'Umum',
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

        // 4. Urutkan Alternatif Berdasarkan Nilai Net Flow (Phi) Tertinggi
        usort($hasilRanking, function ($a, $b) {
            return $b['net_flow'] <=> $a['net_flow'];
        });

        return $hasilRanking;
    }

    /**
     * Implementasi Rumus Spasial Haversine (Menghitung Jarak Geografis dalam Satuan KM)
     */
    private function hitungJarakHaversine($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Jari-jari bumi dalam kilometer

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
     * Eksekutor 6 Tipe Fungsi Preferensi PROMETHEE (Brans & Mareschal)
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

<?php

namespace App\Http\Controllers;

use App\Enums\ProjectStatus;
use App\Enums\JenisPengajuan;
use App\Models\Project;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        if (!$user->companyProfile) {
            return redirect()->route('client.profile.edit')
                ->with('error', 'Anda harus melengkapi profil perusahaan terlebih dahulu sebelum melakukan pengajuan jasa.');
        }

        $profile = $user->companyProfile;
        $serviceType = $this->getServiceTypeBySkala($profile->skala_perusahaan);

        $activeProject = Project::where('klien_id', $user->id)
            ->where('status_proyek', '!=', ProjectStatus::COMPLETED)
            ->latest()
            ->first();

        $estimasiBiaya = 0;
        if ($activeProject) {
            $activeServiceType = $activeProject->serviceType ?? $serviceType;
            $estimasiBiaya = $activeProject->total_harga_kesepakatan
                ?? $this->hitungEstimasiBiayaBackend($activeProject, $activeServiceType);
        }

        return view('client.project.create', compact('profile', 'activeProject', 'estimasiBiaya', 'serviceType'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $profile = $user->companyProfile;

        if (!$profile) {
            return redirect()->route('client.profile.edit')
                ->with('error', 'Profil perusahaan tidak ditemukan.');
        }

        $hasActiveProject = Project::where('klien_id', $user->id)
            ->where('status_proyek', '!=', ProjectStatus::COMPLETED)
            ->exists();

        if ($hasActiveProject) {
            return redirect()->route('client.project.create')
                ->with('error', 'Gagal membuat pengajuan. Anda masih memiliki proyek sertifikasi yang sedang aktif.');
        }

        $validated = $request->validate([
            'nama_merek_dagang'   => 'required|string|max:255',
            'jenis_pengajuan'     => ['required', Rule::in([JenisPengajuan::BARU->value, JenisPengajuan::PERPANJANGAN->value])],
            'jumlah_produk'       => 'required|integer|min:1',
            'jumlah_outlet'       => 'required|integer|min:1',
            'is_luar_jabodetabek' => 'required|boolean',
        ]);

        $serviceType = $this->getServiceTypeBySkala($profile->skala_perusahaan);
        $namaPaket = 'Paket ' . ucfirst($profile->skala_perusahaan);

        Project::create([
            'klien_id'            => $user->id,
            'service_type_id'     => $serviceType ? $serviceType->id : null,
            'nama_paket'          => $namaPaket,
            'jenis_pengajuan'     => $validated['jenis_pengajuan'],
            'jumlah_produk'       => $validated['jumlah_produk'],
            'jumlah_outlet'       => $validated['jumlah_outlet'],
            'nama_merek_dagang'   => $validated['nama_merek_dagang'],
            'is_luar_jabodetabek' => $validated['is_luar_jabodetabek'],
            'status_proyek'       => ProjectStatus::PENGAJUAN_SUBMITTED,
            'total_harga_kesepakatan' => null,
            'file_dokumen_penawaran'  => null,
        ]);

        return redirect()->route('client.project.create')
            ->with('success', 'Pengajuan sertifikasi berhasil dikirim.');
    }

    private function getServiceTypeBySkala(?string $skala)
    {
        $skalaUpper = strtoupper(trim($skala ?? 'KECIL'));
        $kode = 'SKALA_' . $skalaUpper;

        return ServiceType::where('kode_layanan', $kode)->first()
            ?? ServiceType::where('kode_layanan', 'SKALA_KECIL')->first();
    }

    /**
     * Hitung Estimasi berdasarkan konfigurasi harga dinamis di DB
     */
    private function hitungEstimasiBiayaBackend($project, ?ServiceType $serviceType)
    {
        $hargaDasar = $serviceType ? $serviceType->biaya : 5000000;
        $biayaAddonMenu = $serviceType ? $serviceType->biaya_tambahan_menu : 500000;
        $biayaAddonOutlet = $serviceType ? $serviceType->biaya_tambahan_outlet : 1000000;

        // Addon Menu (>50): Kelipatan 30 item menu
        $addonMenu = 0;
        if ($project->jumlah_produk > 50) {
            $addonMenu = ceil(($project->jumlah_produk - 50) / 30) * $biayaAddonMenu;
        }

        // Addon Outlet (>1): Per outlet tambahan
        $addonOutlet = 0;
        if ($project->jumlah_outlet > 1) {
            $addonOutlet = ($project->jumlah_outlet - 1) * $biayaAddonOutlet;
        }

        return $hargaDasar + $addonMenu + $addonOutlet;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Consultant;
use App\Models\ProjectDocument; // Pastikan Model ini di-import
use App\Enums\ProjectStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Overview Utama
     */
    public function index()
    {
        // 1. Ambil Metrik Data Statistik untuk Box Ringkasan

        $activeStatuses = [
            ProjectStatus::PENGAJUAN_SUBMITTED->value,
            ProjectStatus::WAITING_PAYMENT_T1->value,
            ProjectStatus::PAYMENT_T1_VERIFIED->value,
            ProjectStatus::CONSULTANT_ASSIGNED->value,
            ProjectStatus::DOCUMENTS_VALID->value,
            ProjectStatus::AUDIT_COMPLETED->value,
            ProjectStatus::CERTIFICATE_ISSUED->value,
            ProjectStatus::WAITING_PAYMENT_T2->value,
        ];

        $totalPengajuanAktif = Project::whereIn('status_proyek', $activeStatuses)->count();

        $consultantsCount = Consultant::count();
        $consultantsAvailable = Consultant::where('is_active', 1)->count();

        // 2. Mengambil jumlah sertifikat terbit bulan ini secara absolut
        // Kita hitung dari tabel project_documents berdasarkan waktu unggah dokumen 'sertifikat_halal'
        $now = Carbon::now();
        $sertifikatBulanIni = ProjectDocument::where('jenis_dokumen', 'sertifikat_halal')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        // 3. Ambil Data Aktivitas Terbaru untuk Tabel Bawah
        // Memastikan eager loading klien dan companyProfile agar tidak membebani database
        $recentActivities = Project::with(['klien.companyProfile'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPengajuanAktif',
            'consultantsCount',
            'consultantsAvailable',
            'sertifikatBulanIni',
            'recentActivities'
        ));
    }
}

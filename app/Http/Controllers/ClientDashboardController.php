<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Enums\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClientDashboardController extends Controller
{
    /**
     * Menampilkan Halaman Utama Dashboard Klien
     */
    public function index()
    {
        $user = auth()->user();
        $profile = $user->companyProfile;

        // Ambil proyek AKTIF milik klien (Proyek yang belum COMPLETED)
        $activeProject = Project::where('klien_id', $user->id)
            ->where('status_proyek', '!=', ProjectStatus::COMPLETED)
            ->with(['konsultan', 'documents', 'payments'])
            ->latest()
            ->first();

        $currentStep = 0;

        if ($activeProject) {
            $statusVal = $activeProject->status_proyek instanceof ProjectStatus
                ? $activeProject->status_proyek->value
                : (string) $activeProject->status_proyek;

            $uploadedDocs = $activeProject->documents;
            $totalDocs = $uploadedDocs->count();
            $approvedDocsCount = $uploadedDocs->where('status_validasi', 'approved')->count();

            // Cek ketersediaan dokumen khusus
            $hasAuditReport = $uploadedDocs->contains(function ($doc) {
                return in_array($doc->jenis_dokumen, ['laporan_review', 'laporan_hasil_review', 'laporan_audit']);
            });

            $hasCertificate = $uploadedDocs->contains('jenis_dokumen', 'sertifikat_halal');

            // --- EVALUASI LOGIKA 11 TAHAP PROGRES ---
            if ($statusVal === ProjectStatus::COMPLETED->value) {
                $currentStep = 11; // Selesai
            } elseif ($statusVal === ProjectStatus::WAITING_PAYMENT_T2->value) {
                $currentStep = 10; // Pembayaran Termin 2
            } elseif ($hasCertificate || $statusVal === ProjectStatus::CERTIFICATE_ISSUED->value) {
                $currentStep = 9;  // Sertifikat Terbit
            } elseif ($hasAuditReport || $statusVal === ProjectStatus::AUDIT_COMPLETED->value) {
                $currentStep = 8;  // Proses Penerbitan Sertifikat (Lap. Review Selesai)
            } elseif ($activeProject->tanggal_audit || $statusVal === ProjectStatus::DOCUMENTS_VALID->value) {
                $currentStep = 7;  // Penjadwalan Audit (Semua Dokumen Valid)
            } elseif ($totalDocs > 0 && $approvedDocsCount > 0) {
                $currentStep = 6;  // Validasi Dokumen (Proses Review Konsultan)
            } elseif ($totalDocs > 0) {
                $currentStep = 5;  // Dokumen Persyaratan (Klien Upload Dokumen)
            } elseif (!empty($activeProject->konsultan_id) || $statusVal === ProjectStatus::CONSULTANT_ASSIGNED->value) {
                $currentStep = 4;  // Penugasan Konsultan (Konsultan Ditugaskan)
            } elseif ($statusVal === ProjectStatus::PAYMENT_T1_VERIFIED->value) {
                $currentStep = 3;  // Pembayaran Termin 1 Diterima
            } elseif ($statusVal === ProjectStatus::WAITING_PAYMENT_T1->value) {
                $currentStep = 2;  // Penerbitan Invoice
            } else {
                $currentStep = 1;  // Pengajuan Baru Diterima
            }
        }

        // GENERATE LOG AKTIVITAS TERKINI REALTIME (Sesuai 11 Tahap)
        $activities = [];

        if ($activeProject) {
            $statusVal = $activeProject->status_proyek instanceof ProjectStatus
                ? $activeProject->status_proyek->value
                : (string) $activeProject->status_proyek;

            if ($currentStep >= 9) {
                $activities[] = [
                    'title' => 'Sertifikat Halal Resmi Terbit',
                    'desc'  => 'Sertifikat Halal telah diunggah oleh Admin dan siap diunduh.',
                    'time'  => $activeProject->updated_at->diffForHumans(),
                    'icon'  => 'certificate'
                ];
            }

            if ($currentStep >= 8) {
                $activities[] = [
                    'title' => 'Laporan Hasil Review Diunggah',
                    'desc'  => 'Konsultan telah mengunggah Laporan Hasil Review & Audit ke sistem BPJPH.',
                    'time'  => $activeProject->updated_at->diffForHumans(),
                    'icon'  => 'audit'
                ];
            }

            if ($activeProject->tanggal_audit) {
                $activities[] = [
                    'title' => 'Jadwal Audit Lapangan Ditetapkan',
                    'desc'  => 'Audit dijadwalkan pada ' . \Carbon\Carbon::parse($activeProject->tanggal_audit)->translatedFormat('d F Y') . ($activeProject->catatan_audit ? ' (' . $activeProject->catatan_audit . ')' : ''),
                    'time'  => $activeProject->updated_at->diffForHumans(),
                    'icon'  => 'calendar'
                ];
            }

            if ($currentStep >= 6) {
                $activities[] = [
                    'title' => 'Validasi Dokumen Berjalan',
                    'desc'  => 'Konsultan pendamping sedang memeriksa kelengkapan berkas persyaratan Anda.',
                    'time'  => $activeProject->updated_at->diffForHumans(),
                    'icon'  => 'document'
                ];
            }

            if (!empty($activeProject->konsultan_id) && $activeProject->konsultan) {
                $activities[] = [
                    'title' => 'Penugasan Konsultan Pendamping',
                    'desc'  => 'Sistem SPK telah menugaskan ' . $activeProject->konsultan->nama_konsultan . ' sebagai pendamping Anda.',
                    'time'  => $activeProject->updated_at->diffForHumans(),
                    'icon'  => 'user'
                ];
            }

            if ($currentStep >= 3) {
                $activities[] = [
                    'title' => 'Pembayaran Termin 1 Dikonfirmasi',
                    'desc'  => 'Pembayaran DP Termin 1 (60%) telah terverifikasi resmi.',
                    'time'  => $activeProject->updated_at->diffForHumans(),
                    'icon'  => 'payment'
                ];
            }

            $activities[] = [
                'title' => 'Pengajuan Sertifikasi Diterima',
                'desc'  => 'Berkas pendaftaran merek "' . $activeProject->nama_merek_dagang . '" tercatat resmi.',
                'time'  => $activeProject->created_at->diffForHumans(),
                'icon'  => 'document'
            ];
        }

        return view('client.dashboard', compact('user', 'profile', 'activeProject', 'currentStep', 'activities'));
    }

    /**
     * Menu Sidebar: Status Sertifikasi
     */
    public function statusSertifikasi()
    {
        $user = auth()->user();
        $activeProject = Project::with(['documents', 'konsultan', 'payments'])
            ->where('klien_id', $user->id)
            ->where('status_proyek', '!=', ProjectStatus::COMPLETED)
            ->latest()
            ->first();

        $currentStep = 0;
        if ($activeProject) {
            $uploadedDocs = $activeProject->documents;
            $hasAuditReport = $uploadedDocs->contains(function ($doc) {
                return in_array($doc->jenis_dokumen, ['laporan_review', 'laporan_hasil_review', 'laporan_audit']);
            });
            $hasCertificate = $uploadedDocs->contains('jenis_dokumen', 'sertifikat_halal');

            $statusVal = $activeProject->status_proyek instanceof ProjectStatus
                ? $activeProject->status_proyek->value
                : (string) $activeProject->status_proyek;

            if ($statusVal === ProjectStatus::COMPLETED->value) {
                $currentStep = 11;
            } elseif ($statusVal === ProjectStatus::WAITING_PAYMENT_T2->value) {
                $currentStep = 10;
            } elseif ($hasCertificate || $statusVal === ProjectStatus::CERTIFICATE_ISSUED->value) {
                $currentStep = 9;
            } elseif ($hasAuditReport || $statusVal === ProjectStatus::AUDIT_COMPLETED->value) {
                $currentStep = 8;
            } elseif ($activeProject->tanggal_audit || $statusVal === ProjectStatus::DOCUMENTS_VALID->value) {
                $currentStep = 7;
            } elseif ($uploadedDocs->count() > 0 && $uploadedDocs->where('status_validasi', 'approved')->count() > 0) {
                $currentStep = 6;
            } elseif ($uploadedDocs->count() > 0) {
                $currentStep = 5;
            } elseif (!empty($activeProject->konsultan_id)) {
                $currentStep = 4;
            } elseif ($statusVal === ProjectStatus::PAYMENT_T1_VERIFIED->value) {
                $currentStep = 3;
            } elseif ($statusVal === ProjectStatus::WAITING_PAYMENT_T1->value) {
                $currentStep = 2;
            } else {
                $currentStep = 1;
            }
        }

        $totalUploadedDocs = $activeProject ? $activeProject->documents->count() : 0;
        $approvedDocsCount = $activeProject ? $activeProject->documents->where('status_validasi', 'approved')->count() : 0;

        return view('client.status_sertifikasi', compact(
            'activeProject',
            'currentStep',
            'totalUploadedDocs',
            'approvedDocsCount'
        ));
    }

    /**
     * Menu Sidebar: Informasi Penugasan Konsultan
     */
    public function viewConsultant()
    {
        $user = auth()->user();
        $activeProject = Project::with(['konsultan.user', 'documents'])
            ->where('klien_id', $user->id)
            ->where('status_proyek', '!=', ProjectStatus::COMPLETED)
            ->latest()
            ->first();

        return view('client.consultant_info', compact('activeProject'));
    }

    /**
     * Menu Sidebar: Tampilan Utama Halaman Sertifikat Halal Klien (Support Multi-Sertifikat)
     */
    public function viewCertificate(Request $request)
    {
        $user = auth()->user();

        $completedProjects = Project::with(['documents', 'konsultan', 'klien.companyProfile'])
            ->where('klien_id', $user->id)
            ->where('status_proyek', ProjectStatus::COMPLETED)
            ->latest()
            ->get();

        $selectedProjectId = $request->query('project_id');
        $activeProject = null;

        if ($selectedProjectId) {
            $activeProject = $completedProjects->firstWhere('id', $selectedProjectId);
        }

        if (!$activeProject) {
            $activeProject = $completedProjects->first();
        }

        $certDoc = null;
        if ($activeProject) {
            $certDoc = $activeProject->documents()
                ->where('jenis_dokumen', 'sertifikat_halal')
                ->first();
        }

        $isAvailable = $certDoc && Storage::exists($certDoc->file_path);

        return view('client.certificate.index', compact('activeProject', 'certDoc', 'isAvailable', 'completedProjects'));
    }

    /**
     * Stream Preview PDF Sertifikat Halal
     */
    public function previewCertificate(Request $request)
    {
        $user = auth()->user();
        $projectId = $request->query('project_id');

        $query = Project::where('klien_id', $user->id)
            ->where('status_proyek', ProjectStatus::COMPLETED);

        if ($projectId) {
            $project = $query->where('id', $projectId)->firstOrFail();
        } else {
            $project = $query->latest()->firstOrFail();
        }

        $certDoc = $project->documents()
            ->where('jenis_dokumen', 'sertifikat_halal')
            ->firstOrFail();

        if (!Storage::exists($certDoc->file_path)) {
            abort(404, 'Berkas sertifikat tidak ditemukan.');
        }

        return Storage::response($certDoc->file_path, 'Sertifikat_Halal_' . Str::slug($project->nama_merek_dagang) . '.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Sertifikat_Halal_' . Str::slug($project->nama_merek_dagang) . '.pdf"'
        ]);
    }

    /**
     * Unduh File PDF Sertifikat Halal
     */
    public function downloadCertificate(Request $request)
    {
        $user = auth()->user();
        $projectId = $request->query('project_id');

        $query = Project::where('klien_id', $user->id)
            ->whereIn('status_proyek', [ProjectStatus::COMPLETED, ProjectStatus::CERTIFICATE_ISSUED]);

        if ($projectId) {
            $project = $query->where('id', $projectId)->firstOrFail();
        } else {
            $project = $query->latest()->firstOrFail();
        }

        $certDoc = $project->documents()
            ->where('jenis_dokumen', 'sertifikat_halal')
            ->first();

        if (!$certDoc || !Storage::exists($certDoc->file_path)) {
            return redirect()->back()->with('error', 'Sertifikat Halal belum tersedia.');
        }

        $filename = 'Sertifikat_Halal_' . Str::slug($project->nama_merek_dagang) . '.pdf';

        return Storage::download($certDoc->file_path, $filename);
    }
}

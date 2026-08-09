<?php

namespace App\Http\Controllers;

use App\Models\Consultant;
use App\Models\Project;
use App\Models\ProjectDocument;
use App\Models\Payment;
use App\Enums\ProjectStatus;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConsultantProjectController extends Controller
{
    private function getLoggedInConsultant(): ?Consultant
    {
        $user = auth()->user();

        return Consultant::where('user_id', $user->id)
            ->orWhereHas('user', function($q) use ($user) {
                $q->where('email', $user->email);
            })->first() ?? Consultant::first();
    }

    /**
     * Dashboard Overview Utama Konsultan
     */
    public function index()
    {
        $consultant = $this->getLoggedInConsultant();

        // 1. Ambil seluruh proyek penugasan konsultan yang login
        $allProjects = Project::with(['klien.companyProfile', 'documents'])
            ->where('konsultan_id', $consultant?->id)
            ->latest()
            ->get();

        // 2. Hitung statistik untuk kartu informasi dashboard
        $activeCount = $allProjects->where('status_proyek', '!=', ProjectStatus::COMPLETED)->count();

        $completedCount = $allProjects->filter(function($p) {
            return in_array($p->status_proyek, [ProjectStatus::COMPLETED, ProjectStatus::AUDIT_COMPLETED]);
        })->count();

        // Hitung dokumen berkas klien yang statusnya masih 'pending' dan perlu divalidasi
        $needValidationCount = ProjectDocument::whereHas('project', function($q) use ($consultant) {
            $q->where('konsultan_id', $consultant?->id);
        })->where('status_validasi', 'pending')->count();

        // 3. Ambil 6 penugasan proyek terbaru untuk ditampilkan di grid dashboard
        $assignments = $allProjects->take(6);

        return view('consultant.dashboard', compact(
            'consultant',
            'activeCount',
            'completedCount',
            'needValidationCount',
            'assignments'
        ));
    }

    /**
     * Halaman List: Daftar Penugasan Klien Binaan
     */
    public function assignmentsList()
    {
        $consultant = $this->getLoggedInConsultant();

        $assignments = Project::with(['klien.companyProfile', 'documents'])
            ->where('konsultan_id', $consultant?->id)
            ->latest()
            ->get();

        return view('consultant.assignments.index', compact('assignments', 'consultant'));
    }

    /**
     * Halaman Detail: Informasi Lengkap Klien Binaan Specific
     */
    public function showAssignment($id)
    {
        $consultant = $this->getLoggedInConsultant();

        $project = Project::with(['klien.companyProfile', 'documents'])
            ->where('konsultan_id', $consultant?->id)
            ->findOrFail($id);

        return view('consultant.assignments.show', compact('project', 'consultant'));
    }

    /**
     * Menu & Tab Jadwal Audit
     */
    public function schedules()
    {
        $consultant = $this->getLoggedInConsultant();

        $assignments = Project::with(['klien.companyProfile', 'documents'])
            ->where('konsultan_id', $consultant?->id)
            ->latest()
            ->get();

        return view('consultant.schedules.index', compact('assignments', 'consultant'));
    }

    /**
     * Halaman Detail: Kalender & Form Atur Jadwal Audit per Proyek
     */
    public function showSchedule($id)
    {
        $consultant = $this->getLoggedInConsultant();

        $project = Project::with(['klien.companyProfile', 'documents'])
            ->where('konsultan_id', $consultant?->id)
            ->findOrFail($id);

        $allScheduledProjects = Project::with(['klien.companyProfile'])
            ->where('konsultan_id', $consultant?->id)
            ->whereNotNull('tanggal_audit')
            ->get();

        $calendarEvents = $allScheduledProjects->map(function($p) {
            return [
                'id'              => $p->id,
                'title'           => $p->nama_merek_dagang,
                'start'           => \Carbon\Carbon::parse($p->tanggal_audit)->format('Y-m-d'),
                'company'         => $p->klien->companyProfile->nama_perusahaan ?? 'Pelaku Usaha',
                'catatan'         => $p->catatan_audit ?? '',
                'backgroundColor' => '#047857',
                'borderColor'     => '#065f46',
            ];
        })->values();

        return view('consultant.schedules.calendar', compact('project', 'calendarEvents'));
    }

    /**
     * Update Tanggal & Lokasi Jadwal Audit
     */
    public function updateSchedule(Request $request, $id)
    {
        $request->validate([
            'tanggal_audit' => 'required|date',
            'catatan_audit' => 'nullable|string|max:500',
        ], [
            'tanggal_audit.required' => 'Tanggal audit wajib diisi.',
            'tanggal_audit.date'     => 'Format tanggal tidak valid.',
        ]);

        $consultant = $this->getLoggedInConsultant();

        try {
            $project = Project::where('konsultan_id', $consultant?->id)->findOrFail($id);

            // GUARD: Cegah perubahan jika proyek sudah selesai
            if ($project->status_proyek === ProjectStatus::COMPLETED) {
                return redirect()->back()->with('error', 'Aksi ditolak. Proyek ini sudah berstatus Selesai (Read-Only) dan tidak dapat diubah.');
            }

            $project->update([
                'tanggal_audit' => $request->tanggal_audit,
                'catatan_audit' => $request->catatan_audit,
            ]);

            return redirect()->back()->with('success', 'Jadwal audit internal berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui jadwal: ' . $e->getMessage());
        }
    }

    /**
     * List Semua Proyek untuk Validasi Dokumen
     */
    public function documentsList()
    {
        $consultant = $this->getLoggedInConsultant();

        $assignments = Project::with(['klien.companyProfile', 'documents'])
            ->where('konsultan_id', $consultant?->id)
            ->latest()
            ->get();

        return view('consultant.documents.index', compact('assignments', 'consultant'));
    }

    /**
     * Tampilan Detail Validasi Dokumen
     */
    public function showValidateDocument($id)
    {
        $consultant = $this->getLoggedInConsultant();

        $project = Project::with(['klien.companyProfile', 'documents'])
            ->where('konsultan_id', $consultant?->id)
            ->findOrFail($id);

        return view('consultant.documents.validate', compact('project'));
    }

    /**
     * Memproses Validasi Dokumen (Approve / Reject)
     */
    public function updateDocumentStatus(Request $request, $documentId)
    {
        $request->validate([
            'status_validasi'          => 'required|in:approved,rejected',
            'catatan_revisi_konsultan' => 'required_if:status_validasi,rejected|nullable|string|max:1000',
        ]);

        $consultant = $this->getLoggedInConsultant();

        DB::beginTransaction();
        try {
            $doc = ProjectDocument::whereHas('project', function ($q) use ($consultant) {
                $q->where('konsultan_id', $consultant?->id);
            })->findOrFail($documentId);

            // GUARD: Cegah perubahan jika proyek sudah selesai
            if ($doc->project->status_proyek === ProjectStatus::COMPLETED) {
                return redirect()->back()->with('error', 'Aksi ditolak. Proyek ini telah berstatus Selesai (Read-Only) dan dokumen tidak dapat diubah lagi.');
            }

            $doc->update([
                'status_validasi'          => $request->status_validasi,
                'catatan_revisi_konsultan' => $request->catatan_revisi_konsultan,
            ]);

            $project = $doc->project;
            $klienDocsCount = $project->documents()
                ->whereIn('jenis_dokumen', ['daftar_produk', 'daftar_bahan', 'daftar_fasilitas', 'sk_penyelia_halal', 'manual_sjph'])
                ->where('status_validasi', 'approved')
                ->count();

            if ($klienDocsCount >= 5 && $project->status_proyek !== ProjectStatus::COMPLETED) {
                $project->update(['status_proyek' => ProjectStatus::DOCUMENTS_VALID]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Status validasi dokumen berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memvalidasi dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Preview / Stream Download Dokumen Klien
     */
    public function downloadDocument($documentId)
    {
        $consultant = $this->getLoggedInConsultant();

        $doc = ProjectDocument::with('project')->whereHas('project', function ($q) use ($consultant) {
            $q->where('konsultan_id', $consultant?->id);
        })->findOrFail($documentId);

        if (!Storage::exists($doc->file_path)) {
            abort(404, 'File dokumen tidak ditemukan di server.');
        }

        $jenisLabel = match ($doc->jenis_dokumen) {
            'daftar_produk'        => 'Daftar Produk Halal',
            'daftar_bahan'         => 'Daftar Bahan & Komposisi Produk',
            'daftar_fasilitas'     => 'Daftar Fasilitas Produksi',
            'sk_penyelia_halal'    => 'SK Penyelia Halal',
            'manual_sjph'          => 'Manual SJPH',
            'laporan_hasil_review' => 'Laporan Hasil Review Audit',
            default                => ucwords(str_replace('_', ' ', $doc->jenis_dokumen)),
        };

        $extension = pathinfo($doc->file_path, PATHINFO_EXTENSION);
        $cleanBrand = Str::title(str_replace(['/', '\\'], '', $doc->project->nama_merek_dagang));
        $customFileName = "{$cleanBrand} - {$jenisLabel}.{$extension}";

        return Storage::response($doc->file_path, $customFileName, [
            'Content-Disposition' => 'inline; filename="' . $customFileName . '"',
        ]);
    }

    /**
     * Menu Laporan Hasil Review Audit
     */
    public function reportsList()
    {
        $consultant = $this->getLoggedInConsultant();

        $assignments = Project::with(['klien.companyProfile', 'documents'])
            ->where('konsultan_id', $consultant?->id)
            ->latest()
            ->get();

        return view('consultant.reports.index', compact('assignments', 'consultant'));
    }

    /**
     * Unggah Laporan Review & Mengubah Status Proyek ke AUDIT_COMPLETED
     */
    public function uploadAuditReport(Request $request, $projectId)
    {
        $request->validate([
            'file_laporan' => 'required|file|mimes:pdf|max:5120',
        ]);

        $consultant = $this->getLoggedInConsultant();
        $project = Project::where('konsultan_id', $consultant?->id)->findOrFail($projectId);

        // GUARD: Cegah upload ulang jika proyek sudah selesai
        if ($project->status_proyek === ProjectStatus::COMPLETED) {
            return redirect()->back()->with('error', 'Aksi ditolak. Proyek ini sudah berstatus Selesai (Read-Only) dan laporan tidak dapat diunggah ulang.');
        }

        DB::beginTransaction();
        try {
            if ($request->hasFile('file_laporan')) {
                $existingReport = ProjectDocument::where('project_id', $project->id)
                    ->where('jenis_dokumen', 'laporan_hasil_review')
                    ->first();

                if ($existingReport && $existingReport->file_path && Storage::exists($existingReport->file_path)) {
                    Storage::delete($existingReport->file_path);
                }

                $filePath = $request->file('file_laporan')->store('documents/audit_reports');

                ProjectDocument::updateOrCreate(
                    [
                        'project_id'    => $project->id,
                        'jenis_dokumen' => 'laporan_hasil_review',
                    ],
                    [
                        'file_path'       => $filePath,
                        'status_validasi' => 'approved',
                    ]
                );

                $project->status_proyek = ProjectStatus::AUDIT_COMPLETED;
                $project->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Laporan hasil review audit berhasil diunggah. Proyek kini siap untuk penerbitan Sertifikat Halal oleh Admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengunggah laporan: ' . $e->getMessage());
        }
    }
}

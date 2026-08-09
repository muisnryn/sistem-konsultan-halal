<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectDocument;
use App\Enums\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ClientDocumentController extends Controller
{
    /**
     * Menampilkan daftar dokumen persyaratan proyek aktif.
     */
    public function index()
    {
        $user = auth()->user();

        $activeProject = Project::with(['documents', 'konsultan'])
            ->where('klien_id', $user->id)
            ->where('status_proyek', '!=', ProjectStatus::COMPLETED->value)
            ->latest()
            ->first();

        // 5 Jenis dokumen wajib bagi Klien beserta aturan formatnya
        $requiredDocs = [
            'daftar_produk' => [
                'title'       => 'Daftar Produk & Varian',
                'description' => 'Matriks nama produk, merk, dan varian yang diajukan.',
                'format'      => 'Excel (.xls, .xlsx, .csv)',
                'accept'      => '.xls,.xlsx,.csv',
            ],
            'daftar_bahan' => [
                'title'       => 'Daftar Bahan & Spesifikasi',
                'description' => 'Daftar bahan baku, bahan penolong, dan nomor sertifikat halal bahan.',
                'format'      => 'Excel (.xls, .xlsx, .csv)',
                'accept'      => '.xls,.xlsx,.csv',
            ],
            'daftar_fasilitas' => [
                'title'       => 'Daftar Fasilitas Produksi',
                'description' => 'Daftar pabrik, dapur, tempat penyimpanan, dan alat produksi.',
                'format'      => 'Excel (.xls, .xlsx, .csv)',
                'accept'      => '.xls,.xlsx,.csv',
            ],
            'sk_penyelia_halal' => [
                'title'       => 'SK Penyelia Halal',
                'description' => 'Surat Keputusan penetapan Penyelia Halal internal perusahaan.',
                'format'      => 'PDF (.pdf)',
                'accept'      => '.pdf',
            ],
            'manual_sjph' => [
                'title'       => 'Manual SJPH',
                'description' => 'Dokumen Manual Sistem Jaminan Produk Halal perusahaan.',
                'format'      => 'PDF / Word (.pdf, .doc, .docx)',
                'accept'      => '.pdf,.doc,.docx',
            ],
        ];

        return view('client.documents.index', compact('activeProject', 'requiredDocs'));
    }

    /**
     * Mengunggah atau merevisi dokumen persyaratan.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $activeProject = Project::where('klien_id', $user->id)
            ->where('status_proyek', '!=', ProjectStatus::COMPLETED->value)
            ->latest()
            ->first();

        if (!$activeProject) {
            return redirect()->back()->with('error', 'Tidak ditemukan proyek aktif untuk pengunggahan dokumen.');
        }

        // GUARD CONDITION: Klien hanya boleh unggah jika Konsultan sudah diplotting
        $allowedStatuses = [
            ProjectStatus::CONSULTANT_ASSIGNED->value,
            ProjectStatus::DOCUMENTS_VALID->value,
            ProjectStatus::AUDIT_COMPLETED->value,
            ProjectStatus::CERTIFICATE_ISSUED->value,
            ProjectStatus::WAITING_PAYMENT_T2->value,
        ];

        $currentStatus = $activeProject->status_proyek instanceof ProjectStatus
            ? $activeProject->status_proyek->value
            : $activeProject->status_proyek;

        if (!in_array($currentStatus, $allowedStatuses)) {
            return redirect()->back()->with('error', 'Unggah dokumen belum diizinkan sebelum konsultan pendamping ditetapkan oleh Admin.');
        }

        // PENETAPAN ATURAN MIME TYPES BERDASARKAN JENIS DOKUMEN
        $allowedMimes = match ($request->jenis_dokumen) {
            'daftar_produk', 'daftar_bahan', 'daftar_fasilitas' => 'xls,xlsx,csv',
            'sk_penyelia_halal' => 'pdf',
            'manual_sjph'       => 'pdf,doc,docx',
            default             => 'pdf,xls,xlsx,csv,doc,docx',
        };

        $customErrorMessage = match ($request->jenis_dokumen) {
            'daftar_produk', 'daftar_bahan', 'daftar_fasilitas' => 'Dokumen ini wajib berformat Excel (.xls, .xlsx, .csv).',
            'sk_penyelia_halal' => 'Dokumen ini wajib berformat PDF (.pdf).',
            'manual_sjph'       => 'Dokumen ini wajib berformat PDF atau Word (.pdf, .doc, .docx).',
            default             => 'Format file tidak didukung.',
        };

        $request->validate([
            'jenis_dokumen' => ['required', Rule::in([
                'daftar_produk', 'daftar_bahan', 'daftar_fasilitas', 'sk_penyelia_halal', 'manual_sjph'
            ])],
            'file' => ['required', 'file', "mimes:{$allowedMimes}", 'max:10240'], // Maksimal 10 MB
        ], [
            'file.mimes' => 'Format file tidak sesuai! ' . $customErrorMessage,
            'file.max'   => 'Ukuran file melebihi batas maksimal 10 MB.',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('file')) {
                // Cari apakah dokumen jenis ini sudah pernah diunggah sebelumnya
                $existingDoc = ProjectDocument::where('project_id', $activeProject->id)
                    ->where('jenis_dokumen', $request->jenis_dokumen)
                    ->first();

                // Hapus file fisik lama jika ada
                if ($existingDoc && $existingDoc->file_path && Storage::exists($existingDoc->file_path)) {
                    Storage::delete($existingDoc->file_path);
                }

                $filePath = $request->file('file')->store('documents/requirements');

                // Simpan atau ganti dokumen (Reset status ke pending jika re-upload revisi)
                ProjectDocument::updateOrCreate(
                    [
                        'project_id'    => $activeProject->id,
                        'jenis_dokumen' => $request->jenis_dokumen,
                    ],
                    [
                        'file_path'                => $filePath,
                        'status_validasi'          => 'pending',
                        'catatan_revisi_konsultan' => null,
                    ]
                );
            }

            DB::commit();
            return redirect()->back()->with('success', 'Dokumen persyaratan berhasil diunggah dan menanti verifikasi konsultan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengunggah dokumen: ' . $e->getMessage());
        }
    }
}

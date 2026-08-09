<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectDocument;
use App\Models\Payment;
use App\Enums\ProjectStatus;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminCertificateController extends Controller
{
    /**
     * Menampilkan daftar pengajuan yang siap / menunggu unggah sertifikat halal
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pending');

        $query = Project::with(['klien.companyProfile', 'documents', 'payments']);

        if ($tab === 'waiting_payment') {
            $query->where('status_proyek', ProjectStatus::WAITING_PAYMENT_T2);
        } elseif ($tab === 'completed') {
            $query->whereIn('status_proyek', [ProjectStatus::CERTIFICATE_ISSUED, ProjectStatus::COMPLETED]);
        } else {
            // Default: 'pending' (Belum Upload Sertifikat)
            $query->where('status_proyek', ProjectStatus::AUDIT_COMPLETED);
        }

        $projects = $query->latest()->get();

        return view('admin.certificate.upload', compact('projects', 'tab'));
    }

    /**
     * Mengunggah berkas Sertifikat Halal resmi (PDF) & Memicu Tagihan Termin 2 (40%)
     */
    public function upload(Request $request, $projectId)
    {
        $request->validate([
            'file_sertifikat' => 'required|file|mimes:pdf|max:5120',
        ], [
            'file_sertifikat.required' => 'Berkas sertifikat halal wajib diunggah.',
            'file_sertifikat.mimes'    => 'Format berkas harus PDF.',
            'file_sertifikat.max'      => 'Ukuran berkas maksimal 5MB.'
        ]);

        $project = Project::findOrFail($projectId);

        DB::beginTransaction();
        try {
            if ($request->hasFile('file_sertifikat')) {
                // Hapus berkas sertifikat fisik lama jika ada
                $existingCert = ProjectDocument::where('project_id', $project->id)
                    ->where('jenis_dokumen', 'sertifikat_halal')
                    ->first();

                if ($existingCert && $existingCert->file_path && Storage::exists($existingCert->file_path)) {
                    Storage::delete($existingCert->file_path);
                }

                $filePath = $request->file('file_sertifikat')->store('documents/certificates');

                // Simpan/Update ke tabel project_documents
                ProjectDocument::updateOrCreate(
                    [
                        'project_id'    => $project->id,
                        'jenis_dokumen' => 'sertifikat_halal',
                    ],
                    [
                        'file_path'       => $filePath,
                        'status_validasi' => 'approved',
                    ]
                );

                // Buat tagihan Termin 2 (40%) jika belum ada
                $nominalT2 = $project->total_harga_kesepakatan * 0.40;

                Payment::firstOrCreate(
                    [
                        'project_id' => $project->id,
                        'termin'     => 'T2_40',
                    ],
                    [
                        'invoice_number'    => 'INV-T2-' . strtoupper(uniqid()),
                        'nominal_tagihan'   => $nominalT2,
                        'status_pembayaran' => PaymentStatus::PENDING,
                        'snap_token'        => null,
                    ]
                );

                // Cek status pembayaran T2
                $isT2Paid = $project->payments()
                    ->where('termin', 'T2_40')
                    ->where('status_pembayaran', PaymentStatus::SUCCESS)
                    ->exists();

                $project->status_proyek = $isT2Paid ? ProjectStatus::COMPLETED : ProjectStatus::WAITING_PAYMENT_T2;
                $project->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Sertifikat Halal resmi berhasil diunggah untuk pengajuan #' . $project->kode_registrasi . '.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengunggah sertifikat: ' . $e->getMessage());
        }
    }
}
<?php

use App\Http\Controllers\AdminCertificateController;
use App\Http\Controllers\AdminConsultantController;
use App\Http\Controllers\AdminCriteriaController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminSpkController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\ClientDocumentController;
use App\Http\Controllers\ClientPaymentController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\ConsultantProjectController;
use App\Http\Controllers\FinanceProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceTypeController;
use Illuminate\Support\Facades\Route;

// Rute Default Landing Page
Route::get('/', function () {
    return view('welcome');
});

// ROUTE PUBLIC: Webhook Midtrans (Wajib di luar middleware auth)
Route::post('/midtrans/webhook', [ClientPaymentController::class, 'handleWebhook'])->name('midtrans.webhook');

// Redirection Dashboard Berdasarkan Role
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'consultant') {
        return redirect()->route('consultant.dashboard');
    } elseif ($user->role === 'keuangan') {
        return redirect()->route('finance.dashboard');
    } else {
        return redirect()->route('client.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute Global Profil Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ====================================================================
// 1. GROUP ROUTE AKTOR KLIEN
// ====================================================================
Route::middleware(['auth', 'role:klien'])->prefix('klien')->name('client.')->group(function () {

    // 1. Dashboard Klien
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

    // 2. Profil Perusahaan
    Route::get('/profil', [CompanyProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil', [CompanyProfileController::class, 'update'])->name('profile.update');

    // 3. Pengajuan Baru (Diproteksi Guard Profil Perusahaan Wajib Lengkap)
    Route::middleware('ensure.profile.completed')->group(function () {
        Route::get('/pengajuan', [ProjectController::class, 'create'])->name('project.create');
        Route::post('/pengajuan', [ProjectController::class, 'store'])->name('project.store');
    });

    // 4. Dokumen Persyaratan
    Route::get('/dokumen', [ClientDocumentController::class, 'index'])->name('documents.index');
    Route::post('/dokumen/upload', [ClientDocumentController::class, 'store'])->name('documents.store');

    // 5. Pembayaran & Payment Gateway Midtrans
    Route::get('/pembayaran', [ClientPaymentController::class, 'index'])->name('payment.index');
    Route::get('/proyek/{project}/download-penawaran', [ClientPaymentController::class, 'downloadPenawaran'])->name('project.download_penawaran');
    Route::get('/pembayaran/{id}/snap-token', [ClientPaymentController::class, 'getSnapToken'])->name('payment.snap_token');
    Route::get('/pembayaran/{id}/sukses', [ClientPaymentController::class, 'prosesPembayaranSukses'])->name('payment.success_callback');

    // 6. Status Sertifikasi
    Route::get('/status-sertifikasi', [ClientDashboardController::class, 'statusSertifikasi'])->name('certification.status');

    // 7. Penugasan Konsultan
    Route::get('/konsultan-pendamping', [ClientDashboardController::class, 'viewConsultant'])->name('consultant.index');

    // 8. Sertifikat Halal
    Route::get('/sertifikat-halal', [ClientDashboardController::class, 'viewCertificate'])->name('certificate.index');
    Route::get('/sertifikat-halal/preview', [ClientDashboardController::class, 'previewCertificate'])->name('certificate.preview');
    Route::get('/sertifikat-halal/unduh', [ClientDashboardController::class, 'downloadCertificate'])->name('certificate.download');
});

// ====================================================================
// 2. GROUP ROUTE AKTOR KEUANGAN
// ====================================================================
Route::middleware(['auth', 'role:keuangan'])->prefix('keuangan')->name('finance.')->group(function () {
    // 1. Dashboard Ringkasan & Statistik Keuangan
    Route::get('/dashboard', [FinanceProjectController::class, 'index'])->name('dashboard');

    // 2. Penerbitan Invoice & Verifikasi Harga Final (Pengajuan Masuk)
    Route::get('/penerbitan-invoice', [FinanceProjectController::class, 'invoicesList'])->name('invoices.index');
    Route::get('/proyek/{id}/verifikasi', [FinanceProjectController::class, 'edit'])->name('project.edit');
    Route::post('/proyek/{id}/verifikasi', [FinanceProjectController::class, 'update'])->name('project.update');

    // 3. Monitoring Pembayaran (Termin 1 60% & Termin 2 40%)
    Route::get('/monitoring-pembayaran', [FinanceProjectController::class, 'paymentsList'])->name('payments.index');
    Route::get('/monitoring-pembayaran/export-pdf', [FinanceProjectController::class, 'exportPdf'])->name('payments.exportPdf');

    // 4. Laporan Keuangan & Pendapatan
    Route::get('/laporan-keuangan', [FinanceProjectController::class, 'reportsList'])->name('reports.index');
    Route::get('/laporan-keuangan/export-pdf', [FinanceProjectController::class, 'exportReportsPdf'])->name('reports.exportPdf');
});

// ====================================================================
// GROUP ROUTE AKTOR KONSULTAN
// ====================================================================
Route::middleware(['auth', 'role:konsultan,consultant'])->prefix('konsultan')->name('consultant.')->group(function () {
    // 1. Dashboard Ringkasan / Overview
    Route::get('/dashboard', [ConsultantProjectController::class, 'index'])->name('dashboard');

    // 2. Daftar Penugasan (List & Detail Klien Binaan)
    Route::get('/penugasan', [ConsultantProjectController::class, 'assignmentsList'])->name('assignments.index');
    Route::get('/penugasan/{id}', [ConsultantProjectController::class, 'showAssignment'])->name('assignments.show');

    // 3. Schedule / Jadwal Audit
    Route::get('/jadwal-audit', [ConsultantProjectController::class, 'schedules'])->name('schedules.index');
    Route::get('/proyek/{id}/jadwal-audit', [ConsultantProjectController::class, 'showSchedule'])->name('schedules.show');
    Route::post('/proyek/{id}/jadwal-audit', [ConsultantProjectController::class, 'updateSchedule'])->name('schedules.update');

    // 4. Validasi Dokumen
    Route::get('/validasi-dokumen', [ConsultantProjectController::class, 'documentsList'])->name('documents.index');
    Route::get('/proyek/{id}/validasi', [ConsultantProjectController::class, 'showValidateDocument'])->name('documents.validate');
    Route::post('/dokumen/{documentId}/status', [ConsultantProjectController::class, 'updateDocumentStatus'])->name('documents.update-status');
    Route::get('/dokumen/{documentId}/download', [ConsultantProjectController::class, 'downloadDocument'])->name('documents.download');

    // 5. Laporan Review Audit
    Route::get('/laporan-review', [ConsultantProjectController::class, 'reportsList'])->name('reports.index');
    Route::post('/proyek/{projectId}/unggah-audit', [ConsultantProjectController::class, 'uploadAuditReport'])->name('documents.upload-audit');
});

// ====================================================================
// 4. GROUP ROUTE AKTOR ADMIN
// ====================================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // 1. Menu: Dashboard Overview
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // 2. Menu: Konfigurasi Kriteria & SPK
    Route::get('/konfigurasi-kriteria', [AdminCriteriaController::class, 'index'])->name('criteria.index');
    Route::post('/konfigurasi-kriteria/simpan', [AdminCriteriaController::class, 'updateConfig'])->name('criteria.update_config');

    // 3. Menu: Komputasi & Plotting Konsultan (PROMETHEE II Engine)
    Route::get('/spk-plotting', [AdminSpkController::class, 'index'])->name('spk.index');
    Route::get('/proyek/{id}/spk', [AdminSpkController::class, 'tampilkanRekomendasi'])->name('spk.recommend');
    Route::get('/proyek/{id}/spk/hitung-ajax', [AdminSpkController::class, 'hitungSpkAjax'])->name('spk.hitung');
    Route::post('/proyek/{id}/spk/tunjuk', [AdminSpkController::class, 'tunjukKonsultan'])->name('spk.tunjuk');

    // 4. Menu Grup: Kelola Data Master
    // Sub-Menu A: Kelola Data Konsultan
    Route::get('/kelola-konsultan', [AdminConsultantController::class, 'index'])->name('consultant.index');
    Route::post('/kelola-konsultan', [AdminConsultantController::class, 'store'])->name('consultant.store');
    Route::put('/kelola-konsultan/{id}', [AdminConsultantController::class, 'update'])->name('consultant.update');
    Route::delete('/kelola-konsultan/{id}', [AdminConsultantController::class, 'destroy'])->name('consultant.destroy');
    Route::get('/kelola-konsultan/{id}/nilai', [AdminConsultantController::class, 'editEvaluations'])->name('consultant.evaluations.edit');
    Route::put('/kelola-konsultan/{id}/nilai', [AdminConsultantController::class, 'updateEvaluations'])->name('consultant.evaluations.update');

    // Sub-Menu B: Kelola Data Pengguna (FULL CRUD)
    Route::get('/kelola-pengguna', [AdminUserController::class, 'index'])->name('user.index');
    Route::post('/kelola-pengguna', [AdminUserController::class, 'store'])->name('user.store');
    Route::put('/kelola-pengguna/{id}', [AdminUserController::class, 'update'])->name('user.update');
    Route::delete('/kelola-pengguna/{id}', [AdminUserController::class, 'destroy'])->name('user.destroy');

    // Sub-Menu C: Kelola Data Jenis Layanan (FULL CRUD)
    Route::get('/kelola-layanan', [ServiceTypeController::class, 'index'])->name('service.index');
    Route::post('/kelola-layanan', [ServiceTypeController::class, 'store'])->name('service.store');
    Route::put('/kelola-layanan/{id}', [ServiceTypeController::class, 'update'])->name('service.update');
    Route::delete('/kelola-layanan/{id}', [ServiceTypeController::class, 'destroy'])->name('service.destroy');

    // 5. Menu: Unggah Sertifikat Halal
    Route::get('/unggah-sertifikat', [AdminCertificateController::class, 'index'])->name('certificate.index');
    Route::post('/unggah-sertifikat/{id}', [AdminCertificateController::class, 'upload'])->name('certificate.upload');
});

require __DIR__.'/auth.php';

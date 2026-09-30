<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CompanyProfile;
use App\Models\Project;
use App\Models\Payment;
use App\Models\ProjectDocument;
use App\Models\Consultant;
use App\Enums\ProjectStatus;
use App\Enums\PaymentStatus;
use App\Enums\JenisPengajuan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // 1. GENERATE FILE DUMMY FISIK DI DISK STORAGE
        $this->generateDummyFiles();

        // 2. AMBIL KONSULTAN TERSEDIA
        $consultants = Consultant::where('is_active', true)->get();
        $prima = $consultants->where('sertifikasi_no', 'HALAL-CONS-2026-001')->first(); // Prima (Bogor - Makanan/Minuman)
        $exien = $consultants->where('sertifikasi_no', 'HALAL-CONS-2026-002')->first(); // Exien (Jakarta - Kosmetik)
        $iqbal = $consultants->where('sertifikasi_no', 'HALAL-CONS-2026-003')->first(); // Iqbal (Jakarta - Makanan/Minuman)
        $siti  = $consultants->where('sertifikasi_no', 'HALAL-CONS-2026-005')->first(); // Siti Aisyah (Bogor - Makanan/Minuman)

        $reqDocsList = ['daftar_produk', 'daftar_bahan', 'daftar_fasilitas', 'sk_penyelia_halal', 'manual_sjph'];

        // =========================================================================
        // EDGE CASE 1: KLIEN BARU BELUM ISI PROFIL (Uji Middleware EnsureProfileCompleted)
        // =========================================================================
        User::updateOrCreate(
            ['email' => 'klien_baru@halal.com'],
            [
                'name'       => 'Pendaftar Baru',
                'password'   => Hash::make('password'),
                'role'       => 'klien',
                'created_at' => Carbon::now()->subHours(2),
            ]
        ); // Tanpa CompanyProfile agar is_completed = false

        // =========================================================================
        // PROYEK 1: PT Dapur Halal Nusantara
        // Status: PAYMENT_T1_VERIFIED -> SIAP DIUJI ADMIN (SPK PROMETHEE II & PLOTTING)
        // Timeline: Dibuat 10 hari lalu, Bayar T1 8 hari lalu
        // =========================================================================
        $d1 = Carbon::now()->subDays(10);
        $klien1 = User::updateOrCreate(
            ['email' => 'test@halal.com'],
            ['name' => 'Adelia Putri', 'password' => Hash::make('password'), 'role' => 'klien', 'created_at' => $d1]
        );
        CompanyProfile::updateOrCreate(
            ['user_id' => $klien1->id],
            [
                'nama_perusahaan'      => 'PT Dapur Halal Nusantara',
                'skala_perusahaan'     => 'menengah',
                'jenis_kelompok_usaha' => 'Makanan dan Minuman',
                'pic_nama'             => 'Adelia Putri',
                'pic_email'            => 'klien1@halal.com',
                'pic_phone'            => '085722288968',
                'latitude'             => -6.806885, // Cianjur
                'longitude'            => 107.142338, // Cianjur
                'created_at'           => $d1,
            ]
        );
        $p1 = Project::updateOrCreate(
        ['nama_merek_dagang' => 'Dapur Halal Nusantara'],
        [
            'klien_id'                => $klien1->id,
            'konsultan_id'             => null,
            'nama_paket'              => 'Paket Pendampingan Reguler',
            'jenis_pengajuan'         => JenisPengajuan::BARU,
            'jumlah_produk'           => 12,
            'jumlah_outlet'           => 1,
            'is_luar_jabodetabek'     => false,
            'status_proyek'           => ProjectStatus::PAYMENT_T1_VERIFIED,
            'total_harga_kesepakatan' => 15000000.00,
            'file_dokumen_penawaran'  => 'documents/penawaran/sample_penawaran.pdf',
            'latitude'                => -6.806885, // Cianjur
            'longitude'               => 107.142338, // Cianjur
            'created_at'              => $d1,
            'updated_at'              => Carbon::now()->subDays(8),
        ]
    );
        Payment::updateOrCreate(
            ['project_id' => $p1->id, 'termin' => 'T1_60'],
            [
                'invoice_number'    => 'INV-T1-NUSA001',
                'nominal_tagihan'   => 9000000.00,
                'status_pembayaran' => PaymentStatus::SUCCESS,
                'created_at'        => Carbon::now()->subDays(9),
                'updated_at'        => Carbon::now()->subDays(8),
            ]
        );

        // =========================================================================
        // PROYEK 2: CV Rasa Minang Sejahtera
        // Status: PENGAJUAN_SUBMITTED -> SIAP DIUJI FINANCE (PENERBITAN INVOICE & NEGOSIASI)
        // Timeline: Dibuat 1 hari yang lalu
        // =========================================================================
        $d2 = Carbon::now()->subDay();
        $klien2 = User::updateOrCreate(
            ['email' => 'klien2@halal.com'],
            ['name' => 'Budi Santoso', 'password' => Hash::make('password'), 'role' => 'klien', 'created_at' => $d2]
        );
        CompanyProfile::updateOrCreate(
            ['user_id' => $klien2->id],
            [
                'nama_perusahaan'      => 'CV Rasa Minang Sejahtera',
                'skala_perusahaan'     => 'kecil',
                'jenis_kelompok_usaha' => 'Makanan dan Minuman',
                'pic_nama'             => 'Budi Santoso',
                'pic_email'            => 'klien2@halal.com',
                'pic_phone'            => '081234567890',
                'latitude'             => -6.208800,
                'longitude'            => 106.845600, // Jakarta
                'created_at'           => $d2,
            ]
        );
        Project::updateOrCreate(
            ['nama_merek_dagang' => 'Rendang Minang Asli'],
            [
                'klien_id'                => $klien2->id,
                'konsultan_id'             => null,
                'nama_paket'              => 'Paket Pendampingan UMKM',
                'jenis_pengajuan'         => JenisPengajuan::BARU,
                'jumlah_produk'           => 5,
                'jumlah_outlet'           => 1,
                'is_luar_jabodetabek'     => false,
                'status_proyek'           => ProjectStatus::PENGAJUAN_SUBMITTED,
                'total_harga_kesepakatan' => null,
                'latitude'                => -6.208800,
                'longitude'               => 106.845600,
                'created_at'              => $d2,
                'updated_at'              => $d2,
            ]
        );

        // =========================================================================
        // PROYEK 3: PT Kopi Artisan Nusantara
        // Status: WAITING_PAYMENT_T1 -> SIAP DIUJI KLIEN (CHECKOUT BAYAR T1 VIA MIDTRANS)
        // Timeline: Dibuat 3 hari lalu
        // =========================================================================
        $d3 = Carbon::now()->subDays(3);
        $klien3 = User::updateOrCreate(
            ['email' => 'klien3@halal.com'],
            ['name' => 'Citra Lestari', 'password' => Hash::make('password'), 'role' => 'klien', 'created_at' => $d3]
        );
        CompanyProfile::updateOrCreate(
            ['user_id' => $klien3->id],
            [
                'nama_perusahaan'      => 'PT Kopi Artisan Nusantara',
                'skala_perusahaan'     => 'menengah',
                'jenis_kelompok_usaha' => 'Makanan dan Minuman',
                'pic_nama'             => 'Citra Lestari',
                'pic_email'            => 'klien3@halal.com',
                'pic_phone'            => '081987654321',
                'latitude'             => -6.597147,
                'longitude'            => 106.806039,
                'created_at'           => $d3,
            ]
        );
        $p3 = Project::updateOrCreate(
            ['nama_merek_dagang' => 'Kopi Kenangan Nusantara'],
            [
                'klien_id'                => $klien3->id,
                'konsultan_id'             => null,
                'nama_paket'              => 'Paket Pendampingan Reguler',
                'jenis_pengajuan'         => JenisPengajuan::BARU,
                'jumlah_produk'           => 15,
                'jumlah_outlet'           => 2,
                'is_luar_jabodetabek'     => false,
                'status_proyek'           => ProjectStatus::WAITING_PAYMENT_T1,
                'total_harga_kesepakatan' => 12000000.00,
                'file_dokumen_penawaran'  => 'documents/penawaran/sample_penawaran.pdf',
                'latitude'                => -6.597147,
                'longitude'               => 106.806039,
                'created_at'              => $d3,
                'updated_at'              => Carbon::now()->subDays(2),
            ]
        );
        Payment::updateOrCreate(
            ['project_id' => $p3->id, 'termin' => 'T1_60'],
            [
                'invoice_number'    => 'INV-T1-KOPI003',
                'nominal_tagihan'   => 7200000.00,
                'status_pembayaran' => PaymentStatus::PENDING,
                'created_at'        => Carbon::now()->subDays(2),
            ]
        );

        // =========================================================================
        // PROYEK 4: CV Snack Barokah Mandiri
        // Status: CONSULTANT_ASSIGNED -> SIAP DIUJI KONSULTAN PRIMA (REVISI) & KLIEN (RE-UPLOAD)
        // Timeline: Dibuat 15 hari lalu, Assigned 5 hari lalu
        // =========================================================================
        $d4 = Carbon::now()->subDays(15);
        $klien4 = User::updateOrCreate(
            ['email' => 'klien4@halal.com'],
            ['name' => 'Dewi Anggraini', 'password' => Hash::make('password'), 'role' => 'klien', 'created_at' => $d4]
        );
        CompanyProfile::updateOrCreate(
            ['user_id' => $klien4->id],
            [
                'nama_perusahaan'      => 'CV Snack Barokah Mandiri',
                'skala_perusahaan'     => 'kecil',
                'jenis_kelompok_usaha' => 'Makanan dan Minuman',
                'pic_nama'             => 'Dewi Anggraini',
                'pic_email'            => 'klien4@halal.com',
                'pic_phone'            => '081311223344',
                'latitude'             => -6.595000,
                'longitude'            => 106.790000,
                'created_at'           => $d4,
            ]
        );
        $p4 = Project::updateOrCreate(
            ['nama_merek_dagang' => 'Keripik Singkong Barokah'],
            [
                'klien_id'                => $klien4->id,
                'konsultan_id'             => $prima?->id,
                'nama_paket'              => 'Paket Pendampingan UMKM',
                'jenis_pengajuan'         => JenisPengajuan::BARU,
                'jumlah_produk'           => 8,
                'jumlah_outlet'           => 1,
                'is_luar_jabodetabek'     => false,
                'status_proyek'           => ProjectStatus::CONSULTANT_ASSIGNED,
                'total_harga_kesepakatan' => 8000000.00,
                'file_dokumen_penawaran'  => 'documents/penawaran/sample_penawaran.pdf',
                'latitude'                => -6.595000,
                'longitude'               => 106.790000,
                'created_at'              => $d4,
                'updated_at'              => Carbon::now()->subDays(5),
            ]
        );
        Payment::updateOrCreate(
            ['project_id' => $p4->id, 'termin' => 'T1_60'],
            ['invoice_number' => 'INV-T1-SNACK004', 'nominal_tagihan' => 4800000.00, 'status_pembayaran' => PaymentStatus::SUCCESS, 'created_at' => Carbon::now()->subDays(12)]
        );
        ProjectDocument::updateOrCreate(
            ['project_id' => $p4->id, 'jenis_dokumen' => 'daftar_produk'],
            ['file_path' => 'documents/requirements/sample_excel.xlsx', 'status_validasi' => 'pending', 'created_at' => Carbon::now()->subDays(3)]
        );
        ProjectDocument::updateOrCreate(
            ['project_id' => $p4->id, 'jenis_dokumen' => 'daftar_bahan'],
            [
                'file_path' => 'documents/requirements/sample_excel.xlsx',
                'status_validasi' => 'rejected',
                'catatan_revisi_konsultan' => 'Nomor sertifikat halal bahan baku bumbu belum dicantumkan secara lengkap. Mohon perbaiki Excel!',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(1),
            ]
        );

        // =========================================================================
        // PROYEK 5: PT Frozen Food Halal Utama
        // Status: CONSULTANT_ASSIGNED -> SIAP DIUJI SITI AISYAH (APPROVE ALL 5 BERKAS)
        // Timeline: Dibuat 12 hari lalu
        // =========================================================================
        $d5 = Carbon::now()->subDays(12);
        $klien5 = User::updateOrCreate(
            ['email' => 'klien5@halal.com'],
            ['name' => 'Eko Prasetyo', 'password' => Hash::make('password'), 'role' => 'klien', 'created_at' => $d5]
        );
        CompanyProfile::updateOrCreate(
            ['user_id' => $klien5->id],
            [
                'nama_perusahaan'      => 'PT Frozen Food Halal Utama',
                'skala_perusahaan'     => 'menengah',
                'jenis_kelompok_usaha' => 'Makanan dan Minuman',
                'pic_nama'             => 'Eko Prasetyo',
                'pic_email'            => 'klien5@halal.com',
                'pic_phone'            => '081544556677',
                'latitude'             => -6.600000,
                'longitude'            => 106.800000,
                'created_at'           => $d5,
            ]
        );
        $p5 = Project::updateOrCreate(
            ['nama_merek_dagang' => 'Bakso Sapi Premium Halal'],
            [
                'klien_id'                => $klien5->id,
                'konsultan_id'             => $siti?->id,
                'nama_paket'              => 'Paket Pendampingan Reguler',
                'jenis_pengajuan'         => JenisPengajuan::BARU,
                'jumlah_produk'           => 20,
                'jumlah_outlet'           => 3,
                'is_luar_jabodetabek'     => false,
                'status_proyek'           => ProjectStatus::CONSULTANT_ASSIGNED,
                'total_harga_kesepakatan' => 18000000.00,
                'file_dokumen_penawaran'  => 'documents/penawaran/sample_penawaran.pdf',
                'latitude'                => -6.600000,
                'longitude'               => 106.800000,
                'created_at'              => $d5,
                'updated_at'              => Carbon::now()->subDays(4),
            ]
        );
        Payment::updateOrCreate(
            ['project_id' => $p5->id, 'termin' => 'T1_60'],
            ['invoice_number' => 'INV-T1-FROZEN005', 'nominal_tagihan' => 10800000.00, 'status_pembayaran' => PaymentStatus::SUCCESS, 'created_at' => Carbon::now()->subDays(10)]
        );
        foreach ($reqDocsList as $docType) {
            $ext = str_contains($docType, 'daftar') ? 'sample_excel.xlsx' : 'sample_pdf.pdf';
            ProjectDocument::updateOrCreate(
                ['project_id' => $p5->id, 'jenis_dokumen' => $docType],
                ['file_path' => 'documents/requirements/' . $ext, 'status_validasi' => 'pending', 'created_at' => Carbon::now()->subDays(2)]
            );
        }

        // =========================================================================
        // PROYEK 6: PT Sambal Tradisional Bogor
        // Status: DOCUMENTS_VALID -> SIAP DIUJI SITI AISYAH (PENJADWALAN AUDIT KALENDER)
        // Timeline: Dibuat 20 hari lalu, Dokumen Valid 3 hari lalu
        // =========================================================================
        $d6 = Carbon::now()->subDays(20);
        $klien6 = User::updateOrCreate(
            ['email' => 'klien6@halal.com'],
            ['name' => 'Fahri Ramadhan', 'password' => Hash::make('password'), 'role' => 'klien', 'created_at' => $d6]
        );
        CompanyProfile::updateOrCreate(
            ['user_id' => $klien6->id],
            [
                'nama_perusahaan'      => 'PT Sambal Tradisional Bogor',
                'skala_perusahaan'     => 'menengah',
                'jenis_kelompok_usaha' => 'Makanan dan Minuman',
                'pic_nama'             => 'Fahri Ramadhan',
                'pic_email'            => 'klien6@halal.com',
                'pic_phone'            => '081299887766',
                'latitude'             => -6.590000,
                'longitude'            => 106.795000,
                'created_at'           => $d6,
            ]
        );
        $p6 = Project::updateOrCreate(
            ['nama_merek_dagang' => 'Sambal Cumi Dower'],
            [
                'klien_id'                => $klien6->id,
                'konsultan_id'             => $siti?->id,
                'nama_paket'              => 'Paket Pendampingan Reguler',
                'jenis_pengajuan'         => JenisPengajuan::BARU,
                'jumlah_produk'           => 10,
                'jumlah_outlet'           => 1,
                'is_luar_jabodetabek'     => false,
                'status_proyek'           => ProjectStatus::DOCUMENTS_VALID,
                'total_harga_kesepakatan' => 14000000.00,
                'file_dokumen_penawaran'  => 'documents/penawaran/sample_penawaran.pdf',
                'latitude'                => -6.590000,
                'longitude'               => 106.795000,
                'created_at'              => $d6,
                'updated_at'              => Carbon::now()->subDays(3),
            ]
        );
        Payment::updateOrCreate(
            ['project_id' => $p6->id, 'termin' => 'T1_60'],
            ['invoice_number' => 'INV-T1-SAMBAL006', 'nominal_tagihan' => 8400000.00, 'status_pembayaran' => PaymentStatus::SUCCESS, 'created_at' => Carbon::now()->subDays(18)]
        );
        foreach ($reqDocsList as $docType) {
            $ext = str_contains($docType, 'daftar') ? 'sample_excel.xlsx' : 'sample_pdf.pdf';
            ProjectDocument::updateOrCreate(
                ['project_id' => $p6->id, 'jenis_dokumen' => $docType],
                ['file_path' => 'documents/requirements/' . $ext, 'status_validasi' => 'approved', 'created_at' => Carbon::now()->subDays(5)]
            );
        }

        // =========================================================================
        // PROYEK 7: PT Kosmetik Alami Indonesia
        // Status: DOCUMENTS_VALID + JADWAL AUDIT -> SIAP DIUJI EXIEN (UNGGAH LAPORAN AUDIT LHA)
        // Timeline: Dibuat 25 hari lalu, Audit dijadwalkan besok
        // =========================================================================
        $d7 = Carbon::now()->subDays(25);
        $klien7 = User::updateOrCreate(
            ['email' => 'klien7@halal.com'],
            ['name' => 'Farida Nurhaliza', 'password' => Hash::make('password'), 'role' => 'klien', 'created_at' => $d7]
        );
        CompanyProfile::updateOrCreate(
            ['user_id' => $klien7->id],
            [
                'nama_perusahaan'      => 'PT Kosmetik Alami Indonesia',
                'skala_perusahaan'     => 'besar',
                'jenis_kelompok_usaha' => 'Kosmetik dan Obat-Obatan',
                'pic_nama'             => 'Farida Nurhaliza',
                'pic_email'            => 'klien7@halal.com',
                'pic_phone'            => '081799001122',
                'latitude'             => -6.220000,
                'longitude'            => 106.820000,
                'created_at'           => $d7,
            ]
        );
        $p7 = Project::updateOrCreate(
            ['nama_merek_dagang' => 'GlowBeauty Organik'],
            [
                'klien_id'                => $klien7->id,
                'konsultan_id'             => $exien?->id,
                'nama_paket'              => 'Paket Pendampingan Industri Besar',
                'jenis_pengajuan'         => JenisPengajuan::BARU,
                'jumlah_produk'           => 35,
                'jumlah_outlet'           => 1,
                'is_luar_jabodetabek'     => false,
                'status_proyek'           => ProjectStatus::DOCUMENTS_VALID,
                'total_harga_kesepakatan' => 25000000.00,
                'file_dokumen_penawaran'  => 'documents/penawaran/sample_penawaran.pdf',
                'latitude'                => -6.220000,
                'longitude'               => 106.820000,
                'tanggal_audit'           => Carbon::now()->addDays(2)->format('Y-m-d'),
                'catatan_audit'           => 'Audit Fasilitas Laboratorium & Lini Produksi Jakarta',
                'created_at'              => $d7,
                'updated_at'              => Carbon::now()->subDays(2),
            ]
        );
        Payment::updateOrCreate(
            ['project_id' => $p7->id, 'termin' => 'T1_60'],
            ['invoice_number' => 'INV-T1-BEAUTY007', 'nominal_tagihan' => 15000000.00, 'status_pembayaran' => PaymentStatus::SUCCESS, 'created_at' => Carbon::now()->subDays(22)]
        );
        foreach ($reqDocsList as $docType) {
            $ext = str_contains($docType, 'daftar') ? 'sample_excel.xlsx' : 'sample_pdf.pdf';
            ProjectDocument::updateOrCreate(
                ['project_id' => $p7->id, 'jenis_dokumen' => $docType],
                ['file_path' => 'documents/requirements/' . $ext, 'status_validasi' => 'approved', 'created_at' => Carbon::now()->subDays(10)]
            );
        }

        // =========================================================================
        // PROYEK 8: PT Resto Sambal Nusantara
        // Status: AUDIT_COMPLETED -> SIAP DIUJI ADMIN (UNGGAH SERTIFIKAT HALAL BPJPH)
        // Timeline: Dibuat 35 hari lalu, LHA Terbit 2 hari lalu
        // =========================================================================
        $d8 = Carbon::now()->subDays(35);
        $klien8 = User::updateOrCreate(
            ['email' => 'klien8@halal.com'],
            ['name' => 'Hendrik Setiawan', 'password' => Hash::make('password'), 'role' => 'klien', 'created_at' => $d8]
        );
        CompanyProfile::updateOrCreate(
            ['user_id' => $klien8->id],
            [
                'nama_perusahaan'      => 'PT Resto Sambal Nusantara',
                'skala_perusahaan'     => 'menengah',
                'jenis_kelompok_usaha' => 'Jasa Penyediaan Makanan & Minuman',
                'pic_nama'             => 'Hendrik Setiawan',
                'pic_email'            => 'klien8@halal.com',
                'pic_phone'            => '081211223344',
                'latitude'             => -6.175110,
                'longitude'            => 106.865030,
                'created_at'           => $d8,
            ]
        );
        $p8 = Project::updateOrCreate(
            ['nama_merek_dagang' => 'Resto Sambal Nusantara'],
            [
                'klien_id'                => $klien8->id,
                'konsultan_id'             => $iqbal?->id,
                'nama_paket'              => 'Paket Pendampingan Reguler',
                'jenis_pengajuan'         => JenisPengajuan::BARU,
                'jumlah_produk'           => 40,
                'jumlah_outlet'           => 2,
                'is_luar_jabodetabek'     => false,
                'status_proyek'           => ProjectStatus::AUDIT_COMPLETED,
                'total_harga_kesepakatan' => 20000000.00,
                'file_dokumen_penawaran'  => 'documents/penawaran/sample_penawaran.pdf',
                'latitude'                => -6.175110,
                'longitude'               => 106.865030,
                'tanggal_audit'           => Carbon::now()->subDays(5)->format('Y-m-d'),
                'catatan_audit'           => 'Audit Restoran & Dapur Utama Selesai Dilaksanakan',
                'created_at'              => $d8,
                'updated_at'              => Carbon::now()->subDays(2),
            ]
        );
        Payment::updateOrCreate(
            ['project_id' => $p8->id, 'termin' => 'T1_60'],
            ['invoice_number' => 'INV-T1-RESTO008', 'nominal_tagihan' => 12000000.00, 'status_pembayaran' => PaymentStatus::SUCCESS, 'created_at' => Carbon::now()->subDays(30)]
        );
        foreach ($reqDocsList as $docType) {
            $ext = str_contains($docType, 'daftar') ? 'sample_excel.xlsx' : 'sample_pdf.pdf';
            ProjectDocument::updateOrCreate(
                ['project_id' => $p8->id, 'jenis_dokumen' => $docType],
                ['file_path' => 'documents/requirements/' . $ext, 'status_validasi' => 'approved', 'created_at' => Carbon::now()->subDays(15)]
            );
        }
        ProjectDocument::updateOrCreate(
            ['project_id' => $p8->id, 'jenis_dokumen' => 'laporan_hasil_review'],
            ['file_path' => 'documents/audit_reports/sample_pdf.pdf', 'status_validasi' => 'approved', 'created_at' => Carbon::now()->subDays(2)]
        );

        // =========================================================================
        // PROYEK 9: CV Catering Berkah Bersama
        // Status: WAITING_PAYMENT_T2 -> SIAP DIUJI KLIEN (PELUNASAN T2 VIA MIDTRANS)
        // Timeline: Dibuat 40 hari lalu, Sertifikat terbit kemarin
        // =========================================================================
        $d9 = Carbon::now()->subDays(40);
        $klien9 = User::updateOrCreate(
            ['email' => 'klien9@halal.com'],
            ['name' => 'Gilang Ramadhan', 'password' => Hash::make('password'), 'role' => 'klien', 'created_at' => $d9]
        );
        CompanyProfile::updateOrCreate(
            ['user_id' => $klien9->id],
            [
                'nama_perusahaan'      => 'CV Catering Berkah Bersama',
                'skala_perusahaan'     => 'menengah',
                'jenis_kelompok_usaha' => 'Jasa Penyediaan Makanan & Minuman',
                'pic_nama'             => 'Gilang Ramadhan',
                'pic_email'            => 'klien9@halal.com',
                'pic_phone'            => '081288776655',
                'latitude'             => -6.175110,
                'longitude'            => 106.865030,
                'created_at'           => $d9,
            ]
        );
        $p9 = Project::updateOrCreate(
            ['nama_merek_dagang' => 'Berkah Catering Services'],
            [
                'klien_id'                => $klien9->id,
                'konsultan_id'             => $iqbal?->id,
                'nama_paket'              => 'Paket Pendampingan Reguler',
                'jenis_pengajuan'         => JenisPengajuan::BARU,
                'jumlah_produk'           => 50,
                'jumlah_outlet'           => 1,
                'is_luar_jabodetabek'     => false,
                'status_proyek'           => ProjectStatus::WAITING_PAYMENT_T2,
                'total_harga_kesepakatan' => 16000000.00,
                'file_dokumen_penawaran'  => 'documents/penawaran/sample_penawaran.pdf',
                'latitude'                => -6.175110,
                'longitude'               => 106.865030,
                'tanggal_audit'           => Carbon::now()->subDays(10)->format('Y-m-d'),
                'created_at'              => $d9,
                'updated_at'              => Carbon::now()->subDay(),
            ]
        );
        Payment::updateOrCreate(
            ['project_id' => $p9->id, 'termin' => 'T1_60'],
            ['invoice_number' => 'INV-T1-CATERING009', 'nominal_tagihan' => 9600000.00, 'status_pembayaran' => PaymentStatus::SUCCESS, 'created_at' => Carbon::now()->subDays(35)]
        );
        Payment::updateOrCreate(
            ['project_id' => $p9->id, 'termin' => 'T2_40'],
            ['invoice_number' => 'INV-T2-CATERING009', 'nominal_tagihan' => 6400000.00, 'status_pembayaran' => PaymentStatus::PENDING, 'created_at' => Carbon::now()->subDay()]
        );
        foreach ($reqDocsList as $docType) {
            $ext = str_contains($docType, 'daftar') ? 'sample_excel.xlsx' : 'sample_pdf.pdf';
            ProjectDocument::updateOrCreate(
                ['project_id' => $p9->id, 'jenis_dokumen' => $docType],
                ['file_path' => 'documents/requirements/' . $ext, 'status_validasi' => 'approved', 'created_at' => Carbon::now()->subDays(20)]
            );
        }
        ProjectDocument::updateOrCreate(
            ['project_id' => $p9->id, 'jenis_dokumen' => 'laporan_hasil_review'],
            ['file_path' => 'documents/audit_reports/sample_pdf.pdf', 'status_validasi' => 'approved', 'created_at' => Carbon::now()->subDays(5)]
        );
        ProjectDocument::updateOrCreate(
            ['project_id' => $p9->id, 'jenis_dokumen' => 'sertifikat_halal'],
            ['file_path' => 'documents/certificates/sample_pdf.pdf', 'status_validasi' => 'approved', 'created_at' => Carbon::now()->subDay()]
        );

        // =========================================================================
        // PROYEK 10: PT Beverages Segar Sejahtera
        // Status: COMPLETED -> SIAP DIUJI KLIEN (PREVIEW & UNDUH SERTIFIKAT HALAL)
        // Timeline: Dibuat 60 hari lalu, Selesai 5 hari lalu
        // =========================================================================
        $d10 = Carbon::now()->subDays(60);
        $klien10 = User::updateOrCreate(
            ['email' => 'klien10@halal.com'],
            ['name' => 'Hani Rahmawati', 'password' => Hash::make('password'), 'role' => 'klien', 'created_at' => $d10]
        );
        CompanyProfile::updateOrCreate(
            ['user_id' => $klien10->id],
            [
                'nama_perusahaan'      => 'PT Beverages Segar Sejahtera',
                'skala_perusahaan'     => 'menengah',
                'jenis_kelompok_usaha' => 'Makanan dan Minuman',
                'pic_nama'             => 'Hani Rahmawati',
                'pic_email'            => 'klien10@halal.com',
                'pic_phone'            => '081377889900',
                'latitude'             => -6.914744,
                'longitude'            => 107.609810,
                'created_at'           => $d10,
            ]
        );
        $p10 = Project::updateOrCreate(
            ['nama_merek_dagang' => 'Sari Buah Alami Fresh'],
            [
                'klien_id'                => $klien10->id,
                'konsultan_id'             => $prima?->id,
                'nama_paket'              => 'Paket Pendampingan Reguler',
                'jenis_pengajuan'         => JenisPengajuan::BARU,
                'jumlah_produk'           => 10,
                'jumlah_outlet'           => 2,
                'is_luar_jabodetabek'     => false,
                'status_proyek'           => ProjectStatus::COMPLETED,
                'total_harga_kesepakatan' => 14000000.00,
                'file_dokumen_penawaran'  => 'documents/penawaran/sample_penawaran.pdf',
                'latitude'                => -6.914744,
                'longitude'               => 107.609810,
                'tanggal_audit'           => Carbon::now()->subDays(20)->format('Y-m-d'),
                'created_at'              => $d10,
                'updated_at'              => Carbon::now()->subDays(5),
            ]
        );
        Payment::updateOrCreate(
            ['project_id' => $p10->id, 'termin' => 'T1_60'],
            ['invoice_number' => 'INV-T1-BEVERAGE010', 'nominal_tagihan' => 8400000.00, 'status_pembayaran' => PaymentStatus::SUCCESS, 'created_at' => Carbon::now()->subDays(55)]
        );
        Payment::updateOrCreate(
            ['project_id' => $p10->id, 'termin' => 'T2_40'],
            ['invoice_number' => 'INV-T2-BEVERAGE010', 'nominal_tagihan' => 5600000.00, 'status_pembayaran' => PaymentStatus::SUCCESS, 'created_at' => Carbon::now()->subDays(5)]
        );
        foreach ($reqDocsList as $docType) {
            $ext = str_contains($docType, 'daftar') ? 'sample_excel.xlsx' : 'sample_pdf.pdf';
            ProjectDocument::updateOrCreate(
                ['project_id' => $p10->id, 'jenis_dokumen' => $docType],
                ['file_path' => 'documents/requirements/' . $ext, 'status_validasi' => 'approved', 'created_at' => Carbon::now()->subDays(30)]
            );
        }
        ProjectDocument::updateOrCreate(
            ['project_id' => $p10->id, 'jenis_dokumen' => 'laporan_hasil_review'],
            ['file_path' => 'documents/audit_reports/sample_pdf.pdf', 'status_validasi' => 'approved', 'created_at' => Carbon::now()->subDays(10)]
        );
        ProjectDocument::updateOrCreate(
            ['project_id' => $p10->id, 'jenis_dokumen' => 'sertifikat_halal'],
            ['file_path' => 'documents/certificates/sample_pdf.pdf', 'status_validasi' => 'approved', 'created_at' => Carbon::now()->subDays(5)]
        );

        // =========================================================================
        // EDGE CASE 2: KLIEN KLIEN10 MEMILIKI PROYEK KEDUA SANGAT LAMA (Uji Multi-Sertifikat)
        // =========================================================================
        $d10_old = Carbon::now()->subDays(120);
        $p10_old = Project::updateOrCreate(
            ['nama_merek_dagang' => 'Air Mineral Segar Nusantara'],
            [
                'klien_id'                => $klien10->id,
                'konsultan_id'             => $prima?->id,
                'nama_paket'              => 'Paket Perpanjangan Sertifikat',
                'jenis_pengajuan'         => JenisPengajuan::PERPANJANGAN,
                'jumlah_produk'           => 3,
                'jumlah_outlet'           => 1,
                'is_luar_jabodetabek'     => false,
                'status_proyek'           => ProjectStatus::COMPLETED,
                'total_harga_kesepakatan' => 6000000.00,
                'file_dokumen_penawaran'  => 'documents/penawaran/sample_penawaran.pdf',
                'latitude'                => -6.914744,
                'longitude'               => 107.609810,
                'tanggal_audit'           => Carbon::now()->subDays(90)->format('Y-m-d'),
                'created_at'              => $d10_old,
                'updated_at'              => Carbon::now()->subDays(80),
            ]
        );
        Payment::updateOrCreate(
            ['project_id' => $p10_old->id, 'termin' => 'T1_60'],
            ['invoice_number' => 'INV-T1-AIR010', 'nominal_tagihan' => 3600000.00, 'status_pembayaran' => PaymentStatus::SUCCESS, 'created_at' => Carbon::now()->subDays(110)]
        );
        Payment::updateOrCreate(
            ['project_id' => $p10_old->id, 'termin' => 'T2_40'],
            ['invoice_number' => 'INV-T2-AIR010', 'nominal_tagihan' => 2400000.00, 'status_pembayaran' => PaymentStatus::SUCCESS, 'created_at' => Carbon::now()->subDays(80)]
        );
        ProjectDocument::updateOrCreate(
            ['project_id' => $p10_old->id, 'jenis_dokumen' => 'sertifikat_halal'],
            ['file_path' => 'documents/certificates/sample_pdf.pdf', 'status_validasi' => 'approved', 'created_at' => Carbon::now()->subDays(80)]
        );
    }

    /**
     * PRIVATE HELPER: Menulis Berkas Dummy Fisik di Disk Public & Local Storage
     */
    private function generateDummyFiles(): void
    {
        $dummyPdfContent   = "%PDF-1.4 %DUMMY HALAL CERTIFICATE & REPORT DOCUMENT CONTENT FOR SYSTEM TESTING";
        $dummyExcelContent = "Nama Produk,Merk,Varian\nProduk Contoh 1,Merk A,Varian Original\nProduk Contoh 2,Merk B,Varian Pedas";

        // Folder Penawaran
        Storage::disk('public')->put('documents/penawaran/sample_penawaran.pdf', $dummyPdfContent);

        // Folder Requirements (Public & Private)
        Storage::disk('public')->put('documents/requirements/sample_pdf.pdf', $dummyPdfContent);
        Storage::disk('public')->put('documents/requirements/sample_excel.xlsx', $dummyExcelContent);
        Storage::put('documents/requirements/sample_pdf.pdf', $dummyPdfContent);
        Storage::put('documents/requirements/sample_excel.xlsx', $dummyExcelContent);

        // Folder Audit Reports
        Storage::disk('public')->put('documents/audit_reports/sample_pdf.pdf', $dummyPdfContent);
        Storage::put('documents/audit_reports/sample_pdf.pdf', $dummyPdfContent);

        // Folder Certificates
        Storage::disk('public')->put('documents/certificates/sample_pdf.pdf', $dummyPdfContent);
        Storage::put('documents/certificates/sample_pdf.pdf', $dummyPdfContent);
    }
}

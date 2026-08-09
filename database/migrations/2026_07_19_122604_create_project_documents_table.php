<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

            // Klasifikasi jenis dokumen sesuai alur cetak biru
            $table->enum('jenis_dokumen', [
                'daftar_produk',
                'daftar_bahan',
                'daftar_fasilitas',
                'sk_penyelia_halal',
                'manual_sjph',
                'laporan_hasil_review', // Unggahan Konsultan
                'sertifikat_halal'       // Unggahan Admin
            ]);

            $table->string('file_path'); // Lokasi folder berkas di server

            // Status Validasi Khusus untuk peninjauan Konsultan
            $table->enum('status_validasi', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_revisi_konsultan')->nullable(); // Alasan jika dokumen di-reject

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_documents');
    }
};

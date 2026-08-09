<?php

use App\Enums\ProjectStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Mengikat ke user Klien yang mengajukan
            $table->foreignId('klien_id')->constrained('users')->onDelete('restrict');

            // Relasi ke Jenis Layanan (Service Type)
            $table->foreignId('service_type_id')->nullable()->constrained('service_types')->onDelete('set null');

            // Mengikat ke Konsultan yang ditunjuk via SPK (Tabel 'consultants')
            $table->foreignId('konsultan_id')->nullable()->constrained('consultants')->onDelete('set null');

            // Parameter Pengajuan Jasa Pendampingan
            $table->string('nama_paket');
            $table->string('jenis_pengajuan')->default(\App\Enums\JenisPengajuan::BARU->value);
            $table->integer('jumlah_produk');
            $table->integer('jumlah_outlet');
            $table->string('nama_merek_dagang');
            $table->boolean('is_luar_jabodetabek')->default(false);

            // State Kontrol Utama Alur Sertifikasi Halal
            $table->string('status_proyek')->default(ProjectStatus::PROFIL_COMPLETED->value);

            // Field Audit & Catatan Pendampingan
            $table->date('tanggal_audit')->nullable();
            $table->text('catatan_audit')->nullable();

            // Data Finansial (Diisi oleh Keuangan pasca-negosiasi)
            $table->decimal('total_harga_kesepakatan', 12, 2)->nullable();
            $table->string('file_dokumen_penawaran')->nullable();

            // Koordinat Spasial Proyek/Pabrik
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

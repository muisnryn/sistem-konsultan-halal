<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();

            // Relasi One-to-One dengan tabel users (Khusus Akun Klien)
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');

            // Parameter Detail Perusahaan
            $table->string('nama_perusahaan');
            $table->text('alamat_perusahaan')->nullable();
            $table->string('nama_fasilitas_produksi')->nullable();
            $table->text('alamat_fasilitas_produksi')->nullable();
            $table->string('kota_pabrik')->nullable();
            $table->string('pimpinan_perusahaan')->nullable();
            $table->string('file_nib')->nullable(); // Path/nama file PDF NIB
            $table->string('file_npwp')->nullable(); // Path/nama file PDF NPWP
            $table->string('skala_perusahaan')->nullable(); // e.g. kecil, menengah, besar

            // Kontak PIC
            $table->string('pic_nama')->nullable();
            $table->string('pic_jabatan')->nullable();
            $table->string('pic_phone')->nullable();
            $table->string('pic_email')->nullable();

            // Detail Tambahan Operasional Pabrik
            $table->integer('jumlah_karyawan')->nullable();
            $table->string('jenis_kelompok_usaha')->nullable(); // Dibuat string fleksibel agar tidak crash jika kategori bertambah
            $table->string('jenis_kelompok_usaha_lainnya')->nullable();
            $table->string('status_pabrik')->nullable();
            $table->string('kapasitas_produksi')->nullable();

            // Kolom Koordinat Lokasi untuk Kalkulasi Spasial Haversine SPK
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};

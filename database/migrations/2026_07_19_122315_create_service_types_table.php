<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan'); // Contoh: Sertifikasi Jalur Reguler, Self Declare, dll.
            $table->string('kode_layanan')->unique();
            $table->bigInteger('biaya');

            // Tambahan addon harga menu & outlet
            $table->decimal('biaya_tambahan_menu', 12, 2)->default(500000);
            $table->decimal('biaya_tambahan_outlet', 12, 2)->default(1000000);

            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_types');
    }
};

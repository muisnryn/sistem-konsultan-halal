<?php

use App\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Relasi ke proyek terkait
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');

            $table->string('invoice_number')->unique();
            $table->enum('termin', ['T1_60', 'T2_40']); // Pembagian 60% dan 40%
            $table->decimal('nominal_tagihan', 12, 2);

            // Menggunakan default dari Enum PaymentStatus yang sudah kita buat
            $table->string('status_pembayaran')->default(PaymentStatus::PENDING->value);

            // Kolom khusus untuk menyimpan token Midtrans Snap API
            $table->string('snap_token')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama_kriteria');
            $table->decimal('bobot', 5, 2);
            $table->enum('tren', ['max', 'min']);
            $table->string('tipe_preferensi')->default('usual');
            $table->decimal('param_p', 8, 2)->nullable();
            $table->decimal('param_q', 8, 2)->nullable();
            $table->decimal('param_s', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criterias');
    }
};

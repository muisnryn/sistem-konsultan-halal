<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_konsultan');
            $table->string('sertifikasi_no')->unique();
            $table->string('no_hp')->nullable();
            $table->string('domisili');
            $table->string('spesialisasi_industri');

            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultants');
    }
};

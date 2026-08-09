<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consultant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_konsultan',
        'sertifikasi_no',
        'no_hp',
        'domisili',
        'spesialisasi_industri',
        'latitude',
        'longitude',
        'is_active',
    ];

    /**
     * Relasi ke Akun User Login Konsultan
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel consultant_evaluations (Matriks Nilai Kriteria)
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(ConsultantEvaluation::class, 'consultant_id');
    }

    /**
     * Relasi ke Proyek Klien yang Ditangani
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'konsultan_id');
    }

    /**
     * Helper: Generate URL WhatsApp Otomatis ke Konsultan
     */
    public function generateWhatsAppUrl(string $namaMerek = ''): string
    {
        if (empty($this->no_hp)) {
            return '#';
        }

        // Sanitasi nomor HP ke format internasional (62)
        $phone = preg_replace('/[^0-9]/', '', $this->no_hp);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $text = "Halo " . $this->nama_konsultan . ", saya Klien pendampingan sertifikasi Halal" . ($namaMerek ? " untuk merek: *" . $namaMerek . "*" : "") . ". Mohon arahan terkait proses pendampingannya.";

        return "https://wa.me/" . $phone . "?text=" . urlencode($text);
    }
}

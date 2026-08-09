<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'jenis_dokumen',
        'file_path',
        'status_validasi',
        'catatan_revisi_konsultan',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Accessor Label Nama Dokumen yang Ramah Pengguna
     */
    public function getNamaDokumenFormattedAttribute(): string
    {
        return match ($this->jenis_dokumen) {
            'daftar_produk'     => 'Daftar Produk & Varian',
            'daftar_bahan'      => 'Daftar Bahan & Spesifikasi',
            'daftar_fasilitas'  => 'Daftar Fasilitas Produksi',
            'sk_penyelia_halal' => 'SK Penyelia Halal',
            'manual_sjph'       => 'Manual SJPH',
            default             => 'Dokumen Persyaratan',
        };
    }
}

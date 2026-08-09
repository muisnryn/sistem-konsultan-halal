<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'klien_id',
        'service_type_id',
        'konsultan_id',
        'nama_paket',
        'jenis_pengajuan',
        'jumlah_produk',
        'jumlah_outlet',
        'nama_merek_dagang',
        'is_luar_jabodetabek',
        'status_proyek',
        'total_harga_kesepakatan',
        'file_dokumen_penawaran',
        'latitude',
        'longitude',
        'tanggal_audit',
        'catatan_audit',
    ];

    protected function casts(): array
    {
        return [
            'is_luar_jabodetabek' => 'boolean',
            'status_proyek' => ProjectStatus::class,
            'jenis_pengajuan' => \App\Enums\JenisPengajuan::class,
            'total_harga_kesepakatan' => 'decimal:2',
            'tanggal_audit' => 'date',
        ];
    }

    protected function kodeRegistrasi(): Attribute
    {
        return Attribute::make(
            get: function () {
                return 'KHI-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
            }
        );
    }

    public function klien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'klien_id');
    }

    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    public function konsultan(): BelongsTo
    {
        return $this->belongsTo(Consultant::class, 'konsultan_id');
    }

    public function consultant(): BelongsTo
    {
        return $this->belongsTo(Consultant::class, 'konsultan_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProjectDocument::class);
    }
}

<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'project_id',
        'invoice_number',
        'termin',
        'nominal_tagihan',
        'status_pembayaran',
        'snap_token',
    ];

    protected function casts(): array
    {
        return [
            'status_pembayaran' => PaymentStatus::class, // Mengunci status lewat Enum
            'nominal_tagihan' => 'decimal:2',
        ];
    }

    /**
     * Relasi balikan: Data pembayaran ini merujuk pada proyek yang mana.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}

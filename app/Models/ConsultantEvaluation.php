<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultantEvaluation extends Model
{
    protected $fillable = [
        'consultant_id',
        'criteria_id',
        'nilai',
    ];

    /**
     * Relasi balik ke model Consultant
     */
    public function consultant(): BelongsTo
    {
        return $this->belongsTo(Consultant::class, 'consultant_id');
    }

    /**
     * Relasi ke model Criteria
     */
    public function criteria(): BelongsTo
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }
}

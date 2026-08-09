<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $fillable = [
        'kode',
        'nama_kriteria',
        'bobot',
        'tren',
        'tipe_preferensi',
        'param_p',
        'param_q',
        'param_s',
    ];

    public function evaluations()
    {
        return $this->hasMany(ConsultantEvaluation::class);
    }
}

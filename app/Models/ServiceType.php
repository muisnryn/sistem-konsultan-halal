<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceType extends Model
{
    protected $fillable = [
        'nama_layanan',
        'kode_layanan',
        'biaya',
        'biaya_tambahan_menu',
        'biaya_tambahan_outlet',
        'deskripsi'
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'service_type_id');
    }
}

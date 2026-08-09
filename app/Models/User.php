<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function companyProfile(): HasOne
    {
        return $this->hasOne(CompanyProfile::class);
    }

    /**
     * Relasi One-to-One: Akun login milik seorang Konsultan.
     */
    public function consultant(): HasOne
    {
        return $this->hasOne(Consultant::class);
    }

    /**
     * Relasi One-to-Many: Seorang Klien bisa memiliki banyak riwayat pengajuan proyek.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'klien_id');
    }
}

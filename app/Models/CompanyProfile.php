<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'alamat_perusahaan',
        'nama_fasilitas_produksi',
        'alamat_fasilitas_produksi',
        'kota_pabrik',
        'pimpinan_perusahaan',
        'file_nib',
        'file_npwp',
        'skala_perusahaan',
        'pic_nama',
        'pic_jabatan',
        'pic_phone',
        'pic_email',
        'jumlah_karyawan',
        'jenis_kelompok_usaha',
        'jenis_kelompok_usaha_lainnya',
        'status_pabrik',
        'kapasitas_produksi',
        'latitude',
        'longitude',
    ];

    /**
     * Accessor Dinamis: Mengecek apakah profil perusahaan sudah lengkap.
     */
    public function getIsCompletedAttribute(): bool
    {
        return !empty($this->nama_perusahaan)
            && !empty($this->file_nib)
            && !empty($this->file_npwp)
            && !empty($this->pic_phone);
    }

    /**
     * Helper WA: Tautan otomatis WhatsApp untuk Negosiasi Keuangan
     */
    public function generateWhatsAppUrl(string $namaMerekDagang): string
    {
        if (empty($this->pic_phone)) return '#';

        $phoneClean = preg_replace('/[^0-9]/', '', $this->pic_phone);
        if (str_starts_with($phoneClean, '0')) {
            $phoneClean = '62' . substr($phoneClean, 1);
        }

        $pesan = "Halo *{$this->pic_nama}*,\n\n";
        $pesan .= "Saya staf dari Bagian Keuangan *PT Konsultan Halal Indonesia*.\n\n";
        $pesan .= "Terkait pengajuan sertifikasi halal perusahaan Anda (*{$this->nama_perusahaan}*) untuk merek dagang *{$namaMerekDagang}*, berikut kami ingin mengirimkan dokumen penawaran awal untuk ditinjau dan didiskusikan lebih lanjut mengenai kesepakatan harga kontrak pendampingan.\n\n";
        $pesan .= "Mohon informasinya jika Anda sudah luang untuk berdiskusi. Terima kasih banyak.";

        return "https://wa.me/{$phoneClean}?text=" . urlencode($pesan);
    }

    /**
     * Helper WA: Tautan otomatis WhatsApp dari Konsultan ke PIC Klien
     */
    public function generateConsultantWhatsAppUrl(string $namaMerekDagang, string $namaKonsultan = ''): string
    {
        if (empty($this->pic_phone)) return '#';

        $phoneClean = preg_replace('/[^0-9]/', '', $this->pic_phone);
        if (str_starts_with($phoneClean, '0')) {
            $phoneClean = '62' . substr($phoneClean, 1);
        }

        $pesan = "Halo Bpk/Ibu *{$this->pic_nama}* dari *{$this->nama_perusahaan}*,\n\n";
        $pesan .= "Saya *{$namaKonsultan}*, Konsultan Pendamping Sertifikasi Halal Anda untuk merek dagang *{$namaMerekDagang}*.\n\n";
        $pesan .= "Saya ingin mengonfirmasi jadwal pendampingan dan pemeriksaan dokumen persyaratan sertifikasi halal Anda. Terima kasih.";

        return "https://wa.me/{$phoneClean}?text=" . urlencode($pesan);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

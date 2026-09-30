<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CompanyProfileController extends Controller
{
    public function edit()
    {
        $profile = auth()->user()->companyProfile;
        return view('client.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $currentProfile = $user->companyProfile;

        $validated = $request->validate([
            'nama_perusahaan'           => 'required|string|max:255',
            'alamat_perusahaan'         => 'required|string',
            'nama_fasilitas_produksi'   => 'required|string|max:255',
            'alamat_fasilitas_produksi' => 'required|string',
            'kota_pabrik'               => 'required|string|max:255',
            'pimpinan_perusahaan'       => 'required|string|max:255',

            'latitude'                  => 'required|numeric|between:-90,90',
            'longitude'                 => 'required|numeric|between:-180,180',

            'file_nib'                  => ($currentProfile && $currentProfile->file_nib) ? 'nullable|file|mimes:pdf|max:2048' : 'required|file|mimes:pdf|max:2048',
            'file_npwp'                 => ($currentProfile && $currentProfile->file_npwp) ? 'nullable|file|mimes:pdf|max:2048' : 'required|file|mimes:pdf|max:2048',

            'skala_perusahaan'          => ['required', Rule::in(['kecil', 'menengah', 'besar'])],

            'pic_nama'                  => 'required|string|max:255',
            'pic_jabatan'               => 'required|string|max:255',
            'pic_phone'                 => 'required|string|max:20',
            'pic_email'                 => 'required|email|max:255',

            'jumlah_karyawan'           => 'required|integer|min:1',
            'jenis_kelompok_usaha'      => [
                'required',
                'string',
                Rule::in([
                    'Makanan dan Minuman',
                    'Jasa Penyediaan Makanan & Minuman',
                    'Kosmetik dan Obat-Obatan',
                    'RPH / RPA',
                    'Logistik & Distribusi',
                    'Retail',
                    'Barang Gunaan dan Kimia',
                    'Lainnya',
                ]),
            ],
            'jenis_kelompok_usaha_lainnya' => 'required_if:jenis_kelompok_usaha,Lainnya|nullable|string|max:255',
            'status_pabrik'             => ['required', Rule::in(['milik sendiri', 'maklon', 'sewa/kontrak', 'lainnya'])],
            'kapasitas_produksi'        => 'required|string|max:255',
        ], [
            'latitude.required'  => 'Titik lokasi pada peta wajib ditentukan.',
            'longitude.required' => 'Titik lokasi pada peta wajib ditentukan.',
        ]);

        if ($request->hasFile('file_nib')) {
            if ($currentProfile && $currentProfile->file_nib) {
                Storage::disk('public')->delete($currentProfile->file_nib);
            }
            $validated['file_nib'] = $request->file('file_nib')->store('documents/nib', 'public');
        }

        if ($request->hasFile('file_npwp')) {
            if ($currentProfile && $currentProfile->file_npwp) {
                Storage::disk('public')->delete($currentProfile->file_npwp);
            }
            $validated['file_npwp'] = $request->file('file_npwp')->store('documents/npwp', 'public');
        }

        $user->companyProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('client.profile.edit')
            ->with('success', 'Profil perusahaan berhasil diperbarui dan disimpan.');
    }
}

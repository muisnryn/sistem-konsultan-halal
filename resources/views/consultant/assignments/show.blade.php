<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        @php
            $profile = $project->klien->companyProfile ?? null;
            $waUrl = $profile ? $profile->generateConsultantWhatsAppUrl($project->nama_merek_dagang, $consultant->nama_konsultan ?? 'Konsultan Pendamping') : '#';
            $isCompleted = ($project->status_proyek === \App\Enums\ProjectStatus::COMPLETED);
            $namaPerusahaan = $profile->nama_perusahaan ?? $project->nama_merek_dagang;
            $initials = strtoupper(substr($namaPerusahaan, 0, 2));
        @endphp

        <!-- BACK BUTTON & ACTION HEADER BAR -->
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('consultant.assignments.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-700 transition bg-white border border-gray-200 rounded-full shadow-xs hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Daftar Penugasan</span>
            </a>

            @if($waUrl !== '#')
                <a href="{{ $waUrl }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-5 py-2 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-semibold transition shadow-sm">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>Hubungi via WhatsApp</span>
                </a>
            @endif
        </div>

        <!-- HERO CARD PROFIL KLIEN (Rounded 24px Admin Style) -->
        <div class="bg-white rounded-[24px] p-6 sm:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div class="flex items-center gap-4">
                    <div class="h-14 w-14 bg-[#e8f3ec] text-[#195A36] font-bold rounded-full flex items-center justify-center text-lg tracking-wider uppercase shrink-0">
                        {{ $initials }}
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                            {{ $namaPerusahaan }}
                        </h1>
                        <p class="flex flex-wrap items-center gap-2 mt-1 text-xs text-gray-500">
                            <span>ID Registrasi: <strong class="font-mono font-semibold text-gray-700 bg-gray-100 px-2 py-0.5 rounded-md">{{ $project->kode_registrasi }}</strong></span>
                            <span class="text-gray-300">•</span>
                            <span>Merek Dagang: <strong class="font-semibold text-gray-900">{{ $project->nama_merek_dagang }}</strong></span>
                        </p>
                    </div>
                </div>

                <div class="shrink-0">
                    @if($isCompleted)
                        <span class="px-4 py-1.5 text-xs font-medium bg-green-50 text-[#195A36] rounded-full inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                            Selesai / Lunas
                        </span>
                    @else
                        <span class="px-4 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 rounded-full inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                            {{ str_replace('_', ' ', $project->status_proyek->value ?? $project->status_proyek) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- GRID DETAIL INFORMASI LENGKAP -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

            <!-- KARTU 1: PROFIL PERUSAHAAN & LEGALITAS -->
            <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 space-y-4">
                <h3 class="flex items-center gap-2 pb-3 text-xs font-bold tracking-wider text-gray-900 uppercase border-b border-gray-100">
                    <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5s.75 0 .75.75v1.5c0 .75-.75.75-.75.75H9s-.75 0-.75-.75v-1.5c0-.75.75-.75.75-.75zm6 0h1.5s.75 0 .75.75v1.5c0 .75-.75.75-.75.75H15s-.75 0-.75-.75v-1.5c0-.75.75-.75.75-.75z" /></svg>
                    <span>Profil Perusahaan & Legalitas</span>
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Nama Resmi Perusahaan</span>
                        <strong class="font-semibold text-gray-900">{{ $profile->nama_perusahaan ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Pimpinan Perusahaan</span>
                        <strong class="font-semibold text-gray-900">{{ $profile->pimpinan_perusahaan ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Skala Perusahaan</span>
                        <strong class="font-semibold text-gray-900 capitalize">{{ $profile->skala_perusahaan ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Jenis Kelompok Usaha</span>
                        <strong class="font-semibold text-gray-900">{{ $profile->jenis_kelompok_usaha ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">File Dokumen NIB</span>
                        <span>
                            @if(!empty($profile->file_nib))
                                <span class="text-[#195A36] font-semibold inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg> Terunggah
                                </span>
                            @else
                                <span class="text-gray-400">Belum diunggah</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">File Dokumen NPWP</span>
                        <span>
                            @if(!empty($profile->file_npwp))
                                <span class="text-[#195A36] font-semibold inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg> Terunggah
                                </span>
                            @else
                                <span class="text-gray-400">Belum diunggah</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- KARTU 2: PENANGGUNG JAWAB (PIC) & KONTAK -->
            <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 space-y-4">
                <h3 class="flex items-center gap-2 pb-3 text-xs font-bold tracking-wider text-gray-900 uppercase border-b border-gray-100">
                    <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" /></svg>
                    <span>Penanggung Jawab (PIC) & Kontak</span>
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Nama PIC</span>
                        <strong class="font-semibold text-gray-900">{{ $profile->pic_nama ?? $project->klien->name ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Jabatan PIC</span>
                        <strong class="font-semibold text-gray-900">{{ $profile->pic_jabatan ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">No. Telepon / HP</span>
                        <strong class="font-semibold text-gray-900">{{ $profile->pic_phone ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Email PIC</span>
                        <strong class="font-semibold text-gray-900">{{ $profile->pic_email ?? $project->klien->email ?? '-' }}</strong>
                    </div>
                </div>
            </div>

            <!-- KARTU 3: FASILITAS PRODUKSI & OPERASIONAL -->
            <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 space-y-4">
                <h3 class="flex items-center gap-2 pb-3 text-xs font-bold tracking-wider text-gray-900 uppercase border-b border-gray-100">
                    <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.25a.75.75 0 01-.75-.75V8.25a.75.75 0 01.225-.53l7.5-7.5a.75.75 0 011.05 0l7.5 7.5a.75.75 0 01.225.53V20.25a.75.75 0 01-.75.75H13.5z" /></svg>
                    <span>Fasilitas & Kapasitas Produksi</span>
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Nama Fasilitas Produksi</span>
                        <strong class="font-semibold text-gray-900">{{ $profile->nama_fasilitas_produksi ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Kota Pabrik / Fasilitas</span>
                        <strong class="font-semibold text-gray-900">{{ $profile->kota_pabrik ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Status Pabrik</span>
                        <strong class="font-semibold text-gray-900 capitalize">{{ $profile->status_pabrik ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Kapasitas Produksi</span>
                        <strong class="font-semibold text-gray-900">{{ $profile->kapasitas_produksi ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Jumlah Karyawan</span>
                        <strong class="font-semibold text-gray-900">{{ $profile->jumlah_karyawan ?? '-' }} Orang</strong>
                    </div>
                    <div class="py-2 border-b border-gray-50">
                        <span class="block mb-1 text-gray-500">Alamat Perusahaan</span>
                        <p class="font-semibold leading-relaxed text-gray-900">{{ $profile->alamat_perusahaan ?? '-' }}</p>
                    </div>
                    <div class="py-2">
                        <span class="block mb-1 text-gray-500">Alamat Fasilitas Produksi</span>
                        <p class="font-semibold leading-relaxed text-gray-900">{{ $profile->alamat_fasilitas_produksi ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- KARTU 4: INFORMASI PENGAJUAN SERTIFIKASI HALAL -->
            <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 space-y-4">
                <h3 class="flex items-center gap-2 pb-3 text-xs font-bold tracking-wider text-gray-900 uppercase border-b border-gray-100">
                    <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>Informasi Pengajuan Halal</span>
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Nama Paket Layanan</span>
                        <strong class="font-semibold text-gray-900">{{ $project->nama_paket ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Merek Dagang</span>
                        <strong class="font-semibold text-gray-900">{{ $project->nama_merek_dagang }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Jenis Pengajuan</span>
                        <strong class="font-semibold text-gray-900">{{ is_object($project->jenis_pengajuan) ? $project->jenis_pengajuan->value : ucfirst($project->jenis_pengajuan) }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Jumlah Produk</span>
                        <strong class="font-semibold text-gray-900">{{ $project->jumlah_produk }} Produk</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Jumlah Outlet</span>
                        <strong class="font-semibold text-gray-900">{{ $project->jumlah_outlet }} Outlet</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Lokasi Luar Jabodetabek</span>
                        <strong class="font-semibold text-gray-900">{{ $project->is_luar_jabodetabek ? 'Ya' : 'Tidak' }}</strong>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500">Tanggal Audit Lapangan</span>
                        <strong class="{{ $project->tanggal_audit ? 'text-[#195A36]' : 'text-gray-400 italic' }} font-semibold">
                            {{ $project->tanggal_audit ? \Carbon\Carbon::parse($project->tanggal_audit)->translatedFormat('d F Y') : 'Belum ditetapkan' }}
                        </strong>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
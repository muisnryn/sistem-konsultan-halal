<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER BAR (Sesuai Gaya Header Dashboard Admin) -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-semibold mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                    Pendampingan Klien
                </div>
                <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Daftar Penugasan</h1>
                <p class="mt-2 text-sm font-medium text-gray-500">Kelola dan tinjau seluruh proyek pelaku usaha yang ditugaskan kepada Anda.</p>
            </div>
            <div class="px-4 py-2 bg-white border border-gray-100 rounded-full shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] text-xs font-medium text-gray-600 self-start sm:self-auto">
                Total Klien: <strong class="font-bold text-gray-900">{{ number_format($assignments->count()) }} Perusahaan</strong>
            </div>
        </div>

        <!-- LIST KLIEN BINAAN CARDS -->
        <div class="space-y-6">
            @forelse($assignments as $project)
                @php
                    $profile = $project->klien->companyProfile ?? null;
                    $waUrl = $profile ? $profile->generateConsultantWhatsAppUrl($project->nama_merek_dagang, $consultant->nama_konsultan ?? 'Konsultan Pendamping') : '#';
                    $isCompleted = ($project->status_proyek === \App\Enums\ProjectStatus::COMPLETED);
                    $namaPerusahaan = $profile->nama_perusahaan ?? $project->nama_merek_dagang;
                    $initials = strtoupper(substr($namaPerusahaan, 0, 2));
                @endphp

                <!-- Card Klien (Gaya Admin: Rounded 24px, Hover Subtle Translate, Soft Shadow) -->
                <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 space-y-5 transition-transform hover:-translate-y-1 duration-300">

                    <!-- TOP BAR: INISIAL, NAMA USAHA & STATUS BADGE -->
                    <div class="flex flex-col gap-4 pb-4 border-b border-gray-100 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3.5">
                            <div class="h-12 w-12 bg-[#e8f3ec] text-[#195A36] font-bold rounded-full flex items-center justify-center text-sm tracking-wider uppercase shrink-0">
                                {{ $initials }}
                            </div>
                            <div>
                                <h3 class="text-base font-bold leading-snug text-gray-900">
                                    {{ $namaPerusahaan }}
                                </h3>
                                <div class="text-xs text-gray-500 mt-0.5 flex flex-wrap items-center gap-2">
                                    <span>Merek: <strong class="font-semibold text-gray-800">{{ $project->nama_merek_dagang }}</strong></span>
                                    <span class="text-gray-300">•</span>
                                    <span>Skala: <strong class="font-semibold text-gray-700">{{ $profile->skala_perusahaan ?? 'Mikro/Kecil' }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <div class="shrink-0">
                            @if($isCompleted)
                                <span class="px-3.5 py-1 text-xs font-medium bg-green-50 text-[#195A36] rounded-full inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                                    Selesai / Lunas
                                </span>
                            @else
                                <span class="px-3.5 py-1 text-xs font-medium text-blue-700 bg-blue-50 rounded-full inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                    {{ str_replace('_', ' ', $project->status_proyek->value ?? $project->status_proyek) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- RINGKASAN INFORMASI KLIEN -->
                    <div class="grid grid-cols-1 gap-4 text-xs md:grid-cols-3">
                        <div class="space-y-1 bg-gray-50/60 p-3.5 rounded-2xl border border-gray-100/80">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Penanggung Jawab (PIC)</span>
                            <strong class="block text-xs font-semibold text-gray-900">{{ $profile->pic_nama ?? $project->klien->name ?? '-' }}</strong>
                            <span class="block text-gray-500">{{ $profile->pic_phone ?? '-' }}</span>
                        </div>

                        <div class="space-y-1 bg-gray-50/60 p-3.5 rounded-2xl border border-gray-100/80">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Fasilitas & Operasional</span>
                            <strong class="block text-xs font-semibold text-gray-900">
                                {{ $project->jumlah_outlet ?? '1' }} Outlet | {{ $profile->jumlah_karyawan ?? '-' }} Karyawan
                            </strong>
                            <span class="block text-gray-500 truncate">{{ $profile->jenis_kelompok_usaha ?? 'Pangan & Kuliner' }}</span>
                        </div>

                        <div class="space-y-1 bg-gray-50/60 p-3.5 rounded-2xl border border-gray-100/80">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Lokasi Pabrik / Fasilitas</span>
                            <p class="text-xs font-semibold text-gray-800 truncate">
                                {{ $profile->alamat_fasilitas_produksi ?? $profile->alamat_perusahaan ?? 'Alamat belum diisi' }}
                            </p>
                            <span class="block text-gray-500">{{ $profile->kota_pabrik ?? 'Wilayah Terdaftar' }}</span>
                        </div>
                    </div>

                    <!-- FOOTER AKSI: HUBUNGI WA & DETAIL KLIEN -->
                    <div class="flex flex-col items-start justify-between gap-3 pt-3 border-t sm:flex-row sm:items-center border-gray-50">
                        <div class="text-xs font-medium text-gray-400">
                            ID Pengajuan: <span class="font-mono font-bold text-gray-700 bg-gray-100 px-2 py-0.5 rounded-md">{{ $project->kode_registrasi }}</span>
                        </div>

                        <div class="flex items-center w-full gap-2 sm:w-auto">
                            @if($waUrl !== '#')
                                <a href="{{ $waUrl }}"
                                   target="_blank"
                                   class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-semibold transition shadow-sm">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    <span>Hubungi WA</span>
                                </a>
                            @endif

                            <a href="{{ route('consultant.assignments.show', $project->id) }}"
                               class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-full text-xs font-semibold transition">
                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Detail Klien &rarr;</span>
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-12 text-center">
                    <div class="p-4 mx-auto mb-3 text-gray-400 rounded-full bg-gray-50 w-fit">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 01-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Belum Ada Klien Binaan</p>
                    <p class="max-w-sm mx-auto mt-1 text-xs text-gray-500">Anda belum memiliki penugasan binaan UMKM saat ini.</p>
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
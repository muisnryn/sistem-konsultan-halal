<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- BARIS 1: BANNER HERO WELCOME & KARTU REGISTRASI -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <!-- Banner Hijau Ucapan Selamat Datang -->
            <div class="lg:col-span-2 bg-[#195A36] text-white rounded-[24px] p-6 sm:p-8 relative overflow-hidden flex flex-col justify-between min-h-[230px] shadow-sm">
                <div class="relative z-10 max-w-xl space-y-3">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 backdrop-blur-md text-green-100 rounded-full text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-300"></span>
                        Portal Sertifikasi Halal Klien
                    </div>
                    <h2 class="text-xl font-bold leading-snug tracking-tight sm:text-2xl">
                        Selamat Datang, {{ $profile->nama_perusahaan ?? $user->name }}
                    </h2>
                    <p class="text-xs font-medium leading-relaxed text-green-100/90">
                        @if($activeProject)
                            @if($activeProject->tanggal_audit)
                                <span class="inline-flex items-center gap-1.5 font-bold text-white bg-white/10 px-2.5 py-0.5 rounded-full">
                                    <svg class="w-3.5 h-3.5 text-green-300 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                    Jadwal Audit Ditetapkan
                                </span>
                                Audit internal & lapangan akan dilaksanakan pada <strong>{{ \Carbon\Carbon::parse($activeProject->tanggal_audit)->translatedFormat('d F Y') }}</strong>.
                            @elseif($activeProject->konsultan_id && $activeProject->konsultan)
                                Konsultan pendamping Anda (<strong>{{ $activeProject->konsultan->nama_konsultan }}</strong>) telah ditugaskan. Tetap pantau dashboard untuk pembaruan jadwal audit.
                            @else
                                Pengajuan sertifikasi Anda sedang dalam proses peninjauan dan plotting konsultan oleh tim ahli kami.
                            @endif
                        @else
                            Anda belum memiliki pengajuan sertifikasi yang sedang aktif. Silakan buat pengajuan baru untuk memulai proses sertifikasi halal.
                        @endif
                    </p>
                </div>

                <div class="relative z-10 flex flex-wrap items-center gap-3 pt-6">
                    @if($activeProject)
                        <a href="{{ route('client.certification.status') }}" class="px-5 py-2.5 bg-white hover:bg-green-50 text-[#195A36] text-xs font-bold rounded-full shadow-xs transition inline-flex items-center gap-2">
                            <span>Lihat Detail Progres</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                        </a>
                    @else
                        <a href="{{ route('client.project.create') }}" class="px-5 py-2.5 bg-white hover:bg-green-50 text-[#195A36] text-xs font-bold rounded-full shadow-xs transition inline-flex items-center gap-2">
                            <span>Buat Pengajuan Baru</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        </a>
                    @endif
                </div>

                <!-- Element Hiasan Ikon Background -->
                <div class="absolute pointer-events-none -right-8 -bottom-8 text-white/10">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-5.45 9-12V5l-9-3zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 9z"/></svg>
                </div>
            </div>

            <!-- Kartu Info Registrasi & Ringkasan -->
            <div class="flex flex-col justify-between p-6 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                <div>
                    <div class="flex items-start justify-between pb-4 border-b border-gray-100">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">ID Registrasi</span>
                            <strong class="text-lg font-mono font-bold text-gray-900 mt-0.5 block">
                                {{ $activeProject ? '#'.$activeProject->kode_registrasi : '-' }}
                            </strong>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5z" /></svg>
                        </div>
                    </div>

                    <div class="mt-4 space-y-3 text-xs font-semibold">
                        <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                            <span class="text-gray-400">Tanggal Pengajuan</span>
                            <span class="font-mono text-gray-800">{{ $activeProject ? $activeProject->created_at->format('d M Y') : '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                            <span class="text-gray-400">Tipe Layanan</span>
                            <span class="text-gray-800">{{ $activeProject ? (is_object($activeProject->jenis_pengajuan) ? $activeProject->jenis_pengajuan->value : ucfirst($activeProject->jenis_pengajuan)) : '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">Jadwal Audit</span>
                            @if($activeProject && $activeProject->tanggal_audit)
                                <span class="font-extrabold text-[#195A36] font-mono flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-[#195A36] inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                    <span>{{ \Carbon\Carbon::parse($activeProject->tanggal_audit)->translatedFormat('d M Y') }}</span>
                                </span>
                            @else
                                <span class="italic font-normal text-gray-400">Belum ditentukan</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- HIGHLIGHT CARD JADWAL AUDIT -->
        @if($activeProject && $activeProject->tanggal_audit)
            <div class="flex flex-col justify-between gap-5 p-6 text-white border border-[#124227] shadow-sm bg-gradient-to-r from-[#124227] to-[#195A36] rounded-[24px] md:flex-row md:items-center">
                <div class="flex items-start gap-4">
                    <div class="p-3 text-white border bg-white/10 backdrop-blur-sm border-white/20 rounded-2xl shrink-0">
                        <svg class="text-green-300 w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <span class="px-2.5 py-0.5 bg-green-400/20 text-green-200 border border-green-300/30 rounded-full text-[10px] font-extrabold uppercase tracking-wider">
                            Agenda Mendatang
                        </span>
                        <h3 class="flex items-center gap-2 text-base font-extrabold tracking-tight">
                            <span>Agenda Audit Internal & Lapangan</span>
                        </h3>
                        <p class="text-xs font-medium text-green-100/90">
                            Tanggal: <strong class="font-black text-white underline decoration-green-300 underline-offset-2">{{ \Carbon\Carbon::parse($activeProject->tanggal_audit)->translatedFormat('d F Y') }}</strong>
                            @if($activeProject->catatan_audit)
                                &bull; <span class="italic font-normal text-green-200">"{{ $activeProject->catatan_audit }}"</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('client.certification.status') }}" class="w-full md:w-auto px-5 py-2.5 bg-white hover:bg-green-50 text-[#195A36] font-bold text-xs rounded-full shadow-xs transition inline-flex items-center justify-center gap-2">
                        <span>Lihat Panduan Audit</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                    </a>
                </div>
            </div>
        @endif

        <!-- BARIS 2: PROGRES PENGAJUAN SERTIFIKASI (STEPPER REALTIME 11 TAHAP) -->
        @php
            $lineWidthPercent = $currentStep > 1 ? min(100, round(($currentStep - 1) * 10)) : 0;

            $steps = [
                1  => 'Pengajuan',
                2  => 'Penerbitan Invoice',
                3  => 'Pembayaran T1',
                4  => 'Penugasan Konsultan',
                5  => 'Dokumen Persyaratan',
                6  => 'Validasi Dokumen',
                7  => 'Penjadwalan Audit',
                8  => 'Proses Sertifikat',
                9  => 'Sertifikat Terbit',
                10 => 'Pembayaran T2',
                11 => 'Selesai',
            ];
        @endphp

        <div class="p-6 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px] space-y-6 overflow-hidden">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <h3 class="flex items-center gap-2 text-xs font-bold tracking-wider text-gray-900 uppercase">
                    <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 005.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>
                    </div>
                    <span>Progres Sertifikasi Halal</span>
                </h3>
                @if($currentStep > 0)
                    <span class="px-3.5 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full font-bold text-[10px] uppercase tracking-wide">
                        Tahap {{ $currentStep }} Dari 11
                    </span>
                @else
                    <span class="px-3.5 py-1 bg-gray-100 text-gray-500 rounded-full font-bold text-[10px] uppercase tracking-wide">
                        Belum Ada Proyek Aktif
                    </span>
                @endif
            </div>

            <!-- Stepper Timeline Scrollable & Responsif -->
            <div class="pt-2 pb-4 overflow-x-auto no-scrollbar">
                <div class="min-w-[900px] relative px-4">
                    <!-- Progress Line background -->
                    <div class="absolute top-[18px] left-[4%] right-[4%] h-1 bg-gray-100 rounded-full z-0"></div>
                    <div class="absolute top-[18px] left-[4%] h-1 bg-[#195A36] rounded-full z-0 transition-all duration-700 ease-in-out" style="width: {{ $lineWidthPercent }}%;"></div>

                    <div class="relative z-10 grid grid-cols-11 text-center">
                        @foreach($steps as $num => $title)
                            <div class="flex flex-col items-center">
                                <div class="w-9 h-9 rounded-full transition-all duration-300 {{ $currentStep >= $num ? ($currentStep == $num ? 'bg-white border-2 border-[#195A36] text-[#195A36] ring-4 ring-green-100 font-bold scale-110 shadow-xs' : 'bg-[#195A36] text-white shadow-xs') : 'bg-gray-100 text-gray-400 border border-gray-200' }} flex items-center justify-center text-[11px] mb-2 shrink-0">
                                    @if($currentStep > $num)
                                        <svg class="w-3.5 h-3.5 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    @else
                                        {{ $num }}
                                    @endif
                                </div>
                                <strong class="text-[10px] font-bold leading-tight {{ $currentStep >= $num ? 'text-gray-900' : 'text-gray-400' }} block px-1">
                                    {{ $title }}
                                </strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- BARIS 3: KONSULTAN PENDAMPING & AKTIVITAS TERKINI REALTIME -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <!-- KONSULTAN PENDAMPING CARD -->
            <div class="flex flex-col justify-between p-6 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                <div>
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100">
                        <h3 class="text-xs font-bold tracking-wider text-gray-900 uppercase">Konsultan Pendamping</h3>
                        <span class="px-2.5 py-0.5 bg-[#e8f3ec] text-[#195A36] rounded-full text-[9px] font-bold uppercase">Terverifikasi</span>
                    </div>

                    @if($activeProject && $activeProject->konsultan)
                        <div class="flex flex-col items-center py-2 space-y-3 text-center">
                            <div class="relative">
                                <div class="flex items-center justify-center w-20 h-20 text-xl font-bold rounded-full shadow-xs bg-[#e8f3ec] border-2 border-[#195A36] text-[#195A36]">
                                    {{ strtoupper(substr($activeProject->konsultan->nama_konsultan, 0, 2)) }}
                                </div>
                                <span class="absolute bottom-0 right-0 w-5 h-5 bg-[#195A36] border-2 border-white rounded-full flex items-center justify-center text-white">
                                    <svg class="w-3 h-3 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                </span>
                            </div>
                            <div>
                                <strong class="block text-sm font-bold text-gray-900">{{ $activeProject->konsultan->nama_konsultan }}</strong>
                                <span class="text-[10px] text-gray-400 font-medium block mt-0.5">Lead Halal Auditor & Consultant</span>
                                <span class="text-[10px] text-[#195A36] font-semibold block mt-0.5">
                                    {{ $activeProject->konsultan->spesialisasi_industri ?? 'Industri Pangan' }}
                                </span>
                            </div>

                            @if($activeProject->konsultan->no_hp)
                                <a href="{{ $activeProject->konsultan->generateWhatsAppUrl($activeProject->nama_merek_dagang) }}" target="_blank" class="mt-3 w-full py-2.5 px-4 bg-[#195A36] hover:bg-[#124227] text-white text-xs font-bold rounded-full shadow-xs transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    <span>Hubungi via WhatsApp</span>
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="py-8 space-y-2 text-center text-gray-400">
                            <div class="flex items-center justify-center w-12 h-12 mx-auto text-gray-300 border border-gray-200 border-dashed rounded-full bg-gray-50">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" /></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-700">Konsultan Belum Ditugaskan</p>
                            <p class="text-[10px] text-gray-400">Tim admin sedang memplotting konsultan terbaik untuk proyek Anda.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- AKTIVITAS TERKINI (DINAMIS DARI CONTROLLER) -->
            <div class="p-6 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] lg:col-span-2 rounded-[24px]">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100">
                    <h3 class="text-xs font-bold tracking-wider text-gray-900 uppercase">Aktivitas Terkini</h3>
                    <span class="text-[10px] font-semibold text-gray-400">Pembaruan Otomatis</span>
                </div>

                <div class="space-y-4">
                    @forelse($activities as $act)
                        <div class="flex items-start gap-3.5 pb-3 border-b border-gray-50 last:border-b-0 last:pb-0">
                            <div class="w-8 h-8 bg-[#e8f3ec] text-[#195A36] rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                @if($act['icon'] === 'calendar')
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                @elseif($act['icon'] === 'certificate')
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                                @elseif($act['icon'] === 'user')
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" /></svg>
                                @elseif($act['icon'] === 'payment')
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125H3.75A1.125 1.125 0 012.625 15.375V5.625C2.625 5.004 3.129 4.5 3.75 4.5z" /></svg>
                                @elseif($act['icon'] === 'audit')
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <strong class="text-xs font-bold text-gray-900">{{ $act['title'] }}</strong>
                                    <span class="text-[10px] font-mono text-gray-400 font-medium">{{ $act['time'] }}</span>
                                </div>
                                <p class="text-[10px] text-gray-500 mt-0.5 leading-relaxed">{{ $act['desc'] }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-xs font-medium text-center text-gray-400">
                            Belum ada riwayat aktivitas aktif.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
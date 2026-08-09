<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- BREADCRUMB & HEADER TITLE -->
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center pb-2 border-b border-gray-100">
            <div>
                <nav class="text-xs font-semibold text-gray-400 mb-1.5 flex items-center gap-1.5">
                    <a href="{{ route('client.dashboard') }}" class="hover:text-[#195A36] transition">Dashboard</a>
                    <span>/</span>
                    <span class="font-bold text-gray-700">Status Sertifikasi</span>
                </nav>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl sm:text-[28px] font-bold text-gray-900 tracking-tight leading-none">Proses Sertifikasi Aktif</h1>
                    @if($activeProject)
                        <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full border border-gray-200/60">
                            ID Pengajuan: <strong class="font-mono text-gray-900">#{{ $activeProject->kode_registrasi }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <!-- TOMBOL HEADER: HUBUNGI KONSULTAN (JIKA KONSULTAN SUDAH DITUGASKAN) -->
            <div class="flex items-center gap-3">
                @if($activeProject && $activeProject->konsultan_id && $activeProject->konsultan)
                    <a href="{{ $activeProject->konsultan->generateWhatsAppUrl($activeProject->nama_merek_dagang) }}"
                       target="_blank"
                       class="px-5 py-2.5 bg-[#195A36] hover:bg-[#124227] text-white text-xs font-bold rounded-full shadow-xs transition flex items-center gap-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Hubungi Konsultan</span>
                    </a>
                @endif
            </div>
        </div>

        @if(!$activeProject)
            <!-- EMPTY STATE -->
            <div class="p-12 space-y-4 text-center bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                <div class="flex items-center justify-center w-14 h-14 mx-auto bg-[#e8f3ec] text-[#195A36] rounded-full">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                </div>
                <div class="space-y-1">
                    <h3 class="text-base font-bold text-gray-900">Belum Ada Pengajuan Sertifikasi</h3>
                    <p class="max-w-sm mx-auto text-xs text-gray-500 font-medium leading-relaxed">Anda belum memiliki pengajuan sertifikasi yang sedang aktif saat ini. Silakan buat pengajuan baru untuk memulai.</p>
                </div>
                <a href="{{ route('client.project.create') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-bold transition shadow-xs">
                    <span>Buat Pengajuan Sekarang</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                </a>
            </div>
        @else

            <!-- MAIN CONTENT GRID 12 COLUMNS -->
            <div class="grid items-start grid-cols-1 gap-6 lg:grid-cols-12">

                <!-- PANEL KIRI (8/12): TIMELINE PROGRES DETIL -->
                <div class="p-6 sm:p-8 space-y-8 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] lg:col-span-8 rounded-[24px]">

                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08" /></svg>
                            </div>
                            <h3 class="text-xs font-bold tracking-wider uppercase text-gray-900">Timeline Progres Detil</h3>
                        </div>
                        <span class="px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase tracking-wide">
                            {{ $currentStep == 7 ? 'Selesai' : 'Sedang Diproses' }}
                        </span>
                    </div>

                    <!-- VERTICAL STEPPER TIMELINE (7 STEPS) -->
                    <div class="relative space-y-8 pl-4 sm:pl-6 before:absolute before:left-[21px] sm:before:left-[29px] before:top-3 before:bottom-3 before:w-0.5 {{ $currentStep > 1 ? 'before:bg-[#195A36]' : 'before:bg-gray-200' }}">

                        <!-- STEP 1: DIAJUKAN -->
                        <div class="relative flex items-start gap-4 sm:gap-6 group">
                            <div class="relative z-10 w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center shrink-0 transition-all {{ $currentStep >= 1 ? 'bg-[#195A36] text-white shadow-xs' : 'bg-gray-100 text-gray-400 border border-gray-200' }}">
                                @if($currentStep > 1)
                                    <svg class="w-4 h-4 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                @else
                                    <span class="text-xs font-bold">1</span>
                                @endif
                            </div>
                            <div class="pt-1 space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <strong class="text-xs sm:text-sm font-bold text-gray-900">Diajukan</strong>
                                    <span class="text-[10px] text-gray-400 font-mono font-medium">{{ $activeProject->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <p class="text-xs font-medium leading-relaxed text-gray-500">
                                    Pendaftaran merek <strong class="text-gray-800">"{{ $activeProject->nama_merek_dagang }}"</strong> berhasil diterima oleh sistem. Dokumen awal siap diproses.
                                </p>
                            </div>
                        </div>

                        <!-- STEP 2: PENERBITAN INVOICE -->
                        <div class="relative flex items-start gap-4 sm:gap-6 group">
                            <div class="relative z-10 w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center shrink-0 transition-all {{ $currentStep >= 2 ? 'bg-[#195A36] text-white shadow-xs' : 'bg-gray-100 text-gray-400 border border-gray-200' }}">
                                @if($currentStep > 2)
                                    <svg class="w-4 h-4 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                @else
                                    <span class="text-xs font-bold">2</span>
                                @endif
                            </div>
                            <div class="pt-1 space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <strong class="text-xs sm:text-sm font-bold text-gray-900">Penerbitan Invoice</strong>
                                    @if($currentStep == 2)
                                        <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200/80 rounded-full text-[9px] font-bold uppercase">MENUNGGU PEMBAYARAN</span>
                                    @endif
                                </div>
                                <p class="text-xs font-medium leading-relaxed text-gray-500">
                                    Invoice tagihan pendampingan Termin 1 (60%) telah diterbitkan oleh tim Keuangan. Silakan lakukan pembayaran via Payment Gateway.
                                </p>
                            </div>
                        </div>

                        <!-- STEP 3: DIBAYAR -->
                        <div class="relative flex items-start gap-4 sm:gap-6 group">
                            <div class="relative z-10 w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center shrink-0 transition-all {{ $currentStep >= 3 ? 'bg-[#195A36] text-white shadow-xs' : 'bg-gray-100 text-gray-400 border border-gray-200' }}">
                                @if($currentStep > 3)
                                    <svg class="w-4 h-4 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                @else
                                    <span class="text-xs font-bold">3</span>
                                @endif
                            </div>
                            <div class="pt-1 space-y-1">
                                <div class="flex items-center gap-2">
                                    <strong class="text-xs sm:text-sm font-bold text-gray-900">Dibayar</strong>
                                </div>
                                <p class="text-xs font-medium leading-relaxed text-gray-500">
                                    Pembayaran biaya pendampingan telah terverifikasi lunas oleh sistem.
                                </p>
                            </div>
                        </div>

                        <!-- STEP 4: DITUGASKAN (KONSULTAN PENDAMPING) -->
                        <div class="relative flex items-start gap-4 sm:gap-6 group">
                            <div class="relative z-10 w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center shrink-0 transition-all {{ $currentStep >= 4 ? ($currentStep == 4 ? 'bg-white border-2 border-[#195A36] text-[#195A36] ring-4 ring-green-100 scale-110 shadow-xs font-bold' : 'bg-[#195A36] text-white shadow-xs') : 'bg-gray-100 text-gray-400 border border-gray-200' }}">
                                @if($currentStep > 4)
                                    <svg class="w-4 h-4 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" /></svg>
                                @endif
                            </div>
                            <div class="flex-1 pt-1 space-y-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <strong class="text-xs sm:text-sm font-bold text-gray-900">Ditugaskan</strong>
                                    @if($currentStep == 4)
                                        <span class="px-2.5 py-0.5 bg-[#e8f3ec] text-[#195A36] rounded-full text-[9px] font-bold uppercase">TAHAP SAAT INI</span>
                                    @endif
                                </div>

                                <!-- CARD INFO KONSULTAN PENDAMPING -->
                                @if($activeProject->konsultan)
                                    <div class="flex flex-col justify-between gap-4 p-4 border border-gray-100 bg-gray-50/80 rounded-[20px] sm:flex-row sm:items-center">
                                        <div class="flex items-center gap-3.5">
                                            <div class="flex items-center justify-center w-11 h-11 text-base font-bold text-[#195A36] shadow-xs rounded-full bg-[#e8f3ec] border-2 border-[#195A36] shrink-0">
                                                {{ strtoupper(substr($activeProject->konsultan->nama_konsultan, 0, 2)) }}
                                            </div>
                                            <div>
                                                <strong class="block text-xs sm:text-sm font-bold text-gray-900">
                                                    {{ $activeProject->konsultan->nama_konsultan }}
                                                </strong>
                                                <span class="text-[11px] text-gray-500 font-medium block">
                                                    Lead Halal Consultant &bull; {{ $activeProject->konsultan->spesialisasi_industri }}
                                                </span>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="px-2 py-0.5 bg-[#e8f3ec] text-[#195A36] text-[9px] font-bold rounded-full">Terverifikasi</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-xs italic text-gray-400">
                                        Tim Admin sedang menentukan konsultan terbaik untuk mendampingi proyek sertifikasi Anda.
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- STEP 5: VALIDASI DOKUMEN -->
                        <div class="relative flex items-start gap-4 sm:gap-6 group">
                            <div class="relative z-10 w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center shrink-0 transition-all {{ $currentStep >= 5 ? ($currentStep == 5 ? 'bg-white border-2 border-[#195A36] text-[#195A36] ring-4 ring-green-100 scale-110 shadow-xs font-bold' : 'bg-[#195A36] text-white shadow-xs') : 'bg-gray-100 text-gray-400 border border-gray-200' }}">
                                @if($currentStep > 5)
                                    <svg class="w-4 h-4 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                @else
                                    <span class="text-xs font-bold">5</span>
                                @endif
                            </div>
                            <div class="pt-1 space-y-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <strong class="text-xs sm:text-sm font-bold text-gray-900">Validasi Dokumen</strong>
                                    @if($currentStep == 5)
                                        <span class="px-2.5 py-0.5 bg-[#e8f3ec] text-[#195A36] rounded-full text-[9px] font-bold uppercase">TAHAP SAAT INI</span>
                                    @endif
                                </div>
                                <p class="text-xs font-medium leading-relaxed text-gray-500">
                                    Pemeriksaan dan verifikasi kelengkapan 5 dokumen utama Sistem Jaminan Produk Halal (SJPH) oleh konsultan pendamping.
                                </p>
                            </div>
                        </div>

                        <!-- STEP 6: AUDIT LAPANGAN -->
                        <div class="relative flex items-start gap-4 sm:gap-6 group">
                            <div class="relative z-10 w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center shrink-0 transition-all {{ $currentStep >= 6 ? ($currentStep == 6 ? 'bg-white border-2 border-[#195A36] text-[#195A36] ring-4 ring-green-100 scale-110 shadow-xs font-bold' : 'bg-[#195A36] text-white shadow-xs') : 'bg-gray-100 text-gray-400 border border-gray-200' }}">
                                @if($currentStep > 6)
                                    <svg class="w-4 h-4 stroke-[3]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                @endif
                            </div>
                            <div class="space-y-1.5 pt-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <strong class="text-xs sm:text-sm font-bold text-gray-900">Audit Lapangan</strong>
                                    @if($activeProject->tanggal_audit)
                                        <span class="text-xs font-bold font-mono text-[#195A36] bg-[#e8f3ec] px-3 py-0.5 rounded-full flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                            <span>{{ \Carbon\Carbon::parse($activeProject->tanggal_audit)->translatedFormat('d M Y') }}</span>
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs font-medium leading-relaxed text-gray-500">
                                    Kunjungan langsung ke lokasi produksi/pabrik untuk verifikasi kehalalan bahan baku, proses produksi, dan fasilitas sanitasi.
                                </p>
                                @if($activeProject->catatan_audit)
                                    <p class="text-[11px] text-gray-600 italic bg-gray-50 p-3 rounded-[16px] border border-gray-100">
                                        "Catatan Audit: {{ $activeProject->catatan_audit }}"
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- STEP 7: SERTIFIKAT TERBIT -->
                        <div class="relative flex items-start gap-4 sm:gap-6 group">
                            <div class="relative z-10 w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center shrink-0 transition-all {{ $currentStep == 7 ? 'bg-white border-2 border-[#195A36] text-[#195A36] ring-4 ring-green-100 scale-110 shadow-xs font-bold' : 'bg-gray-100 text-gray-400 border border-gray-200' }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-6.75a1.125 1.125 0 00-1.125 1.125V18.75" /></svg>
                            </div>
                            <div class="pt-1 space-y-1">
                                <div class="flex items-center gap-2">
                                    <strong class="text-xs sm:text-sm font-bold text-gray-900">Sertifikat Terbit</strong>
                                </div>
                                <p class="text-xs font-medium leading-relaxed text-gray-500">
                                    Penerbitan nomor ID sertifikasi halal resmi dari BPJPH dan dapat diunduh langsung dalam bentuk sertifikat digital.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- PANEL KANAN (4/12): WIDGET WAKTU & AUDIT -->
                <div class="space-y-6 lg:col-span-4 lg:sticky lg:top-6">

                    <!-- WIDGET 1: WAWASAN ANALITIK -->
                    <div class="p-6 space-y-4 text-white bg-[#195A36] rounded-[24px] shadow-sm relative overflow-hidden">
                        <div class="flex items-center gap-2 text-green-200">
                            <svg class="w-4 h-4 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>
                            <span class="text-[10px] font-bold uppercase tracking-wider">Wawasan Analitik</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-green-100/90">Estimasi Waktu Penyelesaian</span>
                            <strong class="text-2xl font-bold text-white block mt-0.5">14 Hari Kerja</strong>
                        </div>
                        <div class="w-full h-2 overflow-hidden rounded-full bg-[#124227]">
                            <div class="h-full transition-all duration-500 rounded-full bg-green-300" style="width: {{ round(($currentStep / 7) * 100) }}%;"></div>
                        </div>
                        <p class="text-[11px] text-green-100/90 italic font-medium leading-relaxed relative z-10">
                            Berdasarkan histori pendampingan, proses verifikasi Anda berjalan lancar dan tepat waktu.
                        </p>

                        <!-- Background Ornament -->
                        <div class="absolute pointer-events-none -right-6 -bottom-6 text-white/10">
                            <svg class="w-36 h-36" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-5.45 9-12V5l-9-3zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 9z"/></svg>
                        </div>
                    </div>

                    <!-- WIDGET 2: RINGKASAN AUDIT -->
                    <div class="p-6 space-y-4 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                        <h4 class="pb-3 text-xs font-bold tracking-wider uppercase border-b border-gray-100 text-gray-900">
                            Ringkasan Audit
                        </h4>

                        <div class="space-y-3 text-xs font-semibold">
                            <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                                <span class="text-gray-400">Dokumen Terunggah</span>
                                <strong class="font-bold text-gray-900">{{ $totalUploadedDocs }} Dokumen</strong>
                            </div>
                            <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                                <span class="text-gray-400">Review Konsultan</span>
                                @if($approvedDocsCount >= 5)
                                    <span class="px-2.5 py-0.5 bg-[#e8f3ec] text-[#195A36] rounded-full font-bold text-[10px] uppercase">LULUS VALIDASI</span>
                                @else
                                    <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200/80 rounded-full font-bold text-[10px] uppercase">PENINJAUAN</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400">Jadwal Audit Lapangan</span>
                                @if($activeProject->tanggal_audit)
                                    <span class="font-bold text-[#195A36]">SIAP</span>
                                @else
                                    <span class="italic font-normal text-gray-400">MENUNGGU</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- WIDGET 3: BUTUH BANTUAN? (WA CS SUPPORT) -->
                    <div class="p-6 space-y-3 bg-[#124227] text-white rounded-[24px] shadow-xs">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/10 text-green-300 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M12 18h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <strong class="block text-xs font-bold text-white">Butuh Bantuan?</strong>
                                <span class="text-[10px] text-green-100/80 font-medium block">Tim support siap membantu Anda</span>
                            </div>
                        </div>

                        <a href="https://wa.me/6285691720503?text=Halo%20Tim%20Support%20Halal%20Center,%20saya%20butuh%20bantuan%20terkait%20pengajuan%20%23{{ $activeProject->kode_registrasi }}"
                           target="_blank"
                           class="w-full py-2.5 bg-white hover:bg-green-50 text-[#195A36] font-bold text-xs rounded-full transition shadow-xs flex items-center justify-center gap-2">
                            <span>Chat Helpdesk via WA</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                        </a>
                    </div>

                </div>

            </div>

        @endif

    </div>
</x-app-layout>

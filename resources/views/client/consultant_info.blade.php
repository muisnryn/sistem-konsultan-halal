<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        @if(!$activeProject || !$activeProject->konsultan)
            <!-- STATE JIKA BELUM ADA KONSULTAN DITUGASKAN -->
            <div class="p-8 sm:p-12 space-y-5 text-center bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-amber-50 text-amber-700 rounded-full border border-amber-200/80">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <div class="max-w-md mx-auto space-y-1.5">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900">Belum Ada Konsultan Ditugaskan</h3>
                    <p class="text-xs font-medium leading-relaxed text-gray-500">
                        Admin sedang memproses plotting konsultan pendamping terbaik yang sesuai dengan jenis pendaftaran dan domisili perusahaan Anda.
                    </p>
                </div>
                <div class="pt-2">
                    <a href="{{ route('client.certification.status') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200/80 text-xs font-bold rounded-full transition shadow-xs">
                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-1-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                        </svg>
                        <span>Pantau Status Sertifikasi</span>
                    </a>
                </div>
            </div>
        @else
            @php
                $konsultan = $activeProject->konsultan;
                $totalDocs = $activeProject->documents->count();
                $approvedDocs = $activeProject->documents->where('status_validasi', 'approved')->count();
                $pctDocs = $totalDocs > 0 ? round(($approvedDocs / $totalDocs) * 100) : 0;
            @endphp

            <!-- BREADCRUMB & HEADER PAGE SECTION -->
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center pb-2 border-b border-gray-100">
                <div>
                    <nav class="text-xs font-semibold text-gray-400 mb-1.5 flex items-center gap-1.5">
                        <a href="{{ route('client.dashboard') }}" class="hover:text-[#195A36] transition">Dashboard</a>
                        <span>/</span>
                        <span class="font-bold text-gray-700">Penugasan Konsultan</span>
                    </nav>
                    <div class="flex items-center gap-3">
                        <h1 class="text-2xl sm:text-[28px] font-bold text-gray-900 tracking-tight leading-none">Penugasan Konsultan</h1>
                    </div>
                    <p class="text-xs text-gray-500 font-medium mt-1.5">Monitoring dan koordinasi aktif dengan tenaga ahli pendamping sertifikasi.</p>
                </div>

                <!-- CARD PROGRESS PENINJAUAN (COMPACT WIDGET) -->
                <div class="bg-white border border-gray-100 rounded-[20px] p-3.5 shadow-xs w-full sm:w-64 space-y-1.5 shrink-0">
                    <div class="flex justify-between items-center text-xs font-bold">
                        <span class="text-gray-500 uppercase tracking-wider text-[10px]">Progres Review</span>
                        <span class="font-mono font-bold text-[#195A36]">{{ $pctDocs }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-[#195A36] h-full rounded-full transition-all duration-500" style="width: {{ $pctDocs }}%"></div>
                    </div>
                    <p class="text-[10px] text-gray-400 font-medium italic">
                        *Estimasi: {{ $activeProject->tanggal_audit ? \Carbon\Carbon::parse($activeProject->tanggal_audit)->diffForHumans() : '4 hari kerja' }}
                    </p>
                </div>
            </div>

            <!-- MAIN GRID CONTENT -->
            <div class="grid items-start grid-cols-1 gap-6 lg:grid-cols-12">

                <!-- LEFT COLUMN: PROFIL KONSULTAN (4/12) -->
                <div class="p-6 space-y-5 overflow-hidden bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] lg:col-span-4 rounded-[24px] lg:sticky lg:top-6">

                    <!-- BANNER ATAS & FOTO PROFIL -->
                    <div class="space-y-4 text-center">
                        <div class="relative flex items-center justify-center h-20 overflow-hidden bg-[#195A36] rounded-[20px]">
                            <span class="text-[10px] font-bold uppercase tracking-widest text-green-200/90">Lead Halal Expert</span>
                        </div>

                        <div class="relative -mt-12">
                            <div class="flex items-center justify-center w-24 h-24 mx-auto overflow-hidden text-2xl font-bold bg-white border-4 border-white shadow-md rounded-full text-[#195A36]">
                                @if($konsultan->user && $konsultan->user->foto_profile)
                                    <img src="{{ asset('storage/' . $konsultan->user->foto_profile) }}" alt="{{ $konsultan->nama_konsultan }}" class="object-cover w-full h-full">
                                @else
                                    {{ strtoupper(substr($konsultan->nama_konsultan, 0, 2)) }}
                                @endif
                            </div>
                        </div>

                        <!-- NAME & BADGES -->
                        <div class="space-y-1">
                            <h3 class="text-base sm:text-lg font-bold leading-snug text-gray-900">{{ $konsultan->nama_konsultan }}</h3>
                            <p class="text-xs font-medium text-gray-500">Tenaga Ahli Pendamping Resmi</p>

                            <div class="flex items-center justify-center gap-2 pt-1.5">
                                <span class="px-3 py-1 bg-[#e8f3ec] text-[#195A36] text-[11px] font-bold rounded-full flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 fill-[#195A36]" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    4.9 Rating
                                </span>
                                <span class="px-3 py-1 bg-sky-50 text-sky-700 border border-sky-200/80 text-[11px] font-bold rounded-full flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Certified
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- SPESIFIKASI KONSULTAN BOX -->
                    <div class="space-y-2.5 text-xs font-semibold">
                        <div class="p-3.5 bg-gray-50/80 rounded-[16px] border border-gray-100 flex items-center justify-between">
                            <span class="flex items-center gap-2 font-medium text-gray-500">
                                <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Spesialisasi
                            </span>
                            <strong class="font-bold text-gray-900">{{ $konsultan->spesialisasi_industri ?? 'Industri Pangan' }}</strong>
                        </div>

                        <div class="p-3.5 bg-gray-50/80 rounded-[16px] border border-gray-100 flex items-center justify-between">
                            <span class="flex items-center gap-2 font-medium text-gray-500">
                                <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Domisili
                            </span>
                            <strong class="font-bold text-gray-900">{{ $konsultan->domisili ?? 'JABODETABEK' }}</strong>
                        </div>
                    </div>

                    <!-- TOMBOL WHATSAPP FULL WIDTH -->
                    <div class="pt-1">
                        <a href="{{ $konsultan->generateWhatsAppUrl($activeProject->nama_merek_dagang) }}" target="_blank" class="w-full py-3 px-4 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-bold transition flex items-center justify-center gap-2.5 shadow-xs cursor-pointer">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>Hubungi via WhatsApp</span>
                        </a>
                    </div>
                </div>

                <!-- RIGHT COLUMN: STATS CARDS & LOG AKTIVITAS (8/12) -->
                <div class="space-y-6 lg:col-span-8">

                    <!-- 3 STATS CARDS (TOP) -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                        <!-- STAT 1: DOKUMEN REVIEW -->
                        <div class="p-4 bg-white border border-gray-100 rounded-[20px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] flex items-center gap-3.5">
                            <div class="w-10 h-10 bg-[#e8f3ec] text-[#195A36] rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="space-y-0.5">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Dokumen Review</span>
                                <strong class="block text-base font-bold font-mono text-gray-900">{{ $approvedDocs }} / {{ $totalDocs > 0 ? $totalDocs : 5 }}</strong>
                            </div>
                        </div>

                        <!-- STAT 2: KRITERIA TERPENUHI -->
                        <div class="p-4 bg-white border border-gray-100 rounded-[20px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] flex items-center gap-3.5">
                            <div class="w-10 h-10 bg-sky-50 text-sky-700 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div class="space-y-0.5">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Kriteria Terpenuhi</span>
                                <strong class="block text-base font-bold font-mono text-gray-900">{{ $pctDocs }}%</strong>
                            </div>
                        </div>

                        <!-- STAT 3: SLA PENUGASAN -->
                        <div class="p-4 bg-white border border-gray-100 rounded-[20px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] flex items-center gap-3.5">
                            <div class="w-10 h-10 bg-[#e8f3ec] text-[#195A36] rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="space-y-0.5">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">SLA Penugasan</span>
                                <strong class="block text-base font-bold text-[#195A36]">On Time</strong>
                            </div>
                        </div>

                    </div>

                    <!-- LOG AKTIVITAS KONSULTAN PANEL -->
                    <div class="p-6 space-y-6 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <h3 class="text-xs font-bold tracking-wider uppercase text-gray-900">Log Aktivitas Konsultan</h3>
                            </div>
                            <a href="{{ route('client.documents.index') }}" class="text-xs font-bold text-[#195A36] hover:underline">Lihat Semua</a>
                        </div>

                        <!-- TIMELINE LOG LIST -->
                        <div class="space-y-6 relative before:absolute before:inset-0 before:left-4 sm:before:left-5 before:w-0.5 before:bg-gray-100">

                            <!-- LOG 1 -->
                            <div class="relative flex items-start gap-4">
                                <div class="z-10 flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-white rounded-full bg-[#195A36] shrink-0 shadow-xs">
                                    <svg class="w-4 h-4 stroke-[2.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="flex-1 p-4 space-y-2 border border-gray-100 bg-gray-50/80 rounded-[20px]">
                                    <div class="flex flex-wrap items-center justify-between gap-1">
                                        <h4 class="text-xs font-bold text-gray-900">Persetujuan Dokumen Bahan Baku</h4>
                                        <span class="text-[10px] font-mono font-medium text-gray-400 bg-white px-2.5 py-0.5 rounded-full border border-gray-200/60">2 Jam Lalu</span>
                                    </div>
                                    <p class="text-xs font-medium leading-relaxed text-gray-500">
                                        {{ $konsultan->nama_konsultan }} telah memverifikasi sertifikat halal bahan baku (Flavour, Emulsifier, & Sweetener). Semuanya dinyatakan sesuai standar LPPOM.
                                    </p>
                                    <div class="pt-1">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-gray-200/80 rounded-full text-[10px] font-mono font-semibold text-gray-600">
                                            <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0l-6.364-6.364a4.5 4.5 0 016.364-6.364l6.364 6.364a4.5 4.5 0 010 6.364z"/></svg>
                                            verifikasi_bahan_baku_final.pdf
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- LOG 2 -->
                            <div class="relative flex items-start gap-4">
                                <div class="z-10 flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 text-white bg-sky-600 rounded-full shrink-0 shadow-xs">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 012.828 0L20 4.828a2 2 0 010 2.828l-8.586 8.586-3.536 1.061 1.06-3.536L16.586 3.586z"/></svg>
                                </div>
                                <div class="flex-1 p-4 space-y-2 border border-gray-100 bg-gray-50/80 rounded-[20px]">
                                    <div class="flex flex-wrap items-center justify-between gap-1">
                                        <h4 class="text-xs font-bold text-gray-900">Catatan Review Manual SJPH</h4>
                                        <span class="text-[10px] font-mono font-medium text-gray-400 bg-white px-2.5 py-0.5 rounded-full border border-gray-200/60">Kemarin, 14:20</span>
                                    </div>
                                    <p class="text-xs font-medium leading-relaxed text-gray-500">
                                        Ditemukan ketidaksinkronan minor pada poin 4.2 mengenai diagram alir proses. Mohon segera diperbaiki untuk submit audit tahap II.
                                    </p>
                                    <div class="pt-1">
                                        <a href="{{ route('client.documents.index') }}" class="text-[11px] font-bold text-[#195A36] hover:underline inline-flex items-center gap-1">
                                            <span>Buka Catatan Revisi</span>
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        @endif

    </div>
</x-app-layout>

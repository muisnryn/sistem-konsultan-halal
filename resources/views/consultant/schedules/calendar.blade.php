<x-app-layout>
    <!-- FullCalendar v6 via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- TOMBOL KEMBALI KE DAFTAR JADWAL -->
        <div class="flex items-center justify-between">
            <a href="{{ route('consultant.schedules.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-700 transition bg-white border border-gray-200 rounded-full shadow-xs hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Daftar Jadwal</span>
            </a>
        </div>

        <!-- NOTIFIKASI SUCCESS -->
        @if(session('success'))
            <div class="flex items-center justify-between p-4 text-xs font-semibold border bg-emerald-50 border-emerald-200 text-emerald-800 rounded-2xl">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    {{ session('success') }}
                </span>
                <button type="button" onclick="this.parentElement.remove()" class="font-bold text-emerald-700 hover:text-emerald-900">✕</button>
            </div>
        @endif

        <!-- HERO CARD DETAIL PROYEK (Rounded 24px Admin Style) -->
        <div class="bg-white rounded-[24px] p-6 sm:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100">
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div>
                    <span class="block text-xs font-bold tracking-wider text-gray-400 uppercase">Penjadwalan Audit Proyek</span>
                    <h1 class="mt-1 text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                        {{ $project->nama_merek_dagang }}
                    </h1>
                    <p class="flex flex-wrap items-center gap-2 mt-1 text-xs text-gray-500">
                        <span>Perusahaan: <strong class="font-semibold text-gray-900">{{ $project->klien->companyProfile->nama_perusahaan ?? '-' }}</strong></span>
                        <span class="text-gray-300">•</span>
                        <span>Kategori: <strong class="font-semibold text-gray-700">{{ $project->klien->companyProfile->jenis_kelompok_usaha ?? 'Makanan Olahan' }}</strong></span>
                    </p>
                </div>
                <div>
                    @if($project->tanggal_audit)
                        <span class="px-4 py-1.5 bg-green-50 text-[#195A36] border border-green-200 rounded-full text-xs font-semibold inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                            Jadwal Saat Ini: {{ \Carbon\Carbon::parse($project->tanggal_audit)->translatedFormat('d M Y') }}
                        </span>
                    @else
                        <span class="px-4 py-1.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs font-semibold inline-flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            Belum Memiliki Jadwal
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- MAIN GRID: FORM PENJADWALAN & KALENDER -->
        <div class="grid items-start grid-cols-1 gap-6 lg:grid-cols-12">
            
            <!-- FORM ATUR TANGGAL AUDIT (4/12) -->
            <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 lg:col-span-4 space-y-4">
                <h3 class="flex items-center gap-2 pb-3 text-xs font-bold tracking-wider text-gray-900 uppercase border-b border-gray-100">
                    <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6h3.75m3.75 6h9.75m-9.75 0a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 12h3.75m3.75 6h9.75m-9.75 0a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 18h3.75" /></svg>
                    <span>Form Atur / Ubah Jadwal</span>
                </h3>

                <form action="{{ route('consultant.schedules.update', $project->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-gray-700">Tanggal Audit</label>
                        <input type="date" 
                               name="tanggal_audit" 
                               value="{{ old('tanggal_audit', $project->tanggal_audit ? \Carbon\Carbon::parse($project->tanggal_audit)->format('Y-m-d') : '') }}" 
                               required 
                               class="w-full p-2.5 text-xs font-medium rounded-xl border-gray-200 focus:ring-[#195A36] focus:border-[#195A36] text-gray-800 shadow-xs">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-gray-700">Waktu & Catatan Lokasi Audit</label>
                        <textarea name="catatan_audit" 
                                  rows="4" 
                                  placeholder="Contoh: Pukul 09:00 - 15:00 WIB, Lokasi: Pabrik Cikarang..." 
                                  class="w-full p-3 text-xs font-medium rounded-xl border-gray-200 focus:ring-[#195A36] focus:border-[#195A36] text-gray-800 shadow-xs">{{ old('catatan_audit', $project->catatan_audit) }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 text-xs font-semibold text-white transition shadow-sm bg-[#195A36] hover:bg-[#124227] rounded-full cursor-pointer flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        <span>Simpan Jadwal Audit</span>
                    </button>
                </form>
            </div>

            <!-- KALENDER VISUAL AGENDA (8/12) -->
            <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 lg:col-span-8 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="flex items-center gap-2 text-xs font-bold tracking-wider text-gray-900 uppercase">
                        <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                        <span>Kalender Agenda Audit Keseluruhan</span>
                    </h3>
                    <span class="text-xs font-medium text-gray-400">Mencegah terjadinya jadwal bentrok</span>
                </div>

                <div id="auditCalendar" class="min-h-[480px] text-xs"></div>
            </div>

        </div>

    </div>

    <!-- INITIALIZE FULLCALENDAR WITH HIJAU THEME -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('auditCalendar');
            var eventsData = @json($calendarEvents);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'title',
                    right: 'prev,next today'
                },
                buttonText: {
                    today: 'Hari Ini'
                },
                events: eventsData,
                eventClick: function(info) {
                    var eventObj = info.event;
                    var note = eventObj.extendedProps.catatan ? '\nCatatan: ' + eventObj.extendedProps.catatan : '';
                    alert('📌 Proyek: ' + eventObj.title + '\nPerusahaan: ' + eventObj.extendedProps.company + '\nTanggal: ' + eventObj.start.toLocaleDateString('id-ID') + note);
                },
                height: 'auto'
            });

            calendar.render();
        });
    </script>

    <style>
        .fc .fc-toolbar-title { font-size: 0.95rem; font-weight: 700; color: #111827; }
        .fc .fc-button-primary { background-color: #f9fafb; border-color: #e5e7eb; color: #374151; font-size: 0.75rem; font-weight: 600; border-radius: 9999px; padding: 4px 12px; }
        .fc .fc-button-primary:hover { background-color: #195A36; border-color: #195A36; color: #ffffff; }
        .fc .fc-button-active { background-color: #195A36 !important; border-color: #195A36 !important; color: #ffffff !important; }
        .fc .fc-daygrid-day-number { font-size: 0.75rem; font-weight: 600; color: #4b5563; }
        .fc-event { border-radius: 6px; padding: 2px 6px; font-size: 0.7rem; background-color: #195A36; border-color: #195A36; cursor: pointer; }
    </style>
</x-app-layout>
<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER BAGIAN ATAS (Meniru gaya "Dashboard" Admin) -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Dashboard</h1>
                <p class="mt-2 text-sm font-medium text-gray-500">
                    Selamat datang kembali, <span class="font-semibold text-gray-800">{{ $consultant->nama ?? auth()->user()->name }}</span>. Berikut ringkasan penugasan audit sertifikasi halal Anda.
                </p>
            </div>
            <a href="{{ route('consultant.schedules.index') }}" class="px-5 py-2.5 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-semibold transition shadow-sm inline-flex items-center gap-2 self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                Lihat Jadwal Audit
            </a>
        </div>

        <!-- SISTEM KARTU STATISTIK (Presisi persis seperti Kartu Admin) -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

            <!-- Kartu 1: Penugasan Aktif (Meniru Kartu Hijau "Total Projects") -->
            <div class="bg-[#195A36] rounded-[24px] p-6 shadow-md flex flex-col justify-between relative overflow-hidden transition-transform hover:-translate-y-1 duration-300">
                <div class="flex items-start justify-between">
                    <span class="text-sm font-medium tracking-wide text-white/90">Penugasan Aktif</span>
                    <a href="{{ route('consultant.assignments.index') }}" class="p-2 transition rounded-full cursor-pointer bg-white/20 backdrop-blur-sm hover:bg-white/30">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </a>
                </div>
                <div class="mt-6">
                    <strong class="text-[40px] font-bold text-white block tracking-tight leading-none">
                        {{ number_format($activeCount) }}
                    </strong>
                    <div class="inline-flex items-center gap-1.5 mt-4 text-white/90 text-xs bg-white/10 border border-white/20 px-2.5 py-1 rounded-md font-medium">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M3.75 4.5h16.5m-16.5 3.75h16.5" /></svg>
                        Proyek berjalan saat ini
                    </div>
                </div>
            </div>

            <!-- Kartu 2: Audit Selesai (Meniru Kartu Putih "Ended Projects") -->
            <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col justify-between transition-transform hover:-translate-y-1 duration-300">
                <div class="flex items-start justify-between">
                    <span class="text-sm font-medium tracking-wide text-gray-900">Audit Selesai</span>
                    <div class="p-2 transition bg-white border border-gray-200 rounded-full shadow-sm cursor-pointer hover:bg-gray-50">
                        <svg class="w-4 h-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6">
                    <strong class="text-[40px] font-bold text-gray-900 block tracking-tight leading-none">
                        {{ number_format($completedCount) }}
                    </strong>
                    <div class="inline-flex items-center gap-1.5 mt-4 text-gray-500 text-xs bg-gray-50 border border-gray-100 px-2.5 py-1 rounded-md font-medium">
                        <span class="h-2 w-2 rounded-full bg-[#195A36]"></span>
                        Telah divalidasi & tuntas
                    </div>
                </div>
            </div>

            <!-- Kartu 3: Butuh Validasi (Meniru Kartu Putih "Running Projects") -->
            <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col justify-between transition-transform hover:-translate-y-1 duration-300">
                <div class="flex items-start justify-between">
                    <span class="text-sm font-medium tracking-wide text-gray-900">Butuh Validasi</span>
                    <div class="p-2 transition bg-white border border-gray-200 rounded-full shadow-sm cursor-pointer hover:bg-gray-50">
                        <svg class="w-4 h-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6">
                    <strong class="text-[40px] font-bold text-gray-900 block tracking-tight leading-none">
                        {{ number_format($needValidationCount) }}
                    </strong>
                    <div class="inline-flex items-center gap-1.5 mt-4 text-amber-700 text-xs bg-amber-50 border border-amber-100 px-2.5 py-1 rounded-md font-medium">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        Membutuhkan tindakan segera
                    </div>
                </div>
            </div>

        </div>

        <!-- SECTION DAFTAR PENUGASAN TERBARU (Gaya Card-based Admin) -->
        <div class="pt-2 space-y-6">

            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold tracking-tight text-gray-900">Daftar Penugasan Terbaru</h2>
                    <p class="text-xs font-medium text-gray-500 mt-0.5">Klien yang ditugaskan kepada Anda untuk proses sertifikasi.</p>
                </div>
                <a href="{{ route('consultant.assignments.index') }}" class="px-4 py-1.5 border border-gray-200 rounded-full text-xs font-semibold text-gray-600 hover:bg-gray-50 transition flex items-center gap-1">
                    Lihat Semua
                </a>
            </div>

            @if($assignments->isEmpty())
                <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-12 text-center">
                    <div class="p-4 mx-auto mb-3 text-gray-400 rounded-full bg-gray-50 w-fit">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Belum Ada Penugasan Baru</p>
                    <p class="max-w-sm mx-auto mt-1 text-xs text-gray-500">Penugasan audit atau pendampingan baru akan muncul secara otomatis di sini setelah diplotting oleh Admin.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($assignments as $project)
                        @php
                            $validDocs = $project->documents
                                ->whereIn('jenis_dokumen', ['daftar_produk', 'daftar_bahan', 'daftar_fasilitas', 'sk_penyelia_halal', 'manual_sjph'])
                                ->where('status_validasi', 'approved')
                                ->count();

                            $progressPercent = min(100, round(($validDocs / 5) * 100));
                            $namaPerusahaan = $project->klien->companyProfile->nama_perusahaan ?? $project->nama_merek_dagang;
                            $initials = strtoupper(substr($namaPerusahaan, 0, 2));
                        @endphp

                        <!-- Card Item Penugasan (Gaya Admin: Rounded 24px, Soft Badges, Rounded-full Actions) -->
                        <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col justify-between transition-transform hover:-translate-y-1 duration-300">
                            
                            <div class="space-y-4">
                                <!-- Header Info & Avatar Avatar Inisial Bulat Admin -->
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 bg-[#e8f3ec] text-[#195A36] font-bold rounded-full flex items-center justify-center text-sm tracking-wider uppercase shrink-0">
                                            {{ $initials }}
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="text-sm font-semibold leading-snug text-gray-900 truncate">
                                                {{ $project->nama_merek_dagang }}
                                            </h3>
                                            <p class="text-xs text-gray-500 truncate mt-0.5">
                                                {{ $project->klien->companyProfile->nama_perusahaan ?? 'Pelaku Usaha' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Category & Badge Status ala Admin -->
                                <div class="flex flex-wrap items-center gap-2 pt-1">
                                    @if($progressPercent == 100)
                                        <span class="px-3 py-1 text-xs font-medium bg-green-50 text-[#195A36] rounded-full inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                                            Audit Selesai
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-medium bg-amber-50 text-amber-700 rounded-full inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Perlu Validasi
                                        </span>
                                    @endif

                                    <span class="px-3 py-1 text-xs font-medium text-gray-600 border border-gray-100 rounded-full bg-gray-50">
                                        {{ $project->klien->companyProfile->jenis_kelompok_usaha ?? 'Manufaktur' }}
                                    </span>
                                </div>

                                <!-- Progress & Deadline Detail -->
                                <div class="pt-3 border-t border-gray-100 space-y-2.5">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-500">Deadline Audit</span>
                                        <span class="font-semibold text-gray-900">
                                            {{ $project->created_at ? $project->created_at->addDays(14)->format('d M Y') : 'N/A' }}
                                        </span>
                                    </div>

                                    <div class="space-y-1">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-gray-500">Progres Validasi Dokumen</span>
                                            <span class="font-bold {{ $progressPercent == 100 ? 'text-[#195A36]' : 'text-gray-900' }}">
                                                {{ $progressPercent }}% ({{ $validDocs }}/5)
                                            </span>
                                        </div>
                                        <div class="w-full h-2 overflow-hidden bg-gray-100 rounded-full">
                                            <div class="h-full {{ $progressPercent == 100 ? 'bg-[#195A36]' : ($progressPercent >= 50 ? 'bg-amber-500' : 'bg-[#195A36]') }} transition-all duration-300 rounded-full"
                                                 style="width: {{ $progressPercent }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons (Meniru Tombol Oval/Rounded Full Admin) -->
                            <div class="pt-5 mt-4 border-t border-gray-50">
                                @if($progressPercent == 100)
                                    <a href="{{ route('consultant.documents.validate', $project->id) }}"
                                       class="inline-flex items-center justify-center w-full px-4 py-2 text-xs font-semibold text-gray-700 transition border border-gray-200 rounded-full bg-gray-50 hover:bg-gray-100">
                                        Lihat Hasil Review
                                    </a>
                                @else
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('consultant.documents.validate', $project->id) }}"
                                           class="flex-1 px-4 py-2 text-xs font-semibold text-center text-gray-700 transition bg-white border border-gray-200 rounded-full hover:bg-gray-50">
                                            Detail
                                        </a>
                                        <a href="{{ route('consultant.documents.validate', $project->id) }}"
                                           class="flex-1 text-center px-4 py-2 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-semibold transition shadow-sm">
                                            Validasi &rarr;
                                        </a>
                                    </div>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </div>
</x-app-layout>
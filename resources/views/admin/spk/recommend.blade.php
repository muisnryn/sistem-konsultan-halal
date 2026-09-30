<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8"
         x-data="{ activeTab: 'summary', showModal: false, selectedConsultant: null }"
         @open-modal.window="showModal = true; selectedConsultant = $event.detail">

        <!-- HEADER HALAMAN -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase tracking-wide">
                        Engine SPK
                    </span>
                    <span class="text-xs font-semibold text-gray-500">PROMETHEE II & Spasial Haversine</span>
                </div>
                <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Analisis & Plotting</h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.spk.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-full text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <span>Kembali</span>
                </a>
                <button type="button" onclick="eksekusiPrometheeEngine()" class="px-5 py-2.5 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-sm font-semibold transition shadow-sm flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span>Hitung Ulang</span>
                </button>
            </div>
        </div>

        <!-- HERO BANNER: REKOMENDASI UTAMA (RANK 1) -->
        <div id="hero-recommendation" class="relative hidden p-8 overflow-hidden text-white shadow-lg bg-[#195A36] rounded-[24px]">
            <div class="absolute w-64 h-64 rounded-full pointer-events-none -right-10 -top-10 bg-white/10 blur-3xl"></div>
            <div class="absolute w-48 h-48 rounded-full pointer-events-none -left-10 -bottom-10 bg-black/10 blur-2xl"></div>

            <div class="relative z-10 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="space-y-3">
                    <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 px-3.5 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wide">
                        <span class="w-2 h-2 bg-white rounded-full animate-ping"></span>
                        Rekomendasi Terbaik SPK (Rank 1)
                    </div>
                    <h3 id="hero-name" class="text-3xl font-bold tracking-tight text-white">-</h3>
                    <p id="hero-desc" class="max-w-xl text-sm font-medium leading-relaxed text-white/80">-</p>
                </div>

                <div class="flex items-center gap-5 p-5 bg-black/20 border border-white/10 rounded-[20px] backdrop-blur-sm shrink-0">
                    <div class="pr-5 text-center border-r border-white/20">
                        <span class="text-[10px] text-white/70 block font-bold uppercase tracking-wider mb-1">Net Flow (𝜙)</span>
                        <span id="hero-score" class="text-2xl font-bold tracking-tight text-white">+0.0000</span>
                    </div>
                    <button type="button" id="hero-btn-assign" class="px-5 py-3 bg-white hover:bg-gray-50 text-[#195A36] text-sm font-bold rounded-full transition shadow-sm cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5l-9 9l-4-4" />
                        </svg>
                        <span>Tugaskan</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT CONTAINER -->
        <div class="grid items-start grid-cols-1 gap-6 lg:grid-cols-12">

            <!-- KOLOM KIRI (4/12): PROFIL PROYEK & DETAIL ALAMAT -->
            <div class="space-y-6 lg:col-span-4">

                <!-- DETAIL PROYEK & ALAMAT KLIEN -->
                <div class="p-6 space-y-5 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                    <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                        <div class="p-2 bg-[#e8f3ec] text-[#195A36] rounded-full">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold tracking-wide text-gray-900 uppercase">Profil Proyek</h3>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div>
                            <span class="block mb-1 text-xs font-semibold tracking-wide text-gray-500 uppercase">Merek Dagang</span>
                            <strong class="block text-base font-bold text-gray-900">{{ $project->nama_merek_dagang }}</strong>
                        </div>

                        <div>
                            <span class="block mb-1 text-xs font-semibold tracking-wide text-gray-500 uppercase">Nama Perusahaan</span>
                            <span class="block font-medium text-gray-800">{{ $project->klien->companyProfile->nama_perusahaan ?? 'Pelaku Usaha' }}</span>
                        </div>

                        <!-- ALAMAT LENGKAP -->
                        <div class="p-4 space-y-3 bg-gray-50 rounded-[16px] border border-gray-100">
                            <div>
                                <span class="text-[11px] font-bold text-gray-500 uppercase block mb-1">Alamat Kantor</span>
                                <p class="text-xs font-medium leading-relaxed text-gray-700">
                                    {{ $project->klien->companyProfile->alamat_perusahaan ?? 'Belum diisi' }}
                                </p>
                            </div>

                            @if(!empty($project->klien->companyProfile->alamat_fasilitas_produksi))
                                <div class="pt-3 border-t border-gray-200/60">
                                    <span class="text-[11px] font-bold text-gray-500 uppercase block mb-1">Fasilitas Produksi</span>
                                    <p class="text-xs font-medium leading-relaxed text-gray-700">
                                        {{ $project->klien->companyProfile->nama_fasilitas_produksi ? $project->klien->companyProfile->nama_fasilitas_produksi . ' - ' : '' }}
                                        {{ $project->klien->companyProfile->alamat_fasilitas_produksi }}
                                        @if(!empty($project->klien->companyProfile->kota_pabrik))
                                            <span class="font-bold text-[#195A36]">({{ $project->klien->companyProfile->kota_pabrik }})</span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <div class="p-3 bg-white border border-gray-100 shadow-sm rounded-[16px]">
                                <span class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Kelompok Usaha</span>
                                <strong class="block text-xs font-bold text-gray-900">
                                    {{ $project->klien?->companyProfile?->jenis_kelompok_usaha ?? 'Makanan & Minuman' }}
                                </strong>
                            </div>
                            <div class="p-3 bg-white border border-gray-100 shadow-sm rounded-[16px]">
                                <span class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Skala Perusahaan</span>
                                <strong class="block text-xs font-bold text-gray-900 uppercase">
                                    {{ $project->klien?->companyProfile?->skala_perusahaan ?? 'Mikro' }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PARAMETER KRITERIA SPK -->
                <div class="p-6 space-y-4 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 text-gray-600 border border-gray-100 rounded-full bg-gray-50">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 18H7.5m9-6h2.25m-2.25 0a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 12h8.25" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold tracking-wide text-gray-900 uppercase">Kriteria & Bobot</h3>
                        </div>
                        <span class="text-[11px] font-bold text-gray-600 bg-gray-100 px-3 py-1 rounded-full">Total: {{ $criterias->count() }}</span>
                    </div>

                    <div class="text-xs divide-y divide-gray-50">
                        @foreach($criterias as $crit)
                            <div class="flex items-center justify-between py-3 group">
                                <div>
                                    <span class="block font-semibold text-gray-900">{{ $crit->kode }} - {{ $crit->nama_kriteria }}</span>
                                    <span class="text-[11px] text-gray-500 mt-1 block">Tren: <strong class="text-gray-700 uppercase">{{ $crit->tren }}</strong> | Bobot: <strong class="text-[#195A36]">{{ $crit->bobot }}</strong></span>
                                </div>
                                <span class="text-[10px] font-bold text-gray-500 bg-white border border-gray-200 px-2.5 py-1 rounded-full">
                                    {{ ucfirst($crit->tipe_preferensi) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- KOLOM KANAN (8/12): TABBED NAVIGATION & HASIL SPK -->
            <div class="space-y-6 lg:col-span-8">

                <!-- TABS HEADER -->
                <div class="flex flex-wrap gap-2">
                    <button @click="activeTab = 'summary'" :class="activeTab === 'summary' ? 'bg-[#195A36] text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 shadow-sm'" class="px-5 py-2.5 rounded-full text-sm font-semibold transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                        <span>Ringkasan & Ranking</span>
                    </button>
                    <button @click="activeTab = 'matrix'" :class="activeTab === 'matrix' ? 'bg-[#195A36] text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 shadow-sm'" class="px-5 py-2.5 rounded-full text-sm font-semibold transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H4.5A1.125 1.125 0 003.375 5.625m18 0v1.5c0 .621-.504 1.125-1.125 1.125m-16.5-2.625h16.5" />
                        </svg>
                        <span>Matriks Keputusan</span>
                    </button>
                    <button @click="activeTab = 'flows'" :class="activeTab === 'flows' ? 'bg-[#195A36] text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 shadow-sm'" class="px-5 py-2.5 rounded-full text-sm font-semibold transition flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5a1.5 1.5 0 011.5 1.5v3a1.5 1.5 0 01-1.5 1.5h-7.5A1.5 1.5 0 016 10.5v-3A1.5 1.5 0 018.25 6z" />
                        </svg>
                        <span>Detail Flow</span>
                    </button>
                </div>

                <!-- TAB 1: RINGKASAN & PLOTTING -->
                <div x-show="activeTab === 'summary'" class="space-y-6">
                    <!-- GRAFIK BAR -->
                    <div class="p-6 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                        <h3 class="pb-4 mb-4 text-sm font-bold tracking-wide text-gray-900 uppercase border-b border-gray-100">Grafik Skor Net Flow (Top 5 Konsultan)</h3>
                        <div id="chart-container" class="space-y-4">
                            <div class="py-2 space-y-3 animate-pulse">
                                <div class="w-3/4 h-4 bg-gray-100 rounded-full"></div>
                                <div class="h-8 bg-gray-100 rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <!-- TABEL RANKING UTAMA -->
                    <div class="p-6 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                        <div class="mb-5">
                            <h3 class="text-sm font-bold tracking-wide text-gray-900 uppercase">Tabel Perangkingan Konsultan</h3>
                            <p class="mt-1 text-xs text-gray-500">Urutan rekomendasi berdasarkan nilai Net Flow (𝜙) tertinggi.</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left whitespace-nowrap">
                                <thead>
                                    <tr class="font-medium text-gray-400 border-b border-gray-100">
                                        <th class="pb-3 font-medium text-center">Rank</th>
                                        <th class="pb-3 font-medium">Konsultan</th>
                                        <th class="pb-3 font-medium text-center">Net Flow (𝜙)</th>
                                        <th class="pb-3 font-medium text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body" class="divide-y divide-gray-50">
                                    <tr class="animate-pulse">
                                        <td colspan="4" class="py-12 font-medium text-center text-gray-400">Mengkalkulasi matriks keputusan dan rumus Haversine...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: MATRIKS KEPUTUSAN DINAMIS -->
                <div x-show="activeTab === 'matrix'" class="p-6 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                    <div class="mb-5">
                        <h3 class="text-sm font-bold tracking-wide text-gray-900 uppercase">Matriks Evaluasi Alternatif</h3>
                        <p class="mt-1 text-xs text-gray-500">Data kualitatif dan kuantitatif riil dari setiap konsultan sebelum perbandingan berpasangan.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs text-left whitespace-nowrap">
                            <thead>
                                <tr class="font-medium text-gray-400 border-b border-gray-100">
                                    <th class="pb-3 font-medium">Konsultan</th>
                                    <th class="pb-3 font-medium text-center">C1 (Spesialis)</th>
                                    <th class="pb-3 font-medium text-center">C2 (Pengalaman)</th>
                                    <th class="pb-3 font-medium text-center">C3 (Proyek)</th>
                                    <th class="pb-3 font-medium text-center">C4 (Jarak Spasial)</th>
                                    <th class="pb-3 font-medium text-center">C5 (Performa)</th>
                                    <th class="pb-3 font-medium text-center">C6 (Jadwal)</th>
                                </tr>
                            </thead>
                            <tbody id="matrix-table-body" class="text-gray-700 divide-y divide-gray-50">
                                <tr>
                                    <td colspan="7" class="py-10 font-medium text-center text-gray-400">Memuat matriks keputusan...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: DETAIL ALIRAN FLOW -->
                <div x-show="activeTab === 'flows'" class="p-6 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                    <div class="mb-5">
                        <h3 class="text-sm font-bold tracking-wide text-gray-900 uppercase">Detail Aliran Flow PROMETHEE II</h3>
                        <p class="mt-1 text-xs text-gray-500">Leaving Flow mengukur kekuatan, Entering Flow mengukur kelemahan.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left whitespace-nowrap">
                            <thead>
                                <tr class="font-medium text-gray-400 border-b border-gray-100">
                                    <th class="pb-3 font-medium">Nama Konsultan</th>
                                    <th class="pb-3 font-medium text-center">Leaving Flow (𝜙⁺)</th>
                                    <th class="pb-3 font-medium text-center">Entering Flow (𝜙⁻)</th>
                                    <th class="pb-3 font-medium text-center">Net Flow (𝜙 = 𝜙⁺ - 𝜙⁻)</th>
                                </tr>
                            </thead>
                            <tbody id="flows-table-body" class="text-gray-700 divide-y divide-gray-50">
                                <tr>
                                    <td colspan="4" class="py-10 font-medium text-center text-gray-400">Memuat perhitungan flow...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

        <!-- MODAL KONFIRMASI PLOTTING -->
        <div x-show="showModal"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto bg-gray-900/40 backdrop-blur-sm"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <div class="w-full max-w-md p-7 space-y-6 bg-white shadow-2xl rounded-[24px]" @click.outside="showModal = false">

                <!-- HEADER MODAL -->
                <div class="flex items-start justify-between gap-3 pb-4 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-[#e8f3ec] text-[#195A36] rounded-full shrink-0">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Konfirmasi Penugasan</h3>
                            <p class="mt-1 text-xs font-medium text-gray-500">Plotting konsultan penanggung jawab.</p>
                        </div>
                    </div>
                    <button type="button" @click="showModal = false" class="p-2 text-gray-400 transition rounded-full cursor-pointer hover:text-gray-900 hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- RINGKASAN DETAIL -->
                <div class="bg-gray-50 p-5 rounded-[16px] border border-gray-100 space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-500">Merek Dagang:</span>
                        <strong class="font-bold text-right text-gray-900">{{ $project->nama_merek_dagang }}</strong>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-500">Konsultan Terpilih:</span>
                        <strong class="font-bold text-right text-[#195A36]" x-text="selectedConsultant?.nama || '-'"></strong>
                    </div>
                    <div class="flex items-center justify-between" x-show="selectedConsultant?.domisili">
                        <span class="font-medium text-gray-500">Domisili:</span>
                        <span class="font-semibold text-right text-gray-700" x-text="selectedConsultant?.domisili"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-500">Jarak Audit:</span>
                        <span class="font-semibold text-right text-gray-800" x-text="(selectedConsultant?.jarak || '-') + ' KM'"></span>
                    </div>
                    <div class="flex items-center justify-between pt-3 mt-3 border-t border-gray-200/60">
                        <span class="font-bold text-gray-500">Skor Net Flow (𝜙):</span>
                        <span class="font-mono text-sm font-bold"
                              :class="(selectedConsultant?.net_flow_raw >= 0) ? 'text-[#195A36]' : 'text-rose-600'"
                              x-text="(selectedConsultant?.net_flow_raw >= 0 ? '+' : '') + (selectedConsultant?.net_flow || '0.0000')">
                        </span>
                    </div>
                </div>

                <!-- FORM AKSI SUBMIT -->
                <form action="{{ route('admin.spk.tunjuk', $project->id) }}" method="POST" class="flex items-center gap-3 pt-2" x-data="{ submitting: false }" @submit="submitting = true">
                    @csrf
                    <input type="hidden" name="consultant_id" :value="selectedConsultant?.id">

                    <button type="button" @click="showModal = false" :disabled="submitting" class="w-1/2 py-3 text-sm font-semibold text-gray-700 transition bg-white border border-gray-200 rounded-full cursor-pointer hover:bg-gray-50 disabled:opacity-50">
                        Batal
                    </button>

                    <button type="submit" :disabled="submitting" class="w-1/2 py-3 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-sm font-bold transition shadow-md flex items-center justify-center gap-2 disabled:opacity-50 cursor-pointer">
                        <template x-if="!submitting">
                            <span>Ya, Tetapkan</span>
                        </template>
                        <template x-if="submitting">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4 text-white animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Memproses...</span>
                            </span>
                        </template>
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- AJAX CORE ENGINE (AMUAN REFACTORED LENGKAP & AMAN) -->
    <script type="text/javascript">
        let currentRankingData = [];

        document.addEventListener('DOMContentLoaded', function() {
            eksekusiPrometheeEngine();
        });

        function eksekusiPrometheeEngine() {
            const chartBox = document.getElementById('chart-container');
            const tableBox = document.getElementById('table-body');
            const matrixBox = document.getElementById('matrix-table-body');
            const flowsBox = document.getElementById('flows-table-body');
            const heroBox = document.getElementById('hero-recommendation');

            fetch(`/admin/proyek/{{ $project->id }}/spk/hitung-ajax`)
            .then(async res => {
                const responseData = await res.json();
                if (!res.ok) {
                    throw new Error(responseData.message || "Gagal mengambil data dari server.");
                }
                return responseData;
            })
            .then(response => {
                if (!response.success || response.data.length === 0) {
                    const emptyMsg = `<div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold rounded-[16px] text-center">
                        Butuh minimal 2 konsultan aktif untuk komputasi SPK.
                    </div>`;
                    chartBox.innerHTML = emptyMsg;
                    tableBox.innerHTML = `<tr><td colspan="4" class="py-6 font-medium text-center text-rose-600">Tidak ada data konsultan aktif.</td></tr>`;
                    return;
                }

                currentRankingData = response.data;
                const topRank = currentRankingData[0];

                // 1. RENDER HERO RECOMMENDATION CARD (RANK 1)
                heroBox.classList.remove('hidden');
                document.getElementById('hero-name').innerText = topRank.consultant.nama;
                document.getElementById('hero-desc').innerText = `Terpilih sebagai konsultan terbaik berdasarkan kalkulasi jarak spasial (${topRank.nilai_dinamis.jarak} KM), kesesuaian spesialisasi (${topRank.nilai_dinamis.spesialisasi}), serta performa kerja tertinggi.`;
                document.getElementById('hero-score').innerText = (topRank.net_flow >= 0 ? '+' : '') + topRank.net_flow;

                document.getElementById('hero-btn-assign').onclick = function() {
                    openPlottingModal(topRank.consultant.id, topRank.consultant.nama, topRank.nilai_dinamis.jarak, topRank.net_flow, topRank.consultant.domisili);
                };

                // 2. RENDER CHART (TOP 5)
                chartBox.innerHTML = '';
                currentRankingData.slice(0, 5).forEach((item, index) => {
                    const nama = item.consultant.nama;
                    const barWidth = Math.min(Math.max(((item.net_flow + 1) / 2) * 100, 5), 100);
                    const barColor = index === 0 ? 'bg-[#195A36]' : 'bg-gray-300';

                    const chartRow = document.createElement('div');
                    chartRow.className = "space-y-2";
                    chartRow.innerHTML = `
                        <div class="flex justify-between text-sm font-semibold text-gray-700">
                            <span>${index + 1}. ${nama}</span>
                            <span class="font-mono font-bold ${item.net_flow >= 0 ? 'text-[#195A36]' : 'text-rose-600'}">${item.net_flow >= 0 ? '+' : ''}${item.net_flow}</span>
                        </div>
                        <div class="w-full h-3 overflow-hidden border border-gray-100 rounded-full bg-gray-50">
                            <div class="${barColor} h-full rounded-full transition-all duration-700 ease-out" style="width: 0%"></div>
                        </div>
                    `;
                    chartBox.appendChild(chartRow);

                    setTimeout(() => {
                        const barEl = chartRow.querySelector('.h-full');
                        if (barEl) barEl.style.width = `${barWidth}%`;
                    }, 50);
                });

                // 3. RENDER TABEL UTAMA (SUMMARY)
                tableBox.innerHTML = '';
                currentRankingData.forEach((item, index) => {
                    const id = item.consultant.id;
                    const nama = item.consultant.nama;
                    const domisili = item.consultant.domisili;
                    const jarak = item.nilai_dinamis.jarak;
                    const netFlow = item.net_flow;

                    const row = document.createElement('tr');
                    row.className = "hover:bg-gray-50/50 transition group";

                    const rankLabel = index === 0
                        ? `<span class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold rounded-full bg-[#195A36] text-white shadow-sm">1</span>`
                        : `<span class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold text-gray-500 bg-gray-100 rounded-full">${index + 1}</span>`;

                    const btnBg = index === 0 ? 'bg-[#195A36] hover:bg-[#124227] text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50';

                    row.innerHTML = `
                        <td class="px-4 py-4 text-center">${rankLabel}</td>
                        <td class="px-4 py-4">
                            <strong class="block text-base font-semibold text-gray-900">${nama}</strong>
                            <span class="block mt-1 text-xs text-gray-500">Domisili: ${domisili} | Jarak Audit: <span class="font-semibold text-[#195A36]">${jarak} KM</span></span>
                        </td>
                        <td class="px-4 py-4 text-center font-bold text-sm font-mono ${netFlow >= 0 ? 'text-[#195A36]' : 'text-rose-600'}">
                            ${netFlow >= 0 ? '+' : ''}${netFlow}
                        </td>
                        <td class="px-4 py-4 text-right">
                            <button type="button"
                                    onclick="openPlottingModal('${id}', '${nama.replace(/'/g, "\\'")}', '${jarak}', '${netFlow}', '${domisili.replace(/'/g, "\\'")}')"
                                    class="px-5 py-2 text-xs font-semibold rounded-full shadow-sm transition cursor-pointer ${btnBg}">
                                Tugaskan
                            </button>
                        </td>
                    `;
                    tableBox.appendChild(row);
                });

                // 4. RENDER TABEL MATRIKS KEPUTUSAN (SAFE FALLBACK PROPER TANDA BINTANG)
                matrixBox.innerHTML = '';
                currentRankingData.forEach(item => {
                    const row = document.createElement('tr');
                    row.className = "hover:bg-gray-50/50 transition";
                    row.innerHTML = `
                        <td class="px-3 py-4 font-semibold text-gray-900">${item.consultant.nama}</td>
                        <td class="px-3 py-4 text-center">
                            <span class="px-3 py-1 text-[11px] rounded-full font-semibold ${item.nilai_dinamis.spesialisasi === 'Cocok' ? 'bg-[#e8f3ec] text-[#195A36]' : 'bg-gray-100 text-gray-500'}">
                                ${item.nilai_dinamis.spesialisasi}
                            </span>
                        </td>
                        <td class="px-3 py-4 font-mono font-semibold text-center text-gray-700">${item.consultant.spesialisasi ?? 'Umum'}</td>
                        <td class="px-3 py-4 font-mono font-semibold text-center text-gray-700">${item.consultant.sertifikasi_no ?? '-'}</td>
                        <td class="px-3 py-4 text-center font-bold text-[#195A36] font-mono">${item.nilai_dinamis.jarak} KM</td>
                        <td class="px-3 py-4 font-mono font-semibold text-center text-gray-700">${item.consultant.domisili ?? '-'}</td>
                        <td class="px-3 py-4 font-mono font-semibold text-center">
                            <span class="px-2.5 py-1 text-[10px] rounded-full font-bold bg-[#e8f3ec] text-[#195A36]">Tersedia</span>
                        </td>
                    `;
                    matrixBox.appendChild(row);
                });

                // 5. RENDER TABEL FLOWS
                flowsBox.innerHTML = '';
                currentRankingData.forEach(item => {
                    const row = document.createElement('tr');
                    row.className = "hover:bg-gray-50/50 transition";
                    row.innerHTML = `
                        <td class="px-4 py-4 font-semibold text-gray-900">${item.consultant.nama}</td>
                        <td class="px-4 py-4 font-mono font-semibold text-center text-[#195A36]">+${item.leaving_flow}</td>
                        <td class="px-4 py-4 font-mono font-semibold text-center text-rose-600">-${item.entering_flow}</td>
                        <td class="px-4 py-4 text-center font-mono font-bold ${item.net_flow >= 0 ? 'text-[#195A36]' : 'text-rose-600'}">${item.net_flow >= 0 ? '+' : ''}${item.net_flow}</td>
                    `;
                    flowsBox.appendChild(row);
                });

            })
            .catch(err => {
                const errorAlert = `<div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold rounded-[20px] space-y-1">
                    <p class="font-bold">Gagal Menghitung SPK:</p>
                    <p>${err.message}</p>
                </div>`;
                chartBox.innerHTML = errorAlert;
                tableBox.innerHTML = `<tr><td colspan="4" class="py-6 font-medium text-center text-rose-600">${err.message}</td></tr>`;
                matrixBox.innerHTML = `<tr><td colspan="7" class="py-6 font-medium text-center text-rose-600">${err.message}</td></tr>`;
                flowsBox.innerHTML = `<tr><td colspan="4" class="py-6 font-medium text-center text-rose-600">${err.message}</td></tr>`;
            });
        }

        function openPlottingModal(id, nama, jarak, net_flow, domisili = '') {
            const rawScore = parseFloat(net_flow);
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: {
                    id: id,
                    nama: nama,
                    jarak: jarak,
                    net_flow: net_flow,
                    domisili: domisili,
                    net_flow_raw: rawScore
                }
            }));
        }
    </script>

</x-app-layout>

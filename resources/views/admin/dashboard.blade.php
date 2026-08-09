<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER BAGIAN ATAS (Meniru gaya "Dashboard" di referensi) -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Dashboard</h1>
                <p class="mt-2 text-sm font-medium text-gray-500">Sistem SPK Active. Berikut adalah status terkini dari proses sertifikasi halal.</p>
            </div>
        </div>

        <!-- SISTEM KARTU STATISTIK -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

            <!-- Kartu 1: Total Pengajuan Aktif (Meniru Kartu Hijau "Total Projects") -->
            <div class="bg-[#195A36] rounded-[24px] p-6 shadow-md flex flex-col justify-between relative overflow-hidden transition-transform hover:-translate-y-1 duration-300">
                <div class="flex items-start justify-between">
                    <span class="text-sm font-medium tracking-wide text-white/90">Total Pengajuan Aktif</span>
                    <!-- Icon panah kanan atas -->
                    <div class="p-2 transition rounded-full cursor-pointer bg-white/20 backdrop-blur-sm hover:bg-white/30">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6">
                    <strong class="text-[40px] font-bold text-white block tracking-tight leading-none">
                        {{ number_format($totalPengajuanAktif) }}
                    </strong>
                    <!-- Badge keterangan (Meniru badge "Increased from last month") -->
                    <div class="inline-flex items-center gap-1.5 mt-4 text-white/90 text-xs bg-white/10 border border-white/20 px-2.5 py-1 rounded-md font-medium">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" /></svg>
                        Antrean aktif dalam sistem
                    </div>
                </div>
            </div>

            <!-- Kartu 2: Konsultan Terdaftar (Meniru Kartu Putih "Ended Projects") -->
            <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col justify-between transition-transform hover:-translate-y-1 duration-300">
                <div class="flex items-start justify-between">
                    <span class="text-sm font-medium tracking-wide text-gray-900">Konsultan Terdaftar</span>
                    <div class="p-2 transition bg-white border border-gray-200 rounded-full shadow-sm cursor-pointer hover:bg-gray-50">
                        <svg class="w-4 h-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6">
                    <strong class="text-[40px] font-bold text-gray-900 block tracking-tight leading-none">
                        {{ number_format($consultantsCount) }}
                    </strong>
                    <div class="inline-flex items-center gap-1.5 mt-4 text-gray-500 text-xs bg-gray-50 border border-gray-100 px-2.5 py-1 rounded-md font-medium">
                        <span class="h-2 w-2 rounded-full bg-[#195A36] animate-pulse"></span>
                        {{ $consultantsAvailable }} Aktif siap bertugas
                    </div>
                </div>
            </div>

            <!-- Kartu 3: Sertifikat Terbit (Meniru Kartu Putih "Running Projects") -->
            <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col justify-between transition-transform hover:-translate-y-1 duration-300">
                <div class="flex items-start justify-between">
                    <span class="text-sm font-medium tracking-wide text-gray-900">Sertifikat Terbit</span>
                    <div class="p-2 transition bg-white border border-gray-200 rounded-full shadow-sm cursor-pointer hover:bg-gray-50">
                        <svg class="w-4 h-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                        </svg>
                    </div>
                </div>
                <div class="mt-6">
                    <strong class="text-[40px] font-bold text-gray-900 block tracking-tight leading-none">
                        {{ number_format($sertifikatBulanIni) }}
                    </strong>
                    <div class="inline-flex items-center gap-1.5 mt-4 text-gray-500 text-xs bg-gray-50 border border-gray-100 px-2.5 py-1 rounded-md font-medium">
                        Bulan ini (Penyelesaian final)
                    </div>
                </div>
            </div>

        </div>

        <!-- TABEL AKTIVITAS TERBARU (Gaya Card-based yang lebih bersih) -->
        <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 mt-6">

            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold tracking-tight text-gray-900">Aktivitas Proyek Terbaru</h3>
                <button class="px-4 py-1.5 border border-gray-200 rounded-full text-xs font-semibold text-gray-600 hover:bg-gray-50 transition flex items-center gap-1">
                    <a href="{{ route('admin.spk.index') }}">Lihat Semua</a>
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left whitespace-nowrap">
                    <thead>
                        <tr class="font-medium text-gray-400 border-b border-gray-100">
                            <th class="pb-3 font-medium">Klien / Entitas</th>
                            <th class="pb-3 font-medium">Jenis Produk</th>
                            <th class="pb-3 font-medium">Status Proyek</th>
                            <th class="pb-3 font-medium">Waktu Pembaruan</th>
                            <th class="pb-3 font-medium text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentActivities as $act)
                            @php
                                $statusStr = $act->status_proyek?->value ?? $act->status_proyek;
                            @endphp
                            <tr class="transition-colors hover:bg-gray-50/50 group">
                                <td class="flex items-center gap-3 py-4">
                                    <div class="h-10 w-10 bg-[#e8f3ec] text-[#195A36] font-bold rounded-full flex items-center justify-center text-sm tracking-wider uppercase shrink-0">
                                        {{ strtoupper(substr($act->nama_merek_dagang, 0, 2)) }}
                                    </div>
                                    <div>
                                        <span class="block font-semibold text-gray-900">{{ $act->nama_merek_dagang }}</span>
                                        <span class="text-xs text-gray-500">{{ $act->klien->companyProfile->nama_perusahaan ?? 'Pelaku Usaha' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 font-medium text-gray-600">
                                    {{ $act->kategori_produk }}
                                </td>
                                <td class="py-4">
                                    <!-- Penyesuaian Badge Status agar terlihat membulat dan rapi -->
                                    @if($statusStr === 'payment_t1_verified')
                                        <span class="px-3 py-1 font-medium bg-amber-50 text-amber-700 rounded-full text-xs inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Siap Plotting
                                        </span>
                                    @elseif($statusStr === 'consultant_assigned')
                                        <span class="px-3 py-1 text-xs font-medium text-blue-700 rounded-full bg-blue-50">
                                            Konsultan Ditunjuk
                                        </span>
                                    @elseif($statusStr === 'completed')
                                        <span class="px-3 py-1 font-medium bg-green-50 text-[#195A36] rounded-full text-xs">
                                            Selesai / Lunas
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-medium text-gray-600 capitalize bg-gray-100 rounded-full">
                                            {{ str_replace('_', ' ', $statusStr) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 text-sm text-gray-500">
                                    {{ $act->updated_at->diffForHumans() }}
                                </td>
                                <td class="py-4 text-right">
                                    @if($statusStr === 'payment_t1_verified')
                                        <a href="{{ route('admin.spk.recommend', $act->id) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-semibold transition shadow-sm">
                                            Proses Plotting
                                        </a>
                                    @else
                                        <a href="{{ route('admin.spk.recommend', $act->id) }}" class="text-sm font-semibold text-gray-400 transition opacity-0 hover:text-gray-900 group-hover:opacity-100">
                                            Detail &rarr;
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-4 mb-3 text-gray-400 rounded-full bg-gray-50">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900">Belum Ada Aktivitas</p>
                                        <p class="max-w-sm mt-1 text-xs text-gray-500">Data antrean pengajuan yang terverifikasi akan muncul secara otomatis di sini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>

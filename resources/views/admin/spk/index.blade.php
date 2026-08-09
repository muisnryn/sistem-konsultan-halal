<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER HALAMAN -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Plotting Konsultan</h1>
                <p class="mt-2 text-sm font-medium text-gray-500">Antrean SPK aktif yang telah melunasi Termin 1 dan siap dialokasikan.</p>
            </div>
            <span class="px-4 py-1.5 bg-[#e8f3ec] text-[#195A36] border border-[#195A36]/20 rounded-full text-xs font-bold uppercase tracking-wide self-start sm:self-auto flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-[#195A36] animate-pulse"></span>
                Antrean Aktif
            </span>
        </div>

        <!-- ALERT / FLASH MESSAGE -->
        @if (session('success'))
            <div class="p-4 bg-[#e8f3ec] border border-[#195A36]/20 text-[#195A36] text-sm font-semibold rounded-[16px] flex items-center gap-3 shadow-sm animate-fade-in-down">
                <div class="p-1 bg-white rounded-full shadow-sm">
                    <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- TABEL KONTANER -->
        <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left whitespace-nowrap">
                    <thead>
                        <tr class="font-medium text-gray-400 border-b border-gray-100">
                            <th class="pb-3 font-medium">Nama Merek / Perusahaan</th>
                            <th class="pb-3 font-medium">Kategori Produk</th>
                            <th class="pb-3 font-medium">Skala Usaha</th>
                            <th class="pb-3 font-medium">Tanggal Masuk</th>
                            <th class="pb-3 font-medium text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($projects as $proj)
                            <tr class="transition-colors hover:bg-gray-50/50 group">
                                <td class="flex items-center gap-3 py-4">
                                    <div class="h-10 w-10 bg-[#e8f3ec] text-[#195A36] font-bold rounded-full flex items-center justify-center text-sm tracking-wider uppercase shrink-0">
                                        {{ strtoupper(substr($proj->nama_merek_dagang, 0, 2)) }}
                                    </div>
                                    <div>
                                        <span class="block font-semibold text-gray-900">{{ $proj->nama_merek_dagang }}</span>
                                        <span class="text-xs text-gray-500">{{ $proj->klien->companyProfile->nama_perusahaan ?? 'Pelaku Usaha' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 font-medium text-gray-600">
                                    {{ $proj->klien?->companyProfile?->jenis_kelompok_usaha ?? 'Makanan & Minuman' }}
                                </td>
                                <td class="py-4">
                                    <span class="px-3 py-1 text-xs font-medium text-gray-600 uppercase bg-gray-100 rounded-full">
                                        {{ $proj->klien?->companyProfile?->skala_perusahaan ?? 'Mikro' }}
                                    </span>
                                </td>
                                <td class="py-4 text-sm font-medium text-gray-500">
                                    {{ $proj->created_at->format('d M Y') }}
                                </td>
                                <td class="py-4 text-right">
                                    <a href="{{ route('admin.spk.recommend', $proj->id) }}"
                                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-semibold transition shadow-sm">
                                        <span>Proses SPK</span>
                                        <span>&rarr;</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="p-4 mb-3 text-gray-400 rounded-full bg-gray-50">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0 1 12 3m0 0c-1.135.094-1.976 1.057-1.976 2.192V16.5A2.25 2.25 0 0 0 12 18.75h.5m-3-13.312C10.046 5.308 10.05 5.253 10.05 5.2M9 4.108c-.469.04-.929.094-1.383.162A2.25 2.25 0 0 0 5.625 6.464v10.536A2.25 2.25 0 0 0 7.875 19.25h1.373" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900">Tidak Ada Antrean Plotting</p>
                                        <p class="max-w-sm mt-1 text-xs text-gray-500">Saat ini seluruh proyek yang melunasi Termin 1 telah dipasangkan dengan konsultan masing-masing.</p>
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

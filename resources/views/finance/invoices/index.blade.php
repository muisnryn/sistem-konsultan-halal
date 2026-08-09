<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER BAR (Sesuai Gaya Header Dashboard Admin) -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-semibold mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                    Invoice & Penawaran
                </div>
                <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Penerbitan Penawaran & Invoice</h1>
                <p class="mt-2 text-sm font-medium text-gray-500">Kelola verifikasi pengajuan biaya sertifikasi halal serta penerbitan invoice klien.</p>
            </div>
            <div class="px-4 py-2 bg-white border border-gray-100 rounded-full shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] text-xs font-medium text-gray-600 self-start sm:self-auto flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                <span>Total Menunggu: <strong class="font-bold text-gray-900">{{ number_format($projects->count()) }} Pengajuan</strong></span>
            </div>
        </div>

        <!-- TABEL PENERBITAN INVOICE (Rounded 24px Admin Style) -->
        <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="flex items-center gap-2 text-xs font-bold tracking-wider text-gray-900 uppercase">
                    <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm0 5.25h.007v.008H3.75V12zm0 5.25h.007v.008H3.75v-.008z" />
                    </svg>
                    <span>Daftar Antrean Penawaran Harga</span>
                </h3>
                <span class="text-xs font-medium text-gray-400">Menampilkan {{ $projects->count() }} data</span>
            </div>

            @if($projects->isEmpty())
                <div class="py-12 text-center">
                    <div class="p-4 mx-auto mb-3 text-gray-400 rounded-full bg-gray-50 w-fit">
                        <svg class="w-6 h-6 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Semua Pengajuan Telah Diverifikasi</p>
                    <p class="max-w-sm mx-auto mt-1 text-xs text-gray-500">Saat ini tidak ada antrean pengajuan baru yang membutuhkan penetapan penawaran harga maupun pembuatan invoice.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left whitespace-nowrap">
                        <thead>
                            <tr class="font-medium text-gray-400 border-b border-gray-100">
                                <th class="pb-3.5 font-medium">Merek & Perusahaan</th>
                                <th class="pb-3.5 font-medium">Kontak PIC Klien</th>
                                <th class="pb-3.5 font-medium text-center">Detail Operasional</th>
                                <th class="pb-3.5 font-medium text-center">Berkas Legalitas</th>
                                <th class="pb-3.5 font-medium text-right">Tindakan / Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($projects as $project)
                                @php
                                    $profile = $project->klien?->companyProfile ?? null;
                                    $waUrl = ($profile && method_exists($profile, 'generateWhatsAppUrl'))
                                        ? $profile->generateWhatsAppUrl($project->nama_merek_dagang)
                                        : '#';
                                    $namaPerusahaan = $profile->nama_perusahaan ?? 'Profil Perusahaan Belum Diset';
                                    $initials = strtoupper(substr($project->nama_merek_dagang ?? 'P', 0, 2));
                                @endphp
                                <tr class="transition-colors hover:bg-gray-50/50 group">
                                    <!-- Merek & Perusahaan -->
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 bg-[#e8f3ec] text-[#195A36] font-bold rounded-full flex items-center justify-center text-xs tracking-wider uppercase shrink-0">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <strong class="block text-sm font-semibold text-gray-900 group-hover:text-[#195A36] transition-colors">
                                                    {{ $project->nama_merek_dagang }}
                                                </strong>
                                                <span class="text-xs text-gray-500">{{ $namaPerusahaan }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Kontak PIC -->
                                    <td class="py-4">
                                        <div>
                                            <strong class="block text-xs font-semibold text-gray-900">
                                                {{ $profile->pic_nama ?? $project->klien?->name ?? '-' }}
                                            </strong>
                                            <span class="text-gray-500 text-[11px] flex items-center gap-1 mt-0.5">
                                                <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.826-1.47-5.114-3.758-6.584-6.584l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                                </svg>
                                                {{ $profile->pic_phone ?? '-' }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Detail Produk & Outlet -->
                                    <td class="py-4 text-center">
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium inline-flex items-center gap-1.5">
                                            <span>{{ $project->jumlah_produk }} Produk</span>
                                            <span class="text-gray-300">•</span>
                                            <span>{{ $project->jumlah_outlet }} Outlet</span>
                                        </span>
                                    </td>

                                    <!-- Berkas Legalitas -->
                                    <td class="py-4 text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            @if($profile && $profile->file_nib)
                                                <a href="{{ Storage::url($profile->file_nib) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-teal-800 transition border border-teal-100 rounded-full shadow-xs bg-teal-50 hover:bg-teal-100" title="Preview Berkas NIB">
                                                    <svg class="w-3.5 h-3.5 text-teal-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5-3h7.5M12 3v5.25" />
                                                    </svg>
                                                    <span>NIB</span>
                                                </a>
                                            @else
                                                <span class="px-3 py-1 text-xs font-medium text-gray-400 border border-gray-100 rounded-full bg-gray-50" title="NIB Belum Diunggah">
                                                    NIB -
                                                </span>
                                            @endif

                                            @if($profile && $profile->file_npwp)
                                                <a href="{{ Storage::url($profile->file_npwp) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-blue-800 transition border border-blue-100 rounded-full shadow-xs bg-blue-50 hover:bg-blue-100" title="Preview Berkas NPWP">
                                                    <svg class="w-3.5 h-3.5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5-3h7.5M12 3v5.25" />
                                                    </svg>
                                                    <span>NPWP</span>
                                                </a>
                                            @else
                                                <span class="px-3 py-1 text-xs font-medium text-gray-400 border border-gray-100 rounded-full bg-gray-50" title="NPWP Belum Diunggah">
                                                    NPWP -
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($waUrl !== '#')
                                                <a href="{{ $waUrl }}" target="_blank" class="px-3.5 py-1.5 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-semibold transition shadow-xs inline-flex items-center gap-1.5 shrink-0">
                                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                                                    </svg>
                                                    <span>WA Negosiasi</span>
                                                </a>
                                            @endif
                                            <a href="{{ route('finance.project.edit', $project->id) }}" class="px-3.5 py-1.5 bg-gray-900 hover:bg-gray-800 text-white rounded-full text-xs font-semibold transition shadow-xs inline-flex items-center gap-1.5 shrink-0">
                                                <svg class="w-3.5 h-3.5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                                <span>Proses Invoice</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

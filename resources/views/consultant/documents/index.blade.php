<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER BAR (Sesuai Gaya Header Dashboard Admin) -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-semibold mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                    Pemeriksaan Berkas
                </div>
                <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Daftar Proyek Validasi Dokumen</h1>
                <p class="mt-2 text-sm font-medium text-gray-500">Periksa dan berikan validasi terhadap dokumen SJPH yang telah diunggah oleh pelaku usaha.</p>
            </div>
            <div class="px-4 py-2 bg-white border border-gray-100 rounded-full shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] text-xs font-medium text-gray-600 self-start sm:self-auto">
                Total Proyek: <strong class="font-bold text-gray-900">{{ number_format($assignments->count()) }}</strong>
            </div>
        </div>

        <!-- TABEL LIST PROYEK (Kartu Rounded 24px Admin Style) -->
        <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6">
            @if($assignments->isEmpty())
                <div class="py-12 space-y-3 text-center">
                    <div class="p-4 mx-auto text-gray-400 rounded-full bg-gray-50 w-fit">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Belum Ada Dokumen untuk Divalidasi</p>
                    <p class="max-w-sm mx-auto text-xs text-gray-500">Belum ada dokumen proyek binaan yang perlu divalidasi saat ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left whitespace-nowrap">
                        <thead>
                            <tr class="font-medium text-gray-400 border-b border-gray-100">
                                <th class="pb-3.5 font-medium">Merek Dagang & Perusahaan</th>
                                <th class="pb-3.5 font-medium text-center">Status Dokumen Valid</th>
                                <th class="pb-3.5 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($assignments as $project)
                                @php
                                    $validDocs = $project->documents
                                        ->whereIn('jenis_dokumen', ['daftar_produk', 'daftar_bahan', 'daftar_fasilitas', 'sk_penyelia_halal', 'manual_sjph'])
                                        ->where('status_validasi', 'approved')
                                        ->count();
                                    $isCompleted = ($project->status_proyek === \App\Enums\ProjectStatus::COMPLETED);
                                    $namaPerusahaan = $project->klien->companyProfile->nama_perusahaan ?? $project->nama_merek_dagang;
                                    $initials = strtoupper(substr($namaPerusahaan, 0, 2));
                                @endphp
                                <tr class="transition-colors hover:bg-gray-50/50 group">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 bg-[#e8f3ec] text-[#195A36] font-bold rounded-full flex items-center justify-center text-xs tracking-wider uppercase shrink-0">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <strong class="block text-sm font-semibold text-gray-900">{{ $project->nama_merek_dagang }}</strong>
                                                <span class="text-xs text-gray-500">{{ $project->klien->companyProfile->nama_perusahaan ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center">
                                        @if($isCompleted)
                                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium inline-flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                                                Selesai (Read-Only)
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1.5 {{ $validDocs == 5 ? 'bg-green-50 text-[#195A36]' : 'bg-amber-50 text-amber-700' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $validDocs == 5 ? 'bg-[#195A36]' : 'bg-amber-500 animate-pulse' }}"></span>
                                                <strong class="font-mono">{{ $validDocs }} / 5</strong> Dokumen Disetujui
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-right">
                                        @if($isCompleted)
                                            <a href="{{ route('consultant.documents.validate', $project->id) }}"
                                               class="px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-full text-xs font-semibold transition inline-flex items-center gap-1.5 shadow-xs">
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span>Lihat Dokumen</span>
                                            </a>
                                        @else
                                            <a href="{{ route('consultant.documents.validate', $project->id) }}"
                                               class="px-4 py-2 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-semibold transition shadow-sm inline-flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                </svg>
                                                <span>Periksa Dokumen &rarr;</span>
                                            </a>
                                        @endif
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
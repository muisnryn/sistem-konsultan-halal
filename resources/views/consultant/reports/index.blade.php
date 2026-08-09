<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER BAR (Sesuai Gaya Header Dashboard Admin) -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-semibold mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                    Laporan Review Audit
                </div>
                <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Unggah Laporan Hasil Review</h1>
                <p class="mt-2 text-sm font-medium text-gray-500">Kelola dan unggah berkas Laporan Hasil Review Audit Halal untuk proyek binaan Anda.</p>
            </div>
            <div class="px-4 py-2 bg-white border border-gray-100 rounded-full shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] text-xs font-medium text-gray-600 self-start sm:self-auto">
                Total Proyek: <strong class="font-bold text-gray-900">{{ number_format($assignments->count()) }}</strong>
            </div>
        </div>

        <!-- NOTIFIKASI SUCCESS & ERROR -->
        @if(session('success'))
            <div class="flex items-center justify-between p-4 text-xs font-semibold border bg-emerald-50 border-emerald-200 text-emerald-800 rounded-2xl">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    {{ session('success') }}
                </span>
                <button type="button" onclick="this.parentElement.remove()" class="font-bold text-emerald-700 hover:text-emerald-900">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center justify-between p-4 text-xs font-semibold border bg-rose-50 border-rose-200 text-rose-800 rounded-2xl">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    {{ session('error') }}
                </span>
                <button type="button" onclick="this.parentElement.remove()" class="font-bold text-rose-700 hover:text-rose-900">✕</button>
            </div>
        @endif

        <!-- LIST KARTU PROYEK (Rounded 24px Admin Style) -->
        <div class="space-y-4">
            @forelse($assignments as $project)
                @php
                    $report = $project->documents->firstWhere('jenis_dokumen', 'laporan_hasil_review');
                    $isCompleted = ($project->status_proyek === \App\Enums\ProjectStatus::COMPLETED);
                    $namaPerusahaan = $project->klien->companyProfile->nama_perusahaan ?? $project->nama_merek_dagang;
                    $initials = strtoupper(substr($namaPerusahaan, 0, 2));
                @endphp

                <!-- Card Item -->
                <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 transition-all duration-300 hover:border-gray-200">

                    <!-- Left Info Section -->
                    <div class="flex items-start min-w-0 gap-4">
                        <div class="h-12 w-12 bg-[#e8f3ec] text-[#195A36] font-bold rounded-2xl flex items-center justify-center text-sm tracking-wider uppercase shrink-0">
                            {{ $initials }}
                        </div>
                        <div class="min-w-0 space-y-1">
                            <h3 class="text-base font-bold leading-snug text-gray-900 truncate">
                                {{ $project->nama_merek_dagang }}
                            </h3>
                            <p class="text-xs text-gray-500">
                                Perusahaan: <strong class="font-semibold text-gray-700">{{ $namaPerusahaan }}</strong>
                            </p>

                            <!-- Status Laporan / Link Download -->
                            <div class="pt-1">
                                @if($report)
                                    <a href="{{ route('consultant.documents.download', $report->id) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-[#195A36] hover:bg-green-100 rounded-full text-xs font-semibold transition border border-green-200/60">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                        <span>Lihat Laporan Audit (PDF)</span>
                                        <svg class="w-3 h-3 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                                    </a>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-rose-600 bg-rose-50 px-3 py-1 rounded-full border border-rose-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Belum ada Laporan Audit yang diunggah
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Form / Status Lock Section -->
                    <div class="pt-4 border-t border-gray-100 shrink-0 lg:pt-0 lg:border-t-0">
                        @if(!$isCompleted)
                            <form action="{{ route('consultant.documents.upload-audit', $project->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-stretch gap-2 sm:flex-row sm:items-center">
                                @csrf
                                <div class="relative">
                                    <input type="file"
                                           name="file_laporan"
                                           accept=".pdf"
                                           required
                                           class="text-xs text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#e8f3ec] file:text-[#195A36] hover:file:bg-[#d5e8dc] border border-gray-200 rounded-full p-1 bg-gray-50/50 shadow-xs focus:outline-none">
                                </div>
                                <button type="submit" class="px-5 py-2.5 text-xs font-semibold text-white transition shadow-sm bg-[#195A36] hover:bg-[#124227] rounded-full inline-flex items-center justify-center gap-1.5 cursor-pointer shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                                    <span>Unggah Laporan</span>
                                </button>
                            </form>
                        @else
                            <div class="px-4 py-2 bg-gray-50 border border-gray-100 text-gray-500 rounded-full text-xs font-semibold inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                                <span>Proyek Selesai (Laporan Terkunci)</span>
                            </div>
                        @endif
                    </div>

                </div>
            @empty
                <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-12 text-center">
                    <div class="p-4 mx-auto mb-3 text-gray-400 rounded-full bg-gray-50 w-fit">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Belum Ada Proyek Binaan</p>
                    <p class="max-w-sm mx-auto mt-1 text-xs text-gray-500">Belum ada proyek binaan yang membutuhkan unggah laporan audit saat ini.</p>
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
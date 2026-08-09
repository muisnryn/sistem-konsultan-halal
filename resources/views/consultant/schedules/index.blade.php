<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER BAR (Sesuai Gaya Header Dashboard Admin) -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-semibold mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                    Portal Konsultan
                </div>
                <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Penjadwalan Audit Halal</h1>
                <p class="mt-2 text-sm font-medium text-gray-500">Atur dan kelola tanggal pelaksanaan audit lapangan untuk setiap proyek binaan Anda.</p>
            </div>
            <div class="px-4 py-2 bg-white border border-gray-100 rounded-full shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] text-xs font-medium text-gray-600 self-start sm:self-auto flex items-center gap-2">
                <span>Total Penugasan: <strong class="font-bold text-gray-900">{{ number_format($assignments->count()) }}</strong></span>
                <span class="text-gray-300">•</span>
                <span>Sudah Dijadwalkan: <strong class="font-bold text-[#195A36]">{{ number_format($assignments->whereNotNull('tanggal_audit')->count()) }}</strong></span>
            </div>
        </div>

        <!-- NOTIFIKASI SUCCESS / ERROR -->
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

        <!-- TABEL LIST PROYEK (Kartu Rounded 24px Admin Style) -->
        <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6">
            @if($assignments->isEmpty())
                <div class="py-12 space-y-3 text-center">
                    <div class="p-4 mx-auto text-gray-400 rounded-full bg-gray-50 w-fit">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Belum Ada Proyek Binaan</p>
                    <p class="max-w-sm mx-auto text-xs text-gray-500">Belum ada proyek binaan yang ditugaskan kepada Anda saat ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left whitespace-nowrap">
                        <thead>
                            <tr class="font-medium text-gray-400 border-b border-gray-100">
                                <th class="pb-3.5 font-medium">Merek Dagang & Perusahaan</th>
                                <th class="pb-3.5 font-medium">Status Audit</th>
                                <th class="pb-3.5 font-medium">Tanggal Audit Ditetapkan</th>
                                <th class="pb-3.5 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($assignments as $project)
                                @php
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
                                    <td class="py-4">
                                        @if($isCompleted)
                                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium inline-flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                                                Selesai (Read-Only)
                                            </span>
                                        @elseif($project->tanggal_audit)
                                            <span class="px-3 py-1 bg-green-50 text-[#195A36] rounded-full text-xs font-medium inline-flex items-center gap-1.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                                                Terjadwal
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-medium inline-flex items-center gap-1.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                Belum Dijadwalkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 font-mono font-semibold">
                                        @if($project->tanggal_audit)
                                            <span class="inline-flex items-center gap-1.5 text-gray-900">
                                                <svg class="w-3.5 h-3.5 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                                {{ \Carbon\Carbon::parse($project->tanggal_audit)->translatedFormat('d M Y') }}
                                            </span>
                                        @else
                                            <span class="italic font-normal text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-right">
                                        @if($isCompleted)
                                            <span class="px-4 py-2 bg-gray-50 text-gray-400 rounded-full text-xs font-semibold inline-flex items-center gap-1.5 cursor-not-allowed border border-gray-100">
                                                Terkunci
                                            </span>
                                        @else
                                            <a href="{{ route('consultant.schedules.show', $project->id) }}"
                                               class="px-4 py-2 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-semibold transition shadow-sm inline-flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                                                <span>{{ $project->tanggal_audit ? 'Ubah Jadwal' : 'Atur Jadwal Audit' }}</span>
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
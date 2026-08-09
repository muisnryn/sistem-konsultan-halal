<x-app-layout>
    <div class="max-w-[1000px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        <!-- HEADER HALAMAN -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-black tracking-tight text-gray-900 sm:text-3xl">Evaluasi Kriteria</h1>
                <p class="mt-1 text-sm font-medium text-gray-500">Manajemen skor penilaian untuk <span class="text-[#195A36] font-bold">{{ $consultant->nama_konsultan }}</span></p>
            </div>
            <a href="{{ route('admin.consultant.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-full text-xs font-bold transition flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                Kembali
            </a>
        </div>

        <!-- NOTIFIKASI INFORMASI OTOMATIS (C1 & C4) -->
        <div class="p-5 bg-gradient-to-r from-[#e8f3ec]/60 via-white to-white border border-[#195A36]/20 rounded-[22px] flex items-start gap-4 text-gray-800 shadow-2xs">
            <div class="p-2.5 bg-[#195A36] text-white rounded-xl shrink-0 mt-0.5 shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="space-y-1">
                <h4 class="text-xs font-bold text-[#195A36] uppercase tracking-wider">Kalkulasi Otomatis Sistem SPK</h4>
                <p class="text-xs leading-relaxed text-gray-600">
                    Kriteria <strong class="font-semibold text-gray-900">C1 (Spesialisasi)</strong> dan <strong class="font-semibold text-gray-900">C4 (Jarak)</strong> dikalkulasi secara cerdas oleh sistem berdasarkan kategori industri dan titik koordinat (formula Haversine) pada profil konsultan. Input manual untuk kedua kriteria ini dinonaktifkan.
                </p>
            </div>
        </div>

        <form action="{{ route('admin.consultant.evaluations.update', $consultant->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- GRID KRITERIA -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach($criterias as $crit)
                    @php
                        $existingEval = $consultant->evaluations->where('criteria_id', $crit->id)->first();
                        $nilaiLama = $existingEval ? $existingEval->nilai : '';
                        $isAuto = in_array($crit->kode, ['C1', 'C4']);
                    @endphp

                    <div class="bg-white border {{ $isAuto ? 'border-gray-100' : 'border-gray-100' }} shadow-sm rounded-2xl p-5 flex flex-col justify-between gap-4 {{ $isAuto ? 'opacity-75' : '' }}">

                        <div class="flex items-start justify-between">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[10px] font-bold text-[#195A36] bg-[#e8f3ec] px-2 py-0.5 rounded uppercase">{{ $crit->kode }}</span>
                                    @if($isAuto)
                                        <span class="text-[9px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded uppercase">Auto</span>
                                    @endif
                                </div>
                                <h4 class="text-sm font-bold text-gray-900">{{ $crit->nama_kriteria }}</h4>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-[10px] text-gray-400 font-semibold uppercase truncate">
                                {{ str_replace('_', ' ', $crit->tipe_preferensi) }}
                            </span>

                            @if($isAuto)
                                <div class="px-4 py-2 font-mono text-xs text-gray-400 border border-gray-100 cursor-not-allowed bg-gray-50 rounded-xl">
                                    Calculated
                                </div>
                            @else
                                <input type="number"
                                       name="nilai_{{ $crit->id }}"
                                       value="{{ old('nilai_' . $crit->id, $nilaiLama) }}"
                                       step="any"
                                       class="w-24 px-4 py-2 bg-white border border-gray-200 rounded-xl font-mono text-sm font-bold text-gray-900 text-center outline-none focus:ring-2 focus:ring-[#195A36]/20 focus:border-[#195A36] transition"
                                       placeholder="0.0"
                                       required>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ACTION FOOTER -->
            <div class="flex justify-end pt-8">
                <button type="submit" class="px-8 py-3 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-bold transition shadow-md flex items-center gap-2">
                    <span>Simpan Data Evaluasi</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </button>
            </div>
        </form>

    </div>
</x-app-layout>

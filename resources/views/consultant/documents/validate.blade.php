<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        @php
            $isCompleted = ($project->status_proyek === \App\Enums\ProjectStatus::COMPLETED);
            $namaPerusahaan = $project->klien->companyProfile->nama_perusahaan ?? $project->nama_merek_dagang;
            $initials = strtoupper(substr($namaPerusahaan, 0, 2));
        @endphp

        <!-- TOMBOL KEMBALI KE DAFTAR DOKUMEN -->
        <div class="flex items-center justify-between">
            <a href="{{ route('consultant.documents.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-gray-700 transition bg-white border border-gray-200 rounded-full shadow-xs hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Daftar Dokumen</span>
            </a>
        </div>

        @if($isCompleted)
            <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl text-xs font-semibold flex items-center gap-2.5">
                <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                <span><strong>Proyek Telah Selesai:</strong> Halaman ini dalam mode Read-Only. Perubahan status dan catatan dokumen telah dikunci secara permanen.</span>
            </div>
        @endif

        <!-- NOTIFIKASI SUCCESS & ERROR -->
        @if(session('success'))
            <div class="flex items-center justify-between p-4 text-xs font-semibold border bg-emerald-50 border-emerald-200 text-emerald-800 rounded-2xl">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    {{ session('success') }}
                </span>
                <button type="button" onclick="this.parentElement.remove()" class="font-bold text-emerald-700 hover:text-emerald-900">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center justify-between p-4 text-xs font-semibold border bg-rose-50 border-rose-200 text-rose-800 rounded-2xl">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    {{ session('error') }}
                </span>
                <button type="button" onclick="this.parentElement.remove()" class="font-bold text-rose-700 hover:text-rose-900">✕</button>
            </div>
        @endif

        <!-- HERO CARD (DETAIL KLIEN) -->
        <div class="bg-white rounded-[24px] p-6 sm:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 space-y-6">

            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                <div class="flex items-center gap-4">
                    <div class="h-14 w-14 bg-[#e8f3ec] text-[#195A36] font-bold rounded-full flex items-center justify-center text-lg tracking-wider uppercase shrink-0">
                        {{ $initials }}
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                            {{ $namaPerusahaan }}
                        </h1>
                        <p class="flex flex-wrap items-center gap-2 mt-1 text-xs text-gray-500">
                            <span>ID Pengajuan: <strong class="font-mono font-semibold text-gray-700 bg-gray-100 px-2 py-0.5 rounded-md">HL-{{ date('Y') }}-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</strong></span>
                            <span class="text-gray-300">•</span>
                            <span>Kategori: <strong class="font-semibold text-gray-900">{{ $project->klien->companyProfile->jenis_kelompok_usaha ?? 'Makanan Olahan' }}</strong></span>
                        </p>
                    </div>
                </div>

                <div class="shrink-0">
                    <span class="px-4 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-100 rounded-full inline-flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                        {{ str_replace('_', ' ', is_object($project->status_proyek) ? $project->status_proyek->value : $project->status_proyek) }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 pt-5 text-xs border-t border-gray-100 md:grid-cols-3">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Kontak Person</span>
                    <strong class="block mt-1 text-sm font-semibold text-gray-900">{{ $project->klien->name ?? '-' }}</strong>
                    <span class="text-gray-500">{{ $project->klien->email ?? '-' }}</span>
                </div>

                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Lokasi Pabrik</span>
                    <strong class="block mt-1 text-sm font-semibold text-gray-900">
                        {{ $project->klien->companyProfile->alamat_pabrik ?? 'Lokasi Klien' }}
                    </strong>
                    <span class="text-gray-500">Jawa Barat, Indonesia</span>
                </div>

                @php
                    $approvedDocsCount = $project->documents
                        ->whereIn('jenis_dokumen', ['daftar_produk', 'daftar_bahan', 'daftar_fasilitas', 'sk_penyelia_halal', 'manual_sjph'])
                        ->where('status_validasi', 'approved')
                        ->count();
                    $progressPercent = min(100, round(($approvedDocsCount / 5) * 100));
                @endphp

                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Progres Sertifikasi</span>
                        <span class="text-xs font-bold text-[#195A36]">{{ $progressPercent }}%</span>
                    </div>
                    <div class="w-full h-2 mt-2 overflow-hidden bg-gray-100 rounded-full">
                        <div class="h-full transition-all duration-300 bg-[#195A36] rounded-full" style="width: {{ $progressPercent }}%"></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- NAVIGATION TAB BAR -->
        <div class="flex gap-8 pb-1 text-xs font-bold border-b border-gray-200">
            <a href="{{ route('consultant.documents.validate', $project->id) }}"
               class="pb-3 border-b-2 text-[#195A36] border-[#195A36]">
                Validasi Dokumen (5 SJPH)
            </a>
        </div>

        <!-- LIST DOKUMEN SJPH -->
        @php
            $docList = [
                'daftar_produk' => [
                    'title' => 'Daftar Produk & Merek Halal',
                    'badge' => 'Wajib',
                    'desc'  => 'Rincian seluruh nama produk dan kelompok produk yang diajukan.',
                ],
                'daftar_bahan' => [
                    'title' => 'Daftar Bahan & Komposisi Produk',
                    'badge' => 'Wajib',
                    'desc'  => 'Rincian seluruh bahan baku, BTP, dan bahan penolong beserta sertifikat halal bahan.',
                ],
                'daftar_fasilitas' => [
                    'title' => 'Daftar Fasilitas & Matriks Produksi',
                    'badge' => 'Wajib',
                    'desc'  => 'Daftar alamat pabrik, tempat penyimpanan, serta jalur produksi.',
                ],
                'sk_penyelia_halal' => [
                    'title' => 'SK & Sertifikat Penyelia Halal',
                    'badge' => 'Wajib',
                    'desc'  => 'Surat Keputusan penetapan Penyelia Halal internal perusahaan.',
                ],
                'manual_sjph' => [
                    'title' => 'Manual SJPH (Sistem Jaminan Produk Halal)',
                    'badge' => 'Wajib',
                    'desc'  => 'Dokumen panduan implementasi jaminan halal perusahaan.',
                ],
            ];
        @endphp

        <div class="space-y-6">
            @foreach($docList as $typeKey => $info)
                @php
                    $doc = $project->documents->firstWhere('jenis_dokumen', $typeKey);
                @endphp

                <!-- KARTU ELEMEN DOKUMEN (Rounded 24px Admin Style) -->
                <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 grid items-start grid-cols-1 gap-6 lg:grid-cols-12">

                    <!-- LEFT COLUMN (8/12) -->
                    <div class="space-y-4 lg:col-span-8">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 bg-[#e8f3ec] text-[#195A36] rounded-lg">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                </div>
                                <h3 class="text-sm font-bold text-gray-900">{{ $info['title'] }}</h3>
                                <span class="px-2 py-0.5 bg-rose-50 text-rose-600 border border-rose-100 rounded-full text-[10px] font-semibold">
                                    {{ $info['badge'] }}
                                </span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">{{ $info['desc'] }}</p>
                        </div>

                        <!-- FILE BOX -->
                        @if($doc)
                            <div class="p-3.5 bg-gray-50 border border-gray-100 rounded-2xl flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="flex items-center justify-center w-10 h-10 text-xs font-bold text-gray-700 uppercase bg-white border border-gray-200 shadow-xs rounded-xl shrink-0">
                                        {{ strtoupper(pathinfo($doc->file_path, PATHINFO_EXTENSION)) }}
                                    </div>
                                    <div class="truncate">
                                        <strong class="block text-xs font-semibold text-gray-900 truncate">
                                            {{ basename($doc->file_path) }}
                                        </strong>
                                        <span class="text-[10px] text-gray-400">
                                            Diunggah pada {{ $doc->updated_at->translatedFormat('d M Y, H:i') }}
                                        </span>
                                    </div>
                                </div>

                                <a href="{{ route('consultant.documents.download', $doc->id) }}"
                                   target="_blank"
                                   class="p-2 text-gray-600 transition bg-white border border-gray-200 rounded-full shadow-xs hover:bg-gray-100 shrink-0"
                                   title="Unduh File">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                </a>
                            </div>
                        @else
                            <div class="p-3.5 bg-rose-50/60 border border-rose-100 rounded-2xl text-xs text-rose-600 font-semibold flex items-center gap-2">
                                <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                                <span>Dokumen belum diunggah oleh Klien.</span>
                            </div>
                        @endif

                        <!-- FORM CATATAN AUDITOR -->
                        @if($doc)
                            <form id="form-doc-{{ $doc->id }}" action="{{ route('consultant.documents.update-status', $doc->id) }}" method="POST" class="space-y-1.5">
                                @csrf
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Catatan Auditor / Konsultan</label>
                                <textarea name="catatan_revisi_konsultan"
                                          rows="2"
                                          {{ $isCompleted ? 'disabled' : '' }}
                                          placeholder="Tambahkan catatan jika dokumen perlu perbaikan..."
                                          class="w-full p-3 text-xs font-medium rounded-xl border-gray-200 focus:border-[#195A36] focus:ring-[#195A36] text-gray-800 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed shadow-xs">{{ old('catatan_revisi_konsultan', $doc->catatan_revisi_konsultan) }}</textarea>
                            </form>
                        @endif
                    </div>

                    <!-- RIGHT COLUMN (4/12) -->
                    <div class="pt-2 space-y-3 lg:col-span-4 lg:border-l lg:border-gray-100 lg:pl-6 lg:pt-0">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Keputusan Validasi</span>

                        @if($doc)
                            @if($doc->status_validasi === 'approved')
                                <div class="p-3 space-y-1 text-center border border-green-100 bg-green-50 rounded-2xl">
                                    <span class="block text-xs font-bold uppercase text-[#195A36] flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                        Dokumen Disetujui
                                    </span>
                                    <span class="text-[10px] text-green-700 block">Diverifikasi oleh Konsultan</span>
                                </div>
                            @elseif($doc->status_validasi === 'rejected')
                                <div class="p-3 space-y-1 text-center border bg-rose-50 border-rose-100 rounded-2xl">
                                    <span class="flex items-center justify-center block gap-1 text-xs font-bold uppercase text-rose-800">
                                        <svg class="w-4 h-4 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                        Perlu Revisi
                                    </span>
                                    <span class="text-[10px] text-rose-600 block">Menunggu unggahan ulang Klien</span>
                                </div>
                            @endif

                            @if(!$isCompleted)
                                <div class="pt-1 space-y-2">
                                    <!-- BUTTON SETUJUI -->
                                    <button type="button"
                                            onclick="submitStatus('{{ $doc->id }}', 'approved')"
                                            class="w-full py-2.5 bg-[#195A36] hover:bg-[#124227] text-white font-semibold text-xs rounded-full transition shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                        <span>Setujui</span>
                                    </button>

                                    <!-- BUTTON TOLAK / REVISI -->
                                    <button type="button"
                                            onclick="submitStatus('{{ $doc->id }}', 'rejected')"
                                            class="w-full py-2.5 bg-white hover:bg-rose-50 text-rose-600 border border-rose-200 font-semibold text-xs rounded-full transition flex items-center justify-center gap-1.5 cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                        <span>Tolak / Revisi</span>
                                    </button>
                                </div>
                            @else
                                <div class="p-2.5 bg-gray-50 border border-gray-100 rounded-2xl text-center text-[11px] text-gray-500 font-semibold flex items-center justify-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                                    Validasi Terkunci
                                </div>
                            @endif
                        @else
                            <div class="p-3 text-xs font-medium text-center text-gray-400 border border-gray-100 bg-gray-50 rounded-2xl">
                                Menunggu Klien Mengunggah Berkas
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

    </div>

    <!-- JS HELPER UNTUK SUBMIT VALIDASI -->
    <script>
        function submitStatus(docId, status) {
            const form = document.getElementById('form-doc-' + docId);
            if (!form) return;

            let statusInput = form.querySelector('input[name="status_validasi"]');
            if (!statusInput) {
                statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status_validasi';
                form.appendChild(statusInput);
            }
            statusInput.value = status;

            const textarea = form.querySelector('textarea[name="catatan_revisi_konsultan"]');
            if (status === 'rejected' && (!textarea || !textarea.value.trim())) {
                alert('Silakan tuliskan Catatan Auditor terlebih dahulu mengenai kekurangan dokumen yang perlu direvisi.');
                if (textarea) textarea.focus();
                return;
            }

            form.submit();
        }
    </script>
</x-app-layout>
<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- BREADCRUMB & HEADER BAR -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-gray-100">
            <div>
                <nav class="text-xs font-semibold text-gray-400 mb-1.5 flex items-center gap-1.5">
                    <a href="{{ route('client.dashboard') }}" class="hover:text-[#195A36] transition">Dashboard</a>
                    <span>/</span>
                    <span class="font-bold text-gray-700">Dokumen Persyaratan</span>
                </nav>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl sm:text-[28px] font-bold text-gray-900 tracking-tight leading-none">Dokumen Persyaratan SJPH</h1>
                </div>
                <p class="text-xs text-gray-500 font-medium mt-1.5">Lengkapi 5 berkas Sistem Jaminan Produk Halal untuk diverifikasi dan divalidasi oleh Konsultan Pendamping Anda.</p>
            </div>

            @if($activeProject && $activeProject->konsultan)
                <div class="flex items-center gap-3 bg-[#e8f3ec] px-4 py-2.5 rounded-full border border-green-200/60 shrink-0">
                    <div class="w-8 h-8 bg-[#195A36] text-white font-bold rounded-full flex items-center justify-center text-xs uppercase shadow-xs">
                        {{ strtoupper(substr($activeProject->konsultan->nama_konsultan, 0, 2)) }}
                    </div>
                    <div>
                        <span class="text-[9px] text-[#195A36]/80 uppercase font-extrabold block tracking-wider">Konsultan Pendamping</span>
                        <strong class="text-xs text-[#195A36] block font-bold">{{ $activeProject->konsultan->nama_konsultan }}</strong>
                    </div>
                </div>
            @endif
        </div>

        <!-- ALERT SYSTEM -->
        @if (session('success'))
            <div class="p-4 bg-[#e8f3ec] border border-green-200/60 text-[#195A36] text-xs font-semibold rounded-[20px] flex items-center gap-2.5 shadow-xs">
                <svg class="h-4 w-4 text-[#195A36] shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200/80 text-rose-800 text-xs font-semibold rounded-[20px] flex items-center gap-2.5 shadow-xs">
                <svg class="h-4 w-4 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zM12 15.75h.007v.008H12v-.008z" /></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-200/80 text-rose-800 text-xs font-semibold rounded-[20px] space-y-1 shadow-xs">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center gap-1.5"><span>•</span> <span>{{ $error }}</span></p>
                @endforeach
            </div>
        @endif

        @php
            $currentStatus = $activeProject ? ($activeProject->status_proyek instanceof \App\Enums\ProjectStatus ? $activeProject->status_proyek->value : $activeProject->status_proyek) : null;
            $isConsultantAssigned = in_array($currentStatus, [
                'consultant_assigned', 'documents_valid', 'audit_completed', 'certificate_issued', 'waiting_payment_t2'
            ]);

            // Hitung statistik dokumen terunggah & tervalidasi
            $totalReqDocs = count($requiredDocs);
            $approvedDocsCount = $activeProject ? $activeProject->documents->where('status_validasi', 'approved')->count() : 0;
            $rejectedDocsCount = $activeProject ? $activeProject->documents->where('status_validasi', 'rejected')->count() : 0;
            $pendingDocsCount = $activeProject ? $activeProject->documents->where('status_validasi', 'pending')->count() : 0;
            $uploadedDocsCount = $activeProject ? $activeProject->documents->count() : 0;
            $progressPercent = $totalReqDocs > 0 ? min(100, round(($approvedDocsCount / $totalReqDocs) * 100)) : 0;
        @endphp

        <!-- GUARD BANNER: KONSULTAN BELUM DITUNJUK -->
        @if(!$activeProject || !$isConsultantAssigned)
            <div class="bg-amber-50/80 border border-amber-200/80 rounded-[24px] p-8 text-center space-y-3 shadow-xs">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-amber-100 text-amber-800 rounded-full">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div class="max-w-md mx-auto space-y-1">
                    <h3 class="text-sm font-bold text-amber-900">Penugasan Konsultan Sedang Diproses</h3>
                    <p class="text-xs text-amber-800/80 leading-relaxed font-medium">Fitur unggah dokumen persyaratan akan terbuka secara otomatis setelah Admin menetapkan Konsultan Pendamping Halal untuk proyek Anda.</p>
                </div>
            </div>
        @else

            <!-- WIDGET RINGKASAN PROGRES DOKUMEN -->
            <div class="p-6 bg-white rounded-[24px] border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                <div class="md:col-span-7 space-y-2">
                    <div class="flex items-center justify-between text-xs font-bold text-gray-900">
                        <span class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#195A36]"></span>
                            Progres Kelengkapan & Validasi
                        </span>
                        <span class="text-[#195A36] font-mono font-bold">{{ $approvedDocsCount }} dari {{ $totalReqDocs }} Disetujui ({{ $progressPercent }}%)</span>
                    </div>
                    <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-[#195A36] rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%;"></div>
                    </div>
                </div>

                <div class="md:col-span-5 flex flex-wrap items-center justify-start md:justify-end gap-2.5 text-xs font-semibold">
                    <div class="px-3 py-1.5 bg-[#e8f3ec] text-[#195A36] rounded-full text-[11px] font-bold">
                        ✓ {{ $approvedDocsCount }} Approved
                    </div>
                    @if($pendingDocsCount > 0)
                        <div class="px-3 py-1.5 bg-amber-50 text-amber-700 border border-amber-200/80 rounded-full text-[11px] font-bold">
                            ⏳ {{ $pendingDocsCount }} Menunggu
                        </div>
                    @endif
                    @if($rejectedDocsCount > 0)
                        <div class="px-3 py-1.5 bg-rose-50 text-rose-700 border border-rose-200/80 rounded-full text-[11px] font-bold">
                            ✕ {{ $rejectedDocsCount }} Revisi
                        </div>
                    @endif
                    <div class="px-3 py-1.5 bg-gray-100 text-gray-600 rounded-full text-[11px] font-bold">
                        📁 {{ $uploadedDocsCount }}/{{ $totalReqDocs }} Terunggah
                    </div>
                </div>
            </div>

            <!-- GRID DOKUMEN PERSYARATAN -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php $docIndex = 1; @endphp
                @foreach($requiredDocs as $docType => $info)
                    @php
                        $uploadedDoc = $activeProject->documents->firstWhere('jenis_dokumen', $docType);
                    @endphp

                    <div class="bg-white rounded-[24px] border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] p-6 flex flex-col justify-between space-y-5 hover:shadow-md transition">

                        <!-- DOKUMEN HEADER & BADGE -->
                        <div class="space-y-3">
                            <div class="flex justify-between items-start gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-[10px] font-bold shrink-0">
                                        0{{ $docIndex++ }}
                                    </span>
                                    <h3 class="text-xs font-bold text-gray-900 tracking-tight leading-snug">{{ $info['title'] }}</h3>
                                </div>

                                @if(!$uploadedDoc)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-[10px] font-bold uppercase shrink-0">Belum Ada</span>
                                @elseif($uploadedDoc->status_validasi === 'approved')
                                    <span class="px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase shrink-0">Approved ✓</span>
                                @elseif($uploadedDoc->status_validasi === 'rejected')
                                    <span class="px-3 py-1 bg-rose-50 text-rose-700 border border-rose-200/80 rounded-full text-[10px] font-bold uppercase shrink-0">Perlu Revisi ✕</span>
                                @else
                                    <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200/80 rounded-full text-[10px] font-bold uppercase shrink-0 animate-pulse">Menunggu</span>
                                @endif
                            </div>

                            <p class="text-[11px] text-gray-400 font-medium leading-relaxed">{{ $info['description'] }}</p>

                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 border border-gray-100 rounded-full text-[10px] font-semibold text-gray-600">
                                📌 Format Wajib: <span class="text-[#195A36] font-bold">{{ $info['format'] }}</span>
                            </div>
                        </div>

                        <!-- CATATAN REVISI KONSULTAN (JIKA REJECTED) -->
                        @if($uploadedDoc && $uploadedDoc->status_validasi === 'rejected' && $uploadedDoc->catatan_revisi_konsultan)
                            <div class="p-3.5 bg-rose-50/80 rounded-[16px] border border-rose-100 text-rose-900 text-xs space-y-1">
                                <div class="flex items-center gap-1 text-rose-800">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                                    <span class="font-bold uppercase text-[9px] tracking-wider">Catatan Revisi Konsultan:</span>
                                </div>
                                <p class="font-medium italic leading-relaxed text-[11px] text-rose-900/90">"{{ $uploadedDoc->catatan_revisi_konsultan }}"</p>
                            </div>
                        @endif

                        <!-- INFORMASI FILE TERUNGGAH -->
                        @if($uploadedDoc)
                            <div class="p-3.5 bg-gray-50 rounded-[16px] border border-gray-100 flex items-center justify-between text-xs">
                                <div class="truncate max-w-[180px]">
                                    <span class="text-[9px] text-gray-400 block font-bold uppercase">Berkas Terunggah:</span>
                                    <a href="{{ asset('storage/' . $uploadedDoc->file_path) }}" target="_blank" class="font-bold text-[#195A36] hover:underline truncate block text-[11px] flex items-center gap-1 mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-[#195A36] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                        <span>Lihat Dokumen</span>
                                    </a>
                                </div>
                                <span class="text-[10px] text-gray-400 shrink-0 font-mono font-medium">{{ $uploadedDoc->updated_at->diffForHumans() }}</span>
                            </div>
                        @endif

                        <!-- FORM UNGGAH FILE -->
                        <form action="{{ route('client.documents.store') }}" method="POST" enctype="multipart/form-data" class="pt-3 border-t border-gray-100 space-y-2">
                            @csrf
                            <input type="hidden" name="jenis_dokumen" value="{{ $docType }}">

                            <div class="flex items-center gap-2">
                                <input type="file" name="file" accept="{{ $info['accept'] }}" required
                                    class="block w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-[#e8f3ec] file:text-[#195A36] hover:file:bg-green-100 transition cursor-pointer">
                                <button type="submit" class="px-4 py-2 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-bold transition shrink-0 shadow-xs cursor-pointer">
                                    {{ $uploadedDoc ? 'Ganti' : 'Unggah' }}
                                </button>
                            </div>
                        </form>

                    </div>
                @endforeach
            </div>

        @endif

    </div>
</x-app-layout>

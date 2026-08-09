<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- BREADCRUMB & HEADER BAR -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-gray-100">
            <div>
                <nav class="text-xs font-semibold text-gray-400 mb-1.5 flex items-center gap-1.5">
                    <a href="{{ route('client.dashboard') }}" class="hover:text-[#195A36] transition">Dashboard</a>
                    <span>/</span>
                    <span class="font-bold text-gray-700">Sertifikat Halal</span>
                </nav>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl sm:text-[28px] font-bold text-gray-900 tracking-tight leading-none">Dokumen Sertifikat Halal</h1>
                </div>
                <p class="text-xs text-gray-500 font-medium mt-1.5">Unduh dan kelola dokumen sertifikat halal resmi digital yang telah diterbitkan oleh BPJPH.</p>
            </div>

            @if(isset($activeProject) && $activeProject && $isAvailable)
                <div class="flex items-center gap-2">
                    <span class="px-3.5 py-1.5 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-bold uppercase tracking-wide flex items-center gap-2 shrink-0">
                        <span class="w-2 h-2 rounded-full bg-[#195A36]"></span>
                        <span>Terverifikasi BPJPH & LPPOM</span>
                    </span>
                </div>
            @endif
        </div>

        @if(!$isAvailable)
            <!-- STATE JIKA BELUM ADA SERTIFIKAT TERBIT / BELUM LUNAS -->
            <div class="p-8 sm:p-12 space-y-5 text-center bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-amber-50 text-amber-700 rounded-full border border-amber-200/80">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <div class="max-w-md mx-auto space-y-1.5">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900">Sertifikat Halal Belum Tersedia</h3>
                    <p class="text-xs font-medium leading-relaxed text-gray-500">
                        Sertifikat Halal resmi akan tampil di sini setelah seluruh tahapan audit selesai, sertifikat diunggah oleh Admin, dan pelunasan Termin 2 terkonfirmasi.
                    </p>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                    <a href="{{ route('client.certification.status') }}" class="px-6 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200/80 text-xs font-bold rounded-full transition flex items-center gap-2 shadow-xs">
                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-1-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                        </svg>
                        <span>Cek Status Sertifikasi</span>
                    </a>
                    <a href="{{ route('client.payment.index') }}" class="px-6 py-2.5 bg-[#195A36] hover:bg-[#124227] text-white text-xs font-bold rounded-full shadow-xs transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                        </svg>
                        <span>Lihat Tagihan Pembayaran</span>
                    </a>
                </div>
            </div>
        @else
            <!-- BANNER UCAPAN SELAMAT TERBIT -->
            <div class="p-8 sm:p-10 space-y-4 text-center bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                <div class="flex items-center justify-center mx-auto text-white shadow-md w-14 h-14 bg-[#195A36] rounded-full shadow-[#195A36]/20">
                    <svg class="w-7 h-7 stroke-[2.2]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                </div>
                <div class="max-w-2xl mx-auto space-y-1.5">
                    <h1 class="text-2xl font-bold tracking-tight sm:text-3xl text-gray-900">
                        Selamat! Sertifikat Halal Anda Telah Terbit
                    </h1>
                    <p class="text-xs font-medium leading-relaxed sm:text-sm text-gray-500">
                        Proses sertifikasi produk Anda telah selesai dengan verifikasi penuh. Sertifikat kini tersedia untuk diunduh dan digunakan untuk keperluan komersial.
                    </p>
                </div>

                <!-- DROPDOWN MULTI-SERTIFIKAT (JIKA MEMILIKI LEBIH DARI 1 SERTIFIKAT TERBIT) -->
                @if(isset($completedProjects) && $completedProjects->count() > 1)
                    <div class="max-w-md pt-2 mx-auto">
                        <form method="GET" action="{{ route('client.certificate.index') }}" class="flex items-center gap-2 p-2 bg-gray-50/80 rounded-full border border-gray-200/80">
                            <label for="project_id" class="pl-3 text-xs font-bold text-gray-700 shrink-0">Pilih Merek:</label>
                            <select name="project_id" id="project_id" onchange="this.form.submit()" class="w-full text-xs font-bold text-gray-800 bg-white border border-gray-200 rounded-full px-4 py-2 outline-none focus:ring-[#195A36] focus:border-[#195A36] transition cursor-pointer">
                                @foreach($completedProjects as $p)
                                    <option value="{{ $p->id }}" {{ $activeProject->id == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_merek_dagang }} ({{ $p->kode_registrasi }})
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                @endif
            </div>

            <!-- MAIN LAYOUT GRID (2 COLUMNS) -->
            <div class="grid items-start grid-cols-1 gap-6 lg:grid-cols-12">

                <!-- PANEL KIRI (8/12): PRATINJAU SERTIFIKAT PDF -->
                <div class="p-6 space-y-4 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] lg:col-span-8 rounded-[24px]">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xs font-bold tracking-wider uppercase text-gray-900">Pratinjau Sertifikat PDF</h3>
                        </div>
                        <a href="{{ route('client.certificate.preview', ['project_id' => $activeProject->id]) }}" target="_blank" class="px-4 py-2 bg-gray-50 hover:bg-[#e8f3ec] text-gray-700 hover:text-[#195A36] border border-gray-200/80 hover:border-green-200 rounded-full text-xs font-bold transition flex items-center gap-2 shadow-xs">
                            <span>Layar Penuh</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </a>
                    </div>

                    <!-- CONTAINER PREVIEW IFRAME PDF -->
                    <div class="w-full h-[600px] bg-gray-100 rounded-[20px] overflow-hidden border border-gray-100 shadow-inner">
                        <iframe src="{{ route('client.certificate.preview', ['project_id' => $activeProject->id]) }}"
                                class="w-full h-full border-0"
                                title="Pratinjau Sertifikat Halal">
                        </iframe>
                    </div>
                </div>

                <!-- PANEL KANAN (4/12): DETAIL SERTIFIKASI SPESIFIK & UNDUH -->
                <div class="space-y-6 lg:col-span-4 lg:sticky lg:top-6">

                    <!-- CARD DETAIL SERTIFIKASI SPESIFIK -->
                    <div class="p-6 space-y-4 bg-white border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] rounded-[24px]">
                        <div class="flex items-center gap-2.5 pb-3 border-b border-gray-100">
                            <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <h3 class="text-xs font-bold tracking-wider uppercase text-gray-900">Detail Spesifikasi</h3>
                        </div>

                        <div class="space-y-3 text-xs font-semibold">
                            <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                                <span class="text-gray-400">No. Registrasi</span>
                                <strong class="font-mono text-xs font-bold text-[#195A36]">#{{ $activeProject->kode_registrasi }}</strong>
                            </div>
                            <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                                <span class="text-gray-400">Merek Dagang</span>
                                <strong class="font-bold text-gray-900 text-right truncate max-w-[160px]">{{ $activeProject->nama_merek_dagang }}</strong>
                            </div>
                            <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                                <span class="text-gray-400">Jenis Pengajuan</span>
                                <strong class="font-bold capitalize text-gray-900">
                                    {{ ucfirst($activeProject->jenis_pengajuan->value ?? (string)$activeProject->jenis_pengajuan) }}
                                </strong>
                            </div>
                            <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                                <span class="text-gray-400">Paket & Skala</span>
                                <strong class="font-bold text-gray-900">{{ $activeProject->nama_paket }}</strong>
                            </div>
                            <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                                <span class="text-gray-400">Kapasitas Produk</span>
                                <strong class="font-bold text-gray-900">{{ $activeProject->jumlah_produk }} Item Produk</strong>
                            </div>
                            <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                                <span class="text-gray-400">Fasilitas Produksi</span>
                                <strong class="font-bold text-gray-900">{{ $activeProject->jumlah_outlet }} Outlet / Pabrik</strong>
                            </div>
                            <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                                <span class="text-gray-400">Wilayah Operasional</span>
                                <strong class="font-bold text-gray-900">
                                    {{ $activeProject->is_luar_jabodetabek ? 'Luar JABODETABEK' : 'JABODETABEK' }}
                                </strong>
                            </div>
                            <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                                <span class="text-gray-400">Konsultan</span>
                                <strong class="font-bold text-gray-900">{{ $activeProject->konsultan?->nama_konsultan ?? 'Tim Konsultan KHI' }}</strong>
                            </div>
                            <div class="flex items-center justify-between pb-2 border-b border-gray-50">
                                <span class="text-gray-400">Tanggal Terbit</span>
                                <strong class="font-bold text-gray-900">
                                    {{ $certDoc ? $certDoc->created_at->translatedFormat('d F Y') : '-' }}
                                </strong>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400">Masa Berlaku</span>
                                <span class="px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full font-bold text-[10px] uppercase">
                                    Seumur Hidup
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- TOMBOL UNDUH SERTIFIKAT (PDF) -->
                    <div class="space-y-4">
                        <a href="{{ route('client.certificate.download', ['project_id' => $activeProject->id]) }}"
                           class="w-full py-3.5 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-bold shadow-xs transition flex items-center justify-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            <span>Unduh Sertifikat Halal (PDF)</span>
                        </a>

                        <!-- NOTE CATATAN FOOTER REGULASI LPPOM -->
                        <div class="p-4 bg-sky-50/80 border border-sky-100 rounded-[20px] flex items-start gap-2.5 text-[11px] text-sky-900 leading-relaxed font-medium">
                            <div class="w-5 h-5 bg-sky-100 text-sky-700 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </div>
                            <p>
                                Sesuai regulasi UU Halal & BPJPH/LPPOM terbaru, Sertifikat Halal berlaku <strong>Seumur Hidup</strong> selama tidak terdapat perubahan bahan baku atau proses produksi.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        @endif

    </div>
</x-app-layout>

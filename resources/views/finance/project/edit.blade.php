<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        @php
            $company = $project->klien?->companyProfile;
            $waUrl = ($company && method_exists($company, 'generateWhatsAppUrl'))
                ? $company->generateWhatsAppUrl($project->nama_merek_dagang)
                : '#';
            $namaPerusahaan = $company?->nama_perusahaan ?? 'Profil Belum Lengkap';
        @endphp

        <!-- HEADER BAR (Sesuai Gaya Header Dashboard Admin) -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('finance.invoices.index') }}"
                   class="p-2 text-gray-600 transition bg-white border border-gray-200 rounded-full shadow-xs hover:bg-gray-50"
                   title="Kembali ke Daftar Invoices">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </a>
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-semibold mb-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                        Divisi Keuangan
                    </div>
                    <h1 class="text-2xl sm:text-[28px] font-bold text-gray-900 tracking-tight leading-none">
                        Proses Penawaran & Invoice
                    </h1>
                    <p class="mt-1 text-xs font-medium text-gray-500">
                        Kode Registrasi: <strong class="font-mono text-gray-800 bg-gray-100 px-2 py-0.5 rounded-md">{{ $project->kode_registrasi }}</strong>
                    </p>
                </div>
            </div>

            <!-- BADGE STATUS & QUICK WA -->
            <div class="flex items-center self-start gap-2 sm:self-auto">
                @if($waUrl !== '#')
                    <a href="{{ $waUrl }}"
                       target="_blank"
                       class="px-4 py-2 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-semibold transition shadow-sm inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Negosiasi via WA</span>
                    </a>
                @endif
                <span class="px-3.5 py-2 bg-amber-50 text-amber-700 border border-amber-100 rounded-full text-xs font-semibold inline-flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                    Menunggu Penawaran
                </span>
            </div>
        </div>

        <!-- MAIN CONTENT GRID -->
        <div class="grid items-start grid-cols-1 gap-6 lg:grid-cols-12">

            <!-- KOLOM KIRI: RINGKASAN DATA OPERASIONAL KLIEN (7/12) -->
            <div class="space-y-6 lg:col-span-7">

                <!-- KARTU 1: PARAMETER USAHA -->
                <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 space-y-5">
                    <h3 class="flex items-center gap-2 pb-3 text-xs font-bold tracking-wider text-gray-900 uppercase border-b border-gray-100">
                        <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Ringkasan Parameter Usaha Klien</span>
                    </h3>

                    <div class="grid grid-cols-1 gap-4 text-xs sm:grid-cols-2">
                        <div class="bg-gray-50/60 p-3.5 rounded-2xl border border-gray-100/80 space-y-1">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Nama Perusahaan</span>
                            <strong class="block text-xs font-semibold text-gray-900">{{ $namaPerusahaan }}</strong>
                        </div>

                        <div class="bg-gray-50/60 p-3.5 rounded-2xl border border-gray-100/80 space-y-1">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Skala Usaha</span>
                            <span class="px-2.5 py-0.5 bg-gray-200/70 text-gray-800 rounded-full text-[10px] font-semibold uppercase inline-block mt-0.5">
                                {{ $company?->skala_perusahaan ?? '-' }}
                            </span>
                        </div>

                        <div class="bg-gray-50/60 p-3.5 rounded-2xl border border-gray-100/80 space-y-1">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Merek Dagang</span>
                            <strong class="text-[#195A36] font-semibold block text-xs">{{ $project->nama_merek_dagang }}</strong>
                        </div>

                        <div class="bg-gray-50/60 p-3.5 rounded-2xl border border-gray-100/80 space-y-1">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Tipe Pengajuan</span>
                            <strong class="block text-xs font-semibold text-gray-900 capitalize">
                                {{ is_object($project->jenis_pengajuan) ? $project->jenis_pengajuan->value : ucfirst($project->jenis_pengajuan) }}
                            </strong>
                        </div>

                        <div class="bg-gray-50/60 p-3.5 rounded-2xl border border-gray-100/80 space-y-1">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Volume Operasional</span>
                            <strong class="block text-xs font-semibold text-gray-900">
                                {{ $project->jumlah_produk }} Produk — {{ $project->jumlah_outlet }} Outlet
                            </strong>
                        </div>

                        <div class="bg-gray-50/60 p-3.5 rounded-2xl border border-gray-100/80 space-y-1">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Lokasi Wilayah</span>
                            <strong class="block text-xs font-semibold text-gray-900">
                                {{ $project->is_luar_jabodetabek ? 'Luar Jabodetabek' : 'Dalam Jabodetabek' }}
                            </strong>
                        </div>

                        <div class="sm:col-span-2 bg-gray-50/60 p-3.5 rounded-2xl border border-gray-100/80 space-y-1">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Kontak PIC Penanggung Jawab</span>
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                <strong class="text-xs font-semibold text-gray-900">
                                    {{ $company?->pic_nama ?? $project->klien->name }}
                                    @if($company?->pic_phone) ({{ $company->pic_phone }}) @endif
                                </strong>
                                <span class="text-gray-500 font-medium text-[11px]">{{ $company?->pic_email ?? $project->klien->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KARTU 2: ESTIMASI AUTO-KALKULATOR SISTEM -->
                <div class="bg-gray-900 text-white rounded-[24px] p-6 shadow-sm space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-800">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#e8f3ec] flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm3-6h.008v.008H11.25V9.75zm0 2.25h.008v.008H11.25V12zm0 2.25h.008v.008H11.25v-.008zm3-6h.008v.008H14.25V9.75zm0 2.25h.008v.008H14.25V12zm0 2.25h.008v.008H14.25v-.008zM6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                            </svg>
                            Kalkulasi Acuan Standar Sistem
                        </span>
                        <span class="text-[10px] text-gray-400 font-medium">Internal Reference</span>
                    </div>
                    <div class="flex flex-col gap-1 pt-1 sm:flex-row sm:items-center sm:justify-between">
                        <span class="text-xs text-gray-300">Estimasi Biaya Standar Sistem:</span>
                        <strong class="text-xl font-bold text-[#e8f3ec] font-mono">Rp {{ number_format($estimasiSistem, 0, ',', '.') }}</strong>
                    </div>
                    <p class="text-[11px] text-gray-400 leading-relaxed italic border-t border-gray-800/80 pt-3">
                        *Nilai ini dihitung otomatis oleh sistem berdasarkan skala usaha, jumlah produk, dan outlet sebagai acuan awal sebelum kesepakatan final.
                    </p>
                </div>

            </div>

            <!-- KOLOM KANAN: FORM INPUT HARGA KESEPAKATAN & PENAWARAN (5/12) -->
            <div class="space-y-6 lg:col-span-5">
                <div class="bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 space-y-5">
                    <h3 class="flex items-center gap-2 pb-3 text-xs font-bold tracking-wider text-gray-900 uppercase border-b border-gray-100">
                        <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Form Kunci Harga & Terbit Invoice</span>
                    </h3>

                    <form action="{{ route('finance.project.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <!-- INPUT NOMINAL KESEPAKATAN -->
                        <div>
                            <label class="block mb-1 text-xs font-bold text-gray-700">
                                Nilai Kesepakatan Harga Final (Rp) <span class="text-rose-500">*</span>
                            </label>
                            <p class="text-[11px] text-gray-400 mb-2">Total nilai kontrak bersih hasil negosiasi akhir dengan Klien.</p>

                            <div class="relative shadow-xs rounded-xl">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                    <span class="text-xs font-bold text-gray-400">Rp</span>
                                </div>
                                <input type="number"
                                       id="total_harga_kesepakatan"
                                       name="total_harga_kesepakatan"
                                       value="{{ old('total_harga_kesepakatan', $estimasiSistem) }}"
                                       required
                                       oninput="updateTerminBreakdown()"
                                       class="w-full pl-10 pr-3.5 py-2.5 bg-gray-50/50 border border-gray-200 rounded-xl text-xs font-bold text-[#195A36] focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] outline-none transition"
                                       placeholder="0"
                                       min="100000">
                            </div>
                            @error('total_harga_kesepakatan') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- LIVE PREVIEW TERMIN 1 & TERMIN 2 -->
                        <div class="p-4 bg-gray-50/80 border border-gray-100 rounded-2xl space-y-2.5 text-xs">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Preview Skema Invoice Termin</span>
                            <div class="flex items-center justify-between text-gray-700">
                                <span class="font-medium">Termin 1 (60% Diterbitkan Sekarang):</span>
                                <strong id="preview_t1" class="font-mono font-bold text-[#195A36]">Rp 0</strong>
                            </div>
                            <div class="flex items-center justify-between text-gray-500">
                                <span class="font-medium">Termin 2 (40% Pasca Audit):</span>
                                <strong id="preview_t2" class="font-mono font-bold text-gray-700">Rp 0</strong>
                            </div>
                        </div>

                        <!-- UPLOAD DOKUMEN PENAWARAN -->
                        <div>
                            <label class="block mb-1 text-xs font-bold text-gray-700">
                                Upload Berkas Penawaran Resmi (PDF Max 2MB) <span class="text-rose-500">*</span>
                            </label>
                            <p class="text-[11px] text-gray-400 mb-2">Unggah surat penawaran resmi / berita acara kesepakatan.</p>

                            <input type="file"
                                   name="file_dokumen_penawaran"
                                   accept="application/pdf"
                                   {{ $project->file_dokumen_penawaran ? '' : 'required' }}
                                   class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#e8f3ec] file:text-[#195A36] hover:file:bg-[#d5e8dc] border border-gray-200 rounded-full p-1 bg-gray-50/50 shadow-xs focus:outline-none">

                            @if($project->file_dokumen_penawaran)
                                <div class="mt-2.5 p-3 bg-green-50 border border-green-100 rounded-2xl flex items-center justify-between text-xs font-semibold text-[#195A36]">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg> Dokumen Penawaran Tersimpan
                                    </span>
                                    <a href="{{ Storage::url($project->file_dokumen_penawaran) }}"
                                       target="_blank"
                                       class="underline hover:text-[#124227] inline-flex items-center gap-1">
                                        <span>Lihat PDF</span>
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                                    </a>
                                </div>
                            @endif
                            @error('file_dokumen_penawaran') <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- BUTTONS ACTION -->
                        <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-gray-100">
                            <a href="{{ route('finance.invoices.index') }}"
                               class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold text-xs rounded-full transition">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-6 py-2.5 bg-[#195A36] hover:bg-[#124227] text-white font-semibold text-xs rounded-full shadow-sm transition flex items-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                <span>Terbitkan Invoice</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- SCRIPT KALKULASI LIVE TERMIN -->
    <script>
        function updateTerminBreakdown() {
            const inputVal = parseFloat(document.getElementById('total_harga_kesepakatan').value) || 0;
            const t1 = Math.round(inputVal * 0.60);
            const t2 = Math.round(inputVal * 0.40);

            document.getElementById('preview_t1').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(t1);
            document.getElementById('preview_t2').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(t2);
        }

        document.addEventListener('DOMContentLoaded', updateTerminBreakdown);
    </script>
</x-app-layout>
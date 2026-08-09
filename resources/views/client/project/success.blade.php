<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

        <!-- KARTU UTAMA SUKSES (COMPACT & MODERN) -->
        <div class="bg-white rounded-[24px] border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] p-6 sm:p-8 text-center space-y-6 relative overflow-hidden">

            <!-- HEADER: IKON + BADGE + JUDUL -->
            <div class="space-y-4">
                <div class="flex items-center justify-center">
                    <div class="w-14 h-14 bg-[#e8f3ec] text-[#195A36] rounded-full flex items-center justify-center shrink-0 shadow-xs">
                        <svg class="w-7 h-7 stroke-[2.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 px-3.5 py-1 rounded-full border border-amber-200/80 text-[10px] font-bold uppercase tracking-wider animate-pulse">
                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Menunggu Tinjauan Admin & Invoice</span>
                </div>

                <div class="space-y-1.5">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight">
                        Pengajuan Berhasil Dikirim!
                    </h1>
                    <p class="text-xs text-gray-500 leading-relaxed font-medium max-w-md mx-auto">
                        Pengajuan pendampingan Anda telah diterima. Admin sedang melakukan verifikasi awal dan menyiapkan invoice resmi.
                    </p>
                </div>
            </div>

            <!-- RINGKASAN DATA PENGAJUAN (4 KOLOM HORISONTAL RINGKAS) -->
            <div class="bg-gray-50/80 rounded-[20px] p-4 sm:p-5 border border-gray-100 text-left space-y-3">
                <div class="flex items-center justify-between pb-3 border-b border-gray-200/60">
                    <div>
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider block">ID Registrasi</span>
                        <strong class="text-xs font-bold font-mono text-[#195A36]">#{{ $activeProject->kode_registrasi }}</strong>
                    </div>
                    <span class="px-3 py-1 bg-white border border-gray-200/80 text-gray-600 rounded-full text-[10px] font-mono font-medium shadow-2xs">
                        {{ $activeProject->created_at ? $activeProject->created_at->format('d M Y, H:i') : now()->format('d M Y') }}
                    </span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs font-semibold">
                    <div>
                        <span class="text-[9px] font-bold text-gray-400 block uppercase tracking-wider">Merek Dagang</span>
                        <strong class="text-gray-900 font-bold block truncate text-xs mt-0.5" title="{{ $activeProject->nama_merek_dagang }}">
                            {{ $activeProject->nama_merek_dagang }}
                        </strong>
                    </div>
                    <div>
                        <span class="text-[9px] font-bold text-gray-400 block uppercase tracking-wider">Paket Layanan</span>
                        <strong class="text-gray-900 font-bold block truncate text-xs mt-0.5">
                            {{ $activeProject->nama_paket }}
                        </strong>
                    </div>
                    <div>
                        <span class="text-[9px] font-bold text-gray-400 block uppercase tracking-wider">Tipe Pengajuan</span>
                        <strong class="text-gray-900 font-bold block capitalize text-xs mt-0.5">
                            {{ $activeProject->jenis_pengajuan?->value ?? $activeProject->jenis_pengajuan }}
                        </strong>
                    </div>
                    <div>
                        <span class="text-[9px] font-bold text-gray-400 block uppercase tracking-wider">Est. Invoice</span>
                        <strong class="text-[#195A36] font-bold font-mono block text-xs mt-0.5">
                            Rp {{ number_format($estimasiBiaya, 0, ',', '.') }}
                        </strong>
                    </div>
                </div>
            </div>

            <!-- TOMBOL AKSI & FOOTER RINGKAS -->
            <div class="space-y-4 pt-2 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-center gap-2.5">
                    <a href="{{ route('client.dashboard') }}" class="w-full sm:w-auto px-6 py-2.5 bg-[#195A36] hover:bg-[#124227] text-white text-xs font-bold rounded-full transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span>Kembali ke Dashboard</span>
                    </a>

                    <a href="https://wa.me/628123456789?text=Halo%20Admin%20HalalCert,%20saya%20sudah%20mengirimkan%20pengajuan%20sertifikasi%20ID%20%23{{ $activeProject->kode_registrasi }}" target="_blank" class="w-full sm:w-auto px-6 py-2.5 bg-white border border-gray-200/80 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-full transition flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                        <svg class="w-4 h-4 text-[#195A36] fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Hubungi Admin WA</span>
                    </a>
                </div>

                <div class="flex items-center justify-center gap-4 text-[10px] text-gray-400 font-medium">
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3 text-[#195A36]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Sistem BPJPH
                    </span>
                    <span>•</span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3 text-[#195A36]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                        Data Terenkripsi
                    </span>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

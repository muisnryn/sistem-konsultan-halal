<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8" x-data="{ openModal: false, selectedProj: null }">

        <!-- HEADER BAR (Sesuai Gaya Header Dashboard Admin) -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-semibold mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                    Real-Time Tracking
                </div>
                <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Monitoring Pembayaran Proyek</h1>
                <p class="mt-2 text-sm font-medium text-gray-500">Pantau status arus kas, realisasi pembayaran termin, dan pelunasan kontrak klien.</p>
            </div>

            <!-- BADGE TANGGAL MONITORING -->
            <div class="px-4 py-2 bg-white border border-gray-100 rounded-full shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] text-xs font-medium text-gray-600 self-start sm:self-auto flex items-center gap-2">
                <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <span>Status per <strong class="font-bold text-gray-900">{{ date('d M Y') }}</strong></span>
            </div>
        </div>

        <!-- GRID 3 KARTU STATISTIK RINGKASAN UTAMA (Rounded 24px Style) -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

            <!-- KARTU 1: TOTAL PENDAPATAN LUNAS -->
            <div class="bg-white rounded-[24px] p-6 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:-translate-y-1 transition-all duration-300 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold tracking-wider text-gray-400 uppercase">Total Pendapatan Lunas</span>
                    <div class="w-11 h-11 rounded-2xl bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#195A36] font-mono">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h2>
                    <p class="text-xs font-semibold text-[#195A36] mt-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 005.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.94" />
                        </svg>
                        <span>Akumulasi Pelunasan Kas Selesai</span>
                    </p>
                </div>
            </div>

            <!-- KARTU 2: PENDING TERMIN 1 -->
            <div class="bg-white rounded-[24px] p-6 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:-translate-y-1 transition-all duration-300 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold tracking-wider text-gray-400 uppercase">Pending Uang Muka (Termin 1 - 60%)</span>
                    <div class="flex items-center justify-center w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="font-mono text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                        Rp {{ number_format($pendingTermin1, 0, ',', '.') }}
                    </h2>
                    <p class="text-xs font-semibold text-amber-600 mt-2 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        <span>Menunggu Pembayaran Awal Klien</span>
                    </p>
                </div>
            </div>

            <!-- KARTU 3: PENDING TERMIN 2 -->
            <div class="bg-white rounded-[24px] p-6 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:-translate-y-1 transition-all duration-300 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold tracking-wider text-gray-400 uppercase">Pending Pelunasan (Termin 2 - 40%)</span>
                    <div class="flex items-center justify-center w-11 h-11 rounded-2xl bg-sky-50 text-sky-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 011.5 1.5v9.75a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5V6a1.5 1.5 0 011.5-1.5z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="font-mono text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                        Rp {{ number_format($pendingTermin2, 0, ',', '.') }}
                    </h2>
                    <p class="text-xs font-semibold text-sky-600 mt-2 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                        <span>Menunggu Pelunasan Akhir Proyek</span>
                    </p>
                </div>
            </div>

        </div>

        <!-- CONTAINER TABEL DATA UTAMA (Rounded 24px Style) -->
        <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-5">

            <!-- TOOLBAR ATAS: SEGMENTED TAB FILTER & NAVIGASI KE LAPORAN KEUANGAN -->
            <div class="flex flex-col gap-4 pb-2 border-b border-gray-100 sm:flex-row sm:items-center sm:justify-between">

                <!-- SEGMENTED CONTROLS FILTER STATUS (OVAL PILL) -->
                <div class="flex items-center self-start gap-1 p-1 border rounded-full bg-gray-100/80 border-gray-200/50 sm:self-auto">
                    <a href="{{ route('finance.payments.index', ['status' => 'all']) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 {{ $statusFilter === 'all' ? 'bg-[#195A36] text-white shadow-xs' : 'text-gray-500 hover:text-gray-900' }}">
                        Semua Proyek
                    </a>
                    <a href="{{ route('finance.payments.index', ['status' => 'paid']) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 {{ $statusFilter === 'paid' ? 'bg-[#195A36] text-white shadow-xs' : 'text-gray-500 hover:text-gray-900' }}">
                        Lunas
                    </a>
                    <a href="{{ route('finance.payments.index', ['status' => 'unpaid']) }}"
                       class="px-4 py-1.5 rounded-full text-xs font-semibold transition-all duration-200 {{ $statusFilter === 'unpaid' ? 'bg-[#195A36] text-white shadow-xs' : 'text-gray-500 hover:text-gray-900' }}">
                        Belum Lunas
                    </a>
                </div>

                <!-- TOMBOL CTA KE HALAMAN LAPORAN KEUANGAN -->
                <div>
                    <a href="{{ route('finance.reports.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2 text-xs font-semibold text-white transition bg-gray-900 rounded-full shadow-xs hover:bg-gray-800 group">
                        <svg class="w-4 h-4 text-green-400 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <span>Cetak Laporan Keuangan</span>
                    </a>
                </div>

            </div>

            <!-- TABEL DATA MONITORING -->
            @if($projects->isEmpty())
                <div class="py-12 text-center">
                    <div class="p-4 mx-auto mb-3 text-gray-400 rounded-full bg-gray-50 w-fit">
                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Tidak Ada Data Monitoring</p>
                    <p class="mt-1 text-xs text-gray-500">Tidak ada data proyek dengan status pembayaran yang sesuai dengan filter.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left whitespace-nowrap">
                        <thead>
                            <tr class="font-medium text-gray-400 border-b border-gray-100">
                                <th class="pb-3.5 font-medium">Klien & Merek Dagang</th>
                                <th class="pb-3.5 font-medium text-right">Total Kontrak</th>
                                <th class="pb-3.5 font-medium text-center">Termin 1 (60%)</th>
                                <th class="pb-3.5 font-medium text-center">Termin 2 (40%)</th>
                                <th class="pb-3.5 font-medium text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($projects as $proj)
                                @php
                                    $company = $proj->klien->companyProfile ?? null;
                                    $t1 = $proj->payments->where('termin', 'T1_60')->first();
                                    $t2 = $proj->payments->where('termin', 'T2_40')->first();

                                    $t1Status = $t1 ? (in_array($t1->status_pembayaran->value ?? $t1->status_pembayaran, ['paid', 'success', 'settlement']) ? 'Lunas' : 'Pending') : '-';
                                    $t2Status = $t2 ? (in_array($t2->status_pembayaran->value ?? $t2->status_pembayaran, ['paid', 'success', 'settlement']) ? 'Lunas' : 'Pending') : 'Belum Terbit';

                                    $namaPerusahaan = $company->nama_perusahaan ?? $proj->nama_merek_dagang;
                                    $initials = strtoupper(substr($namaPerusahaan, 0, 2));

                                    $projData = json_encode([
                                        'kode' => $proj->kode_registrasi,
                                        'client' => $namaPerusahaan,
                                        'brand' => $proj->nama_merek_dagang,
                                        'total' => 'Rp ' . number_format($proj->total_harga_kesepakatan, 0, ',', '.'),
                                        't1_inv' => $t1->invoice_number ?? '-',
                                        't1_amount' => $t1 ? 'Rp ' . number_format($t1->nominal_tagihan, 0, ',', '.') : '-',
                                        't1_status' => $t1Status,
                                        't2_inv' => $t2->invoice_number ?? '-',
                                        't2_amount' => $t2 ? 'Rp ' . number_format($t2->nominal_tagihan, 0, ',', '.') : '-',
                                        't2_status' => $t2Status,
                                    ]);
                                @endphp
                                <tr class="transition-colors hover:bg-gray-50/50 group">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-9 w-9 bg-[#e8f3ec] text-[#195A36] font-bold rounded-full flex items-center justify-center text-xs tracking-wider uppercase shrink-0">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <strong class="block text-sm font-semibold text-gray-900 group-hover:text-[#195A36] transition-colors">
                                                    {{ $namaPerusahaan }}
                                                </strong>
                                                <span class="text-xs text-gray-500">
                                                    Merek: {{ $proj->nama_merek_dagang }} &bull; <span class="font-mono font-medium text-gray-700">{{ $proj->kode_registrasi }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-4 font-mono font-bold text-right text-gray-900">
                                        Rp {{ number_format($proj->total_harga_kesepakatan, 0, ',', '.') }}
                                    </td>

                                    <!-- TERMIN 1 -->
                                    <td class="py-4 text-center">
                                        @if($t1)
                                            <span class="block font-mono font-bold text-gray-800">
                                                Rp {{ number_format($t1->nominal_tagihan, 0, ',', '.') }}
                                            </span>
                                            @if($t1Status === 'Lunas')
                                                <span class="px-2.5 py-0.5 bg-green-50 text-[#195A36] border border-green-100 rounded-full text-[10px] font-semibold uppercase inline-inline-flex items-center gap-1 mt-1">
                                                    Lunas
                                                </span>
                                            @else
                                                <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-100 rounded-full text-[10px] font-semibold uppercase inline-inline-flex items-center gap-1 mt-1">
                                                    Pending
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <!-- TERMIN 2 -->
                                    <td class="py-4 text-center">
                                        @if($t2)
                                            <span class="block font-mono font-bold text-gray-800">
                                                Rp {{ number_format($t2->nominal_tagihan, 0, ',', '.') }}
                                            </span>
                                            @if($t2Status === 'Lunas')
                                                <span class="px-2.5 py-0.5 bg-green-50 text-[#195A36] border border-green-100 rounded-full text-[10px] font-semibold uppercase inline-inline-flex items-center gap-1 mt-1">
                                                    Lunas
                                                </span>
                                            @else
                                                <span class="px-2.5 py-0.5 bg-sky-50 text-sky-700 border border-sky-100 rounded-full text-[10px] font-semibold uppercase inline-inline-flex items-center gap-1 mt-1">
                                                    Pending
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-[10px] text-gray-400 font-medium bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">
                                                Belum Terbit
                                            </span>
                                        @endif
                                    </td>

                                    <!-- AKSI DETAIL -->
                                    <td class="py-4 text-center">
                                        <button type="button"
                                                @click="selectedProj = {{ $projData }}; openModal = true"
                                                title="Lihat Detail Termin"
                                                class="p-2 text-gray-400 hover:text-[#195A36] hover:bg-[#e8f3ec] rounded-full transition-colors cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>

        <!-- MODAL RINCIAN TERMIN DUAL (ALPINE.JS WITH ROUNDED 24px) -->
        <div x-show="openModal"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs">

            <div class="w-full max-w-lg p-6 space-y-5 overflow-hidden bg-white border border-gray-100 shadow-2xl rounded-[24px]"
                 @click.away="openModal = false">

                <!-- HEADER MODAL -->
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="flex items-center gap-2 text-sm font-bold text-gray-900">
                        <div class="w-8 h-8 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <span>Rincian Dual Termin Pembayaran</span>
                    </h3>
                    <button type="button" @click="openModal = false" class="p-1 text-gray-400 transition-colors rounded-full hover:text-gray-600 hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- BODY MODAL -->
                <template x-if="selectedProj">
                    <div class="space-y-4 text-xs">
                        <div class="grid grid-cols-2 gap-3 p-4 border border-gray-100 bg-gray-50/80 rounded-2xl">
                            <div>
                                <span class="text-gray-400 block text-[10px] font-bold uppercase tracking-wider">KODE PROYEK</span>
                                <strong class="font-mono text-xs text-gray-900" x-text="selectedProj.kode"></strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[10px] font-bold uppercase tracking-wider">TOTAL KONTRAK</span>
                                <strong class="font-mono text-sm text-[#195A36]" x-text="selectedProj.total"></strong>
                            </div>
                        </div>

                        <!-- TERMIN 1 -->
                        <div class="p-4 bg-white border border-gray-100 rounded-2xl space-y-2.5 shadow-xs">
                            <div class="flex items-center justify-between font-bold text-gray-900">
                                <span>Termin 1 (60% Uang Muka)</span>
                                <span x-text="selectedProj.t1_status"
                                      :class="selectedProj.t1_status === 'Lunas' ? 'px-2.5 py-0.5 bg-green-50 text-[#195A36] border border-green-100 rounded-full text-[10px]' : 'px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-100 rounded-full text-[10px]'">
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-gray-500 text-[11px] pt-2 border-t border-gray-50">
                                <span class="font-mono" x-text="'No Invoice: ' + selectedProj.t1_inv"></span>
                                <strong class="font-mono text-xs text-gray-900" x-text="selectedProj.t1_amount"></strong>
                            </div>
                        </div>

                        <!-- TERMIN 2 -->
                        <div class="p-4 bg-white border border-gray-100 rounded-2xl space-y-2.5 shadow-xs">
                            <div class="flex items-center justify-between font-bold text-gray-900">
                                <span>Termin 2 (40% Pelunasan Akhir)</span>
                                <span x-text="selectedProj.t2_status"
                                      :class="selectedProj.t2_status === 'Lunas' ? 'px-2.5 py-0.5 bg-green-50 text-[#195A36] border border-green-100 rounded-full text-[10px]' : 'px-2.5 py-0.5 bg-sky-50 text-sky-700 border border-sky-100 rounded-full text-[10px]'">
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-gray-500 text-[11px] pt-2 border-t border-gray-50">
                                <span class="font-mono" x-text="'No Invoice: ' + selectedProj.t2_inv"></span>
                                <strong class="font-mono text-xs text-gray-900" x-text="selectedProj.t2_amount"></strong>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- FOOTER MODAL -->
                <div class="flex justify-end pt-2 border-t border-gray-100">
                    <button type="button" @click="openModal = false" class="px-5 py-2 text-xs font-semibold text-gray-700 transition bg-gray-100 rounded-full cursor-pointer hover:bg-gray-200">
                        Tutup
                    </button>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
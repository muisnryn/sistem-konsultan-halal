<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER BANNER & BAR AKSI UTAMA -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('finance.payments.index') }}"
                   title="Kembali ke Monitoring Pembayaran"
                   class="p-2 text-gray-600 transition bg-white border border-gray-200 rounded-full shadow-xs hover:bg-gray-50 group">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </a>
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-semibold mb-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                        Modul Keuangan &bull; Real-Time Database
                    </div>
                    <h1 class="text-2xl sm:text-[32px] font-bold text-gray-900 tracking-tight leading-none">Laporan Keuangan & Pendapatan</h1>
                    <p class="mt-2 text-sm font-medium text-gray-500">Ringkasan pendapatan kotor, estimasi pajak, dan pendapatan bersih lembaga.</p>
                </div>
            </div>

            <div class="flex items-center self-start gap-2 sm:self-auto">
                <button type="button"
                        onclick="printReportPdf()"
                        class="px-5 py-2.5 bg-[#195A36] hover:bg-[#124227] text-white rounded-full text-xs font-semibold transition shadow-xs inline-flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12.1227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-19.126 0C1.081 7.441.313 8.375.313 9.456v6.294c0 1.081.768 2.015 1.837 2.175h1.09" />
                    </svg>
                    <span>Cetak PDF Laporan Resmi</span>
                </button>
            </div>
        </div>

        <!-- LAYOUT GRID UTAMA -->
        <div class="grid items-start grid-cols-1 gap-6 lg:grid-cols-12">

            <!-- SIDEBAR KIRI: PARAMETER FILTER & TOOL EKSPOR (4 KOLOM) -->
            <div class="space-y-6 lg:col-span-4">

                <!-- KARTU PARAMETER LAPORAN -->
                <form action="{{ route('finance.reports.index') }}" method="GET" class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                        <h3 class="flex items-center gap-2 text-xs font-bold tracking-wider text-gray-900 uppercase">
                            <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                                </svg>
                            </div>
                            <span>Filter Parameter</span>
                        </h3>
                        <a href="{{ route('finance.reports.index') }}" class="text-[11px] font-semibold text-gray-400 hover:text-rose-600 transition">Reset</a>
                    </div>

                    <div>
                        <label class="block mb-1 text-xs font-bold text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $startDate }}"
                               class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition">
                    </div>

                    <div>
                        <label class="block mb-1 text-xs font-bold text-gray-700">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                               class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition">
                    </div>

                    <div>
                        <label class="block mb-1 text-xs font-bold text-gray-700">Kelompok Usaha Klien</label>
                        <select name="category" class="w-full px-4 py-2.5 bg-gray-50/50 border border-gray-200 rounded-full text-xs font-semibold text-gray-800 outline-none focus:bg-white focus:ring-[#195A36] focus:border-[#195A36] transition cursor-pointer">
                            <option value="all" {{ $categoryFilter == 'all' ? 'selected' : '' }}>Semua Kelompok Usaha</option>
                            @foreach($availableCategories as $catOption)
                                <option value="{{ $catOption }}" {{ $categoryFilter == $catOption ? 'selected' : '' }}>
                                    {{ $catOption }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="flex items-center justify-center w-full gap-2 py-2.5 text-xs font-semibold text-white transition shadow-xs bg-[#195A36] hover:bg-[#124227] rounded-full cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <span>Terapkan Filter Data</span>
                    </button>
                </form>

                <!-- KARTU OPSI EKSPOR LAPORAN -->
                <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-3">
                    <h3 class="flex items-center gap-2 pb-3 text-xs font-bold tracking-wider text-gray-900 uppercase border-b border-gray-100">
                        <div class="flex items-center justify-center rounded-full w-7 h-7 bg-sky-50 text-sky-600">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                        </div>
                        <span>Opsi Ekspor Dokumen</span>
                    </h3>

                    <button type="button"
                            onclick="printReportPdf()"
                            class="flex items-center justify-between w-full p-3.5 text-xs font-semibold transition border border-gray-100 hover:border-gray-200 bg-gray-50/60 hover:bg-gray-50 rounded-full text-gray-700 group cursor-pointer">
                        <div class="flex items-center gap-2.5">
                            <div class="flex items-center justify-center rounded-full w-7 h-7 bg-rose-50 text-rose-600 shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <span>Ekspor ke Format PDF Resmi</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform text-gray-400 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>

                    <button type="button" onclick="alert('Fitur ekspor Excel siap digunakan.')" class="flex items-center justify-between w-full p-3.5 text-xs font-semibold transition border border-gray-100 hover:border-gray-200 bg-gray-50/60 hover:bg-gray-50 rounded-full text-gray-700 group cursor-pointer">
                        <div class="flex items-center gap-2.5">
                            <div class="flex items-center justify-center rounded-full w-7 h-7 bg-[#e8f3ec] text-[#195A36] shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-8.625 1.125v-15c0-.621.504-1.125 1.125-1.125h17.25c0 .621.504 1.125 1.125 1.125v15c0 .621-.504 1.125-1.125 1.125" />
                                </svg>
                            </div>
                            <span>Ekspor ke Format Excel</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform text-gray-400 group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>

            </div>

            <!-- AREA UTAMA LAPORAN: METRIK KARTU & PREVIEW TABEL (8 KOLOM) -->
            <div class="space-y-6 lg:col-span-8">

                <!-- GRID 3 KARTU METRIK RINGKASAN RINGKAS -->
                @php
                    $sumGross = !empty($reportRows) ? array_sum(array_column($reportRows, 'gross_revenue')) : $totalRevenue;
                    $sumTax = !empty($reportRows) ? array_sum(array_column($reportRows, 'tax_11')) : ($totalRevenue * 0.11);
                    $sumNet = !empty($reportRows) ? array_sum(array_column($reportRows, 'net_revenue')) : ($totalRevenue - $sumTax);
                @endphp

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                    <!-- KARTU 1: PENDAPATAN KOTOR -->
                    <div class="bg-white rounded-[24px] p-5 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pendapatan Kotor</span>
                            <div class="w-8 h-8 bg-[#e8f3ec] text-[#195A36] rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="font-mono text-lg font-bold tracking-tight text-gray-900">
                            Rp {{ number_format($sumGross, 0, ',', '.') }}
                        </h2>
                        <span class="text-[11px] font-semibold text-gray-500 block">
                            {{ number_format($totalTransactions) }} Transaksi Lunas
                        </span>
                    </div>

                    <!-- KARTU 2: ESTIMASI PAJAK 11% -->
                    <div class="bg-white rounded-[24px] p-5 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Estimasi Pajak (11%)</span>
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-rose-50 text-rose-600 shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 14.25l6-6md0 0h-3.75m3.75 0V12m-9 3h3.75M3 21h18M3 3h18" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="font-mono text-lg font-bold tracking-tight text-rose-600">
                            Rp {{ number_format($sumTax, 0, ',', '.') }}
                        </h2>
                        <span class="text-[11px] font-semibold text-rose-500 block">
                            Potongan Kewajiban Pajak
                        </span>
                    </div>

                    <!-- KARTU 3: PENDAPATAN BERSIH -->
                    <div class="bg-[#195A36] text-white rounded-[24px] p-5 shadow-sm space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-green-200 uppercase tracking-wider">Pendapatan Bersih</span>
                            <div class="w-8 h-8 bg-[#124227] text-green-300 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 005.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.94" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="font-mono text-lg font-bold tracking-tight text-white">
                            Rp {{ number_format($sumNet, 0, ',', '.') }}
                        </h2>
                        <span class="text-[11px] font-medium text-green-100 block">
                            Nett Revenue Lembaga
                        </span>
                    </div>

                </div>

                <!-- KARTU TABEL LAPORAN KEUANGAN -->
                <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-5">

                    <!-- HEADER TABEL -->
                    <div class="flex flex-col gap-2 pb-4 border-b border-gray-100 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#195A36] mb-1">
                                <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m-9 0h10" />
                                </svg>
                                <span>Breakdown Database Real-Time</span>
                            </div>
                            <h3 class="text-base font-bold tracking-tight text-gray-900">Rincian Laporan Per Kelompok Usaha</h3>
                            <p class="text-xs font-medium text-gray-500 mt-0.5">Pengelompokan pendapatan dari transaksi klien terverifikasi.</p>
                        </div>
                        <span class="px-4 py-1.5 bg-gray-50 border border-gray-100 text-gray-700 font-semibold rounded-full text-xs self-start sm:self-auto inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            <span>{{ date('d M Y', strtotime($startDate)) }} — {{ date('d M Y', strtotime($endDate)) }}</span>
                        </span>
                    </div>

                    <!-- TABEL DATA FINANSIAL -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-xs text-left whitespace-nowrap">
                            <thead>
                                <tr class="font-medium text-gray-400 border-b border-gray-100">
                                    <th class="pb-3.5 font-medium pl-2">Kelompok Usaha Klien</th>
                                    <th class="pb-3.5 font-medium text-center">Jml Transaksi</th>
                                    <th class="pb-3.5 font-medium text-right">Pendapatan Kotor</th>
                                    <th class="pb-3.5 font-medium text-right">Pajak (11%)</th>
                                    <th class="pb-3.5 font-medium text-right pr-2">Pendapatan Bersih</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($reportRows as $row)
                                    <tr class="transition-colors hover:bg-gray-50/60 group">
                                        <td class="py-4 pl-2 font-semibold text-gray-900">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-2 h-2 rounded-full bg-[#195A36] shrink-0 group-hover:scale-125 transition-transform"></div>
                                                <span class="truncate max-w-[240px] font-semibold text-gray-900" title="{{ $row['category_name'] }}">
                                                    {{ $row['category_name'] }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-4 text-center">
                                            <span class="inline-block px-3 py-1 font-mono text-xs font-semibold text-gray-800 rounded-full bg-gray-100/80">
                                                {{ number_format($row['transaction_count']) }} Transaksi
                                            </span>
                                        </td>
                                        <td class="py-4 font-mono font-bold text-right text-gray-900">
                                            Rp {{ number_format($row['gross_revenue'], 0, ',', '.') }}
                                        </td>
                                        <td class="py-4 font-mono font-bold text-right text-rose-600">
                                            Rp {{ number_format($row['tax_11'], 0, ',', '.') }}
                                        </td>
                                        <td class="py-4 text-right font-mono font-bold text-[#195A36] pr-2">
                                            Rp {{ number_format($row['net_revenue'], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center">
                                            <div class="p-4 mx-auto mb-3 text-gray-400 rounded-full bg-gray-50 w-fit">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-semibold text-gray-900">Tidak Ada Data Transaksi</p>
                                            <p class="mt-1 text-xs text-gray-500">Tidak ditemukan transaksi lunas pada rentang tanggal atau kategori yang dipilih.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if(!empty($reportRows))
                                <tfoot class="font-bold text-gray-900 border-t-2 border-gray-100 bg-gray-50/60">
                                    <tr>
                                        <td class="py-4 pl-3 text-xs font-bold tracking-wider uppercase">Total Keseluruhan</td>
                                        <td class="py-4 font-mono text-xs font-bold text-center">
                                            {{ number_format(array_sum(array_column($reportRows, 'transaction_count'))) }} Transaksi
                                        </td>
                                        <td class="py-4 font-mono text-xs font-bold text-right text-gray-900">
                                            Rp {{ number_format(array_sum(array_column($reportRows, 'gross_revenue')), 0, ',', '.') }}
                                        </td>
                                        <td class="py-4 font-mono text-xs font-bold text-right text-rose-600">
                                            Rp {{ number_format(array_sum(array_column($reportRows, 'tax_11')), 0, ',', '.') }}
                                        </td>
                                        <td class="py-4 text-right font-mono text-sm text-[#195A36] font-bold pr-3">
                                            Rp {{ number_format(array_sum(array_column($reportRows, 'net_revenue')), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- SCRIPT CETAK DIALOG TANPA PINDAH TAB -->
    <script>
        function printReportPdf() {
            // URL ekspor PDF dengan membawa query filter yang aktif
            const pdfUrl = "{{ route('finance.reports.exportPdf', request()->query()) }}";

            // Buat iframe tersembunyi
            let printIframe = document.getElementById('pdf-print-iframe');
            if (!printIframe) {
                printIframe = document.createElement('iframe');
                printIframe.id = 'pdf-print-iframe';
                printIframe.style.position = 'fixed';
                printIframe.style.right = '0';
                printIframe.style.bottom = '0';
                printIframe.style.width = '0';
                printIframe.style.height = '0';
                printIframe.style.border = '0';
                document.body.appendChild(printIframe);
            }

            // Muat URL PDF ke iframe
            printIframe.src = pdfUrl;

            // Trigger cetak otomatis saat iframe selesai loading
            printIframe.onload = function() {
                setTimeout(function() {
                    printIframe.contentWindow.focus();
                    printIframe.contentWindow.print();
                }, 300);
            };
        }
    </script>
</x-app-layout>
<x-app-layout>
    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER OVERVIEW (Sesuai Gaya Header Dashboard Admin) -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-semibold mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                    Keuangan & Arus Kas
                </div>
                <h1 class="text-[32px] font-bold text-gray-900 tracking-tight leading-none">Dashboard Overview</h1>
                <p class="mt-2 text-sm font-medium text-gray-500">Ringkasan aktivitas keuangan, pendapatan, dan transaksi pembayaran terdaftar.</p>
            </div>

            <!-- ALERT PENGAJUAN BUTUH INVOICE -->
            @if($pendingInvoiceCount > 0)
                <a href="{{ route('finance.invoices.index') }}"
                   class="inline-flex items-center self-start gap-2 px-4 py-2 text-xs font-semibold text-white transition rounded-full shadow-sm bg-amber-500 hover:bg-amber-600 sm:self-auto">
                    <span class="relative flex w-2 h-2">
                        <span class="absolute inline-flex w-full h-full bg-white rounded-full opacity-75 animate-ping"></span>
                        <span class="relative inline-flex w-2 h-2 bg-white rounded-full"></span>
                    </span>
                    <span>{{ $pendingInvoiceCount }} Pengajuan Butuh Invoice &rarr;</span>
                </a>
            @endif
        </div>

        <!-- METRIC CARDS OVERVIEW (3 KOLOM ROUNDED 24px) -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

            <!-- KARTU 1: TOTAL PENDAPATAN -->
            <div class="bg-white rounded-[24px] p-6 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:-translate-y-1 transition-all duration-300 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold tracking-wider text-gray-400 uppercase">Total Pendapatan</span>
                    <div class="w-11 h-11 rounded-2xl bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 005.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.94" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="font-mono text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                        Rp {{ number_format($totalPaidRevenue, 0, ',', '.') }}
                    </h2>
                    <p class="text-xs font-semibold text-[#195A36] mt-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        <span>Pendapatan Terverifikasi Lunas</span>
                    </p>
                </div>
            </div>

            <!-- KARTU 2: PEMBAYARAN MENUNGGU (OUTSTANDING) -->
            <div class="bg-white rounded-[24px] p-6 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:-translate-y-1 transition-all duration-300 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold tracking-wider text-gray-400 uppercase">Pembayaran Menunggu</span>
                    <div class="flex items-center justify-center w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="font-mono text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                        Rp {{ number_format($totalOutstanding, 0, ',', '.') }}
                    </h2>
                    <p class="text-xs font-semibold text-amber-600 mt-2 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        <span>{{ $pendingPaymentsCount }} Invoice Menunggu Pelunasan</span>
                    </p>
                </div>
            </div>

            <!-- KARTU 3: TOTAL TRANSAKSI -->
            <div class="bg-white rounded-[24px] p-6 border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:-translate-y-1 transition-all duration-300 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold tracking-wider text-gray-400 uppercase">Total Transaksi</span>
                    <div class="flex items-center justify-center text-blue-600 w-11 h-11 rounded-2xl bg-blue-50 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                        {{ number_format($totalTransactions) }}
                    </h2>
                    <p class="text-xs font-semibold text-gray-400 mt-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Total Invoice Diterbitkan</span>
                    </p>
                </div>
            </div>

        </div>

        <!-- TABEL TRANSAKSI TERBARU (Rounded 24px) -->
        <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] border border-gray-100 p-6 space-y-4">

            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-base font-bold tracking-tight text-gray-900">Transaksi Terbaru</h3>
                <a href="{{ route('finance.payments.index') }}"
                   class="text-xs font-semibold text-[#195A36] hover:underline inline-flex items-center gap-1">
                    <span>Lihat Semua Transaksi</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            @if($recentPayments->isEmpty())
                <div class="py-12 text-center">
                    <div class="p-4 mx-auto mb-3 text-gray-400 rounded-full bg-gray-50 w-fit">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125H3.75A1.125 1.125 0 012.625 15.375V5.625C2.625 5.004 3.129 4.5 3.75 4.5z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-900">Belum Ada Transaksi</p>
                    <p class="mt-1 text-xs text-gray-500">Belum ada riwayat transaksi pembayaran yang tercatat saat ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-left whitespace-nowrap">
                        <thead>
                            <tr class="font-medium text-gray-400 border-b border-gray-100">
                                <th class="pb-3.5 font-medium">ID Invoice</th>
                                <th class="pb-3.5 font-medium">Nama Klien / Perusahaan</th>
                                <th class="pb-3.5 font-medium">Tanggal</th>
                                <th class="pb-3.5 font-medium text-right">Jumlah Tagihan</th>
                                <th class="pb-3.5 font-medium text-center">Status</th>
                                <th class="pb-3.5 font-medium text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recentPayments as $pay)
                                @php
                                    $statusVal = is_object($pay->status_pembayaran) ? $pay->status_pembayaran->value : $pay->status_pembayaran;
                                    $isPaid = in_array($statusVal, ['paid', 'success', 'settlement']);
                                    $company = $pay->project->klien->companyProfile ?? null;
                                    $namaKlien = $company->nama_perusahaan ?? $pay->project->nama_merek_dagang;
                                    $initials = strtoupper(substr($namaKlien, 0, 2));
                                @endphp
                                <tr class="transition-colors hover:bg-gray-50/50 group">
                                    <td class="py-4 font-mono font-bold text-gray-900">
                                        <span class="bg-gray-100 px-2.5 py-1 rounded-md text-gray-800">{{ $pay->invoice_number }}</span>
                                        <span class="block text-[10px] text-gray-400 font-sans font-normal uppercase mt-1">Termin: {{ $pay->termin }}</span>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-9 w-9 bg-[#e8f3ec] text-[#195A36] font-bold rounded-full flex items-center justify-center text-xs tracking-wider uppercase shrink-0">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <strong class="block text-sm font-semibold text-gray-900">{{ $namaKlien }}</strong>
                                                <span class="text-xs text-gray-500">Merek: {{ $pay->project->nama_merek_dagang }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 font-medium text-gray-500">
                                        {{ $pay->created_at ? $pay->created_at->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="py-4 font-mono font-bold text-right text-gray-900">
                                        Rp {{ number_format($pay->nominal_tagihan, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 text-center">
                                        @if($isPaid)
                                            <span class="px-3 py-1 bg-green-50 text-[#195A36] rounded-full text-xs font-semibold inline-flex items-center gap-1.5 border border-green-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                                                Lunas
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-semibold inline-flex items-center gap-1.5 border border-amber-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-center">
                                        <a href="{{ route('finance.payments.index') }}"
                                           class="inline-flex items-center justify-center px-4 py-1.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-full text-xs font-semibold transition shadow-xs">
                                            Detail
                                        </a>
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
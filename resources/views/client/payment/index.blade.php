<x-app-layout>
    @php
        // Cari tagihan aktif yang belum lunas
        $unpaidPayment = $payments->first(function($p) {
            $status = $p->status_pembayaran?->value ?? $p->status_pembayaran;
            return $status !== 'success';
        });
    @endphp

    <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- HEADER BAR HALAMAN -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-gray-100">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-semibold mb-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#195A36]"></span>
                    Sistem Pembayaran Aman
                </div>
                <h1 class="text-2xl sm:text-[28px] font-bold text-gray-900 tracking-tight leading-none">Pembayaran Jasa Pendampingan</h1>
                <p class="text-xs text-gray-500 font-medium mt-1.5">Selesaikan pembayaran tagihan termin untuk melanjutkan proses sertifikasi halal Anda.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3.5 py-1.5 bg-[#e8f3ec] text-[#195A36] rounded-full text-xs font-bold uppercase tracking-wide flex items-center gap-2 shrink-0">
                    <span class="w-2 h-2 rounded-full bg-[#195A36] animate-pulse"></span>
                    <span>Pembayaran Via Midtrans</span>
                </span>
            </div>
        </div>

        <!-- ALERT SYSTEM -->
        @if (session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200/80 text-rose-800 text-xs font-semibold rounded-[20px] flex items-center gap-2.5 shadow-xs">
                <svg class="h-4 w-4 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="p-4 bg-[#e8f3ec] border border-green-200/60 text-[#195A36] text-xs font-semibold rounded-[20px] flex items-center gap-2.5 shadow-xs">
                <svg class="h-4 w-4 text-[#195A36] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($unpaidPayment)
            <!-- GRID TATA LETAK CHECKOUT (2 KOLOM) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                <!-- KOLOM KIRI (5/12): RINGKASAN TAGIHAN AKTIF -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white rounded-[24px] border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] p-6 space-y-5">
                        <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5h16.5a1.5 1.5 0 011.5 1.5v9.75a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5V6a1.5 1.5 0 011.5-1.5z" /></svg>
                                </div>
                                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Tagihan Aktif</h3>
                            </div>
                            <span class="px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase">
                                {{ $unpaidPayment->termin === 'T1_60' ? 'Termin 1 (60%)' : 'Termin 2 (40%)' }}
                            </span>
                        </div>

                        <div class="space-y-4 text-xs">
                            <!-- Nomor Invoice Box -->
                            <div class="p-4 bg-gray-50/80 rounded-[20px] border border-gray-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider">Nomor Invoice</span>
                                    <strong class="text-gray-900 font-mono font-bold text-sm">#{{ $unpaidPayment->invoice_number }}</strong>
                                </div>
                                <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-200/80 rounded-full text-[10px] font-bold uppercase animate-pulse">
                                    Belum Lunas
                                </span>
                            </div>

                            <!-- Merek Dagang -->
                            <div class="px-1 space-y-0.5">
                                <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider">Merek Dagang / Produk Utama</span>
                                <strong class="text-gray-900 font-bold block text-xs sm:text-sm">{{ $unpaidPayment->project->nama_merek_dagang }}</strong>
                            </div>

                            <!-- Akses Penawaran PDF -->
                            <div class="pt-3 border-t border-gray-100">
                                <span class="text-[10px] font-bold text-gray-400 block uppercase tracking-wider mb-2">Dokumen Penawaran Resmi</span>
                                <a href="{{ route('client.project.download_penawaran', $unpaidPayment->project_id) }}" target="_blank" class="w-full py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200/80 rounded-full text-xs font-bold transition flex items-center justify-center gap-2 shadow-xs">
                                    <svg class="w-4 h-4 text-[#195A36]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                    <span>Unduh Dokumen Penawaran (PDF)</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN (7/12): DETAIL PENGAJUAN, RINCIAN BIAYA & TOMBOL BAYAR -->
                <div class="lg:col-span-7 space-y-6">

                    <div class="bg-white rounded-[24px] border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] p-6 space-y-6">
                        <!-- HEADER KARTU DETAIL -->
                        <div class="border-b border-gray-100 pb-3 flex items-center justify-between">
                            <div>
                                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Rincian Parameter & Biaya</h3>
                                <p class="text-[11px] text-gray-400 font-medium mt-0.5">Rincian parameter operasional dan skema tagihan sertifikasi Anda.</p>
                            </div>
                            <span class="px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase shrink-0">
                                Paket {{ ucfirst($unpaidPayment->project->klien->companyProfile->skala_perusahaan ?? 'Usaha') }}
                            </span>
                        </div>

                        <!-- PARAMETER OPERASIONAL (3 BOX STATS) -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="p-3.5 bg-gray-50/80 rounded-[16px] border border-gray-100">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Jumlah Menu / Produk</span>
                                <strong class="text-gray-900 font-bold text-xs sm:text-sm mt-1 block">{{ $unpaidPayment->project->jumlah_produk }} Item</strong>
                            </div>

                            <div class="p-3.5 bg-gray-50/80 rounded-[16px] border border-gray-100">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Fasilitas / Outlet</span>
                                <strong class="text-gray-900 font-bold text-xs sm:text-sm mt-1 block">{{ $unpaidPayment->project->jumlah_outlet }} Titik</strong>
                            </div>

                            <div class="p-3.5 bg-gray-50/80 rounded-[16px] border border-gray-100">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Wilayah Kerja</span>
                                <strong class="text-gray-900 font-bold text-xs mt-1 block truncate">{{ $unpaidPayment->project->is_luar_jabodetabek ? 'Luar Jabodetabek' : 'Dalam Jabodetabek' }}</strong>
                            </div>
                        </div>

                        <!-- CARD BREAKDOWN FINANSIAL -->
                        <div class="p-6 bg-[#124227] text-white rounded-[20px] space-y-3.5 shadow-xs">
                            <div class="flex justify-between items-center text-xs text-green-100/80 font-medium">
                                <span>Total Kontrak Kesepakatan Proyek:</span>
                                <strong class="font-mono font-bold text-white text-sm">Rp {{ number_format($unpaidPayment->project->total_harga_kesepakatan, 0, ',', '.') }}</strong>
                            </div>

                            <div class="flex justify-between items-center text-xs text-green-100/80 font-medium">
                                <span>Skema Tagihan Termin Saat Ini:</span>
                                <span class="font-bold text-green-300">{{ $unpaidPayment->termin === 'T1_60' ? 'Termin 1 (60% Uang Muka)' : 'Termin 2 (40% Pelunasan)' }}</span>
                            </div>

                            <hr class="border-green-800/80 my-2">

                            <div class="flex justify-between items-baseline pt-0.5">
                                <span class="text-xs font-bold text-green-300 uppercase tracking-wider">Total Tagihan Termin Ini:</span>
                                <strong class="text-xl sm:text-2xl font-mono font-bold text-green-300">
                                    Rp {{ number_format($unpaidPayment->nominal_tagihan, 0, ',', '.') }}
                                </strong>
                            </div>
                        </div>

                        <!-- EKSEKUSI PEMBAYARAN MIDTRANS -->
                        <div class="pt-2 space-y-3">
                            <button type="button"
                                    onclick="bayarTransaksiactiv('{{ $unpaidPayment->id }}')"
                                    id="btn-{{ $unpaidPayment->id }}"
                                    class="w-full py-3.5 bg-[#195A36] hover:bg-[#124227] text-white font-bold text-xs sm:text-sm rounded-full shadow-xs transition flex items-center justify-center gap-2 cursor-pointer">
                                <span>Bayar Sekarang Via Midtrans</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
                            </button>

                            <div class="flex items-center justify-center gap-1.5 text-[10px] text-gray-400 font-medium">
                                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                                <span>Transaksi dienkripsi secara aman dan diproses otomatis via Midtrans Gateway.</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        @else
            <!-- TAMPILAN JIKA TIDAK ADA TAGIHAN AKTIF / SEMUA SUDAH LUNAS -->
            <div class="bg-white rounded-[24px] border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] p-10 text-center space-y-3">
                <div class="w-12 h-12 bg-[#e8f3ec] text-[#195A36] rounded-full flex items-center justify-center mx-auto font-bold text-lg">
                    ✓
                </div>
                <div class="space-y-1">
                    <h3 class="text-base font-bold text-gray-900">Tidak Ada Tagihan Aktif</h3>
                    <p class="text-xs text-gray-500 font-medium max-w-sm mx-auto leading-relaxed">
                        Seluruh tagihan invoice Anda telah berhasil dilunasi atau belum ada invoice baru yang diterbitkan.
                    </p>
                </div>
            </div>
        @endif

        <!-- SECTION RIWAYAT PEMBAYARAN LUNAS (IF ANY) -->
        @php
            $paidPayments = $payments->filter(function($p) {
                $status = $p->status_pembayaran?->value ?? $p->status_pembayaran;
                return $status === 'success';
            });
        @endphp

        @if($paidPayments->isNotEmpty())
            <div class="bg-white rounded-[24px] border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] overflow-hidden p-6 space-y-4">
                <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
                    <div class="w-7 h-7 rounded-full bg-[#e8f3ec] text-[#195A36] flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Riwayat Pembayaran Lunas</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/80 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                <th class="py-3 px-4 rounded-l-xl">Invoice</th>
                                <th class="py-3 px-4">Termin</th>
                                <th class="py-3 px-4">Nominal</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-right rounded-r-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs font-semibold text-gray-700">
                            @foreach($paidPayments as $paid)
                                <tr>
                                    <td class="py-3.5 px-4 font-mono font-bold text-gray-900">#{{ $paid->invoice_number }}</td>
                                    <td class="py-3.5 px-4">{{ $paid->termin === 'T1_60' ? 'Termin 1 (60%)' : 'Termin 2 (40%)' }}</td>
                                    <td class="py-3.5 px-4 text-[#195A36] font-mono font-bold">Rp {{ number_format($paid->nominal_tagihan, 0, ',', '.') }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-3 py-1 bg-[#e8f3ec] text-[#195A36] rounded-full text-[10px] font-bold uppercase">Lunas</span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <a href="{{ route('client.project.download_penawaran', $paid->project_id) }}" target="_blank" class="text-[#195A36] hover:underline text-[11px] font-bold">Unduh Penawaran ↗</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>

    <!-- SCRIPT UTAMA MIDTRANS SNAP (SANDBOX MODE) -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script type="text/javascript">
        function bayarTransaksiactiv(paymentId) {
            const btn = document.getElementById('btn-' + paymentId);
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span>Memuat Gerbang...</span>';
            btn.disabled = true;

            fetch(`/klien/pembayaran/${paymentId}/snap-token`)
                .then(response => response.json())
                .then(data => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;

                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            btn.innerHTML = '<span>Memverifikasi...</span>';
                            btn.disabled = true;

                            fetch(`/klien/pembayaran/${paymentId}/sukses`)
                            .then(res => res.json())
                            .then(resData => {
                                if (resData.status === 'success') {
                                    alert("✓ Pembayaran Berhasil Diverifikasi Sistem! Menuju Tahap Selanjutnya.");
                                    location.reload();
                                } else if (resData.status === 'pending') {
                                    alert("⚠️ " + (resData.message || "Pembayaran masih pending. Silakan selesaikan transaksi di simulator Midtrans."));
                                    location.reload();
                                } else {
                                    alert(resData.message || "Status pembayaran belum dapat dikonfirmasi.");
                                    location.reload();
                                }
                            })
                            .catch(err => {
                                console.error('Detail Sistem Error:', err);
                                alert("Gagal memverifikasi status pembayaran ke backend.");
                                location.reload();
                            });
                        },
                        onPending: function(result) {
                            alert("Menunggu Anda menyelesaikan transfer pembayaran di Midtrans Payment Simulator.");
                            location.reload();
                        },
                        onError: function(result) {
                            alert("Pembayaran gagal dilakukan.");
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        },
                        onClose: function() {
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memproses permintaan pembayaran.');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
        }
    </script>
</x-app-layout>

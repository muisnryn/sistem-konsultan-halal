<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Monitoring Pembayaran Proyek</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #10b981; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #065f46; font-size: 16px; }
        .header p { margin: 4px 0 0; color: #666; font-size: 10px; }
        .stats { margin-bottom: 15px; font-weight: bold; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; vertical-align: middle; }
        th { background-color: #f1f5f9; color: #334155; text-transform: uppercase; font-size: 9px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge-success { color: #047857; font-weight: bold; }
        .badge-pending { color: #b45309; font-weight: bold; }
        .badge-none { color: #94a3b8; font-style: italic; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 6px 12px; background: #059669; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
            Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" style="padding: 6px 12px; background: #e2e8f0; color: #333; border: none; border-radius: 6px; cursor: pointer; margin-left: 5px;">
            Tutup
        </button>
    </div>

    <div class="header">
        <h2>LAPORAN MONITORING PEMBAYARAN & TERMIN KLIEN</h2>
        <p>Sistem Pengajuan & Sertifikasi Halal — Tanggal Cetak: {{ date('d F Y') }}</p>
    </div>

    <div class="stats">
        Total Akumulasi Pendapatan Lunas: Rp {{ number_format($totalRevenue, 0, ',', '.') }}
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="22%">Klien & Merek Dagang</th>
                <th class="text-right" width="15%">Total Kontrak</th>
                <th class="text-center" width="23%">Termin 1 (60%)</th>
                <th class="text-center" width="23%">Termin 2 (40%)</th>
                <th class="text-center" width="12%">Status Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $index => $proj)
                @php
                    $company = $proj->klien->companyProfile ?? null;
                    $t1 = $proj->payments->where('termin', 'T1_60')->first();
                    $t2 = $proj->payments->where('termin', 'T2_40')->first();

                    $t1Status = $t1 ? (in_array($t1->status_pembayaran->value ?? $t1->status_pembayaran, ['paid', 'success', 'settlement']) ? 'LUNAS' : 'PENDING') : 'BELUM ADA';
                    $t2Status = $t2 ? (in_array($t2->status_pembayaran->value ?? $t2->status_pembayaran, ['paid', 'success', 'settlement']) ? 'LUNAS' : 'PENDING') : 'BELUM ADA';

                    $isAllPaid = ($t1Status === 'LUNAS' && $t2Status === 'LUNAS');
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $company->nama_perusahaan ?? $proj->nama_merek_dagang }}</strong><br>
                        <small style="color: #64748b;">Merek: {{ $proj->nama_merek_dagang }} ({{ $proj->kode_registrasi }})</small>
                    </td>
                    <td class="font-mono text-right">
                        <strong>Rp {{ number_format($proj->total_harga_kesepakatan, 0, ',', '.') }}</strong>
                    </td>
                    <td class="text-center">
                        @if($t1)
                            Rp {{ number_format($t1->nominal_tagihan, 0, ',', '.') }}<br>
                            <span class="{{ $t1Status === 'LUNAS' ? 'badge-success' : 'badge-pending' }}">{{ $t1Status }}</span>
                        @else
                            <span class="badge-none">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($t2)
                            Rp {{ number_format($t2->nominal_tagihan, 0, ',', '.') }}<br>
                            <span class="{{ $t2Status === 'LUNAS' ? 'badge-success' : 'badge-pending' }}">{{ $t2Status }}</span>
                        @else
                            <span class="badge-none">Belum Diterbitkan</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($isAllPaid)
                            <span class="badge-success">SELESAI LUNAS</span>
                        @else
                            <span class="badge-pending">BERJALAN</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data proyek atau pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
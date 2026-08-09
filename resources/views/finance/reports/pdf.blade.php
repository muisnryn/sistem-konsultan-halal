<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan & Pendapatan - PT Konsultan Halal Indonesia</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 15mm 15mm 15mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif, Arial, sans-serif;
            color: #111827;
            font-size: 11pt;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .font-mono { font-family: 'Courier New', Courier, monospace; }
        .uppercase { text-transform: uppercase; }

        .kop-header {
            width: 100%;
            border-bottom: 3px double #000000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }
        .kop-title {
            font-size: 16pt;
            font-weight: bold;
            color: #000000;
            letter-spacing: 0.5px;
        }
        .kop-subtitle {
            font-size: 9.5pt;
            color: #374151;
            margin-top: 2px;
        }

        .report-title-container {
            text-align: center;
            margin-bottom: 22px;
        }
        .report-title {
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .report-period {
            font-size: 10pt;
            margin-top: 4px;
            color: #4b5563;
        }

        .summary-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .summary-box td {
            border: 1px solid #9ca3af;
            padding: 8px 12px;
            vertical-align: top;
            background-color: #f9fafb;
        }
        .summary-label {
            font-size: 8.5pt;
            font-weight: bold;
            color: #4b5563;
            text-transform: uppercase;
        }
        .summary-value {
            font-size: 12pt;
            font-weight: bold;
            margin-top: 3px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .data-table th {
            background-color: #e5e7eb;
            color: #111827;
            font-size: 9.5pt;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #6b7280;
            padding: 7px 8px;
        }
        .data-table td {
            border: 1px solid #9ca3af;
            padding: 7px 8px;
            font-size: 10pt;
        }
        .data-table tfoot td {
            background-color: #f3f4f6;
            font-weight: bold;
            border-top: 2px solid #111827;
        }

        .signature-section {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .signature-space {
            height: 65px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT PERUSAHAAN RESMI -->
    <div class="kop-header">
        <table class="kop-table">
            <tr>
                <td class="text-left" style="vertical-align: middle;">
                    <div class="uppercase kop-title">PT KONSULTAN HALAL INDONESIA</div>
                    <div class="kop-subtitle">Layanan Sertifikasi & Pendampingan Halal Terintegrasi</div>
                    <div class="kop-subtitle">Jl. Raya Sertifikasi No. 10, Jakarta Pusat &bull; Telp: (021) 555-0192 &bull; Email: finance@halal.go.id</div>
                </td>
                <td class="text-right" style="vertical-align: middle; width: 200px;">
                    <div style="font-size: 9pt; color: #4b5563;">
                        <strong>Nomor:</strong> FIN/REP/{{ date('Ym') }}/{{ rand(100, 999) }}<br>
                        <strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i') }} WIB
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- JUDUL DOKUMEN LAPORAN -->
    <div class="report-title-container">
        <h1 class="uppercase report-title">LAPORAN KEUANGAN & REKAPITULASI PENDAPATAN</h1>
        <div class="report-period">
            Periode: <strong>{{ date('d F Y', strtotime($startDate)) }}</strong> s/d <strong>{{ date('d F Y', strtotime($endDate)) }}</strong>
        </div>
    </div>

    @php
        $sumGross = !empty($reportRows) ? array_sum(array_column($reportRows, 'gross_revenue')) : $totalRevenue;
        $sumTax = !empty($reportRows) ? array_sum(array_column($reportRows, 'tax_11')) : ($totalRevenue * 0.11);
        $sumNet = !empty($reportRows) ? array_sum(array_column($reportRows, 'net_revenue')) : ($totalRevenue - $sumTax);
        $sumTx = !empty($reportRows) ? array_sum(array_column($reportRows, 'transaction_count')) : $totalTransactions;
    @endphp

    <!-- RINGKASAN METRIK FINANSIAL -->
    <table class="summary-box">
        <tr>
            <td style="width: 33.33%;">
                <div class="summary-label">Total Pendapatan Kotor</div>
                <div class="font-mono summary-value">Rp {{ number_format($sumGross, 0, ',', '.') }}</div>
                <div style="font-size: 8.5pt; color: #6b7280; margin-top: 2px;">{{ number_format($sumTx) }} Transaksi Terverifikasi</div>
            </td>
            <td style="width: 33.33%;">
                <div class="summary-label">Estimasi Kewajiban Pajak (11%)</div>
                <div class="font-mono summary-value" style="color: #b91c1c;">Rp {{ number_format($sumTax, 0, ',', '.') }}</div>
                <div style="font-size: 8.5pt; color: #b91c1c; margin-top: 2px;">Potongan Kewajiban Pajak</div>
            </td>
            <td style="width: 33.33%; background-color: #f0fdf4;">
                <div class="summary-label" style="color: #166534;">Pendapatan Bersih (Nett)</div>
                <div class="font-mono summary-value" style="color: #15803d;">Rp {{ number_format($sumNet, 0, ',', '.') }}</div>
                <div style="font-size: 8.5pt; color: #166534; margin-top: 2px;">Nett Revenue Lembaga</div>
            </td>
        </tr>
    </table>

    <!-- TABEL DATA FINANSIAL PER KELOMPOK USAHA -->
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 6%;">No</th>
                <th class="text-left" style="width: 36%;">Kelompok Usaha Klien</th>
                <th class="text-center" style="width: 14%;">Jml Transaksi</th>
                <th class="text-right" style="width: 14.66%;">Pendapatan Kotor</th>
                <th class="text-right" style="width: 14.66%;">Pajak (11%)</th>
                <th class="text-right" style="width: 14.68%;">Pendapatan Bersih</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportRows as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-bold text-left">{{ $row['category_name'] }}</td>
                    <td class="font-mono text-center">{{ number_format($row['transaction_count']) }}</td>
                    <td class="font-mono text-right">Rp {{ number_format($row['gross_revenue'], 0, ',', '.') }}</td>
                    <td class="font-mono text-right" style="color: #b91c1c;">Rp {{ number_format($row['tax_11'], 0, ',', '.') }}</td>
                    <td class="font-mono font-bold text-right" style="color: #15803d;">Rp {{ number_format($row['net_revenue'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px; color: #6b7280;">
                        Tidak ada transaksi terverifikasi untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if(!empty($reportRows))
            <tfoot>
                <tr>
                    <td colspan="2" class="font-bold text-left uppercase">Total Keseluruhan</td>
                    <td class="font-mono font-bold text-center">{{ number_format($sumTx) }}</td>
                    <td class="font-mono font-bold text-right">Rp {{ number_format($sumGross, 0, ',', '.') }}</td>
                    <td class="font-mono font-bold text-right" style="color: #b91c1c;">Rp {{ number_format($sumTax, 0, ',', '.') }}</td>
                    <td class="font-mono font-bold text-right" style="color: #15803d;">Rp {{ number_format($sumNet, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- PENGESAHAN & TANDA TANGAN -->
    <div class="signature-section">
        <div style="font-size: 8.5pt; color: #6b7280; margin-bottom: 15px;">
            * Dokumen ini dibuat secara otomatis melalui Sistem Informasi SPK Halal dan dinyatakan sah sebagai laporan resmi bagian keuangan.
        </div>

        <table class="signature-table">
            <tr>
                <td>
                    <p style="margin: 0; color: #4b5563;">Dibuat Oleh,</p>
                    <p style="margin: 3px 0 0 0; font-weight: bold;">Manager Keuangan</p>
                    <div class="signature-space"></div>
                    <p class="font-bold uppercase" style="text-decoration: underline;">( ............................................ )</p>
                </td>
                <td>
                    <p style="margin: 0; color: #4b5563;">Disetujui Oleh,</p>
                    <p style="margin: 3px 0 0 0; font-weight: bold;">Direktur PT Konsultan Halal Indonesia</p>
                    <div class="signature-space"></div>
                    <p class="font-bold uppercase" style="text-decoration: underline;">( ............................................ )</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Enums\ProjectStatus;
use App\Enums\PaymentStatus;
use Illuminate\Support\Facades\Storage;

class FinanceProjectController extends Controller
{

    /**
     * Dashboard Ringkasan & Overview Keuangan
     */
    public function index()
    {
        // 1. Total Pendapatan Lunas
        $totalPaidRevenue = Payment::whereIn('status_pembayaran', ['paid', 'success', 'settlement'])->sum('nominal_tagihan');

        // 2. Total Pembayaran Menunggu (Outstanding)
        $totalOutstanding = Payment::where('status_pembayaran', 'pending')->sum('nominal_tagihan');
        $pendingPaymentsCount = Payment::where('status_pembayaran', 'pending')->count();

        // 3. Total Seluruh Transaksi / Invoice
        $totalTransactions = Payment::count();

        // 4. Pengajuan Masuk yang Butuh Penerbitan Invoice
        $pendingInvoiceCount = Project::where('status_proyek', ProjectStatus::PENGAJUAN_SUBMITTED)->count();

        // 5. Transaksi / Pembayaran Terbaru (Top 5)
        $recentPayments = Payment::with(['project.klien.companyProfile'])
            ->latest()
            ->take(5)
            ->get();

        return view('finance.dashboard', compact(
            'totalPaidRevenue',
            'totalOutstanding',
            'pendingPaymentsCount',
            'totalTransactions',
            'pendingInvoiceCount',
            'recentPayments'
        ));
    }

    /**
     * 2. Menu Halaman: Penerbitan Invoice
     */
    public function invoicesList()
    {
        $projects = Project::with('klien.companyProfile')
            ->where('status_proyek', ProjectStatus::PENGAJUAN_SUBMITTED)
            ->latest()
            ->get();

        return view('finance.invoices.index', compact('projects'));
    }

    /**
     * Form Input Harga Kesepakatan Final & Unggah Penawaran
     */
    public function edit($id)
    {
        $project = Project::with('klien.companyProfile')->findOrFail($id);
        $estimasiSistem = $this->hitungEstimasiAwal($project);

        return view('finance.project.edit', compact('project', 'estimasiSistem'));
    }

    /**
     * Memproses Harga Kesepakatan & Terbitkan Invoice T1 (60%).
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'total_harga_kesepakatan' => 'required|numeric|min:100000',
            'file_dokumen_penawaran'  => ($project->file_dokumen_penawaran ? 'nullable' : 'required') . '|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file_dokumen_penawaran')) {
            if ($project->file_dokumen_penawaran && Storage::disk('public')->exists($project->file_dokumen_penawaran)) {
                Storage::disk('public')->delete($project->file_dokumen_penawaran);
            }
            $path = $request->file('file_dokumen_penawaran')->store('documents/penawaran', 'public');
            $project->file_dokumen_penawaran = $path;
        }

        $project->total_harga_kesepakatan = $validated['total_harga_kesepakatan'];
        $project->status_proyek = ProjectStatus::WAITING_PAYMENT_T1;
        $project->save();

        $nominalT1 = $validated['total_harga_kesepakatan'] * 0.60;

        Payment::updateOrCreate(
            [
                'project_id' => $project->id,
                'termin'     => 'T1_60',
            ],
            [
                'invoice_number'    => 'INV-T1-' . strtoupper(uniqid()),
                'nominal_tagihan'   => $nominalT1,
                'status_pembayaran' => PaymentStatus::PENDING,
                'snap_token'        => null,
            ]
        );

        return redirect()->route('finance.invoices.index')
            ->with('success', 'Harga kesepakatan berhasil dikunci dan Invoice T1 (60%) telah resmi diterbitkan.');
    }

    /**
     * 3. Menu Halaman: Monitoring Pembayaran (Berbasis Proyek & Dual Termin)
     */
    public function paymentsList(Request $request)
    {
        // Total Pendapatan Lunas
        $totalRevenue = Payment::whereIn('status_pembayaran', ['paid', 'success', 'settlement'])->sum('nominal_tagihan');

        // Pending Pembayaran Termin 1
        $pendingTermin1 = Payment::where('termin', 'T1_60')
            ->where('status_pembayaran', 'pending')
            ->sum('nominal_tagihan');

        // Pending Pembayaran Termin 2
        $pendingTermin2 = Payment::where('termin', 'T2_40')
            ->where('status_pembayaran', 'pending')
            ->sum('nominal_tagihan');

        // Filter Tab Status
        $statusFilter = $request->get('status', 'all');

        $query = Project::with(['klien.companyProfile', 'payments'])
            ->whereNotNull('total_harga_kesepakatan')
            ->latest();

        if ($statusFilter === 'paid') {
            $query->whereDoesntHave('payments', function($q) {
                $q->where('status_pembayaran', 'pending');
            });
        } elseif ($statusFilter === 'unpaid') {
            $query->whereHas('payments', function($q) {
                $q->where('status_pembayaran', 'pending');
            });
        }

        $projects = $query->get();

        // Pengecekan otomatis Termin 1
        foreach ($projects as $proj) {
            $hasT1 = $proj->payments->where('termin', 'T1_60')->first();
            if (!$hasT1 && $proj->total_harga_kesepakatan > 0) {
                Payment::create([
                    'project_id' => $proj->id,
                    'termin' => 'T1_60',
                    'invoice_number' => 'INV-T1-' . strtoupper(uniqid()),
                    'nominal_tagihan' => $proj->total_harga_kesepakatan * 0.60,
                    'status_pembayaran' => PaymentStatus::PENDING,
                ]);
                $proj->load('payments');
            }
        }

        return view('finance.payments.index', compact(
            'projects',
            'totalRevenue',
            'pendingTermin1',
            'pendingTermin2',
            'statusFilter'
        ));
    }

    /**
     * Export Laporan Monitoring Pembayaran ke PDF
     */
    public function exportPdf(Request $request)
    {
        $statusFilter = $request->get('status', 'all');

        $query = Project::with(['klien.companyProfile', 'payments'])
            ->whereNotNull('total_harga_kesepakatan')
            ->latest();

        if ($statusFilter === 'paid') {
            $query->whereDoesntHave('payments', function($q) {
                $q->where('status_pembayaran', 'pending');
            });
        } elseif ($statusFilter === 'unpaid') {
            $query->whereHas('payments', function($q) {
                $q->where('status_pembayaran', 'pending');
            });
        }

        $projects = $query->get();
        $totalRevenue = Payment::whereIn('status_pembayaran', ['paid', 'success', 'settlement'])->sum('nominal_tagihan');

        return view('finance.payments.pdf', compact('projects', 'totalRevenue', 'statusFilter'));
    }

    /**
     * 4. Menu Halaman: Laporan Keuangan (Web View)
     */
    public function reportsList(Request $request)
    {
        $data = $this->getReportData($request);
        return view('finance.reports.index', $data);
    }

    /**
     * Export Dokumen Laporan Keuangan ke PDF Resmi
     */
    public function exportReportsPdf(Request $request)
    {
        $data = $this->getReportData($request);
        return view('finance.reports.pdf', $data);
    }

    /**
     * Helper terpusat untuk kalkulasi data Laporan Keuangan
     */
    private function getReportData(Request $request)
    {
        $startDate = $request->get('start_date', date('Y-01-01'));
        $endDate = $request->get('end_date', date('Y-m-d'));
        $categoryFilter = $request->get('category', 'all');

        // 1. Fetch seluruh transaksi pembayaran yang LUNAS / SUCCESS
        $paidPaymentsQuery = Payment::with(['project.klien.companyProfile'])
            ->whereIn('status_pembayaran', ['paid', 'success', 'settlement', PaymentStatus::PAID]);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $paidPaymentsQuery->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        $paidPayments = $paidPaymentsQuery->get();

        // 2. Ringkasan Total Atas
        $totalRevenue = $paidPayments->sum('nominal_tagihan');
        $totalTransactions = $paidPayments->count();

        // 3. Pengelompokan Dinamis berdasarkan profil perusahaan
        $grouped = $paidPayments->groupBy(function ($payment) {
            $cp = $payment->project->klien->companyProfile ?? null;

            if (!$cp) {
                return 'Tidak Diketahui / Tanpa Profil';
            }

            $jenis = trim($cp->jenis_kelompok_usaha ?? '');
            $lainnya = trim($cp->jenis_kelompok_usaha_lainnya ?? '');

            if (strtolower($jenis) === 'lainnya' || empty($jenis)) {
                return !empty($lainnya) ? $lainnya : 'Lainnya';
            }

            return $jenis;
        });

        // Daftar kategori unik untuk filter
        $availableCategories = $grouped->keys()->sort()->values()->toArray();

        // 4. Kalkulasi Pendapatan Kotor, Pajak 11%, dan Pendapatan Bersih
        $reportRows = [];

        foreach ($grouped as $catName => $payments) {
            if ($categoryFilter !== 'all' && $categoryFilter !== $catName) {
                continue;
            }

            $gross = $payments->sum('nominal_tagihan');
            $tax = $gross * 0.11;
            $net = $gross - $tax;

            $reportRows[] = [
                'category_name'     => $catName,
                'transaction_count' => $payments->count(),
                'gross_revenue'     => $gross,
                'tax_11'            => $tax,
                'net_revenue'       => $net,
            ];
        }

        return compact(
            'totalRevenue',
            'totalTransactions',
            'reportRows',
            'availableCategories',
            'startDate',
            'endDate',
            'categoryFilter'
        );
    }

    /**
     * Helper Hitung Estimasi Awal
     */
    private function hitungEstimasiAwal($project)
    {
        $skalaRaw = $project->klien->companyProfile->skala_perusahaan ?? 'kecil';
        $skala = strtolower($skalaRaw);

        $hargaDasar = ($skala === 'kecil') ? 5000000 : (($skala === 'menengah') ? 10000000 : 15000000);
        $biayaMenu  = ($skala === 'kecil') ? 500000 : (($skala === 'menengah') ? 1000000 : 1500000);

        $addonMenu = ($project->jumlah_produk > 50) ? ceil(($project->jumlah_produk - 50) / 30) * $biayaMenu : 0;
        $addonOutlet = ($project->jumlah_outlet > 1) ? ($project->jumlah_outlet - 1) * 1000000 : 0;

        return $hargaDasar + $addonMenu + $addonOutlet;
    }
}

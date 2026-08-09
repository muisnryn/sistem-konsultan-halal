<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Project;
use App\Enums\PaymentStatus;
use App\Enums\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class ClientPaymentController extends Controller
{
    /**
     * Konfigurasi Kunci API Midtrans
     */
    private function initMidtrans(): void
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized  = config('services.midtrans.is_sanitized', true);
        Config::$is3ds        = config('services.midtrans.is_3ds', true);
    }

    /**
     * Menampilkan daftar tagihan sekaligus bertindak sebagai Failsafe Parser Redirect Midtrans.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Tangkap data kembalian Midtrans & Verifikasi Langsung ke API Midtrans
        if ($request->has('order_id')) {
            $invoiceNumber = $request->query('order_id');
            $payment = Payment::where('invoice_number', $invoiceNumber)->first();

            if ($payment) {
                $this->verifikasiDanUpdateStatus($payment);
            }
        }

        $payments = Payment::with('project')
            ->whereHas('project', function ($query) use ($user) {
                $query->where('klien_id', $user->id);
            })
            ->latest()
            ->get();

        return view('client.payment.index', compact('payments'));
    }

    /**
     * Mengambil Snap Token dari Midtrans secara real-time via AJAX
     */
    public function getSnapToken($id)
    {
        $user = auth()->user();

        $payment = Payment::with('project.klien.companyProfile')
            ->where('id', $id)
            ->whereHas('project', function ($query) use ($user) {
                $query->where('klien_id', $user->id);
            })->firstOrFail();

        if ($payment->snap_token) {
            return response()->json(['snap_token' => $payment->snap_token]);
        }

        $this->initMidtrans();

        $params = [
            'transaction_details' => [
                'order_id'     => $payment->invoice_number,
                'gross_amount' => (int) $payment->nominal_tagihan,
            ],
            'item_details' => [
                [
                    'id'       => $payment->termin,
                    'price'    => (int) $payment->nominal_tagihan,
                    'quantity' => 1,
                    'name'     => 'Pendampingan Halal - ' . ($payment->termin === 'T1_60' ? 'Termin 1 (60%)' : 'Termin 2 (40%)'),
                ]
            ],
            'customer_details' => [
                'first_name' => $user->companyProfile?->pic_nama ?? $user->name,
                'email'      => $user->companyProfile?->pic_email ?? $user->email,
                'phone'      => $user->companyProfile?->pic_phone ?? '',
            ],
            'callbacks' => [
                'finish'   => route('client.payment.index'),
                'unfinish' => route('client.payment.index'),
                'error'    => route('client.payment.index'),
            ]
        ];

        try {
            $vendorCert = base_path('vendor/midtrans/midtrans-php/Midtrans/cert/cacert.pem');
            if (file_exists($vendorCert)) {
                ini_set('curl.cainfo', $vendorCert);
            }

            $snapToken = Snap::getSnapToken($params);

            $payment->snap_token = $snapToken;
            $payment->save();

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal terhubung ke Midtrans: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Memproses pembaruan status database via AJAX Callback (Terverifikasi Server API)
     */
    public function prosesPembayaranSukses($id)
    {
        $user = auth()->user();

        $payment = Payment::with('project')
            ->where('id', $id)
            ->whereHas('project', function ($query) use ($user) {
                $query->where('klien_id', $user->id);
            })->firstOrFail();

        if ($payment->status_pembayaran === PaymentStatus::SUCCESS) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Pembayaran telah terverifikasi lunas.'
            ], 200);
        }

        // Verifikasi kebenaran transaksi langsung ke Server API Midtrans
        $isSuccess = $this->verifikasiDanUpdateStatus($payment);

        if ($isSuccess) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Pembayaran berhasil dikonfirmasi.'
            ], 200);
        }

        // Mengembalikan HTTP 200 agar dibaca dengan lancar oleh JavaScript
        return response()->json([
            'status'  => 'pending',
            'message' => 'Status pembayaran belum dikonfirmasi oleh sistem Midtrans. Silakan selesaikan transaksi di simulator Midtrans.'
        ], 200);
    }

    /**
     * Webhook Handler (HTTP Notification) Resmi dari Server Midtrans (24/7 Auto Sync)
     */
    public function handleWebhook(Request $request)
    {
        $this->initMidtrans();

        $serverKey    = config('services.midtrans.server_key');
        $orderId      = $request->order_id;
        $statusCode   = $request->status_code;
        $grossAmount  = $request->gross_amount;
        $signatureKey = $request->signature_key;

        // Verifikasi SHA512 Signature Key untuk Mencegah Spoofing
        $mySignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $mySignature) {
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        $payment = Payment::where('invoice_number', $orderId)->first();
        if (!$payment) {
            return response()->json(['message' => 'Payment record not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $fraudStatus       = $request->fraud_status ?? 'accept';

        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            if ($transactionStatus == 'capture' && $fraudStatus == 'challenge') {
                $payment->status_pembayaran = PaymentStatus::PENDING;
            } else {
                $this->markAsSuccess($payment);
            }
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $payment->status_pembayaran = PaymentStatus::FAILED;
            $payment->save();
        }

        return response()->json(['message' => 'Webhook notification processed successfully']);
    }

    /**
     * Auxiliary: Verifikasi Langsung ke API Status Midtrans
     */
    private function verifikasiDanUpdateStatus(Payment $payment): bool
    {
        if ($payment->status_pembayaran === PaymentStatus::SUCCESS) {
            return true;
        }

        $this->initMidtrans();

        try {
            $status = Transaction::status($payment->invoice_number);
            $transactionStatus = is_object($status) ? $status->transaction_status : $status['transaction_status'];
            $fraudStatus       = is_object($status) ? ($status->fraud_status ?? 'accept') : ($status['fraud_status'] ?? 'accept');

            if (in_array($transactionStatus, ['settlement', 'capture'])) {
                if ($transactionStatus == 'capture' && $fraudStatus == 'challenge') {
                    return false;
                }

                $this->markAsSuccess($payment);
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }

    /**
     * Auxiliary: Tandai Pembayaran Lunas dan Transisi Status Proyek
     */
    private function markAsSuccess(Payment $payment): void
    {
        $payment->status_pembayaran = PaymentStatus::SUCCESS;
        $payment->save();

        $project = $payment->project;
        if ($project) {
            if ($payment->termin === 'T1_60') {
                $project->status_proyek = ProjectStatus::PAYMENT_T1_VERIFIED;
            } elseif ($payment->termin === 'T2_40') {
                $project->status_proyek = ProjectStatus::COMPLETED;
            }
            $project->save();
        }
    }

    /**
     * Unduh Berkas Penawaran PDF
     */
    public function downloadPenawaran($projectId)
    {
        $user = auth()->user();

        // Cari proyek milik klien yang bersangkutan
        $project = Project::where('id', $projectId)
            ->where('klien_id', $user->id)
            ->firstOrFail();

        // Cek keberadaan berkas penawaran
        if (!$project->file_dokumen_penawaran || !Storage::disk('public')->exists($project->file_dokumen_penawaran)) {
            return back()->with('error', 'Berkas dokumen penawaran belum tersedia atau telah dihapus.');
        }

        // Mengunduh / Menampilkan PDF secara aman
        $filePath = Storage::disk('public')->path($project->file_dokumen_penawaran);
        $fileName = 'Penawaran-HalalCert-' . $project->kode_registrasi . '.pdf';

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}

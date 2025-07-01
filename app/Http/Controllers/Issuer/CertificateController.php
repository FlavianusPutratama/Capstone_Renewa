<?php

namespace App\Http\Controllers\Issuer;

use App\Http\Controllers\Controller;
use App\Models\EnergyReport;
use App\Models\Certificate;
use App\Models\Order; // <-- PENTING: Import model Order
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    /**
     * Menyetujui laporan energi dan menerbitkan sertifikat.
     */
    public function issue(Request $request, EnergyReport $report)
    {
        // ... (method ini tidak berubah)
        if ($report->status !== 'pending_verification') {
            return redirect()->route('issuer.dashboard')->with('error', 'Laporan ini sudah diproses.');
        }

        try {
            DB::transaction(function () use ($report) {
                $report->status = 'approved';
                $report->save();

                $ownerId = $report->powerPlant->user_id;

                Certificate::create([
                    'energy_report_id' => $report->id,
                    'issuer_id' => Auth::id(),
                    'owner_id' => $ownerId,
                    'certificate_uid' => 'REC-' . now()->year . '-' . strtoupper(Str::random(8)),
                    'amount_mwh' => $report->amount_mwh,
                    'generation_start_date' => $report->reporting_period_start,
                    'generation_end_date' => $report->reporting_period_end,
                    'status' => 'available_for_sale',
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->route('issuer.dashboard')->with('error', 'Gagal menerbitkan sertifikat. Terjadi kesalahan: ' . $e->getMessage());
        }
        
        return redirect()->route('issuer.dashboard')->with('success', 'Sertifikat berhasil diterbitkan dari laporan.');
    }

    /**
     * Menolak laporan energi.
     */
    public function reject(Request $request, EnergyReport $report)
    {
        // ... (method ini tidak berubah)
        $request->validate(['rejection_reason' => 'required|string|max:255']);

        if ($report->status !== 'pending_verification') {
            return redirect()->route('issuer.dashboard')->with('error', 'Laporan ini sudah diproses.');
        }

        $report->status = 'rejected';
        $report->rejection_reason = $request->rejection_reason;
        $report->save();

        return redirect()->route('issuer.dashboard')->with('success', 'Laporan energi telah ditolak.');
    }

    /**
     * Menyetujui pembayaran dan mentransfer kepemilikan sertifikat.
     * Ini adalah simulasi transaksi on-chain `transferCertificate()`.
     */
    public function approvePayment(Request $request, Order $order)
    {
        // Pastikan order masih menunggu konfirmasi
        if ($order->status !== 'awaiting_confirmation') {
            return redirect()->route('issuer.dashboard')->with('error', 'Pesanan ini sudah diproses sebelumnya.');
        }

        try {
            DB::transaction(function () use ($order) {
                // 1. Ubah status pesanan menjadi 'completed'
                $order->status = 'completed';
                $order->order_completed_at = now();
                $order->save();

                // 2. Temukan semua sertifikat yang terkait dengan pesanan ini (logika yang lebih baik)
                // Untuk sekarang, kita asumsikan 1 order = 1 sertifikat (berdasarkan certificate_id)
                $certificate = Certificate::findOrFail($order->certificate_id);
                
                // 3. Transfer Kepemilikan & Ubah Status Sertifikat
                $certificate->owner_id = $order->buyer_id;
                $certificate->status = 'sold'; // atau 'retired' jika langsung digunakan
                $certificate->save();
            });
        } catch (\Exception $e) {
            return redirect()->route('issuer.dashboard')->with('error', 'Gagal menyelesaikan transaksi. Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('issuer.dashboard')->with('success', 'Pembayaran untuk pesanan #' . $order->order_uid . ' telah disetujui dan sertifikat telah ditransfer.');
    }

    /**
     * Menolak pembayaran.
     */
    public function rejectPayment(Request $request, Order $order)
    {
        // Logika untuk menolak pembayaran bisa dikembangkan di sini.
        // Contoh: mengembalikan status order ke 'pending_payment' atau 'cancelled'.
        // Dan mengembalikan status sertifikat dari 'on_hold' ke 'available_for_sale'.

        return redirect()->route('issuer.dashboard')->with('info', 'Fitur tolak pembayaran sedang dalam pengembangan.');
    }
}

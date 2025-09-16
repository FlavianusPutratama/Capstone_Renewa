<?php

namespace App\Http\Controllers\Issuer;

use App\Http\Controllers\Controller;
use App\Models\EnergyReport;
use App\Models\Certificate;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingReports = EnergyReport::with(['powerPlant.user'])
            ->where('status', 'pending_verification')
            ->orderBy('created_at', 'asc')
            ->get();

        $pendingOrders = Order::where('status', 'awaiting_confirmation')
            ->whereHas('certificates.energyReport.powerPlant')
            ->with(['buyer', 'certificates.energyReport.powerPlant'])
            ->orderBy('created_at', 'asc')
            ->get();

        $recIssuedThisMonth = Certificate::whereYear('created_at', Carbon::now()->year)
                                          ->whereMonth('created_at', Carbon::now()->month)
                                          ->sum('amount_mwh');

        $stats = [
            'pending_reviews' => $pendingReports->count(),
            'pending_payments' => $pendingOrders->count(),
            'rec_issued_month' => $recIssuedThisMonth,
        ];

        return view('issuer.dashboard', compact('pendingReports', 'pendingOrders', 'stats'));
    }

    /**
     * VERSI FINAL: Memverifikasi pembayaran dengan mem-bypass Route-Model Binding.
     */
    public function verifyPayment($orderId)
    {
        DB::beginTransaction();
        try {
            // Cari Order secara manual menggunakan ID, sama seperti di tes diagnostik.
            $order = Order::findOrFail($orderId);

            if ($order->status !== 'awaiting_confirmation') {
                throw new \Exception('Pesanan ini tidak lagi dalam status menunggu konfirmasi.');
            }

            // Jalankan logika yang sudah terbukti benar.
            $order->certificates()->update(['status' => 'sold']);
            $order->status = 'completed';
            $order->payment_confirmed_at = Carbon::now();
            $order->save();

            DB::commit();

            return redirect()->route('issuer.dashboard')->with('success', 'Pembayaran untuk pesanan ' . $order->order_uid . ' telah berhasil diverifikasi.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Verifikasi Gagal untuk Order ID: {$orderId}. Pesan: " . $e->getMessage());
            return redirect()->route('issuer.dashboard')->with('error', 'Gagal menyelesaikan transaksi. Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
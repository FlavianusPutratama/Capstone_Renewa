<?php

namespace App\Http\Controllers\Issuer;

use App\Http\Controllers\Controller;
use App\Models\EnergyReport;
use App\Models\Certificate;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan data utama di dashboard issuer.
     */
    public function index()
    {
        // 1. Ambil laporan energi yang perlu diverifikasi
        $pendingReports = EnergyReport::with(['powerPlant.user'])
            ->where('status', 'pending_verification')
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. Ambil pesanan yang pembayarannya perlu diverifikasi
        // PERBAIKAN: Mengubah 'certificate' menjadi 'certificates'
        $pendingOrders = Order::with(['buyer', 'certificates.energyReport.powerPlant'])
            ->where('status', 'awaiting_confirmation')
            ->orderBy('created_at', 'asc')
            ->get();

        // 3. Hitung statistik
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
     * FUNGSI BARU: Memverifikasi pembayaran sebuah pesanan.
     */
    public function verifyPayment(Order $order)
    {
        // Memastikan order ada dan statusnya 'awaiting_confirmation'
        if ($order && $order->status == 'awaiting_confirmation') {
            
            // Mengubah status order menjadi 'completed'
            $order->status = 'completed';
            $order->save();

            // PERBAIKAN: Menggunakan relasi 'certificates' (jamak) untuk update
            // Ini akan mengubah status SEMUA sertifikat yang terkait menjadi 'sold'
            $order->certificates()->update(['status' => 'sold']);

            return redirect()->route('issuer.dashboard')->with('success', 'Pembayaran untuk pesanan ' . $order->order_uid . ' telah berhasil diverifikasi.');
        }

        return redirect()->route('issuer.dashboard')->with('error', 'Pesanan tidak ditemukan atau sudah diverifikasi.');
    }
}
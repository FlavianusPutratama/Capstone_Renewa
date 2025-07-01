<?php

namespace App\Http\Controllers\Issuer;

use App\Http\Controllers\Controller;
use App\Models\EnergyReport;
use App\Models\Certificate;
use App\Models\Order; // <-- PENTING: Import model Order
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil laporan energi yang perlu diverifikasi
        $pendingReports = EnergyReport::with(['powerPlant.user'])
            ->where('status', 'pending_verification')
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. Ambil pesanan yang pembayarannya perlu diverifikasi
        $pendingOrders = Order::with(['buyer', 'certificate.energyReport.powerPlant'])
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
}

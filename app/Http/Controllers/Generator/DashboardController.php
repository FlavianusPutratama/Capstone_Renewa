<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\Controller;
use App\Models\EnergyReport;
use App\Models\Certificate;
use App\Models\PowerPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dasbor untuk Generator.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Ambil data dasar yang diperlukan
        $powerPlants = PowerPlant::where('user_id', $user->id)->get();
        $powerPlantIds = $powerPlants->pluck('id');
        $powerPlant = $powerPlants->first();

        // 2. Siapkan query untuk mengambil laporan energi
        $query = EnergyReport::whereIn('power_plant_id', $powerPlantIds);

        // (Opsional) Terapkan filter dan sorting pada query
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        $sortBy = $request->input('sort_by', 'newest');
        if ($sortBy === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // --- INI BAGIAN PENTING ---
        // 3. JALANKAN QUERY dan ambil datanya dari database
        $energyReports = $query->get();

        // 4. SETELAH DATA DIAMBIL, baru lakukan perhitungan
        $totalEnergyGenerated = $energyReports->sum('amount_mwh');
        $totalCertificatesIssued = Certificate::whereIn('energy_report_id', $energyReports->pluck('id'))->sum('amount_mwh');
        $totalReportsPending = $energyReports->where('status', 'pending_verification')->count();

        // 5. Kirim semua variabel yang sudah benar ke view
        return view('generator.dashboard', compact(
            'user',
            'powerPlants',
            'powerPlant',
            'energyReports',
            'totalEnergyGenerated',
            'totalCertificatesIssued',
            'totalReportsPending'
        ));
    }
}
<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\Controller;
use App\Models\EnergyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dasbor untuk Generator.
     */
    public function index(Request $request)
    {
        $user = Auth::user()->load('powerPlants');
        $powerPlant = $user->powerPlants->first();

        // Ambil ID dari semua pembangkit milik user
        $powerPlantIds = $user->powerPlants->pluck('id');

        // Mulai query untuk mengambil laporan
        $query = EnergyReport::whereIn('power_plant_id', $powerPlantIds);

        // Terapkan filter status jika ada
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Terapkan sorting
        $sortBy = $request->input('sort_by', 'newest');
        if ($sortBy === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Ambil data laporan setelah filter dan sort
        $energyReports = $query->get();

        return view('generator.dashboard', [
            'user' => $user,
            'powerPlant' => $powerPlant,
            'energyReports' => $energyReports,
            'filters' => $request->only(['status', 'sort_by']), // Kirim filter ke view
        ]);
    }
}

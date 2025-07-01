<?php

namespace App\Http\Controllers\Generator;

use App\Http\Controllers\Controller;
use App\Models\EnergyReport;
use App\Models\PowerPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnergyReportController extends Controller
{
    /**
     * Menyimpan laporan produksi energi yang baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form
        $validated = $request->validate([
            'power_plant_id' => 'required|exists:power_plants,id',
            'reporting_period_start' => 'required|date',
            'reporting_period_end' => 'required|date|after_or_equal:reporting_period_start',
            'amount_mwh' => 'required|numeric|min:0',
            'supporting_document' => 'nullable|file|mimes:pdf|max:2048', // Opsional, maks 2MB
        ]);

        // 2. Otorisasi: Pastikan pembangkit ini milik pengguna yang login
        $powerPlant = PowerPlant::findOrFail($validated['power_plant_id']);
        if ($powerPlant->user_id !== Auth::id()) {
            // Jika bukan pemilik, tolak akses
            return back()->with('error', 'Anda tidak memiliki izin untuk melaporkan produksi untuk pembangkit ini.');
        }

        $documentPath = null;
        // 3. Jika ada dokumen, simpan
        if ($request->hasFile('supporting_document')) {
            $documentPath = $request->file('supporting_document')->store('report_documents', 'public');
        }

        // 4. Buat laporan baru di database
        EnergyReport::create([
            'power_plant_id' => $validated['power_plant_id'],
            'reporting_period_start' => $validated['reporting_period_start'],
            'reporting_period_end' => $validated['reporting_period_end'],
            'amount_mwh' => $validated['amount_mwh'],
            'supporting_document_path' => $documentPath,
            'status' => 'pending_verification', // Status awal
        ]);

        // 5. Kembalikan ke dasbor dengan pesan sukses
        return redirect()->route('generator.dashboard')->with('success', 'Laporan produksi energi berhasil diajukan dan sedang menunggu verifikasi.');
    }
}
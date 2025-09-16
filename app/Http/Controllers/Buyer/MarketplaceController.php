<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\PowerPlant;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    /**
     * Menampilkan halaman marketplace dengan daftar pembangkit yang dikelompokkan.
     */
    public function index(Request $request)
    {
        // Cek apakah pengguna sudah memilih kategori.
        if (!$request->has('category')) {
            return redirect()->route('buyer.categoryselect')->with('info', 'Silakan pilih kategori pembelian terlebih dahulu.');
        }

        // Validasi input dari URL
        $validated = $request->validate([
            'category' => 'required|string|in:Retail,Signature,Enterprise',
        ]);

        $category = $validated['category'];

        // Tentukan minimal pembelian di sisi server
        $minPurchase = match ($category) {
            'Retail' => 10,
            'Enterprise' => 200,
            default => 0,
        };

        // Query utama untuk mengambil data Pembangkit
        $query = PowerPlant::query()
            ->with('user') // Eager load relasi user
            ->withSum(['certificates' => function ($query) {
                // Pastikan hanya menjumlahkan sertifikat yang tersedia
                $query->where('certificates.status', 'available_for_sale');
            }], 'amount_mwh')
            // Pastikan hanya menampilkan pembangkit yang punya sertifikat
            ->whereHas('certificates', function ($query) {
                $query->where('certificates.status', 'available_for_sale');
            });

        // Filter berdasarkan total energi yang tersedia harus lebih besar dari minimal pembelian
        // (Contoh: Jangan tampilkan pembangkit 150 MWh jika kategori Enterprise min. 200)
        $query->having('certificates_sum_amount_mwh', '>=', $minPurchase);

        // Eksekusi query
        $powerPlants = $query->get();
        
        // ======================================================
        // === PERBAIKANNYA DI SINI ===
        // ======================================================
        // Buat array $filters untuk dikirim ke view.
        $filters = [
            'category' => $category
        ];

        // Kirim 'powerPlants' dan 'filters' ke view.
        return view('buyer.marketplace', compact('powerPlants', 'filters'));
    }
}
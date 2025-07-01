<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\PowerPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Validasi input dari URL, hanya untuk kategori
        $validated = $request->validate([
            'category' => 'required|string|in:Retail,Signature,Enterprise',
        ]);

        $category = $validated['category'];

        // Tentukan minimal pembelian yang BENAR di sisi server berdasarkan kategori.
        $minPurchase = match ($category) {
            'Retail' => 10,
            'Enterprise' => 200,
            default => 0, // Untuk 'Signature' atau kategori lain di masa depan
        };

        // Query utama: Ambil data Pembangkit
        $query = PowerPlant::query();

        // Tambahkan query untuk menjumlahkan MWh dari sertifikat yang TERSEDIA
        // dengan menyebutkan nama tabel secara eksplisit pada 'status'.
        $query->withSum(['certificates' => function ($query) {
            $query->where('certificates.status', 'available_for_sale');
        }], 'amount_mwh')
        ->has('certificates');

        // Terapkan filter berdasarkan minimal pembelian yang sudah kita tentukan di server
        $query->having('certificates_sum_amount_mwh', '>=', $minPurchase);
        
        // Eager load relasi owner untuk menampilkan nama generator
        $query->with('user');

        // Eksekusi query
        $powerPlants = $query->get();
        
        // Kirim data ke view
        return view('buyer.marketplace', [
            'powerPlants' => $powerPlants,
            'category' => $category,
        ]);
    }
}
<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\PowerPlant;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    /**
     * Menampilkan halaman detail untuk satu pembangkit listrik.
     */
    public function show(Request $request, PowerPlant $powerPlant) // <-- Tambahkan Request $request
    {
        $powerPlant->load(['user']);

        $availableMwh = $powerPlant->certificates()
                                   ->where('certificates.status', 'available_for_sale')
                                   ->sum('certificates.amount_mwh');

        // Tentukan min_purchase berdasarkan kategori dari URL
        $category = $request->query('category', 'Signature'); // Default ke Signature
        $minPurchase = match ($category) {
            'Retail' => 10,
            'Enterprise' => 200,
            default => 0,
        };

        return view('buyer.product-detail', [
            'powerPlant' => $powerPlant,
            'availableMwh' => $availableMwh,
            'category' => $category, // <-- Kirim kategori ke view
            'minPurchase' => $minPurchase, // <-- Kirim min_purchase yang aman ke view
        ]);
    }
}

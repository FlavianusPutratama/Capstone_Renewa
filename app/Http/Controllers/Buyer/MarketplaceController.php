<?php

// app\Http\Controllers\Buyer\MarketplaceController.php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');
        $minQuantity = 0;

        switch ($category) {
            case 'Retail':
                $minQuantity = 10;
                break;
            case 'Signature':
                $minQuantity = 0; // Tidak ada minimum
                break;
            case 'Enterprise':
                $minQuantity = 200;
                break;
            default:
                $minQuantity = 0; // Default jika tidak ada kategori
                break;
        }

        $products = [
            [
                'name' => 'PLTP Ulubelu Geothermal Project Energy',
                'price' => 120000,
                'image' => 'https://cdn01.metrotvnews.com/img/ekonomi/2024/PLTP%20Ulubelu%20(PLN%20IP).jpeg.jpg',
                'description' => 'Sumber energi: Panas Bumi',
                'capacity' => 110, // kapasitas dalam MW
            ],
            [
                'name' => 'PLTA Cirata',
                'price' => 225000,
                'image' => 'https://zonaebt.com/wp-content/uploads/5b35231b7e6789107916bcba8e4539a3-1.jpg',
                'description' => 'Sumber energi : Air - Dam',
                'capacity' => 1008,
            ],
            [
                'name' => 'PLTP Kamojang',
                'price' => 500000,
                'image' => 'https://rm.id/images/berita/med/pltp-kamojang-unit-1-cikal-bakal-pembangkit-geothermal-di-tanah-air_30180.jpg',
                'description' => 'Sumber energi: Panas Bumi',
                'capacity' => 140,
            ],
            [
                'name' => 'PLTM LAMBUR',
                'price' => 85000,
                'image' => 'https://cdn1-production-images-kly.akamaized.net/HRrsxlitdlL-gK09qVFiDinM0iQ=/500x281/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/3986892/original/084621700_1649234074-WhatsApp_Image_2022-04-06_at_09.24.06.jpeg',
                'description' => 'Sumber energi: Air',
                'capacity' => 9,
            ],
            [
                'name' => 'PLTA Bakaru',
                'price' => 150000,
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSE_oXOrTfDn2TzeDW59YRkbvUHpH2i8vzPOg&s',
                'description' => 'Sumber energi: Air',
                'capacity' => 130,
            ],
            [
                'name' => 'PLTP Lahendong',
                'price' => 100000,
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTIH-N3kuH4tDviyt4jF-FcdomGsEup3v-1DQ&s',
                'description' => 'Sumber energi: Panas Bumi',
                'capacity' => 80,
            ],
        ];
        

        return view('buyer.marketplace', compact('products', 'category', 'minQuantity'));
    }
}
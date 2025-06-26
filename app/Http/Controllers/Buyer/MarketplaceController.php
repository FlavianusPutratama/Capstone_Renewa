<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');
        $minQuantity = 0;

        switch ($category) {
            case 'Retail': $minQuantity = 10; break;
            case 'Signature': $minQuantity = 0; break;
            case 'Enterprise': $minQuantity = 200; break;
            default: $minQuantity = 0; break;
        }

        $products = [
            [
                'generator_id' => 1, // <-- ID DITAMBAHKAN
                'name' => 'PLTP Ulubelu Geothermal Project Energy',
                'price' => 35000, // <-- HARGA DIUBAH
                'image' => 'https://cdn01.metrotvnews.com/img/ekonomi/2024/PLTP%20Ulubelu%20(PLN%20IP).jpeg.jpg',
                'description' => 'Sumber energi: Panas Bumi',
                'capacity' => 110,
            ],
            [
                'generator_id' => 2, // <-- ID DITAMBAHKAN
                'name' => 'PLTA Cirata',
                'price' => 35000, // <-- HARGA DIUBAH
                'image' => 'https://zonaebt.com/wp-content/uploads/5b35231b7e6789107916bcba8e4539a3-1.jpg',
                'description' => 'Sumber energi: Air - Dam',
                'capacity' => 1008,
            ],
            [
                'generator_id' => 3, // <-- ID DITAMBAHKAN
                'name' => 'PLTP Kamojang',
                'price' => 35000, // <-- HARGA DIUBAH
                'image' => 'https://rm.id/images/berita/med/pltp-kamojang-unit-1-cikal-bakal-pembangkit-geothermal-di-tanah-air_30180.jpg',
                'description' => 'Sumber energi: Panas Bumi',
                'capacity' => 140,
            ],
            [
                'generator_id' => 4,
                'name' => 'PLTM LAMBUR',
                'price' => 35000,
                'image' => 'https://cdn1-production-images-kly.akamaized.net/HRrsxlitdlL-gK09qVFiDinM0iQ=/500x281/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/3986892/original/084621700_1649234074-WhatsApp_Image_2022-04-06_at_09.24.06.jpeg',
                'description' => 'Sumber energi: Air',
                'capacity' => 9,
            ],
            [
                'generator_id' => 5,
                'name' => 'PLTA Bakaru',
                'price' => 35000,
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSE_oXOrTfDn2TzeDW59YRkbvUHpH2i8vzPOg&s',
                'description' => 'Sumber energi: Air',
                'capacity' => 130,
            ],
            [
                'generator_id' => 6,
                'name' => 'PLTP Lahendong',
                'price' => 35000,
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTIH-N3kuH4tDviyt4jF-FcdomGsEup3v-1DQ&s',
                'description' => 'Sumber energi: Panas Bumi',
                'capacity' => 80,
            ],
        ];

        $availableEnergy = DB::table('energy_data')
            ->select('source_type', DB::raw('SUM(amount_kwh) as total_kwh'))
            ->groupBy('source_type')
            ->get()
            ->keyBy('source_type');

        foreach ($products as $key => $product) {
            $sourceType = trim(str_replace(['Sumber energi:', ' '], '', $product['description']));
            
            if (isset($availableEnergy[$sourceType])) {
                $kwh = $availableEnergy[$sourceType]->total_kwh;
                $products[$key]['available_mwh'] = $kwh / 1000;
            } else {
                $products[$key]['available_mwh'] = 0; 
            }
        }

        return view('buyer.marketplace', compact('products', 'category', 'minQuantity'));
    }
}
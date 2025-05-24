<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Renewa</title>
    <meta name="description" content="Marketplace untuk pembelian produk energi terbarukan.">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css')
    
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 via-white to-green-100">
    @include('layouts.partials.navbar')

    <main class="pt-32 pb-12 bg-gradient-to-br from-green-50 via-white to-green-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-4xl font-bold mb-6 text-center text-gray-900">
                Temukan Solusi Energi Terbarukan yang Tepat untuk Anda
            </h2>
    
            @if(isset($category))
                <div class="text-center mb-4">
                    <p>Kategori yang dipilih: <strong>{{ $category }}</strong></p>
                    <p>Minimum pembelian: <strong>{{ $minQuantity }}</strong> unit</p>
                </div>
            @endif
    
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $product['name'] }}</h3>
                        <p class="text-gray-600 mt-2">{{ $product['description'] }}</p>
                        <p class="text-gray-600 mt-1">Kapasitas (MW): <strong>{{ $product['capacity'] }}</strong></p>
                        <p class="text-green-600 font-bold mt-4">Rp{{ number_format($product['price'], 0, ',', '.') }}</p>
                        <a href="#" class="mt-4 inline-block text-green-600 hover:text-green-800 font-semibold">Lihat Detail</a>
                    </div>
                </div>
                @endforeach
            </div>                        
        </div>
    </main>            

    <footer class="bg-gray-800 text-white py-12 mt-16">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400">© 2025 Renewa Indonesia. Seluruh hak dilindungi undang-undang.</p>
        </div>
    </footer>

</body>
</html>

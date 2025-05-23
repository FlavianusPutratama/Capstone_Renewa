<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Renewa</title>
    <meta name="description" content="Marketplace untuk pembelian produk energi terbarukan.">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 via-white to-green-100">
    <nav class="bg-white shadow-sm py-4 mb-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-10">
                <a href="/" class="font-bold text-xl text-gray-800">Renewa</a>
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-green-500">Beranda</a>
                    <a href="{{ route('generatormap') }}" class="text-gray-600 hover:text-green-500">Peta Pembangkit</a>
                    <a href="#" class="text-gray-600 hover:text-green-500">Beli REC</a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('profile.show') }}" class="text-green-600 hover:text-green-700">
                        {{ $greeting ?? 'Halo' }}, {{ Auth::user()->name }}!
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Logout</button>
                    </form>
                @else
                    <a href="{{ route('buyer.login') }}" class="text-green-600 hover:text-green-700">Masuk</a>
                    <a href="{{ route('buyer.register') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-12 bg-gradient-to-br from-green-50 via-white to-green-100">
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

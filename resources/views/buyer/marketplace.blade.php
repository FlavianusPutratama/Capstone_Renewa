<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Renewa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 via-white to-green-100">
    @include('layouts.partials.navbar')

    <main class="pt-32 pb-12 bg-gradient-to-br from-green-50 via-white to-green-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div id="product-list-section">
                <h2 class="text-4xl font-bold mb-6 text-center text-gray-900">
                    Temukan Solusi Energi Terbarukan yang Tepat untuk Anda
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-48 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $product['name'] }}</h3>
                            <p class="text-gray-600 mt-2">{{ $product['description'] }}</p>
                            <p class="text-gray-600 mt-1">Kapasitas (MW): <strong>{{ $product['capacity'] }}</strong></p>
                            <p class="text-blue-600 mt-2">Energi Tersedia: <strong>{{ number_format($product['available_mwh'], 2, ',', '.') }} MWh</strong></p>
                            <div class="mt-auto pt-4">
                                <p class="text-green-600 font-bold text-xl mt-2">Rp{{ number_format($product['price'], 0, ',', '.') }}</p>
                                <button onclick="showPurchaseDetails('{{ json_encode($product) }}')" class="mt-4 w-full text-center bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                                    Beli
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>                        
            </div>

            <div id="purchase-section" class="hidden">
            </div>
        </div>
    </main>              

    <footer class="bg-gray-800 text-white py-12 mt-16">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400">© 2025 Renewa Indonesia. Seluruh hak dilindungi undang-undang.</p>
        </div>
    </footer>

    <script>
        const productListSection = document.getElementById('product-list-section');
        const purchaseSection = document.getElementById('purchase-section');

        function showPurchaseDetails(productJson) {
            // Konversi string JSON dari data produk menjadi objek
            const product = JSON.parse(productJson);
            
            // Mengisi data ke elemen-elemen di bagian pembelian
            document.getElementById('purchase-img').src = product.image;
            document.getElementById('purchase-name').innerText = product.name;
            document.getElementById('purchase-description').innerText = product.description;
            document.getElementById('purchase-capacity').innerText = product.capacity;
            
            // Format harga ke format Rupiah
            document.getElementById('purchase-price').innerText = 'Rp' + new Intl.NumberFormat('id-ID').format(product.price);

            // Menyembunyikan daftar produk dan menampilkan bagian pembelian
            productListSection.classList.add('hidden');
            purchaseSection.classList.remove('hidden');

            // Scroll ke atas halaman agar pengguna langsung melihat form pembelian
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function backToList() {
            // Menyembunyikan bagian pembelian dan menampilkan kembali daftar produk
            purchaseSection.classList.add('hidden');
            productListSection.classList.remove('hidden');
        }
    </script>

</body>
</html>
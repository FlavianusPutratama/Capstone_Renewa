<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Kode ini menggunakan $filters['category'], bukan $data --}}
    <title>Marketplace - {{ $filters['category'] }} - Renewa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('layouts.partials.navbar')

    <main class="py-12 pt-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <header class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800">Temukan Solusi Energi Terbarukan</h1>
                 {{-- Kode ini menggunakan $filters['category'], bukan $data --}}
                <p class="text-lg text-gray-600 mt-2">Menampilkan pembangkit untuk kategori: <span class="font-semibold text-green-600">{{ $filters['category'] }}</span></p>
            </header>

            @if($powerPlants->isEmpty())
                <div class="text-center py-20 bg-white rounded-2xl shadow-md">
                    <i class="fas fa-store-slash fa-5x text-gray-300 mb-4"></i>
                    <h2 class="text-2xl font-semibold text-gray-600">Pembangkit Tidak Ditemukan</h2>
                    <p class="text-gray-500 mt-2">Saat ini belum ada pembangkit yang memenuhi kriteria kategori Anda. Silakan coba kategori lain.</p>
                    <a href="{{ route('buyer.categoryselect') }}" class="mt-6 inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">Kembali ke Pemilihan Kategori</a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {{-- Kode ini menggunakan $powerPlants, bukan $data --}}
                    @foreach ($powerPlants as $powerPlant)
                        <a href="{{ route('buyer.marketplace.show', [
                            'powerPlant' => $powerPlant->id, 
                            'category' => $filters['category'],
                        ]) }}" class="group block bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col transform transition-transform hover:-translate-y-2">
                            <div class="h-48 w-full">
                                @if($powerPlant->image_url)
                                    <img src="{{ $powerPlant->image_url }}" alt="Foto {{ $powerPlant->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image fa-3x text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="text-xl font-bold text-gray-900 truncate group-hover:text-green-600 transition" title="{{ $powerPlant->name }}">{{ $powerPlant->name }}</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600">Sumber energi: <span class="font-semibold">{{ $powerPlant->energy_type }}</span></p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-200 flex-grow">
                                    <p class="text-sm text-gray-600">Energi Tersedia:</p>
                                    <p class="font-bold text-green-600 text-lg">{{ number_format($powerPlant->certificates_sum_amount_mwh, 2, ',', '.') }} MWh</p>
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                      <p class="text-xl font-bold text-gray-800">Rp35.000 <span class="text-sm font-normal text-gray-500">/ MWh</span></p>
                                      <span class="bg-green-500 text-white font-bold py-2 px-6 rounded-lg transition-all group-hover:bg-green-600">
                                          Lihat Detail
                                      </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    <footer class="text-center py-8 mt-12 text-gray-500 text-sm">
        © {{ date('Y') }} Renewa Indonesia. Seluruh hak dilindungi undang-undang.
    </footer>
</body>
</html>
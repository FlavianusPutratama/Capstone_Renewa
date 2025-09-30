<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Perusahaan: {{ $company->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('layouts.partials.navbar')

    <main class="py-12 pt-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl p-8">
                <header class="text-center mb-10 border-b pb-8">
                    <h1 class="text-4xl font-bold text-gray-800">{{ $company->name }}</h1>
                    <p class="text-lg text-gray-600 mt-2">Riwayat Pembelian Renewable Energy Certificate (REC)</p>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Alamat</p>
                        <p class="text-xl font-medium text-gray-800">{{ $company->address }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">NIB</p>
                        <p class="text-xl font-mono text-gray-800">{{ $company->nib }}</p>
                    </div>
                </div>

                <div class="mt-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Riwayat Transaksi</h2>
                    @if($company->user->orders->isEmpty())
                        <div class="text-center py-10 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">Perusahaan ini belum memiliki riwayat pembelian REC.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($company->user->orders as $order)
                                <a href="{{ route('rec.show', $order->order_uid) }}" class="block p-4 border rounded-lg bg-white hover:bg-gray-50 transition-colors">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold text-green-700">Order ID: {{ $order->order_uid }}</p>
                                            <p class="text-sm text-gray-600 mt-1">
                                                <i class="fas fa-calendar-alt mr-2"></i>
                                                Tanggal Pembelian: {{ $order->created_at->format('d F Y') }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-lg text-gray-800">
                                                {{ number_format($order->certificates->sum('amount_mwh'), 2, ',', '.') }} MWh
                                            </p>
                                            <span class="text-sm text-green-600">Lihat Detail <i class="fas fa-arrow-right ml-1"></i></span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <div class="text-center mt-12">
                    <a href="{{ route('welcome') }}#track-section" class="text-green-600 hover:text-green-800 font-medium transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
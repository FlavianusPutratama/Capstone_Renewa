<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sertifikat REC - Order #{{ $order->order_uid }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .certificate-bg {
            background-image: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
            border: 1px solid #d1fae5;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('layouts.partials.navbar')

    <main class="py-12 pt-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto certificate-bg rounded-2xl shadow-xl p-8 md:p-12">
                <header class="text-center mb-10 border-b-2 border-green-200 pb-8">
                    <i class="fas fa-check-circle fa-4x text-green-500 mb-4"></i>
                    <h1 class="text-4xl font-bold text-gray-800">Sertifikat Energi Terbarukan</h1>
                    <p class="text-lg text-gray-600 mt-2">Bukti Kontribusi Terhadap Energi Bersih</p>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Diterbitkan Untuk</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $order->buyer->company->name ?? 'Informasi Perusahaan Tidak Tersedia' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Order ID</p>
                        <p class="text-2xl font-mono text-green-700 bg-green-100 p-2 rounded-lg inline-block">{{ $order->order_uid }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Tanggal Pembelian</p>
                        <p class="text-xl font-medium text-gray-800">{{ $order->created_at->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase">Total Energi Terverifikasi</p>
                        <p class="text-xl font-bold text-gray-800">{{ number_format($totalMwh, 2, ',', '.') }} MWh</p>
                    </div>
                </div>

                <div class="mt-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Rincian Sumber Energi</h2>
                    <div class="space-y-4">
                        @foreach($order->certificates as $certificate)
                        <div class="p-4 border rounded-lg bg-white/50">
                            <p class="font-semibold text-gray-800">{{ $certificate->energyReport->powerPlant->name }}</p>
                            <div class="flex justify-between items-center text-sm text-gray-600 mt-1">
                                <span><i class="fas fa-plug mr-2"></i>Tipe: {{ $certificate->energyReport->powerPlant->energy_type }}</span>
                                <span><i class="fas fa-calendar-alt mr-2"></i>Periode Pembangkitan: {{ $certificate->generation_start_date->format('M Y') }}</span>
                                <span class="font-bold text-green-700">{{ number_format($certificate->amount_mwh, 2, ',', '.') }} MWh</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="text-center mt-12">
                    <a href="{{ route('welcome') }}" class="text-green-600 hover:text-green-800 font-medium transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
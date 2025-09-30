<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran - Pesanan #{{ $order->order_uid }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('layouts.partials.navbar')

    <main class="py-12 pt-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto">
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-200 rounded-xl text-green-700 text-sm flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                @endif
                @if(session('info'))
                    <div class="mb-6 p-4 bg-blue-100 border border-blue-200 rounded-xl text-blue-700 text-sm flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>{{ session('info') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-200 rounded-xl text-red-700 text-sm flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
                    </div>
                @endif


                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="text-center mb-8 border-b pb-6">
                        @if($order->status == 'pending_payment')
                            <i class="fas fa-file-invoice-dollar fa-3x text-yellow-500 mb-4"></i>
                            <h1 class="text-3xl font-bold text-gray-800">Lanjutkan Pembayaran</h1>
                        @elseif($order->status == 'awaiting_confirmation')
                            <i class="fas fa-hourglass-half fa-3x text-blue-500 mb-4"></i>
                            <h1 class="text-3xl font-bold text-gray-800">Menunggu Konfirmasi</h1>
                        @elseif($order->status == 'completed')
                            <i class="fas fa-check-circle fa-3x text-green-500 mb-4"></i>
                            <h1 class="text-3xl font-bold text-gray-800">Pesanan Selesai</h1>
                        @endif
                        <p class="text-gray-500 mt-1">Detail untuk pesanan <span class="font-semibold text-gray-700">#{{ $order->order_uid }}</span>.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status Pesanan:</span>
                            @if($order->status == 'pending_payment')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Pembayaran</span>
                            @elseif($order->status == 'awaiting_confirmation')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Menunggu Konfirmasi</span>
                            @elseif($order->status == 'completed')
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Jumlah REC Dibeli:</span>
                            <span class="text-xl font-bold text-gray-900">{{ number_format($totalMwh, 2, ',', '.') }} MWh</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Pembayaran:</span>
                            <span class="text-xl font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    @if($order->status == 'pending_payment')
                    <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                        <h3 class="font-semibold text-lg mb-4">Instruksi Transfer (Simulasi)</h3>
                        <p class="text-sm text-gray-600 mb-2">Silakan lakukan transfer ke nomor Virtual Account di bawah ini:</p>
                        <div class="p-4 bg-white border rounded-md text-center">
                            <p class="text-sm text-gray-500">Bank Renewa (Contoh)</p>
                            <p class="text-2xl font-mono font-bold tracking-widest text-gray-800 my-2">{{ $order->virtual_account_number }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="mt-8">
                        @if($order->status == 'pending_payment')
                            <p class="text-center text-sm text-gray-500 mb-4">Setelah Anda melakukan pembayaran, klik tombol di bawah ini.</p>
                            <form action="{{ route('buyer.orders.confirm', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg transition-all text-lg">
                                    <i class="fas fa-check-circle mr-2"></i>Saya Sudah Bayar
                                </button>
                            </form>
                        @elseif($order->status == 'awaiting_confirmation')
                             <div class="text-center p-4 bg-blue-50 rounded-lg">
                                <p class="text-blue-700">Terima kasih atas konfirmasi Anda. Pesanan akan segera diverifikasi oleh tim kami.</p>
                             </div>
                        @else
                             <div class="text-center p-4 bg-green-50 rounded-lg space-y-3">
                                <p class="text-green-700">Pesanan ini telah selesai. Terima kasih telah mendukung energi terbarukan!</p>
                                <a href="{{ route('buyer.orders.certificate', $order->id) }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition-all">
                                    <i class="fas fa-certificate mr-2"></i>Lihat Sertifikat
                                </a>
                             </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
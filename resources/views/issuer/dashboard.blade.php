<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Issuer Dashboard - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alpine.js untuk fungsionalitas Tab --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .modal-overlay { background-color: rgba(0, 0, 0, 0.5); transition: opacity 0.3s ease; }
        .navbar-scrolled { backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.9); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    {{-- Inisialisasi Alpine.js untuk Tab --}}
    <div x-data="{ activeTab: 'reports' }" class="min-h-screen">
        @include('layouts.partials.navbar')

        <header class="bg-white shadow-md mt-20">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    <i class="fas fa-certificate mr-3 text-blue-500"></i>
                    <span>Issuer Dashboard</span>
                </h2>
                <p class="text-sm text-gray-500 mt-1">Pusat verifikasi laporan dan pengelolaan transaksi.</p>
            </div>
        </header>

        <main>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-md" role="alert">
                            <p class="font-bold">Sukses</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                     @if(session('error'))
                        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-md" role="alert">
                            <p class="font-bold">Error</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-blue-400 to-indigo-500 text-white p-6 rounded-2xl shadow-lg"><p class="text-sm uppercase">Laporan Perlu Ditinjau</p><p class="text-3xl font-bold">{{ $pendingReports->count() }}</p></div>
                        <div class="bg-gradient-to-br from-amber-400 to-orange-500 text-white p-6 rounded-2xl shadow-lg"><p class="text-sm uppercase">Pembayaran Perlu Dikonfirmasi</p><p class="text-3xl font-bold">{{ $pendingOrders->count() }}</p></div>
                        <div class="bg-gradient-to-br from-teal-400 to-green-500 text-white p-6 rounded-2xl shadow-lg"><p class="text-sm uppercase">REC Diterbitkan (Bulan Ini)</p><p class="text-3xl font-bold">{{ number_format($stats['rec_issued_month'] ?? 0, 0, ',', '.') }}</p></div>
                    </div>
                    
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button @click="activeTab = 'reports'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'reports', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'reports' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none">Verifikasi Laporan Energi</button>
                            <button @click="activeTab = 'payments'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'payments', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'payments' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none">Verifikasi Pembayaran</button>
                        </nav>
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                        <!-- Tab 1: Verifikasi Laporan Energi -->
                        <div x-show="activeTab === 'reports'" x-cloak class="p-6 md:p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">Antrian Verifikasi Laporan Produksi</h3>
                            @if($pendingReports->isEmpty())
                                <div class="text-center py-16"><p class="text-gray-500">Tidak ada laporan yang perlu diverifikasi.</p></div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50"><tr><th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Generator & Pembangkit</th><th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Detail Laporan</th><th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th></tr></thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($pendingReports as $report)
                                                <tr class="hover:bg-blue-50/50">
                                                    <td class="px-6 py-4"><div class="font-medium text-gray-900">{{ $report->powerPlant->user->name }}</div><div class="text-sm text-gray-500">{{ $report->powerPlant->name }}</div></td>
                                                    <td class="px-6 py-4"><div class="font-bold text-gray-800">{{ number_format($report->amount_mwh, 2, ',', '.') }} MWh</div><div class="text-sm text-gray-500">{{ $report->reporting_period_start->format('d M Y') }} - {{ $report->reporting_period_end->format('d M Y') }}</div></td>
                                                    <td class="px-6 py-4 text-center"><button data-report='@json($report)' class="review-report-btn inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50">Tinjau</button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Tab 2: Verifikasi Pembayaran -->
                        <div x-show="activeTab === 'payments'" x-cloak class="p-6 md:p-8" style="display: none;">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">Antrian Konfirmasi Pembayaran</h3>
                            @if($pendingOrders->isEmpty())
                                <div class="text-center py-16"><p class="text-gray-500">Tidak ada pembayaran yang perlu dikonfirmasi.</p></div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left">Pembeli & Pesanan</th><th class="px-6 py-3 text-left">Detail Transaksi</th><th class="px-6 py-3 text-center">Aksi</th></tr></thead>
                                        <tbody>
                                            @foreach($pendingOrders as $order)
                                            <tr class="hover:bg-blue-50/50">
                                                <td class="px-6 py-4"><div class="font-medium">{{ $order->buyer->name }}</div><div class="text-sm text-gray-500">#{{ $order->order_uid }}</div></td>
                                                <td class="px-6 py-4"><div class="font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div><div class="text-sm text-gray-500">Dikonfirmasi pada: {{ $order->payment_confirmed_at->format('d M Y, H:i') }}</div></td>
                                                <td class="px-6 py-4 text-center">
                                                    <div class="flex justify-center space-x-2">
                                                        <form action="{{ route('issuer.orders.approvePayment', $order->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menyetujui pembayaran ini?');">
                                                            @csrf
                                                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md">Setujui</button>
                                                        </form>
                                                        <form action="{{ route('issuer.orders.rejectPayment', $order->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menolak pembayaran ini?');">
                                                            @csrf
                                                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md">Tolak</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <div id="reviewModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay hidden opacity-0">
        <div id="modalCard" class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl m-4 transform transition-all duration-300 scale-95 opacity-0">
            <div class="flex justify-between items-center p-6 border-b"><h3 class="text-2xl font-bold text-gray-800">Detail Laporan Produksi</h3><button id="closeModalButton" class="text-gray-400 hover:text-gray-600">&times;</button></div>
            <div id="modalBody" class="p-8"></div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('reviewModal');
            const modalCard = document.getElementById('modalCard');
            const closeModalButton = document.getElementById('closeModalButton');
            const modalBody = document.getElementById('modalBody');
            const reviewButtons = document.querySelectorAll('.review-report-btn');

            function openModal() {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modalCard.classList.remove('scale-95', 'opacity-0');
                    modalCard.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeModal() {
                modalCard.classList.remove('scale-100', 'opacity-100');
                modalCard.classList.add('scale-95', 'opacity-0');
                modal.classList.add('opacity-0');
                setTimeout(() => { modal.classList.add('hidden'); }, 300);
            }

            reviewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const reportData = JSON.parse(this.dataset.report);
                    const periodStart = new Date(reportData.reporting_period_start).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                    const periodEnd = new Date(reportData.reporting_period_end).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                    
                    let documentLink = '#';
                    let documentHtml = '<span class="text-sm text-gray-400">Tidak ada dokumen.</span>';
                    if (reportData.supporting_document_path) {
                        documentLink = `/storage/${reportData.supporting_document_path}`;
                        documentHtml = `<a href="${documentLink}" target="_blank" class="text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center p-2 bg-blue-50 hover:bg-blue-100 rounded-lg transition-all"><i class="fas fa-file-pdf fa-lg mr-2"></i><span>Lihat Dokumen PDF</span></a>`;
                    }
                    
                    const issueUrl = `{{ route('issuer.reports.issue', ['report' => ':reportId']) }}`.replace(':reportId', reportData.id);
                    const rejectUrl = `{{ route('issuer.reports.reject', ['report' => ':reportId']) }}`.replace(':reportId', reportData.id);
                    
                    modalBody.innerHTML = `
                        <div class="space-y-4">
                            <div><dt class="text-sm font-medium text-gray-500">Nama Generator</dt><dd class="mt-1 text-lg text-gray-900">${reportData.power_plant.user.name}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Nama Pembangkit</dt><dd class="mt-1 text-lg text-gray-900">${reportData.power_plant.name}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Periode</dt><dd class="mt-1 text-lg text-gray-900">${periodStart} - ${periodEnd}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Jumlah Energi</dt><dd class="mt-1 text-2xl font-bold text-green-600">${Number(reportData.amount_mwh).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})} MWh</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Dokumen Pendukung</dt><dd class="mt-1">${documentHtml}</dd></div>
                        </div>
                        <div class="mt-8 pt-6 border-t">
                            <form action="${rejectUrl}" method="POST" id="rejectForm-${reportData.id}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <label for="rejection_reason-${reportData.id}" class="block text-sm font-medium text-gray-700">Alasan Penolakan (Wajib diisi jika menolak)</label>
                                <textarea name="rejection_reason" id="rejection_reason-${reportData.id}" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: Data tidak sesuai..."></textarea>
                            </form>
                        </div>
                        <div class="mt-4 flex justify-end space-x-4">
                            <button type="submit" form="rejectForm-${reportData.id}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg">Tolak</button>
                            <form action="${issueUrl}" method="POST" onsubmit="return confirm('Anda yakin ingin MENERBITKAN SERTIFIKAT dari laporan ini?');">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg">Terbitkan REC</button>
                            </form>
                        </div>
                    `;
                    openModal();
                });
            });
            
            closeModalButton.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
            window.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal(); });
        });
    </script>
</body>
</html>

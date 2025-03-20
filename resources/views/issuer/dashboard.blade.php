<!-- resources/views/issuer/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Penerbit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Selamat datang, {{ Auth::user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="font-medium text-green-700 mb-2">Total REC Diterbitkan</h4>
                            <p class="text-2xl font-bold">0</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="font-medium text-blue-700 mb-2">REC Terjual</h4>
                            <p class="text-2xl font-bold">0</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                            <h4 class="font-medium text-purple-700 mb-2">Penjualan (IDR)</h4>
                            <p class="text-2xl font-bold">Rp 0</p>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4">
                        <h4 class="font-medium mb-3">Tindakan Cepat</h4>
                        <div class="flex space-x-3">
                            <a href="#" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                Terbitkan REC Baru
                            </a>
                            <a href="#" class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg">
                                Kelola Sertifikat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Marketplace</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $product)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $product['name'] }}</h3>
                    <p class="text-gray-600 mt-2">{{ $product['description'] }}</p>
                    <p class="text-indigo-600 font-bold mt-4">Rp{{ number_format($product['price'], 0, ',', '.') }}</p>
                    <a href="#" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-semibold">Lihat Detail</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

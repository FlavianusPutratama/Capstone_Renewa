<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<nav class="bg-white shadow-lg py-4 fixed w-full top-0 z-50 transition-all duration-300" id="navbar">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center space-x-10">
            <a href="/" class="font-bold text-2xl bg-green-600 to-blue-600 bg-clip-text text-transparent">
                <i class="fas fa-leaf mr-2"></i>Renewa
            </a>
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'text-green-600 font-semibold border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600 font-medium' }} transition-all duration-300 hover:scale-105">
                    <i class="fas fa-home mr-1"></i>Beranda
                </a>
                <a href="{{ route('generatormap') }}" class="{{ request()->routeIs('generatormap') ? 'text-green-600 font-semibold border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600 font-medium' }} transition-all duration-300 hover:scale-105">
                    <i class="fas fa-map-marked-alt mr-1"></i>Peta Pembangkit
                </a>
                <a href="#" class="text-gray-700 hover:text-green-600 font-medium transition-all duration-300 hover:scale-105">
                    <i class="fas fa-shopping-cart mr-1"></i>Beli REC
                </a>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            @auth
                @php
                    date_default_timezone_set('Asia/Bangkok');
                    $currentTime = date('H:i');
                    
                    if ($currentTime >= '01:00' && $currentTime < '10:00') {
                        $greeting = 'Pagi';
                        $icon = 'fa-sun';
                    } elseif ($currentTime >= '10:00' && $currentTime < '14:30') {
                        $greeting = 'Siang';
                        $icon = 'fa-sun';
                    } elseif ($currentTime >= '14:30' && $currentTime < '18:00') {
                        $greeting = 'Sore';
                        $icon = 'fa-cloud-sun';
                    } else {
                        $greeting = 'Malam';
                        $icon = 'fa-moon';
                    }
                @endphp
                <a href="{{ route('profile.show') }}" class="text-green-600 hover:text-green-700 font-medium transition-all duration-300 flex items-center" >
                    <i class="fas {{ $icon }} mr-2"></i>{{ $greeting }}, {{ Auth::user()->name }}!
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-2 rounded-full font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            @else
                <a href="{{ route('buyer.login', ['source' => 'navbar']) }}" class="text-green-600 hover:text-green-700 font-medium transition-all duration-300">
                    <i class="fas fa-sign-in-alt mr-1"></i>Masuk
                </a>
                <a href="{{ route('buyer.register') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-2 rounded-full font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-user-plus mr-1"></i>Daftar
                </a>
            @endauth
        </div>
    </div>
</nav>
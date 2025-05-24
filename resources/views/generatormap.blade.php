<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Pembangkit EBT - Renewa</title>
    <meta name="description" content="Peta interaktif pembangkit Energi Baru Terbarukan di Indonesia">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Custom styles */
        html {
            scroll-behavior: smooth;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .navbar-scrolled {
            backdrop-filter: blur(15px);
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .hero-pattern {
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(120, 219, 226, 0.4) 0%, transparent 50%);
            background-size: 100% 100%;
        }
        
        .map-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .map-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 35px 70px rgba(0, 0, 0, 0.2);
        }
        
        .floating-card {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .floating-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(16, 185, 129, 0.1) 0%, rgba(34, 197, 94, 0.1) 100%);
            border-radius: inherit;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }
        
        .floating-card:hover::before {
            opacity: 1;
        }
        
        .floating-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.2);
        }
        
        .stats-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            transform: translateY(-5px);
        }
        
        .feature-icon {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
        
        .loading-shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        .energy-icon-solar {
            color: #f59e0b;
            filter: drop-shadow(0 2px 4px rgba(245, 158, 11, 0.3));
        }
        
        .energy-icon-wind {
            color: #06b6d4;
            filter: drop-shadow(0 2px 4px rgba(6, 182, 212, 0.3));
        }
        
        .energy-icon-hydro {
            color: #3b82f6;
            filter: drop-shadow(0 2px 4px rgba(59, 130, 246, 0.3));
        }
        
        .energy-icon-geo {
            color: #ef4444;
            filter: drop-shadow(0 2px 4px rgba(239, 68, 68, 0.3));
        }
        
        .energy-icon-bio {
            color: #10b981;
            filter: drop-shadow(0 2px 4px rgba(16, 185, 129, 0.3));
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 via-white to-blue-50">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md shadow-lg py-4 fixed w-full top-0 z-50 transition-all duration-300" id="navbar">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-10">
                <a href="/" class="font-bold text-2xl bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent" data-aos="fade-right" data-aos-duration="800">
                    <i class="fas fa-leaf mr-2"></i>Renewa
                </a>
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-green-600 font-medium transition-all duration-300 hover:scale-105" data-aos="fade-down" data-aos-delay="100">
                        <i class="fas fa-home mr-1"></i>Beranda
                    </a>
                    <a href="{{ route('generatormap') }}" class="text-green-600 font-semibold border-b-2 border-green-600" data-aos="fade-down" data-aos-delay="200">
                        <i class="fas fa-map-marked-alt mr-1"></i>Peta Pembangkit
                    </a>
                    <a href="#" class="text-gray-700 hover:text-green-600 font-medium transition-all duration-300 hover:scale-105" data-aos="fade-down" data-aos-delay="300">
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
                    <a href="{{ route('profile.show') }}" class="text-green-600 hover:text-green-700 font-medium transition-all duration-300 flex items-center" data-aos="fade-left" data-aos-delay="100">
                        <i class="fas {{ $icon }} mr-2"></i>{{ $greeting }}, {{ Auth::user()->name }}!
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-2 rounded-full font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg" data-aos="fade-left" data-aos-delay="200">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('buyer.login') }}" class="text-green-600 hover:text-green-700 font-medium transition-all duration-300" data-aos="fade-left" data-aos-delay="100">
                        <i class="fas fa-sign-in-alt mr-1"></i>Masuk
                    </a>
                    <a href="{{ route('buyer.register') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-2 rounded-full font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg" data-aos="fade-left" data-aos-delay="200">
                        <i class="fas fa-user-plus mr-1"></i>Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-16 gradient-bg hero-pattern relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-green-600/20"></div>
        <div class="absolute top-0 left-0 w-full h-full">
            <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
            <div class="absolute top-1/2 right-1/3 w-48 h-48 bg-green-400/10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-1/4 left-1/2 w-40 h-40 bg-blue-400/10 rounded-full blur-xl"></div>
        </div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight" data-aos="fade-up" data-aos-duration="1000">
                    Peta Pembangkit <span class="bg-gradient-to-r from-green-300 to-blue-300 bg-clip-text text-transparent">Energi Terbarukan</span>
                </h1>
                <p class="text-xl text-white/90 mb-8 leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                    Jelajahi lokasi pembangkit energi baru terbarukan di seluruh Indonesia dan lihat kontribusi nyata dalam mengurangi emisi karbon
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center" data-aos="fade-up" data-aos-delay="400">
                    <button onclick="scrollToMap()" class="bg-white text-gray-800 px-8 py-4 rounded-full font-semibold hover:bg-green-50 transition-all duration-300 hover:scale-105 hover:shadow-xl flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
                        Lihat Peta Interaktif
                    </button>
                    <a href="#statistics" class="text-white border-2 border-white/30 px-8 py-4 rounded-full font-semibold hover:bg-white/10 transition-all duration-300 hover:scale-105 flex items-center">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Lihat Statistik
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="statistics" class="py-16 bg-gradient-to-r from-green-50 to-blue-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4" data-aos="fade-up">Statistik Pembangkit EBT</h2>
                <p class="text-xl text-gray-600" data-aos="fade-up" data-aos-delay="200">Data terkini pembangkit energi terbarukan di Indonesia</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
                <div class="stats-card rounded-2xl p-6 text-center floating-card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="text-4xl mb-4 energy-icon-solar">
                        <i class="fas fa-sun pulse-animation"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Tenaga Surya</h3>
                    <p class="text-3xl font-bold text-gray-800 counter" data-target="2500">0</p>
                    <p class="text-sm text-gray-600">MW Terpasang</p>
                </div>
                
                <div class="stats-card rounded-2xl p-6 text-center floating-card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="text-4xl mb-4 energy-icon-wind">
                        <i class="fas fa-wind pulse-animation"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Tenaga Angin</h3>
                    <p class="text-3xl font-bold text-gray-800 counter" data-target="1800">0</p>
                    <p class="text-sm text-gray-600">MW Terpasang</p>
                </div>
                
                <div class="stats-card rounded-2xl p-6 text-center floating-card" data-aos="zoom-in" data-aos-delay="300">
                    <div class="text-4xl mb-4 energy-icon-hydro">
                        <i class="fas fa-water pulse-animation"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Tenaga Air</h3>
                    <p class="text-3xl font-bold text-gray-800 counter" data-target="6500">0</p>
                    <p class="text-sm text-gray-600">MW Terpasang</p>
                </div>
                
                <div class="stats-card rounded-2xl p-6 text-center floating-card" data-aos="zoom-in" data-aos-delay="400">
                    <div class="text-4xl mb-4 energy-icon-geo">
                        <i class="fas fa-mountain pulse-animation"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Panas Bumi</h3>
                    <p class="text-3xl font-bold text-gray-800 counter" data-target="2300">0</p>
                    <p class="text-sm text-gray-600">MW Terpasang</p>
                </div>
                
                <div class="stats-card rounded-2xl p-6 text-center floating-card" data-aos="zoom-in" data-aos-delay="500">
                    <div class="text-4xl mb-4 energy-icon-bio">
                        <i class="fas fa-leaf pulse-animation"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Bioenergi</h3>
                    <p class="text-3xl font-bold text-gray-800 counter" data-target="1200">0</p>
                    <p class="text-sm text-gray-600">MW Terpasang</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Map Section -->
    <section id="map-section" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4" data-aos="fade-up">Peta Interaktif Pembangkit EBT</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                    Klik pada marker di peta untuk melihat detail pembangkit energi terbarukan, termasuk kapasitas, jenis teknologi, dan status operasional
                </p>
            </div>
            
            <div class="max-w-6xl mx-auto">
                <div class="map-container bg-white shadow-2xl" data-aos="zoom-in" data-aos-duration="1000">
                    <div class="aspect-w-16 aspect-h-10 rounded-2xl overflow-hidden">
                        <iframe 
                            src="https://www.google.com/maps/d/embed?mid=1cG4o5P8LSzr-ZB1WL2oK9rV8Ic7I77g&ehbc=2E312F&noprof=1" 
                            width="100%" 
                            height="600" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy"
                            class="w-full h-full">
                        </iframe>
                    </div>
                </div>
                
                <!-- Map Controls -->
                <div class="flex flex-wrap justify-center gap-4 mt-8" data-aos="fade-up" data-aos-delay="400">
                    <button class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-full font-medium hover:from-green-600 hover:to-green-700 transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center">
                        <i class="fas fa-search-plus mr-2"></i>Zoom In
                    </button>
                    <button class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-full font-medium hover:from-blue-600 hover:to-blue-700 transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center">
                        <i class="fas fa-layer-group mr-2"></i>Filter
                    </button>
                    <button class="bg-gradient-to-r from-purple-500 to-purple-600 text-white px-6 py-3 rounded-full font-medium hover:from-purple-600 hover:to-purple-700 transition-all duration-300 hover:scale-105 hover:shadow-lg flex items-center">
                        <i class="fas fa-download mr-2"></i>Export Data
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-green-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4" data-aos="fade-up">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600" data-aos="fade-up" data-aos-delay="200">Explore berbagai fitur canggih untuk analisis pembangkit EBT</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 shadow-xl floating-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-5xl mb-6 feature-icon text-center">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Analisis Real-time</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Monitor performa pembangkit secara real-time dengan data yang terupdate setiap saat
                    </p>
                </div>
                
                <div class="bg-white rounded-2xl p-8 shadow-xl floating-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-5xl mb-6 feature-icon text-center">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Cakupan Nasional</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Database lengkap pembangkit EBT di seluruh Indonesia dari Sabang sampai Merauke
                    </p>
                </div>
                
                <div class="bg-white rounded-2xl p-8 shadow-xl floating-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-5xl mb-6 feature-icon text-center">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Data Terverifikasi</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Semua data telah diverifikasi dan bersumber dari instansi resmi pemerintah
                    </p>
                </div>
                
                <div class="bg-white rounded-2xl p-8 shadow-xl floating-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-5xl mb-6 feature-icon text-center">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Mobile Friendly</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Interface responsif yang dapat diakses dengan mudah dari berbagai perangkat
                    </p>
                </div>
                
                <div class="bg-white rounded-2xl p-8 shadow-xl floating-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="text-5xl mb-6 feature-icon text-center">
                        <i class="fas fa-download"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Export Data</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Download data dalam berbagai format untuk analisis lebih lanjut
                    </p>
                </div>
                
                <div class="bg-white rounded-2xl p-8 shadow-xl floating-card" data-aos="fade-up" data-aos-delay="600">
                    <div class="text-5xl mb-6 feature-icon text-center">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">Notifikasi Update</h3>
                    <p class="text-gray-600 text-center leading-relaxed">
                        Dapatkan notifikasi otomatis untuk setiap update data pembangkit baru
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 gradient-bg hero-pattern relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-green-600/30 to-blue-600/30"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-4xl font-bold text-white mb-6" data-aos="fade-up">Siap Berkontribusi untuk Energi Bersih?</h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Bergabunglah dengan revolusi energi terbarukan Indonesia dan mulai investasi pada masa depan yang berkelanjutan
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center" data-aos="fade-up" data-aos-delay="400">
                @auth
                    <a href="{{ route('buyer.categoryselect') }}" class="bg-white text-gray-800 px-8 py-4 rounded-full font-semibold hover:bg-green-50 transition-all duration-300 hover:scale-105 hover:shadow-xl flex items-center">
                        <i class="fas fa-shopping-cart mr-2 text-green-600"></i>
                        Beli REC Sekarang
                    </a>
                @else
                    <a href="{{ route('buyer.login') }}" class="bg-white text-gray-800 px-8 py-4 rounded-full font-semibold hover:bg-green-50 transition-all duration-300 hover:scale-105 hover:shadow-xl flex items-center">
                        <i class="fas fa-shopping-cart mr-2 text-green-600"></i>
                        Beli REC Sekarang
                    </a>
                @endauth
                
                <a href="{{ route('welcome') }}" class="text-white border-2 border-white/30 px-8 py-4 rounded-full font-semibold hover:bg-white/10 transition-all duration-300 hover:scale-105 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16" data-aos="fade-up">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-6">
                        <i class="fas fa-leaf text-3xl text-green-400 mr-3"></i>
                        <span class="font-bold text-2xl bg-gradient-to-r from-green-400 to-blue-400 bg-clip-text text-transparent">Renewa</span>
                    </div>
                    <p class="text-gray-400 mb-6 leading-relaxed">
                        Platform terdepan untuk sertifikat energi terbarukan di Indonesia, mendukung transisi menuju masa depan yang berkelanjutan.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-green-400 transition-colors duration-300 hover:scale-110">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-green-400 transition-colors duration-300 hover:scale-110">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-green-400 transition-colors duration-300 hover:scale-110">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-green-400 transition-colors duration-300 hover:scale-110">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div data-aos="fade-up" data-aos-delay="200">
                    <h3 class="text-xl font-semibold mb-6 text-green-400">Navigasi</h3>
                    <ul class="space-y-3">
                       <li><a href="{{ route('welcome') }}" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i>Beranda</a></li>
                       <li><a href="{{ route('generatormap') }}" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i>Peta Pembangkit</a></li>
                       <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i>Beli REC</a></li>
                       <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i>Tentang Kami</a></li>
                   </ul>
               </div>
               
               <div data-aos="fade-up" data-aos-delay="300">
                   <h3 class="text-xl font-semibold mb-6 text-green-400">Layanan</h3>
                   <ul class="space-y-3">
                       <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i>Sertifikat REC</a></li>
                       <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i>Verifikasi Energi</a></li>
                       <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i>Konsultasi</a></li>
                       <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right mr-2 text-xs"></i>API Integration</a></li>
                   </ul>
               </div>
               
               <div data-aos="fade-up" data-aos-delay="400">
                   <h3 class="text-xl font-semibold mb-6 text-green-400">Hubungi Kami</h3>
                   <div class="space-y-4">
                       <div class="flex items-start">
                           <i class="fas fa-map-marker-alt text-green-400 mt-1 mr-3"></i>
                           <p class="text-gray-400 text-sm">
                               Jl. Sudirman No. 123<br>
                               Jakarta Pusat, Indonesia
                           </p>
                       </div>
                       <div class="flex items-center">
                           <i class="fas fa-phone text-green-400 mr-3"></i>
                           <p class="text-gray-400 text-sm">+62 21 1234 5678</p>
                       </div>
                       <div class="flex items-center">
                           <i class="fas fa-envelope text-green-400 mr-3"></i>
                           <p class="text-gray-400 text-sm">info@renewa.id</p>
                       </div>
                   </div>
               </div>
           </div>
           
           <div class="border-t border-gray-800 pt-8 mt-12" data-aos="fade-up" data-aos-delay="500">
               <div class="flex flex-col md:flex-row justify-between items-center">
                   <p class="text-gray-400 text-sm mb-4 md:mb-0">
                       © 2025 Renewa Indonesia. Seluruh hak dilindungi undang-undang.
                   </p>
                   <div class="flex space-x-6 text-sm">
                       <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Kebijakan Privasi</a>
                       <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Syarat & Ketentuan</a>
                       <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Cookie Policy</a>
                   </div>
               </div>
           </div>
       </div>
   </footer>

   <!-- Scroll to Top Button -->
   <button id="scrollToTop" class="fixed bottom-8 right-8 bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-full shadow-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 hover:scale-110 z-50 opacity-0 invisible">
       <i class="fas fa-chevron-up text-xl"></i>
   </button>

   <!-- Loading Overlay -->
   <div id="loadingOverlay" class="fixed inset-0 bg-gradient-to-br from-green-900/90 to-blue-900/90 backdrop-blur-sm z-50 flex items-center justify-center">
       <div class="text-center">
           <div class="w-16 h-16 border-4 border-white/30 border-t-white rounded-full animate-spin mb-4"></div>
           <p class="text-white text-xl font-semibold">Memuat Peta Pembangkit...</p>
           <p class="text-white/70 text-sm mt-2">Mohon tunggu sebentar</p>
       </div>
   </div>

   <!-- AOS JavaScript -->
   <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
   
   <!-- Custom JavaScript -->
   <script>
       // Initialize AOS
       AOS.init({
           duration: 800,
           easing: 'ease-in-out',
           once: true,
           mirror: false,
           offset: 50,
           delay: 0,
       });

       // Loading overlay
       window.addEventListener('load', function() {
           setTimeout(() => {
               document.getElementById('loadingOverlay').style.opacity = '0';
               setTimeout(() => {
                   document.getElementById('loadingOverlay').style.display = 'none';
               }, 300);
           }, 1500);
       });

       // Navbar scroll effect
       window.addEventListener('scroll', function() {
           const navbar = document.getElementById('navbar');
           if (window.scrollY > 50) {
               navbar.classList.add('navbar-scrolled');
           } else {
               navbar.classList.remove('navbar-scrolled');
           }
       });

       // Scroll to map function
       function scrollToMap() {
           document.getElementById('map-section').scrollIntoView({
               behavior: 'smooth',
               block: 'start'
           });
       }

       // Counter animation
       function animateCounter(element) {
           const target = parseInt(element.getAttribute('data-target'));
           const duration = 2000;
           const step = target / (duration / 16);
           let current = 0;
           
           const timer = setInterval(() => {
               current += step;
               if (current >= target) {
                   element.textContent = target.toLocaleString();
                   clearInterval(timer);
               } else {
                   element.textContent = Math.floor(current).toLocaleString();
               }
           }, 16);
       }

       // Intersection Observer for counters
       const counterObserver = new IntersectionObserver((entries) => {
           entries.forEach(entry => {
               if (entry.isIntersecting) {
                   const counters = entry.target.querySelectorAll('.counter');
                   counters.forEach(counter => {
                       animateCounter(counter);
                   });
                   counterObserver.unobserve(entry.target);
               }
           });
       });

       document.addEventListener('DOMContentLoaded', function() {
           const statsSection = document.getElementById('statistics');
           if (statsSection) {
               counterObserver.observe(statsSection);
           }
       });

       // Scroll to top functionality
       const scrollToTopBtn = document.getElementById('scrollToTop');
       
       window.addEventListener('scroll', function() {
           if (window.scrollY > 500) {
               scrollToTopBtn.classList.remove('opacity-0', 'invisible');
               scrollToTopBtn.classList.add('opacity-100', 'visible');
           } else {
               scrollToTopBtn.classList.add('opacity-0', 'invisible');
               scrollToTopBtn.classList.remove('opacity-100', 'visible');
           }
       });

       scrollToTopBtn.addEventListener('click', function() {
           window.scrollTo({
               top: 0,
               behavior: 'smooth'
           });
       });

       // Enhanced hover effects
       document.querySelectorAll('.floating-card').forEach(card => {
           card.addEventListener('mouseenter', function() {
               this.style.transform = 'translateY(-15px) scale(1.02)';
               this.style.boxShadow = '0 25px 50px rgba(16, 185, 129, 0.25)';
           });
           
           card.addEventListener('mouseleave', function() {
               this.style.transform = 'translateY(0) scale(1)';
               this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.1)';
           });
       });

       // Smooth scrolling for anchor links
       document.querySelectorAll('a[href^="#"]').forEach(anchor => {
           anchor.addEventListener('click', function (e) {
               e.preventDefault();
               const target = document.querySelector(this.getAttribute('href'));
               if (target) {
                   target.scrollIntoView({
                       behavior: 'smooth',
                       block: 'start'
                   });
               }
           });
       });

       // Parallax effect for hero section
       window.addEventListener('scroll', function() {
           const scrolled = window.pageYOffset;
           const heroSection = document.querySelector('.hero-pattern');
           if (heroSection) {
               const speed = scrolled * 0.5;
               heroSection.style.transform = `translateY(${speed}px)`;
           }
       });

       // Add scroll progress indicator
       const scrollProgress = document.createElement('div');
       scrollProgress.style.cssText = `
           position: fixed;
           top: 0;
           left: 0;
           width: 0%;
           height: 4px;
           background: linear-gradient(90deg, #10b981, #3b82f6);
           z-index: 9999;
           transition: width 0.3s ease;
       `;
       document.body.appendChild(scrollProgress);

       window.addEventListener('scroll', function() {
           const scrollTop = window.pageYOffset;
           const docHeight = document.documentElement.scrollHeight - window.innerHeight;
           const scrollPercent = (scrollTop / docHeight) * 100;
           scrollProgress.style.width = scrollPercent + '%';
       });

       // Interactive map enhancements
       const mapContainer = document.querySelector('.map-container');
       if (mapContainer) {
           mapContainer.addEventListener('mouseenter', function() {
               this.style.transform = 'translateY(-10px) scale(1.01)';
               this.style.boxShadow = '0 35px 70px rgba(0, 0, 0, 0.2)';
           });
           
           mapContainer.addEventListener('mouseleave', function() {
               this.style.transform = 'translateY(0) scale(1)';
               this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.15)';
           });
       }

       // Add typing effect to hero title
       function typeWriter(element, text, speed = 100) {
           let i = 0;
           element.innerHTML = '';
           function type() {
               if (i < text.length) {
                   element.innerHTML += text.charAt(i);
                   i++;
                   setTimeout(type, speed);
               }
           }
           type();
       }

       // Initialize typing effect after page load
       setTimeout(() => {
           const heroTitle = document.querySelector('h1');
           if (heroTitle) {
               const originalText = heroTitle.textContent;
               typeWriter(heroTitle, originalText, 50);
           }
       }, 2000);

       // Add floating animation to icons
       document.querySelectorAll('.pulse-animation').forEach((icon, index) => {
           icon.style.animationDelay = `${index * 0.2}s`;
       });

       // Enhanced button interactions
       document.querySelectorAll('button, .btn').forEach(button => {
           button.addEventListener('click', function(e) {
               const ripple = document.createElement('span');
               const rect = this.getBoundingClientRect();
               const size = Math.max(rect.width, rect.height);
               const x = e.clientX - rect.left - size / 2;
               const y = e.clientY - rect.top - size / 2;
               
               ripple.style.cssText = `
                   position: absolute;
                   width: ${size}px;
                   height: ${size}px;
                   left: ${x}px;
                   top: ${y}px;
                   background: rgba(255, 255, 255, 0.3);
                   border-radius: 50%;
                   transform: scale(0);
                   animation: ripple 0.6s linear;
                   pointer-events: none;
               `;
               
               this.style.position = 'relative';
               this.style.overflow = 'hidden';
               this.appendChild(ripple);
               
               setTimeout(() => {
                   ripple.remove();
               }, 600);
           });
       });

       // Add ripple animation keyframes
       const style = document.createElement('style');
       style.textContent = `
           @keyframes ripple {
               to {
                   transform: scale(2);
                   opacity: 0;
               }
           }
       `;
       document.head.appendChild(style);

       // Performance optimization: Lazy load images
       const images = document.querySelectorAll('img');
       const imageObserver = new IntersectionObserver((entries, observer) => {
           entries.forEach(entry => {
               if (entry.isIntersecting) {
                   const img = entry.target;
                   if (img.dataset.src) {
                       img.src = img.dataset.src;
                       img.classList.remove('loading-shimmer');
                       observer.unobserve(img);
                   }
               }
           });
       });

       images.forEach(img => {
           if (img.dataset.src) {
               img.classList.add('loading-shimmer');
               imageObserver.observe(img);
           }
       });
   </script>
</body>
</html>
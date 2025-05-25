<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renewa - Solusi Energi Terbarukan</title>
    <meta name="description" content="Platform Renewable Energy Certificate untuk mendukung energi bersih di Indonesia">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css')
    
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Custom smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom animations untuk elemen yang belum terlihat */
        [data-aos] {
            pointer-events: none;
        }
        
        [data-aos].aos-animate {
            pointer-events: auto;
        }
        
        /* Loading animation untuk hero */
        .hero-fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: heroFadeIn 1.2s ease-out forwards;
        }
        
        @keyframes heroFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Custom hover effects */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Navbar scroll effect */
        .navbar-scrolled {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }
        
        /* Counter animation class */
        .counter-number {
            font-weight: bold;
            font-size: 1.5rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('layouts.partials.navbar')

    <!-- Hero Section -->
    <section class="py-16 bg-[#EAEAEA] mt-20">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl font-bold leading-tight mb-4 hero-fade-in">
                    Buktikan <span class="text-green-500" data-aos="fade-up" data-aos-delay="300">Energi Hijau</span> Anda, Kurangi <span class="text-green-500" data-aos="fade-up" data-aos-delay="500">Jejak Karbon</span> Sekarang!
                </h1>
                <p class="text-gray-600 mb-8" data-aos="fade-up" data-aos-delay="700">Kontribusi nyata dalam upaya mengurangi emisi karbon dan mendukung transisi energi bersih di Indonesia.</p>
                @auth
                    <a href="{{ route('buyer.categoryselect') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-lg inline-block transition-all hover:scale-105 hover:shadow-lg" data-aos="zoom-in" data-aos-delay="900">Beli REC</a>
                @else
                    <a href="{{ route('buyer.login') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-lg inline-block transition-all hover:scale-105 hover:shadow-lg" data-aos="zoom-in" data-aos-delay="900">Beli REC</a>
                @endauth
            </div>
            <div class="md:w-1/2">
                <img src="{{ asset('images/herocontent.svg') }}" alt="Renewable Energy Certificate" class="w-4/5 mx-auto" data-aos="fade-left" data-aos-delay="400" data-aos-duration="1000">
            </div>
        </div>
    </section>

    <!-- Klien Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-2" data-aos="fade-up">Klien Kami</h2>
            <p class="text-gray-600 mb-8" data-aos="fade-up" data-aos-delay="200">Terima Kasih Atas Kontribusi Anda Terhadap Pengembangan Energi Terbarukan di Indonesia</p>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-8">
                <div class="flex justify-center items-center hover-lift" data-aos="zoom-in" data-aos-delay="100">
                    <img src="{{ asset('images/Pertamina Logo.png') }}" alt="Client 1" class="h-10">
                </div>
                <div class="flex justify-center items-center hover-lift" data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{ asset('images/Indofood Logo.png') }}" alt="Client 2" class="h-10">
                </div>
                <div class="flex justify-center items-center hover-lift" data-aos="zoom-in" data-aos-delay="300">
                    <img src="{{ asset('images/Pama Logo.png') }}" alt="Client 3" class="h-10">
                </div>
                <div class="flex justify-center items-center hover-lift" data-aos="zoom-in" data-aos-delay="400">
                    <img src="{{ asset('images/Telkom Logo.png') }}" alt="Client 4" class="h-10">
                </div>
                <div class="flex justify-center items-center hover-lift" data-aos="zoom-in" data-aos-delay="500">
                    <img src="{{ asset('images/MRT Jakarta Logo.png') }}" alt="Client 5" class="h-10">
                </div>
                <div class="flex justify-center items-center hover-lift" data-aos="zoom-in" data-aos-delay="600">
                    <img src="{{ asset('images/Mandiri Logo.png') }}" alt="Client 6" class="h-10">
                </div>
            </div>
        </div>
    </section>

    <!-- Peran REC Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12" data-aos="fade-up">Apa Saja Peran REC?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-sm text-center hover-lift" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6" data-aos="zoom-in" data-aos-delay="300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4" data-aos="fade-up" data-aos-delay="400">Bukti Nyata Energi Hijau!</h3>
                    <p class="text-gray-600" data-aos="fade-up" data-aos-delay="500">Sertifikat resmi yang menunjukkan asal energi terbarukan Anda dan kontribusi dalam mengurangi emisi karbon.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm text-center hover-lift" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6" data-aos="zoom-in" data-aos-delay="400">
                        <svg fill="#000000" height="45px" width="45px" version="1.1" class="text-green-500" viewBox="0 0 511.801 511.801">
                            <path d="M 368.047 188.007 C 369.293 183.037 366.32 177.987 361.41 176.727 C 351.48 174.18 341.281 172.621 330.988 172.045 C 326.348 87.159 256.638 19.541 171.607 19.541 C 83.584 19.541 11.972 92 11.972 181.066 C 11.972 267.26 79.042 337.899 163.149 342.362 C 162.902 343.322 162.797 344.336 162.873 345.38 C 163.953 360.171 167.033 374.705 172.026 388.575 C 173.383 392.344 176.9 394.683 180.647 394.683 C 181.69 394.683 182.75 394.502 183.786 394.121 C 188.547 392.365 191 387.039 189.268 382.222 C 184.852 369.955 182.129 357.099 181.172 344.012 C 181.129 343.425 181.027 342.858 180.884 342.31 C 261.366 337.621 326.048 272.332 330.934 190.965 L 330.943 190.973 C 330.95 190.858 330.961 190.743 330.967 190.628 C 339.744 191.181 348.436 192.551 356.901 194.723 C 361.815 195.985 366.802 192.975 368.047 188.007 Z M 181.097 323.705 C 185.788 252.515 242.221 195.414 312.578 190.667 C 307.886 261.857 251.452 318.958 181.097 323.705 Z M 162.719 323.749 L 162.709 323.743 C 88.93 319.086 30.321 256.872 30.321 181.066 C 30.321 102.238 93.701 38.107 171.607 38.107 C 246.526 38.107 308.013 97.41 312.616 172.062 L 312.621 172.073 C 232.106 176.851 167.441 242.28 162.719 323.749 Z" style="fill: rgb(34, 197, 94);"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4" data-aos="fade-up" data-aos-delay="500">Transparansi dalam Energi Terbarukan!</h3>
                    <p class="text-gray-600" data-aos="fade-up" data-aos-delay="600">Platform yang memastikan setiap unit energi terbarukan dapat diverifikasi dan dilacak secara transparan.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm text-center hover-lift" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6" data-aos="zoom-in" data-aos-delay="500">
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 512.000000 512.000000" class="text-green-500">
                            <path d="M4039 5091 c-28 -29 -29 -32 -29 -136 0 -137 18 -174 88 -175 22 0 41 8 57 25 24 23 25 30 25 142 -1 123 -5 139 -47 161 -35 19 -63 14 -94 -17z" style="fill: rgb(34, 197, 94);"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4" data-aos="fade-up" data-aos-delay="600">Majukan Energi Bersih!</h3>
                    <p class="text-gray-600" data-aos="fade-up" data-aos-delay="700">Mendukung pengembangan proyek energi terbarukan dan percepatan transisi energi berkelanjutan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Data dan Peta Section -->
    <section class="py-16 bg-white">git
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0" data-aos="fade-right" data-aos-duration="1000">
                    <img src="{{ asset('images\ilustrasi-bagian-peta.png') }}" alt="Data dan Peta Pembangkit" class="w-3/5 mx-auto">
                </div>
                <div class="md:w-1/2 md:pl-12">
                    <h2 class="text-2xl font-bold mb-4" data-aos="fade-left" data-aos-delay="200">Lihat data dan peta pembangkit <span class="text-green-500">Energi Baru Terbarukan (EBT)</span> yang tersedia</h2>
                    <p class="text-gray-600 mb-6" data-aos="fade-left" data-aos-delay="400">Platform ini menyediakan data dan peta interaktif yang menampilkan lokasi pembangkit Energi Baru Terbarukan (EBT) di seluruh wilayah. Informasi yang disajikan mencakup kapasitas, jenis energi, dan kontribusi terhadap pengurangan emisi karbon dari setiap pembangkit.</p>
                    <a href="{{ route('generatormap') }}" class="bg-green-100 hover:bg-green-200 text-green-700 font-medium px-6 py-3 rounded-lg inline-block transition-all hover:scale-105 hover:shadow-lg" data-aos="fade-left" data-aos-delay="600">Lihat Pembangkit</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Potensi Energi Section -->
    <section class="py-16 bg-gray-50" id="statistics-section">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl font-bold mb-1" data-aos="fade-up">Potensi <span class="text-green-500">Energi Baru Terbarukan (EBT)</span> di Indonesia</h2>
            <p class="text-gray-600 mb-12" data-aos="fade-up" data-aos-delay="200">Kapasitas cadangan besar potensi EBT di Indonesia</p>
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm hover-lift" data-aos="flip-left" data-aos-delay="100">
                    <div class="w-12 h-12 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm mb-2">Panas Bumi</h3>
                    <p class="counter-number" data-target="29544">29,544 MW</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover-lift" data-aos="flip-left" data-aos-delay="200">
                    <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm mb-2">Bayu</h3>
                    <p class="counter-number" data-target="60647">60,647 MW</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover-lift" data-aos="flip-left" data-aos-delay="300">
                    <div class="w-12 h-12 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm mb-2">Bioenergi</h3>
                    <p class="counter-number" data-target="207898">207,898 MW</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover-lift" data-aos="flip-left" data-aos-delay="400">
                    <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm mb-2">Surya</h3>
                    <p class="counter-number" data-target="94476">94,476 MW</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm hover-lift" data-aos="flip-left" data-aos-delay="500">
                    <div class="w-12 h-12 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 text-sm mb-2">Hidro</h3>
                    <p class="counter-number" data-target="17989">17,989 MW</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto bg-gray-100 rounded-2xl overflow-hidden hover-lift" data-aos="zoom-in" data-aos-duration="1000">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3" data-aos="fade-right" data-aos-delay="200">
                        <img src="{{ asset('images/testimoni.png') }}" alt="Testimonial" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-2/3 p-8">
                        <svg class="h-8 w-8 text-gray-400 mb-4" fill="currentColor" viewBox="0 0 24 24" data-aos="fade-down" data-aos-delay="300">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <p class="text-gray-600 mb-6" data-aos="fade-up" data-aos-delay="400">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ornare velit at lorem auctor, ut lacinia dui condimentum. Nunc pulvinar eu mi vitae ornare. Etiam ut ultricies metus. Sed tortor felis, mattis sit amet ex sed, feugiat molestie velit. Mauris lacus tellus, porta at viverra in, venenatis vitae felis. Maecenas nec ultrices sem.</p>
                        <div data-aos="fade-up" data-aos-delay="500">
                            <p class="font-bold">Tim Smith</p>
                            <p class="text-sm text-gray-500">Direktur Operasi, Bumi Bersih Association</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4" data-aos="fade-up">Peduli adalah pemasaran baru</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="200">Bergabunglah dengan komunitas yang peduli terhadap masa depan planet kita. Lihat bagaimana kontribusi Anda dapat membuat perbedaan nyata untuk lingkungan dan masyarakat.</p>
            @auth
                <a href="{{ route('buyer.categoryselect') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-lg inline-block transition-all hover:scale-105 hover:shadow-lg" data-aos="zoom-in" data-aos-delay="400">Beli REC Sekarang</a>
            @else
                <a href="{{ route('buyer.register') }}" class="bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-lg inline-block transition-all hover:scale-105 hover:shadow-lg" data-aos="zoom-in" data-aos-delay="400">Daftar Sekarang</a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-8 md:mb-0">
                    <div class="flex items-center mb-4">
                        <svg class="h-6 w-6 text-green-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        <span class="font-bold text-xl">Renewa</span>
                    </div>
                    <p class="text-gray-400 mb-4">Hak Cipta © 2025 Renewa Indonesia.<br>Seluruh hak dilindungi undang-undang.</p>
                    <div class="flex space-x-4">
                       <a href="#" class="text-gray-400 hover:text-white transition-colors hover:scale-110"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                       <a href="#" class="text-gray-400 hover:text-white transition-colors hover:scale-110"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg></a>
                       <a href="#" class="text-gray-400 hover:text-white transition-colors hover:scale-110"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                   </div>
               </div>

               <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                   <div>
                       <h3 class="text-lg font-semibold mb-4">Perusahaan</h3>
                       <ul class="space-y-2">
                           <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Tentang Kami</a></li>
                           <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                           <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Hubungi Kami</a></li>
                           <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Harga</a></li>
                           <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Testimonial</a></li>
                       </ul>
                   </div>
                   <div>
                       <h3 class="text-lg font-semibold mb-4">Dukungan</h3>
                       <ul class="space-y-2">
                           <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Pusat Bantuan</a></li>
                           <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Syarat Layanan</a></li>
                           <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Legal</a></li>
                           <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Kebijakan Privasi</a></li>
                           <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Status</a></li>
                       </ul>
                   </div>
                   <div class="col-span-2 md:col-span-1">
                       <h3 class="text-lg font-semibold mb-4">Tetap terhubung</h3>
                       <p class="text-gray-400 mb-4">Dapatkan update dan berita terbaru tentang energi terbarukan</p>
                       <div class="flex">
                           <input type="email" placeholder="Email anda" class="px-4 py-2 w-full rounded-l-lg focus:outline-none text-gray-800 transition-all focus:ring-2 focus:ring-green-500">
                           <button class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-r-lg transition-all hover:scale-105">
                               <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                               </svg>
                           </button>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </footer>

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

       // Navbar scroll effect
       window.addEventListener('scroll', function() {
           const navbar = document.getElementById('navbar');
           if (window.scrollY > 50) {
               navbar.classList.add('navbar-scrolled');
           } else {
               navbar.classList.remove('navbar-scrolled');
           }
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

       // Add loading animation to images
       document.addEventListener('DOMContentLoaded', function() {
           const images = document.querySelectorAll('img');
           images.forEach(img => {
               img.addEventListener('load', function() {
                   this.style.opacity = '1';
               });
               if (img.complete) {
                   img.style.opacity = '1';
               }
           });
       });

       // Enhanced hover effects for cards
       document.querySelectorAll('.hover-lift').forEach(card => {
           card.addEventListener('mouseenter', function() {
               this.style.transform = 'translateY(-10px) scale(1.02)';
               this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.15)';
           });
           
           card.addEventListener('mouseleave', function() {
               this.style.transform = 'translateY(0) scale(1)';
               this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.1)';
           });
       });

       // Fixed counter animation for statistics only
       function animateCounters() {
           const counters = document.querySelectorAll('.counter-number');
           counters.forEach(counter => {
               const target = parseInt(counter.getAttribute('data-target'));
               if (!target || isNaN(target)) return; // Skip if no valid target
               
               const duration = 2000;
               const step = target / (duration / 16);
               let current = 0;
               
               const timer = setInterval(() => {
                   current += step;
                   if (current >= target) {
                       counter.textContent = target.toLocaleString() + ' MW';
                       clearInterval(timer);
                   } else {
                       counter.textContent = Math.floor(current).toLocaleString() + ' MW';
                   }
               }, 16);
           });
       }

       // Trigger counter animation when statistics section is visible
       let hasAnimated = false;
       const observer = new IntersectionObserver((entries) => {
           entries.forEach(entry => {
               if (entry.isIntersecting && !hasAnimated) {
                   animateCounters();
                   hasAnimated = true; // Prevent multiple animations
               }
           });
       });

       // Observe the statistics section
       const statsSection = document.getElementById('statistics-section');
       if (statsSection) {
           observer.observe(statsSection);
       }

       // Enhanced page load animation
       window.addEventListener('load', function() {
           document.body.classList.add('loaded');
           
           // Stagger animation for navbar items
           const navItems = document.querySelectorAll('nav a');
           navItems.forEach((item, index) => {
               setTimeout(() => {
                   item.style.opacity = '1';
                   item.style.transform = 'translateY(0)';
               }, index * 100);
           });
       });

       // Add scroll progress indicator
       const scrollProgress = document.createElement('div');
       scrollProgress.style.cssText = `
           position: fixed;
           top: 0;
           left: 0;
           width: 0%;
           height: 3px;
           background: linear-gradient(90deg, #10b981, #34d399);
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
   </script>
   
   <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
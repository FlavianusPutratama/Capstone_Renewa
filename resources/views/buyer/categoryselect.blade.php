<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renewa - Pilih Kategori Pembelian</title>
    <meta name="description" content="Pilih kategori pembelian REC yang sesuai dengan kebutuhan Anda">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css')
    
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <!-- Font Awesome -->
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
        
        .category-card {
            width: 100%; /* Memastikan card memenuhi lebar kolom */
            aspect-ratio: 1; /* Membuat card persegi */
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('layouts.partials.navbar')

    <main class="py-16 bg-gradient-to-br from-green-50 via-white to-green-100 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-gray-900" data-aos="fade-up">
                Satu Langkah, Menuju <span class="text-green-600">Energi Hijau</span>
            </h1>
            <p class="mt-4 text-lg text-gray-600" data-aos="fade-up" data-aos-delay="200">
                Pilih Kategori Pembelian yang Sesuai dengan Kebutuhan dan Keinginanmu!
            </p>
    
            <div class="mt-16 grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Card: Retail -->
                <form action="{{ route('marketplace') }}" method="POST"
                class="w-full aspect-square bg-white rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 flex flex-col items-center justify-center p-6 group hover-lift"
                data-aos="fade-up" data-aos-delay="100">
                @csrf
                <input type="hidden" name="category" value="Retail">
                <button type="submit" class="flex flex-col items-center">
                <img src="https://storage.googleapis.com/a1aa/image/9kbKe83fD6XbRLYejGEuMZ1AfsLmYJxHlJYtpuF4jQI.jpg"
                    alt="Retail Icon"
                    class="w-20 h-20 object-cover mb-6 rounded-md group-hover:brightness-110 transition" />
                <h2 class="text-2xl font-semibold text-gray-800 group-hover:text-green-600 transition">Retail</h2>
                <p class="mt-2 text-gray-600">Layanan kepada pelanggan untuk kebutuhan retail.</p>
                <p class="mt-4 text-sm text-green-700 font-medium">Min. pembelian 10 unit REC</p>
                </button>
                </form>

                <!-- Card: Signature -->
                <form action="{{ route('marketplace') }}" method="POST"
                class="w-full aspect-square bg-white rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 flex flex-col items-center justify-center p-6 group hover-lift"
                data-aos="fade-up" data-aos-delay="200">
                @csrf
                <input type="hidden" name="category" value="Signature">
                <button type="submit" class="flex flex-col items-center">
                <img src="https://storage.googleapis.com/a1aa/image/9kbKe83fD6XbRLYejGEuMZ1AfsLmYJxHlJYtpuF4jQI.jpg"
                    alt="Signature Icon"
                    class="w-20 h-20 object-cover mb-6 rounded-md group-hover:brightness-110 transition" />
                <h2 class="text-2xl font-semibold text-gray-800 group-hover:text-green-600 transition">Signature</h2>
                <p class="mt-2 text-gray-600">Energi hijau untuk keperluan sehari-hari</p>
                <p class="mt-4 text-sm text-green-700 font-medium">Pembelian REC &lt; 10 unit</p>
                </button>
                </form>

                <!-- Card: Enterprise -->
                <form action="{{ route('marketplace') }}" method="POST"
                class="w-full aspect-square bg-white rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 flex flex-col items-center justify-center p-6 group hover-lift"
                data-aos="fade-up" data-aos-delay="300">
                @csrf
                <input type="hidden" name="category" value="Enterprise">
                <button type="submit" class="flex flex-col items-center">
                <img src="https://storage.googleapis.com/a1aa/image/9kbKe83fD6XbRLYejGEuMZ1AfsLmYJxHlJYtpuF4jQI.jpg"
                    alt="Enterprise Icon"
                    class="w-20 h-20 object-cover mb-6 rounded-md group-hover:brightness-110 transition" />
                <h2 class="text-2xl font-semibold text-gray-800 group-hover:text-green-600 transition">Enterprise</h2>
                <p class="mt-2 text-gray-600">Bisnis skala kecil, menengah, hingga besar.</p>
                <p class="mt-4 text-sm text-green-700 font-medium">Min. pembelian 200 unit REC</p>
                </button>
                </form>
            </div>
        </div>
    </main>

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
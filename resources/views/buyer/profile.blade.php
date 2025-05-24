<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renewa - Profil Pengguna</title>
    <meta name="description" content="Kelola profil dan informasi akun Anda di platform Renewa">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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
        
        /* Navbar scroll effect */
        .navbar-scrolled {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('layouts.partials.navbar')

    <main class="py-12 pt-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-700">Profil <i class="fas fa-user"></i></h2>
                    <button id="editButton" class="text-gray-500"><i class="fas fa-edit"></i></button>
                </div>
                <form id="profileForm" action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700">Nama</label>
                            <input type="text" name="name" class="w-full mt-1 p-2 border rounded" value="{{ $user->name }}" disabled>
                        </div>
                        <div>
                            <label class="block text-gray-700">Alamat</label>
                            <input type="text" name="address" class="w-full mt-1 p-2 border rounded" value="{{ $user->address }}" disabled>
                        </div>
                        <div>
                            <label class="block text-gray-700">Email</label>
                            <input type="email" name="email" class="w-full mt-1 p-2 border rounded" value="{{ $user->email }}" disabled>
                        </div>
                        <div>
                            <label class="block text-gray-700">Provinsi</label>
                            <select name="province" id="province" class="w-full mt-1 p-2 border rounded" required disabled>
                                <option value="">Pilih Provinsi</option>
                                <option value="jabar" {{ $user->province == 'jabar' ? 'selected' : '' }}>Jawa Barat</option>
                                <option value="jateng" {{ $user->province == 'jateng' ? 'selected' : '' }}>Jawa Tengah</option>
                                <option value="jatim" {{ $user->province == 'jatim' ? 'selected' : '' }}>Jawa Timur</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700">No. Telepon</label>
                            <input type="text" name="phone" class="w-full mt-1 p-2 border rounded" value="{{ $user->phone }}" disabled>
                        </div>
                        <div>
                            <label class="block text-gray-700">Kabupaten/Kota</label>
                            <select name="regency" id="regency" class="w-full mt-1 p-2 border rounded" required disabled>
                                <option value="">Pilih Kabupaten/Kota</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700">NIK</label>
                            <input type="text" name="nik" class="w-full mt-1 p-2 border rounded" value="{{ $user->nik }}" disabled>
                        </div>
                        <div>
                            <label class="block text-gray-700">Kecamatan</label>
                            <select name="district" id="district" class="w-full mt-1 p-2 border rounded" required disabled>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700">Kelurahan</label>
                            <select name="village" id="village" class="w-full mt-1 p-2 border rounded" required disabled>
                                <option value="">Pilih Kelurahan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('welcome') }}" class="text-green-500">Ubah Password</a>
                    </div>
                    <div class="mt-6 hidden" id="saveButtonContainer">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded w-full flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- AOS JavaScript -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    
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

        const regencies = {
            jabar: {
                '1': { name: 'Bandung', districts: { '1': ['Cimahi', 'Cileunyi'], '2': ['Cibiru', 'Cimahi Selatan'] } },
                '2': { name: 'Bogor', districts: { '1': ['Cibinong', 'Cileungsi'], '2': ['Cisarua', 'Ciawi'] } },
                '3': { name: 'Depok', districts: { '1': ['Cinere', 'Limo', 'Tapos'] } }
            },
            jateng: {
                '1': { name: 'Semarang', districts: { '1': ['Semarang Selatan', 'Semarang Utara'] } },
                '2': { name: 'Solo', districts: { '1': ['Banjarsari', 'Laweyan'] } }
            },
            jatim: {
                '1': { name: 'Surabaya', districts: { '1': ['Gubeng', 'Tegalsari'] } }
            }
        };

        document.getElementById('province').addEventListener('change', function() {
            const province = this.value;
            const regencySelect = document.getElementById('regency');
            regencySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>'; // Reset options

            if (province) {
                const regencyData = regencies[province];
                for (const [key, value] of Object.entries(regencyData)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.textContent = value.name;
                    regencySelect.appendChild(option);
                }
            }
            document.getElementById('district').innerHTML = '<option value="">Pilih Kecamatan</option>'; // Reset districts
            document.getElementById('village').innerHTML = '<option value="">Pilih Kelurahan</option>'; // Reset villages
        });

        document.getElementById('regency').addEventListener('change', function() {
            const province = document.getElementById('province').value;
            const regency = this.value;
            const districtSelect = document.getElementById('district');
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>'; // Reset options

            if (province && regency) {
                const districtData = regencies[province][regency].districts;
                for (const [key, value] of Object.entries(districtData)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.textContent = key; // Use key as district name
                    districtSelect.appendChild(option);
                }
            }
            document.getElementById('village').innerHTML = '<option value="">Pilih Kelurahan</option>'; // Reset villages
        });

        document.getElementById('district').addEventListener('change', function() {
            const province = document.getElementById('province').value;
            const regency = document.getElementById('regency').value;
            const district = this.value;
            const villageSelect = document.getElementById('village');
            villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>'; // Reset options

            if (province && regency && district) {
                const villageData = regencies[province][regency].districts[district];
                villageData.forEach(village => {
                    const option = document.createElement('option');
                    option.value = village;
                    option.textContent = village;
                    villageSelect.appendChild(option);
                });
            }
        });
    </script>
</body>
</html>
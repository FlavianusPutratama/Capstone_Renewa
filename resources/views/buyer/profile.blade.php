<?php
// resources/views/buyer/profile.blade.php
?>
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

        /* Glass morphism effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        
        /* Enhanced input styling */
        .modern-input, .modern-select {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(229, 231, 235, 0.6);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .modern-input:focus, .modern-select:focus {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgb(34, 197, 94);
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
            transform: translateY(-1px);
        }

        .modern-input:disabled, .modern-select:disabled {
            background: rgba(249, 250, 251, 0.8);
            color: rgb(107, 114, 128);
            cursor: not-allowed;
        }
        
        /* Button hover effects */
        .modern-btn {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .modern-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .modern-btn:hover::before {
            left: 100%;
        }
        
        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('layouts.partials.navbar')

    <main class="py-12 pt-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm flex items-center" data-aos="fade-down">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="glass-card rounded-3xl p-8" data-aos="fade-up">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-user-circle mr-3 text-green-600"></i>Profil Pengguna
                    </h2>
                    <button id="editButton" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors flex items-center">
                        <i class="fas fa-edit mr-2"></i>Edit Profil
                    </button>
                </div>

                <form id="profileForm" action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('POST')
                    
                    <!-- Personal Information Section -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user mr-3 text-green-600"></i>
                            Informasi Pribadi
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" class="modern-input w-full px-4 py-3 rounded-xl focus:outline-none" value="{{ $user->name }}" disabled>
                                @error('name')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Email</label>
                                <input type="email" name="email" class="modern-input w-full px-4 py-3 rounded-xl focus:outline-none" value="{{ $user->email }}" disabled>
                                @error('email')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">No. Telepon</label>
                                <input type="text" name="phone" class="modern-input w-full px-4 py-3 rounded-xl focus:outline-none" value="{{ $user->phone }}" disabled>
                                @error('phone')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">NIK</label>
                                <input type="text" name="nik" class="modern-input w-full px-4 py-3 rounded-xl focus:outline-none" value="{{ $user->nik }}" disabled>
                                @error('nik')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address Information Section -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-map-marker-alt mr-3 text-green-600"></i>
                            Informasi Alamat
                        </h3>

                        <div class="space-y-6">
                            <!-- Street Address -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Nama Jalan/No. Rumah</label>
                                <input type="text" name="address" class="modern-input w-full px-4 py-3 rounded-xl focus:outline-none" value="{{ $user->address }}" disabled>
                                @error('address')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Province -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Provinsi</label>
                                    <select name="province" id="province" class="modern-select w-full px-4 py-3 rounded-xl focus:outline-none" disabled>
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                    @error('province')
                                        <p class="text-red-500 text-sm flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Regency -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Kabupaten/Kota</label>
                                    <select name="regency" id="regency" class="modern-select w-full px-4 py-3 rounded-xl focus:outline-none" disabled>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                    @error('regency')
                                        <p class="text-red-500 text-sm flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- District -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Kecamatan</label>
                                    <select name="district" id="district" class="modern-select w-full px-4 py-3 rounded-xl focus:outline-none" disabled>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    @error('district')
                                        <p class="text-red-500 text-sm flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Village -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Kelurahan</label>
                                    <select name="village" id="village" class="modern-select w-full px-4 py-3 rounded-xl focus:outline-none" disabled>
                                        <option value="">Pilih Kelurahan</option>
                                    </select>
                                    @error('village')
                                        <p class="text-red-500 text-sm flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                        <a href="{{ route('welcome') }}" class="text-green-600 hover:text-green-700 font-medium transition-colors flex items-center">
                            <i class="fas fa-key mr-2"></i>Ubah Password
                        </a>
                        
                        <div class="hidden" id="saveButtonContainer">
                            <button type="submit" class="modern-btn px-8 py-3 rounded-xl font-semibold text-white flex items-center">
                                <i class="fas fa-save mr-2"></i>Simpan Perubahan
                            </button>
                        </div>
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

        // User data from server
        const userData = {
            province: '{{ $user->province }}',
            regency: '{{ $user->regency }}',
            district: '{{ $user->district }}',
            village: '{{ $user->village }}'
        };

        let provincesData = {};
        let regenciesData = {};
        let districtsData = {};
        let isEditMode = false;

        // Show notification function
        function showNotification(message, type = 'error') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-xl text-white font-semibold z-50 transform transition-all duration-300 ${
                type === 'error' ? 'bg-red-500' : 'bg-green-500'
            }`;
            notification.innerHTML = `
                <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle'} mr-2"></i>
                ${message}
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Fetch and populate provinces
        async function fetchProvinces() {
            try {
                const response = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                const provinces = await response.json();
                provincesData = provinces;
                
                const provinceSelect = document.getElementById('province');
                provinceSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                
                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name;
                    option.textContent = province.name;
                    option.dataset.id = province.id;
                    provinceSelect.appendChild(option);
                });

                // Set selected province if exists
                if (userData.province) {
                    provinceSelect.value = userData.province;
                    const selectedProvince = provinces.find(p => p.name === userData.province);
                    if (selectedProvince) {
                        await fetchRegencies(selectedProvince.id);
                    }
                }
            } catch (error) {
                console.error('Error fetching provinces:', error);
                showNotification('Gagal memuat data provinsi', 'error');
            }
        }

        // Fetch and populate regencies
        async function fetchRegencies(provinceId) {
            try {
                const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`);
                const regencies = await response.json();
                regenciesData = regencies;
                
                const regencySelect = document.getElementById('regency');
                regencySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                
                regencies.forEach(regency => {
                    const option = document.createElement('option');
                    option.value = regency.name;
                    option.textContent = regency.name;
                    option.dataset.id = regency.id;
                    regencySelect.appendChild(option);
                });

                regencySelect.disabled = false;

                // Set selected regency if exists
                if (userData.regency) {
                    regencySelect.value = userData.regency;
                    const selectedRegency = regencies.find(r => r.name === userData.regency);
                    if (selectedRegency) {
                        await fetchDistricts(selectedRegency.id);
                    }
                }
            } catch (error) {
                console.error('Error fetching regencies:', error);
                showNotification('Gagal memuat data kabupaten/kota', 'error');
            }
        }

        // Fetch and populate districts
        async function fetchDistricts(regencyId) {
            try {
                const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`);
                const districts = await response.json();
                districtsData = districts;
                
                const districtSelect = document.getElementById('district');
                districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                
                districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.name;
                    option.textContent = district.name;
                    option.dataset.id = district.id;
                    districtSelect.appendChild(option);
                });

                districtSelect.disabled = false;

                // Set selected district if exists
                if (userData.district) {
                    districtSelect.value = userData.district;
                    const selectedDistrict = districts.find(d => d.name === userData.district);
                    if (selectedDistrict) {
                        await fetchVillages(selectedDistrict.id);
                    }
                }
            } catch (error) {
                console.error('Error fetching districts:', error);
                showNotification('Gagal memuat data kecamatan', 'error');
            }
        }

        // Fetch and populate villages
        async function fetchVillages(districtId) {
            try {
                const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`);
                const villages = await response.json();
                
                const villageSelect = document.getElementById('village');
                villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
                
                villages.forEach(village => {
                    const option = document.createElement('option');
                    option.value = village.name;
                    option.textContent = village.name;
                    villageSelect.appendChild(option);
                });

                villageSelect.disabled = false;

                // Set selected village if exists
                if (userData.village) {
                    villageSelect.value = userData.village;
                }
            } catch (error) {
                console.error('Error fetching villages:', error);
                showNotification('Gagal memuat data kelurahan', 'error');
            }
        }

        // Event listeners for dropdown changes
        document.getElementById('province').addEventListener('change', async function() {
            const selectedOption = this.options[this.selectedIndex];
            const provinceId = selectedOption.dataset.id;
            
            // Reset dependent dropdowns
            document.getElementById('regency').innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
            document.getElementById('district').innerHTML = '<option value="">Pilih Kecamatan</option>';
            document.getElementById('village').innerHTML = '<option value="">Pilih Kelurahan</option>';
            
            document.getElementById('regency').disabled = true;
            document.getElementById('district').disabled = true;
            document.getElementById('village').disabled = true;

            if (provinceId) {
                await fetchRegencies(provinceId);
            }
        });

        document.getElementById('regency').addEventListener('change', async function() {
            const selectedOption = this.options[this.selectedIndex];
            const regencyId = selectedOption.dataset.id;
            
            // Reset dependent dropdowns
            document.getElementById('district').innerHTML = '<option value="">Pilih Kecamatan</option>';
            document.getElementById('village').innerHTML = '<option value="">Pilih Kelurahan</option>';
            
            document.getElementById('district').disabled = true;
            document.getElementById('village').disabled = true;

            if (regencyId) {
                await fetchDistricts(regencyId);
            }
        });

        document.getElementById('district').addEventListener('change', async function() {
            const selectedOption = this.options[this.selectedIndex];
            const districtId = selectedOption.dataset.id;
            
            // Reset village dropdown
            document.getElementById('village').innerHTML = '<option value="">Pilih Kelurahan</option>';
            document.getElementById('village').disabled = true;

            if (districtId) {
                await fetchVillages(districtId);
            }
        });

        // Edit button functionality
        document.getElementById('editButton').addEventListener('click', function() {
            isEditMode = !isEditMode;
            const inputs = document.querySelectorAll('#profileForm input, #profileForm select');
            const saveButton = document.getElementById('saveButtonContainer');
            
            inputs.forEach(input => {
                input.disabled = !isEditMode;
            });
            
            if (isEditMode) {
                this.innerHTML = '<i class="fas fa-times mr-2"></i>Batal';
                this.className = 'px-4 py-2 bg-red-100 hover:bg-red-200 rounded-xl transition-colors flex items-center text-red-700';
                saveButton.classList.remove('hidden');
            } else {
                this.innerHTML = '<i class="fas fa-edit mr-2"></i>Edit Profil';
                this.className = 'px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors flex items-center';
                saveButton.classList.add('hidden');
                
                // Reset form to original values
                document.querySelector('input[name="name"]').value = '{{ $user->name }}';
                document.querySelector('input[name="email"]').value = '{{ $user->email }}';
                document.querySelector('input[name="phone"]').value = '{{ $user->phone }}';
                document.querySelector('input[name="nik"]').value = '{{ $user->nik }}';
                document.querySelector('input[name="address"]').value = '{{ $user->address }}';
                
                // Reset dropdowns
                fetchProvinces();
            }
        });

        // Form submission with validation
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            if (!isEditMode) {
                e.preventDefault();
                return;
            }

            // Basic validation
            const requiredFields = ['name', 'email', 'phone', 'nik', 'address', 'province', 'regency', 'district', 'village'];
            let isValid = true;

            requiredFields.forEach(field => {
                const input = document.querySelector(`[name="${field}"]`);
                if (!input.value.trim()) {
                   input.classList.add('border-red-500');
                   isValid = false;
               } else {
                   input.classList.remove('border-red-500');
               }
           });

           if (!isValid) {
               e.preventDefault();
               showNotification('Mohon lengkapi semua field yang wajib diisi', 'error');
               return;
           }

           // Email validation
           const email = document.querySelector('input[name="email"]').value;
           const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
           if (!emailRegex.test(email)) {
               e.preventDefault();
               document.querySelector('input[name="email"]').classList.add('border-red-500');
               showNotification('Format email tidak valid', 'error');
               return;
           }

           // NIK validation
           const nik = document.querySelector('input[name="nik"]').value;
           if (nik.length !== 16) {
               e.preventDefault();
               document.querySelector('input[name="nik"]').classList.add('border-red-500');
               showNotification('NIK harus 16 digit', 'error');
               return;
           }

           // Show loading state
           const submitBtn = this.querySelector('button[type="submit"]');
           const originalText = submitBtn.innerHTML;
           submitBtn.disabled = true;
           submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
           
           // Reset loading state after form submission
           setTimeout(() => {
               submitBtn.disabled = false;
               submitBtn.innerHTML = originalText;
           }, 2000);
       });

       // Initialize page
       document.addEventListener('DOMContentLoaded', function() {
           fetchProvinces();
           
           // Auto-hide success message
           const successAlert = document.querySelector('.bg-green-50');
           if (successAlert) {
               setTimeout(() => {
                   successAlert.style.opacity = '0';
                   setTimeout(() => successAlert.remove(), 300);
               }, 5000);
           }
       });

       // Phone number formatting
       document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
           let value = e.target.value.replace(/\D/g, '');
           if (value.startsWith('8') && value.length > 1) {
               value = '0' + value;
           }
           if (value.length > 15) {
               value = value.slice(0, 15);
           }
           e.target.value = value;
       });

       // NIK formatting
       document.querySelector('input[name="nik"]').addEventListener('input', function(e) {
           let value = e.target.value.replace(/\D/g, '');
           if (value.length > 16) {
               value = value.slice(0, 16);
           }
           e.target.value = value;
       });

       // Real-time validation feedback
       const inputs = document.querySelectorAll('input, select');
       inputs.forEach(input => {
           input.addEventListener('blur', function() {
               if (this.hasAttribute('required') && !this.value.trim()) {
                   this.classList.add('border-red-500');
               } else {
                   this.classList.remove('border-red-500');
               }
           });

           input.addEventListener('input', function() {
               if (this.classList.contains('border-red-500') && this.value.trim()) {
                   this.classList.remove('border-red-500');
               }
           });
       });
   </script>
</body>
</html>
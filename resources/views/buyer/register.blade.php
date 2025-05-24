<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Renewa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite('resources/css/app.css')
    
    <style>
        /* Custom gradient backgrounds */
        .auth-gradient {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 25%, #f0f9ff 75%, #eff6ff 100%);
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
        
        /* Floating animation */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }
        
        /* Logo pulse effect */
        .logo-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        /* Section dividers */
        .section-divider {
            position: relative;
            margin: 2rem 0;
        }
        
        .section-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(229, 231, 235, 0.8), transparent);
        }
        
        .section-title {
            background: rgba(255, 255, 255, 0.9);
            padding: 0 1rem;
            margin: 0 auto;
            width: fit-content;
            position: relative;
            z-index: 1;
        }
        
        /* Custom scrollbar */
        .form-container {
            max-height: 85vh;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(34, 197, 94, 0.3) transparent;
        }
        
        .form-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .form-container::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .form-container::-webkit-scrollbar-thumb {
            background: rgba(34, 197, 94, 0.3);
            border-radius: 3px;
        }
        
        .form-container::-webkit-scrollbar-thumb:hover {
            background: rgba(34, 197, 94, 0.5);
        }
        
        /* Loading animation */
        .loading-dots {
            display: inline-block;
        }
        
        .loading-dots::after {
            content: '';
            animation: loadingDots 1.5s infinite;
        }
        
        @keyframes loadingDots {
            0%, 20% { content: '.'; }
            40% { content: '..'; }
            60%, 100% { content: '...'; }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center auth-gradient p-4">
    <!-- Background decorations -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-10 left-10 w-32 h-32 bg-green-200 rounded-full opacity-20 floating"></div>
        <div class="absolute top-20 right-20 w-24 h-24 bg-blue-200 rounded-full opacity-20 floating" style="animation-delay: -1s;"></div>
        <div class="absolute bottom-20 left-20 w-40 h-40 bg-green-100 rounded-full opacity-30 floating" style="animation-delay: -2s;"></div>
        <div class="absolute bottom-10 right-10 w-28 h-28 bg-blue-100 rounded-full opacity-25 floating" style="animation-delay: -0.5s;"></div>
    </div>

    <div class="w-full max-w-4xl relative z-10">
        <!-- Logo and Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl mb-4 logo-pulse">
                <i class="fas fa-leaf text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Bergabung dengan Renewa</h1>
            <p class="text-gray-600">Daftar untuk memulai perjalanan energi hijau Anda</p>
        </div>

        <!-- Registration Form -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="form-container p-8">
                <form method="POST" action="{{ route('buyer.register') }}" class="space-y-8">
                    @csrf

                    <!-- Personal Information Section -->
                    <div>
                        <div class="section-divider">
                            <h3 class="section-title text-xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-user mr-3 text-green-600"></i>
                                Informasi Pribadi
                            </h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700">
                                    Nama Lengkap *
                                </label>
                                <input 
                                    id="name" 
                                    type="text" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    required 
                                    autofocus
                                    class="modern-input w-full px-4 py-3 rounded-xl focus:outline-none placeholder-gray-400"
                                    placeholder="Masukkan nama lengkap"
                                >
                                @error('name')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-semibold text-gray-700">
                                    Email *
                                </label>
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required
                                    class="modern-input w-full px-4 py-3 rounded-xl focus:outline-none placeholder-gray-400"
                                    placeholder="nama@email.com"
                                >
                                @error('email')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="space-y-2">
                                <label for="phone" class="block text-sm font-semibold text-gray-700">
                                    Nomor Telepon *
                                </label>
                                <input 
                                    id="phone" 
                                    type="text" 
                                    name="phone" 
                                    value="{{ old('phone') }}" 
                                    required
                                    class="modern-input w-full px-4 py-3 rounded-xl focus:outline-none placeholder-gray-400"
                                    placeholder="08xxxxxxxxxx"
                                >
                                @error('phone')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- NIK -->
                            <div class="space-y-2">
                                <label for="nik" class="block text-sm font-semibold text-gray-700">
                                    NIK *
                                </label>
                                <input 
                                    id="nik" 
                                    type="text" 
                                    name="nik" 
                                    value="{{ old('nik') }}" 
                                    required
                                    maxlength="16"
                                    class="modern-input w-full px-4 py-3 rounded-xl focus:outline-none placeholder-gray-400"
                                    placeholder="16 digit NIK"
                                >
                                @error('nik')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div>
                        <div class="section-divider">
                            <h3 class="section-title text-xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-lock mr-3 text-green-600"></i>
                                Keamanan Akun
                            </h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Password -->
                            <div class="space-y-2">
                                <label for="password" class="block text-sm font-semibold text-gray-700">
                                    Password *
                                </label>
                                <div class="relative">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        name="password" 
                                        required
                                        class="modern-input w-full px-4 py-3 rounded-xl focus:outline-none placeholder-gray-400 pr-12"
                                        placeholder="Minimal 8 karakter"
                                    >
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('password', 'eyeIcon1')" 
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                                    >
                                        <i id="eyeIcon1" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <span id="passwordStrength"></span>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-2">
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                                    Konfirmasi Password *
                                </label>
                                <div class="relative">
                                    <input 
                                        id="password_confirmation" 
                                        type="password" 
                                        name="password_confirmation" 
                                        required
                                        class="modern-input w-full px-4 py-3 rounded-xl focus:outline-none placeholder-gray-400 pr-12"
                                        placeholder="Ulangi password"
                                    >
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('password_confirmation', 'eyeIcon2')" 
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                                    >
                                        <i id="eyeIcon2" class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="text-xs mt-1" id="passwordMatch"></div>
                                @error('password_confirmation')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div>
                        <div class="section-divider">
                            <h3 class="section-title text-xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-map-marker-alt mr-3 text-green-600"></i>
                                Informasi Alamat
                            </h3>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Street Address -->
                            <div class="space-y-2">
                                <label for="address" class="block text-sm font-semibold text-gray-700">
                                    Nama Jalan/No. Rumah *
                                </label>
                                <input 
                                    id="address" 
                                    type="text" 
                                    name="address" 
                                    value="{{ old('address') }}" 
                                    required
                                    class="modern-input w-full px-4 py-3 rounded-xl focus:outline-none placeholder-gray-400"
                                    placeholder="Jl. Contoh No. 123"
                                >
                                @error('address')
                                    <p class="text-red-500 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Province -->
                                <div class="space-y-2">
                                    <label for="province" class="block text-sm font-semibold text-gray-700">
                                        Provinsi *
                                    </label>
                                    <select 
                                        id="province" 
                                        name="province" 
                                        required
                                        class="modern-select w-full px-4 py-3 rounded-xl focus:outline-none"
                                    >
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
                                    <label for="regency" class="block text-sm font-semibold text-gray-700">
                                        Kabupaten/Kota *
                                    </label>
                                    <select 
                                        id="regency" 
                                        name="regency" 
                                        required
                                        class="modern-select w-full px-4 py-3 rounded-xl focus:outline-none"
                                        disabled
                                    >
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
                                    <label for="district" class="block text-sm font-semibold text-gray-700">
                                        Kecamatan *
                                    </label>
                                    <select 
                                        id="district" 
                                        name="district" 
                                        required
                                        class="modern-select w-full px-4 py-3 rounded-xl focus:outline-none"
                                        disabled
                                    >
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
                                    <label for="village" class="block text-sm font-semibold text-gray-700">
                                        Kelurahan *
                                    </label>
                                    <select 
                                        id="village" 
                                        name="village" 
                                        required
                                        class="modern-select w-full px-4 py-3 rounded-xl focus:outline-none"
                                        disabled
                                    >
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

                    <!-- Terms and Conditions -->
                    <div class="p-6 bg-gray-50 rounded-xl">
                        <label class="flex items-start space-x-3">
                            <input 
                                type="checkbox" 
                                name="terms" 
                                required
                                class="w-5 h-5 text-green-600 bg-white border-gray-300 rounded focus:ring-green-500 focus:ring-2 mt-0.5"
                            >
                            <span class="text-sm text-gray-700 leading-relaxed">
                                Saya menyetujui 
                                <a href="{{ route('terms') }}" class="text-green-600 hover:text-green-700 font-semibold underline" target="_blank">
                                    Syarat dan Ketentuan
                                </a>
                                serta 
                                <a href="{{ route('privacy') }}" class="text-green-600 hover:text-green-700 font-semibold underline" target="_blank">
                                    Kebijakan Privasi
                                </a>
                                yang berlaku.
                            </span>
                        </label>
                        @error('terms')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button 
                            type="submit" 
                            id="submitBtn"
                            class="modern-btn w-full py-4 px-6 rounded-xl font-semibold text-white text-lg"
                        >
                            <i class="fas fa-user-plus mr-2"></i>
                            <span id="btnText">Daftar Sekarang</span>
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="text-center mt-8 pt-6 border-t border-gray-200">
                    <p class="text-gray-600 text-sm">
                        Sudah punya akun? 
                        <a href="{{ route('buyer.login') }}" class="text-green-600 hover:text-green-700 font-semibold transition-colors">
                            Masuk sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="{{ route('welcome') }}" class="text-gray-500 hover:text-gray-700 text-sm transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke beranda
            </a>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'fas fa-eye';
            }
        }

        function checkPasswordStrength(password) {
            let strength = 0;
            let feedback = [];
            
            if (password.length >= 8) strength += 1;
            else feedback.push('minimal 8 karakter');
            
            if (/[a-z]/.test(password)) strength += 1;
            else feedback.push('huruf kecil');
            
            if (/[A-Z]/.test(password)) strength += 1;
            else feedback.push('huruf besar');
            
            if (/[0-9]/.test(password)) strength += 1;
            else feedback.push('angka');
            
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            else feedback.push('karakter khusus');
            
            const strengthEl = document.getElementById('passwordStrength');
            
            if (password.length === 0) {
                strengthEl.innerHTML = '';
                return;
            }
            
            let strengthText = '';
            let strengthClass = '';
            
            switch (strength) {
                case 0:
                case 1:
                    strengthText = `<i class="fas fa-times text-red-500 mr-1"></i>Lemah`;
                    strengthClass = 'text-red-500';
                    break;
                case 2:
                case 3:
                    strengthText = `<i class="fas fa-minus text-yellow-500 mr-1"></i>Sedang`;
                    strengthClass = 'text-yellow-500';
                    break;
                case 4:
                case 5:
                    strengthText = `<i class="fas fa-check text-green-500 mr-1"></i>Kuat`;
                    strengthClass = 'text-green-500';
                    break;
            }
            
            if (feedback.length > 0 && strength < 4) {
                strengthText += ` (perlu: ${feedback.join(', ')})`;
            }
            
            strengthEl.innerHTML = strengthText;
            strengthEl.className = `text-xs mt-1 ${strengthClass}`;
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchEl = document.getElementById('passwordMatch');
            
            if (confirmPassword.length === 0) {
                matchEl.innerHTML = '';
                return;
            }
            
            if (password === confirmPassword) {
                matchEl.innerHTML = '<i class="fas fa-check text-green-500 mr-1"></i>Password cocok';
                matchEl.className = 'text-xs mt-1 text-green-500';
                document.getElementById('password_confirmation').classList.remove('border-red-500');
            } else {
                matchEl.innerHTML = '<i class="fas fa-times text-red-500 mr-1"></i>Password tidak cocok';
                matchEl.className = 'text-xs mt-1 text-red-500';
                document.getElementById('password_confirmation').classList.add('border-red-500');
            }
        }

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
            
            // Slide in animation
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // NIK validation
        document.getElementById('nik').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 16) {
                value = value.slice(0, 16);
            }
            e.target.value = value;
        });

        // Phone validation
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 15) {
                value = value.slice(0, 15);
            }
            e.target.value = value;
        });

        // Password strength checking
        document.getElementById('password').addEventListener('input', function(e) {
            checkPasswordStrength(e.target.value);
            checkPasswordMatch();
        });

        // Password confirmation checking
        document.getElementById('password_confirmation').addEventListener('input', function() {
            checkPasswordMatch();
        });

        // Fetch Provinces
        fetch('https://flavianusputratama.github.io/api-wilayah-indonesia/api/provinces.json')
            .then(response => response.json())
            .then(provinces => {
                const provinceSelect = document.getElementById('province');
                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.name;
                    option.textContent = province.name;
                    option.dataset.id = province.id;
                    provinceSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching provinces:', error);
                showNotification('Gagal memuat data provinsi', 'error');
            });

        // Fetch Regencies
        document.getElementById('province').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const provinceId = selectedOption.dataset.id;
            const regencySelect = document.getElementById('regency');
            const districtSelect = document.getElementById('district');
            const villageSelect = document.getElementById('village');
            
            // Reset dependent dropdowns
            regencySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
            
            regencySelect.disabled = !provinceId;
            districtSelect.disabled = true;
            villageSelect.disabled = true;

            if (provinceId) {
                regencySelect.innerHTML = '<option value="">Memuat...</option>';
                
                fetch(`https://flavianusputratama.github.io/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                    .then(response => response.json())
                    .then(regencies => {
                        regencySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                        regencies.forEach(regency => {
                            const option = document.createElement('option');
                            option.value = regency.name;
                            option.textContent = regency.name;
                            option.dataset.id = regency.id;
                            regencySelect.appendChild(option);
                       });
                       regencySelect.disabled = false;
                   })
                   .catch(error => {
                       console.error('Error fetching regencies:', error);
                       regencySelect.innerHTML = '<option value="">Error memuat data</option>';
                       showNotification('Gagal memuat data kabupaten/kota', 'error');
                   });
           }
       });

       // Fetch Districts
       document.getElementById('regency').addEventListener('change', function() {
           const selectedOption = this.options[this.selectedIndex];
           const regencyId = selectedOption.dataset.id;
           const districtSelect = document.getElementById('district');
           const villageSelect = document.getElementById('village');
           
           // Reset dependent dropdowns
           districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
           villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
           
           districtSelect.disabled = !regencyId;
           villageSelect.disabled = true;

           if (regencyId) {
               districtSelect.innerHTML = '<option value="">Memuat...</option>';
               
               fetch(`https://flavianusputratama.github.io/api-wilayah-indonesia/api/districts/${regencyId}.json`)
                   .then(response => response.json())
                   .then(districts => {
                       districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                       districts.forEach(district => {
                           const option = document.createElement('option');
                           option.value = district.name;
                           option.textContent = district.name;
                           option.dataset.id = district.id;
                           districtSelect.appendChild(option);
                       });
                       districtSelect.disabled = false;
                   })
                   .catch(error => {
                       console.error('Error fetching districts:', error);
                       districtSelect.innerHTML = '<option value="">Error memuat data</option>';
                       showNotification('Gagal memuat data kecamatan', 'error');
                   });
           }
       });

       // Fetch Villages
       document.getElementById('district').addEventListener('change', function() {
           const selectedOption = this.options[this.selectedIndex];
           const districtId = selectedOption.dataset.id;
           const villageSelect = document.getElementById('village');
           
           // Reset village dropdown
           villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
           villageSelect.disabled = !districtId;

           if (districtId) {
               villageSelect.innerHTML = '<option value="">Memuat...</option>';
               
               fetch(`https://flavianusputratama.github.io/api-wilayah-indonesia/api/villages/${districtId}.json`)
                   .then(response => response.json())
                   .then(villages => {
                       villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
                       villages.forEach(village => {
                           const option = document.createElement('option');
                           option.value = village.name;
                           option.textContent = village.name;
                           villageSelect.appendChild(option);
                       });
                       villageSelect.disabled = false;
                   })
                   .catch(error => {
                       console.error('Error fetching villages:', error);
                       villageSelect.innerHTML = '<option value="">Error memuat data</option>';
                       showNotification('Gagal memuat data kelurahan', 'error');
                   });
           }
       });

       // Form validation before submit
       function validateForm() {
           const requiredFields = document.querySelectorAll('input[required], select[required]');
           let isValid = true;
           let firstInvalidField = null;

           requiredFields.forEach(field => {
               if (!field.value.trim()) {
                   field.classList.add('border-red-500');
                   if (!firstInvalidField) {
                       firstInvalidField = field;
                   }
                   isValid = false;
               } else {
                   field.classList.remove('border-red-500');
               }
           });

           // Check password confirmation
           const password = document.getElementById('password').value;
           const confirmPassword = document.getElementById('password_confirmation').value;
           
           if (password !== confirmPassword) {
               document.getElementById('password_confirmation').classList.add('border-red-500');
               if (!firstInvalidField) {
                   firstInvalidField = document.getElementById('password_confirmation');
               }
               isValid = false;
           }

           // Check password strength
           if (password.length < 8) {
               document.getElementById('password').classList.add('border-red-500');
               if (!firstInvalidField) {
                   firstInvalidField = document.getElementById('password');
               }
               isValid = false;
           }

           // Check NIK length
           const nik = document.getElementById('nik').value;
           if (nik.length !== 16) {
               document.getElementById('nik').classList.add('border-red-500');
               if (!firstInvalidField) {
                   firstInvalidField = document.getElementById('nik');
               }
               isValid = false;
               showNotification('NIK harus 16 digit', 'error');
           }

           // Check terms checkbox
           const termsCheckbox = document.querySelector('input[name="terms"]');
           if (!termsCheckbox.checked) {
               showNotification('Mohon setujui syarat dan ketentuan', 'error');
               isValid = false;
           }

           if (!isValid && firstInvalidField) {
               firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
               firstInvalidField.focus();
               showNotification('Mohon lengkapi semua field yang wajib diisi', 'error');
           }

           return isValid;
       }

       // Form submission with loading state
       document.querySelector('form').addEventListener('submit', function(e) {
           if (!validateForm()) {
               e.preventDefault();
               return;
           }

           const submitBtn = document.getElementById('submitBtn');
           const btnText = document.getElementById('btnText');
           
           submitBtn.disabled = true;
           submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
           btnText.innerHTML = '<span class="loading-dots">Mendaftar</span>';
           
           // Add spinner
           const spinner = document.createElement('i');
           spinner.className = 'fas fa-spinner fa-spin mr-2';
           btnText.insertBefore(spinner, btnText.firstChild);
       });

       // Add entrance animation
       document.addEventListener('DOMContentLoaded', function() {
           const card = document.querySelector('.glass-card');
           card.style.opacity = '0';
           card.style.transform = 'translateY(20px)';
           
           setTimeout(() => {
               card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
               card.style.opacity = '1';
               card.style.transform = 'translateY(0)';
           }, 100);
       });

       // Auto-scroll to error fields
       window.addEventListener('load', function() {
           const firstError = document.querySelector('.text-red-500');
           if (firstError) {
               const field = firstError.closest('.space-y-2')?.querySelector('input, select');
               if (field) {
                   setTimeout(() => {
                       field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                       field.focus();
                   }, 500);
               }
           }
       });

       // Smooth scrolling enhancement
       const formContainer = document.querySelector('.form-container');
       let isScrolling = false;

       formContainer.addEventListener('scroll', function() {
           if (!isScrolling) {
               window.requestAnimationFrame(function() {
                   // Add shadow to indicate more content below
                   const scrollTop = formContainer.scrollTop;
                   const scrollHeight = formContainer.scrollHeight;
                   const clientHeight = formContainer.clientHeight;
                   
                   if (scrollTop > 10) {
                       formContainer.classList.add('shadow-inner');
                   } else {
                       formContainer.classList.remove('shadow-inner');
                   }
                   
                   isScrolling = false;
               });
               isScrolling = true;
           }
       });

       // Enhanced focus management
       const inputs = document.querySelectorAll('input, select');
       inputs.forEach((input, index) => {
           input.addEventListener('keydown', function(e) {
               if (e.key === 'Enter' && input.type !== 'submit') {
                   e.preventDefault();
                   const nextInput = inputs[index + 1];
                   if (nextInput) {
                       nextInput.focus();
                   }
               }
           });
       });

       // Real-time validation feedback
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

       // Auto-format phone number
       document.getElementById('phone').addEventListener('input', function(e) {
           let value = e.target.value.replace(/\D/g, '');
           
           // Auto add country code if starting with 8
           if (value.startsWith('8') && value.length > 1) {
               value = '0' + value;
           }
           
           if (value.length > 15) {
               value = value.slice(0, 15);
           }
           
           e.target.value = value;
       });

       // Email validation
       document.getElementById('email').addEventListener('blur', function() {
           const email = this.value;
           const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
           
           if (email && !emailRegex.test(email)) {
               this.classList.add('border-red-500');
               showNotification('Format email tidak valid', 'error');
           } else {
               this.classList.remove('border-red-500');
           }
       });

       // Prevent form resubmission on page refresh
       if (window.history.replaceState) {
           window.history.replaceState(null, null, window.location.href);
       }
   </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Generator - Renewa</title>
    <meta name="description" content="Daftarkan pembangkit energi terbarukan Anda di platform Renewa.">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        .auth-gradient { background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 25%, #f0f9ff 75%, #eff6ff 100%); }
        .glass-card { background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.2); }
        .modern-input, .modern-select, .modern-file-input { border-color: #d1d5db; transition: all 0.3s ease; }
        .modern-input:focus, .modern-select:focus, .modern-file-input:focus-within { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2); }
        .modern-btn { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3); }
        .modern-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(16, 185, 129, 0.4); }
    </style>
</head>
<body class="font-sans antialiased auth-gradient">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-4xl space-y-8">
            <div class="text-center">
                <a href="{{ route('welcome') }}">
                    <h1 class="text-4xl font-bold text-gray-800">
                        <i class="fas fa-leaf text-green-500"></i>
                        Renewa
                    </h1>
                </a>
                <h2 class="mt-4 text-3xl font-extrabold text-gray-900">Pendaftaran Akun Generator</h2>
                <p class="mt-2 text-md text-gray-600">Daftarkan pembangkit energi terbarukan Anda untuk verifikasi.</p>
            </div>
            
            <div class="glass-card mt-8 p-8 rounded-2xl shadow-2xl">
                <form method="POST" action="{{ route('generator.register') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Bagian Informasi Kontak -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center mb-4">
                            <i class="fas fa-user-tie mr-3 text-green-500"></i>
                            Informasi Kontak (PIC/Perusahaan)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap PIC</label>
                                <input id="name" class="modern-input block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus />
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input id="email" class="modern-input block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required />
                            </div>
                            <div class="md:col-span-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input id="phone" class="modern-input block mt-1 w-full" type="text" name="phone" value="{{ old('phone') }}" required />
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Detail Pembangkit -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center mb-4">
                           <i class="fas fa-industry mr-3 text-green-500"></i>
                            Informasi Pembangkit
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="power_plant_name" class="block text-sm font-medium text-gray-700">Nama Pembangkit</label>
                                <input id="power_plant_name" class="modern-input block mt-1 w-full" type="text" name="power_plant_name" value="{{ old('power_plant_name') }}" required />
                            </div>
                             <div>
                                <label for="energy_type" class="block text-sm font-medium text-gray-700">Jenis Energi</label>
                                <select id="energy_type" name="energy_type" class="modern-select block mt-1 w-full rounded-md" required>
                                    <option value="" disabled {{ old('energy_type') ? '' : 'selected' }}>Pilih Jenis Energi</option>
                                    <option value="PLTP" {{ old('energy_type') == 'PLTP' ? 'selected' : '' }}>PLTP (Panas Bumi)</option>
                                    <option value="PLTA" {{ old('energy_type') == 'PLTA' ? 'selected' : '' }}>PLTA (Air)</option>
                                    <option value="PLTM" {{ old('energy_type') == 'PLTM' ? 'selected' : '' }}>PLTM (Mikrohidro)</option>
                                </select>
                            </div>
                             <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-700">Kapasitas (MW)</label>
                                <input id="capacity" class="modern-input block mt-1 w-full" type="number" step="0.01" name="capacity" value="{{ old('capacity') }}" required />
                            </div>
                            <div>
                                <label for="operational_permit_document" class="block text-sm font-medium text-gray-700">Unggah Izin Operasi (PDF)</label>
                                <input id="operational_permit_document" class="modern-file-input block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" type="file" name="operational_permit_document" required>
                                <p class="mt-1 text-xs text-gray-500">Maksimal ukuran file: 2MB.</p>
                            </div>
                            {{-- ===== KOLOM BARU DI SINI ===== --}}
                            <div class="md:col-span-2">
                                <label for="image_url" class="block text-sm font-medium text-gray-700">URL Gambar Pembangkit</label>
                                <input id="image_url" class="modern-input block mt-1 w-full" type="url" name="image_url" value="{{ old('image_url') }}" placeholder="Contoh: https://contoh.com/gambar.jpg" />
                                <p class="mt-1 text-xs text-gray-500">Masukkan link gambar pembangkit Anda yang akan ditampilkan di marketplace.</p>
                            </div>
                            {{-- ============================== --}}
                        </div>
                    </div>
                    
                    <!-- Bagian Kredensial -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center mb-4">
                           <i class="fas fa-lock mr-3 text-green-500"></i>
                            Kredensial Akun
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input id="password" class="modern-input block mt-1 w-full" type="password" name="password" required />
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input id="password_confirmation" class="modern-input block mt-1 w-full" type="password" name="password_confirmation" required />
                            </div>
                        </div>
                    </div>

                    <!-- Persetujuan dan Tombol Aksi -->
                    <div class="pt-5">
                        <div class="flex flex-col md:flex-row items-center justify-between">
                            <div class="mb-4 md:mb-0">
                                <label class="flex items-center">
                                    <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500" name="terms" required>
                                    <span class="ml-2 text-sm text-gray-600">
                                        {{ __('Saya menyatakan bahwa data yang diisi adalah benar.') }}
                                    </span>
                                </label>
                            </div>
                            <div class="flex items-center space-x-4">
                                <a class="text-sm text-gray-600 hover:text-green-700" href="{{ route('login') }}">
                                    {{ __('Sudah punya akun?') }}
                                </a>
                                <button type="submit" class="modern-btn inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white">
                                    Ajukan Pendaftaran
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

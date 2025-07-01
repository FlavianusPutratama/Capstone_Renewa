<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Issuer - Renewa</title>
    <meta name="description" content="Ajukan pendaftaran sebagai Issuer di platform Renewable Energy Certificate Renewa.">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        .auth-gradient { background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 25%, #f0f9ff 75%, #eff6ff 100%); }
        .glass-card { background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.2); }
        .modern-input, .modern-file-input { border-color: #d1d5db; transition: all 0.3s ease; }
        .modern-input:focus, .modern-file-input:focus-within { border-color: #10b981; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2); }
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
                <h2 class="mt-4 text-3xl font-extrabold text-gray-900">Pendaftaran Akun Issuer</h2>
                <p class="mt-2 text-md text-gray-600">Lengkapi data institusi Anda untuk memulai proses verifikasi.</p>
            </div>
            
            <div class="glass-card mt-8 p-8 rounded-2xl shadow-2xl">
                <form method="POST" action="{{ route('issuer.register') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Bagian Informasi Institusi -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center mb-4">
                            <i class="fas fa-building mr-3 text-green-500"></i>
                            Informasi Institusi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="company_name" :value="__('Nama Institusi/Perusahaan')" />
                                <x-text-input id="company_name" class="modern-input block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required autofocus />
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nib" :value="__('Nomor Induk Berusaha (NIB)')" />
                                <x-text-input id="nib" class="modern-input block mt-1 w-full" type="text" name="nib" :value="old('nib')" required />
                                <x-input-error :messages="$errors->get('nib')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Informasi Penanggung Jawab -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center mb-4">
                           <i class="fas fa-user-tie mr-3 text-green-500"></i>
                            Informasi Penanggung Jawab (PIC)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap PIC')" />
                                <x-text-input id="name" class="modern-input block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email PIC')" />
                                <x-text-input id="email" class="modern-input block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="phone" :value="__('Nomor Telepon PIC')" />
                                <x-text-input id="phone" class="modern-input block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bagian Dokumen & Kredensial -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center mb-4">
                           <i class="fas fa-file-alt mr-3 text-green-500"></i>
                            Dokumen & Kredensial
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <div>
                                <x-input-label for="legal_document" :value="__('Unggah Dokumen Legalitas (PDF)')" />
                                <input id="legal_document" class="modern-file-input block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" type="file" name="legal_document" required>
                                <p class="mt-1 text-xs text-gray-500">Maksimal ukuran file: 2MB.</p>
                                <x-input-error :messages="$errors->get('legal_document')" class="mt-2" />
                            </div>
                            <div></div>
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="modern-input block mt-1 w-full" type="password" name="password" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                <x-text-input id="password_confirmation" class="modern-input block mt-1 w-full" type="password" name="password_confirmation" required />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
                                        {{ __('Saya menyetujui data yang diisi adalah benar.') }}
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

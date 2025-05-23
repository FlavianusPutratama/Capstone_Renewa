<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pembeli REC</title>
    @vite('resources/css/app.css') <!-- atau link CSS kamu -->
    <style>
        /* Background gradasi hijau ke putih */
        body {
            background: linear-gradient(135deg, #a8f0c6 0%, #ffffff 100%);
        }

        /* Card default (desktop/tablet) */
        .card {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px; /* Menyesuaikan lebar card */
        }

        /* Jika layar kecil (HP), hilangkan total stylenya */
        @media (max-width: 768px) {
            .card {
                background: transparent;
                backdrop-filter: none;
                box-shadow: none;
                border-radius: 0;
                padding: 0;
                max-width: 100%;
            }
        }
    </style>
</head>
<body class="flex min-h-screen items-center justify-center p-4">

    <div class="card">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800">Daftar untuk Membeli REC</h2>
            <p class="text-gray-600 mt-2">Buat akun untuk mulai membeli sertifikat energi terbarukan (Tambahin Pilihan Buyer atau Generator)</p>
        </div>

        <form method="POST" action="{{ route('buyer.register') }}">
            @csrf

            <!-- Nama Lengkap dan Email -->
            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="w-full md:w-1/2 px-2 mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>

            <!-- Nomor Telepon dan NIK -->
            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <x-input-label for="phone" :value="__('Nomor Telepon')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div class="w-full md:w-1/2 px-2 mb-4">
                    <x-input-label for="nik" :value="__('NIK')" />
                    <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required />
                    <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                </div>
            </div>

            <!-- Password dan Konfirmasi Password -->
            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="w-full md:w-1/2 px-2 mb-4">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <!-- Alamat -->
            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <x-input-label for="address" :value="__('Nama Jalan/No. Rumah')" />
                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <!-- Dropdown Provinsi -->
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <x-input-label for="province" :value="__('Provinsi')" />
                    <select id="province" name="province" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                    <x-input-error :messages="$errors->get('province')" class="mt-2" />
                </div>
            </div>

            <!-- Dropdown Kabupaten/Kota -->
            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <x-input-label for="regency" :value="__('Kabupaten/Kota')" />
                    <select id="regency" name="regency" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" required>
                        <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                    <x-input-error :messages="$errors->get('regency')" class="mt-2" />
                </div>

                <!-- Dropdown Kecamatan -->
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <x-input-label for="district" :value="__('Kecamatan')" />
                    <select id="district" name="district" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    <x-input-error :messages="$errors->get('district')" class="mt-2" />
                </div>
            </div>

            <!-- Dropdown Kelurahan -->
            <div class="w-full px-2 mb-4">
                <x-input-label for="village" :value="__('Kelurahan')" />
                <select id="village" name="village" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" required>
                    <option value="">Pilih Kelurahan</option>
                </select>
                <x-input-error :messages="$errors->get('village')" class="mt-2" />
            </div>

            <!-- Syarat & Ketentuan -->
            <div class="flex items-start mt-4">
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" name="terms" required>
                    <span class="ms-2 text-sm text-gray-600">
                        {{ __('Saya menyetujui') }}
                        <a class="text-green-600 hover:text-green-700" href="{{ route('terms') }}">{{ __('Syarat dan Ketentuan') }}</a>
                        {{ __('serta') }}
                        <a class="text-green-600 hover:text-green-700" href="{{ route('privacy') }}">{{ __('Kebijakan Privasi') }}</a>
                    </span>
                </label>
                <x-input-error :messages="$errors->get('terms')" class="mt-2" />
            </div>

            <!-- Tombol Daftar -->
            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('buyer.login') }}">
                    {{ __('Sudah punya akun?') }}
                </a>

                <x-primary-button class="bg-green-500 hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:ring-green-500">
                    {{ __('Daftar') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Script untuk Fetch Dropdown Wilayah -->
        <script>
            // Fetch Provinces
            fetch('https://flavianusputratama.github.io/api-wilayah-indonesia/api/provinces.json')
                .then(response => response.json())
                .then(provinces => {
                    const provinceSelect = document.getElementById('province');
                    provinces.forEach(province => {
                        const option = document.createElement('option');
                        option.value = province.id;
                        option.textContent = province.name;
                        provinceSelect.appendChild(option);
                    });
                });

            // Fetch Regencies
            document.getElementById('province').addEventListener('change', function() {
                const provinceId = this.value;
                const regencySelect = document.getElementById('regency');
                regencySelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                document.getElementById('district').innerHTML = '<option value="">Pilih Kecamatan</option>';
                document.getElementById('village').innerHTML = '<option value="">Pilih Kelurahan</option>';

                if (provinceId) {
                    fetch(`https://flavianusputratama.github.io/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
                        .then(response => response.json())
                        .then(regencies => {
                            regencies.forEach(regency => {
                                const option = document.createElement('option');
                                option.value = regency.id;
                                option.textContent = regency.name;
                                regencySelect.appendChild(option);
                            });
                        });
                }
            });

            // Fetch Districts
            document.getElementById('regency').addEventListener('change', function() {
                const regencyId = this.value;
                const districtSelect = document.getElementById('district');
                districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                document.getElementById('village').innerHTML = '<option value="">Pilih Kelurahan</option>';

                if (regencyId) {
                    fetch(`https://flavianusputratama.github.io/api-wilayah-indonesia/api/districts/${regencyId}.json`)
                        .then(response => response.json())
                        .then(districts => {
                            districts.forEach(district => {
                                const option = document.createElement('option');
                                option.value = district.id;
                                option.textContent = district.name;
                                districtSelect.appendChild(option);
                            });
                        });
                }
            });

            // Fetch Villages
            document.getElementById('district').addEventListener('change', function() {
                const districtId = this.value;
                const villageSelect = document.getElementById('village');
                villageSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';

                if (districtId) {
                    fetch(`https://flavianusputratama.github.io/api-wilayah-indonesia/api/villages/${districtId}.json`)
                        .then(response => response.json())
                        .then(villages => {
                            villages.forEach(village => {
                                const option = document.createElement('option');
                                option.value = village.id;
                                option.textContent = village.name;
                                villageSelect.appendChild(option);
                            });
                        });
                }
            });
        </script>
    </div>

</body>
</html>
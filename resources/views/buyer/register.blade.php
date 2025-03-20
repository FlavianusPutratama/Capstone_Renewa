<!-- resources/views/buyer/register.blade.php -->
<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Daftar untuk Membeli REC</h2>
        <p class="text-gray-600">Buat akun untuk mulai membeli sertifikat energi terbarukan</p>
    </div>

    <form method="POST" action="{{ route('buyer.register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label class="flex items-start">
                <input type="checkbox" class="mt-1 rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" name="terms" required>
                <span class="ms-2 text-sm text-gray-600">
                    {{ __('Saya menyetujui') }}
                    <a class="text-green-600 hover:text-green-700" href="{{ route('terms') }}">{{ __('Syarat dan Ketentuan') }}</a>
                    {{ __('serta') }}
                    <a class="text-green-600 hover:text-green-700" href="{{ route('privacy') }}">{{ __('Kebijakan Privasi') }}</a>
                </span>
            </label>
            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" href="{{ route('buyer.login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="bg-green-500 hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:ring-green-500">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
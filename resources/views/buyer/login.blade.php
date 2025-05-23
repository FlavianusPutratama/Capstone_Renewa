<!-- resources/views/buyer/login.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pembeli REC</title>
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
            max-width: 400px;
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
        <div class="mb-8 text-center">
            <h2 class="text-4xl font-extrabold text-gray-800 drop-shadow-md">Renewa</h2>
            <p class="mt-3 text-sm text-gray-700">Masuk untuk melanjutkan pembelian<br><span class="font-semibold text-green-600">Sertifikat Energi Terbarukan (REC)</span></p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-100 p-3 text-green-700 text-sm shadow">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('buyer.login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-6">
                <label for="email" class="block mb-1 text-sm font-semibold text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-lg border border-gray-300 bg-white/70 p-3 shadow-inner placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition">
                @error('email')
                    <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block mb-1 text-sm font-semibold text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full rounded-lg border border-gray-300 bg-white/70 p-3 shadow-inner placeholder-gray-400 focus:border-green-500 focus:ring-2 focus:ring-green-300 focus:outline-none transition">
                @error('password')
                    <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center space-x-2">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-400">
                    <span class="text-sm text-gray-600">Ingat saya</span>
                </label>

                <a href="{{ route('buyer.register') }}" class="text-sm text-green-600 hover:text-green-700 font-semibold transition">
                    Belum punya akun?
                </a>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full rounded-lg bg-gradient-to-r from-green-400 to-green-600 py-3 font-bold text-white shadow-lg hover:from-green-500 hover:to-green-700 transition-all duration-300 focus:ring-4 focus:ring-green-300">
                    Masuk
                </button>
            </div>
        </form>
    </div>

</body>
</html>

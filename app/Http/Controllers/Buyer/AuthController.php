<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException; // Ditambahkan untuk penanganan error yang lebih spesifik
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display the buyer login view.
     */
    public function showLoginForm(Request $request) // <-- Modifikasi: Tambahkan Request $request
    {
        // --- LOGIKA BARU DITAMBAHKAN ---
        // Cek apakah ada parameter 'source' dari URL
        if ($request->has('source') && $request->source === 'navbar') {
            // Jika iya, simpan tujuan redirect di session
            Session::put('login_redirect_target', 'welcome');
        } else {
            // Jika tidak, hapus session agar tidak mengganggu proses intended()
            Session::forget('login_redirect_target');
        }
        // ------------------------------

        return view('buyer.login');
    }

    // ... (metode showProfile dan updateProfile tidak berubah) ...
    public function showProfile()
    {
        $user = auth()->user();
        return view('buyer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // ... kode tidak berubah ...
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'buyer') {

                // --- LOGIKA REDIRECT BARU DITAMBAHKAN ---
                // Cek apakah ada session tujuan redirect dari navbar
                if (Session::has('login_redirect_target') && Session::get('login_redirect_target') === 'welcome') {
                    // Hapus session agar tidak digunakan lagi
                    Session::forget('login_redirect_target');
                    // Arahkan ke route 'welcome'
                    return redirect()->route('welcome');
                }
                // ----------------------------------------

                // Jika tidak ada session, gunakan intended() seperti biasa
                return redirect()->intended(route('buyer.categoryselect')); // <-- Gunakan helper route() untuk keamanan

            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Kredensial ini tidak memiliki akses sebagai pembeli.',
                ])->onlyInput('email');
            }
        }

        return back()->withErrors([
            'email' => __('Email atau password yang Anda masukkan tidak valid.'),
        ])->onlyInput('email');
    }

    /**
     * Display the buyer registration view.
     */
    public function showRegistrationForm()
    {
        return view('buyer.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'],
            'nik' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
            'address' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string'],
            'regency' => ['required', 'string'],
            'district' => ['required', 'string'],
            'village' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nik' => $request->nik,
            'address' => $request->address,
            'province' => $request->province,
            'regency' => $request->regency,
            'district' => $request->district,
            'village' => $request->village,
            'password' => Hash::make($request->password),
            'role' => 'buyer', // Pastikan ini sesuai dengan sistem role Anda
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect('/'); // Atau ke halaman yang lebih sesuai setelah registrasi buyer
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // --- METHOD BARU UNTUK UPDATE PASSWORD ---
    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'], 
            // 'new_password_confirmation' akan divalidasi oleh aturan 'confirmed' pada 'new_password'
        ]);

        $user = auth()->user();

        // 2. Cek apakah password lama sesuai
        if (!Hash::check($request->current_password, $user->password)) {
            // Jika tidak sesuai, kembali dengan pesan error spesifik untuk field current_password
            // Ini akan ditampilkan di bawah input 'Password Lama' jika Anda menggunakan @error('current_password') di Blade
            // throw ValidationException::withMessages([
            //     'current_password' => 'Password lama yang Anda masukkan tidak sesuai.',
            // ]);
            // Alternatif: menggunakan session flash error umum
            return back()->with('error', 'Password lama yang Anda masukkan tidak sesuai.');
        }

        // 3. Update password baru ke database
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // 4. Kembali ke halaman profil dengan pesan sukses
        //    Penting: pastikan modal tertutup setelah submit berhasil atau error.
        //    Menggunakan 'back()' akan mengembalikan ke halaman profil, dan pesan flash akan ditampilkan.
        return back()->with('success', 'Password berhasil diperbarui!');
    }
    // -----------------------------------------
}

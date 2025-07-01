<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
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

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function updateProfile(Request $request)
    {
        // 1. Ambil pengguna yang sedang login
        $user = Auth::user();

        // 2. Validasi data yang masuk
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            // Pastikan validasi NIK unik, tapi abaikan NIK milik pengguna saat ini
            'nik' => ['required', 'string', 'digits:16', Rule::unique('users')->ignore($user->id)],
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'regency' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'village' => 'required|string|max:255',
        ]);

        // 3. Update data pengguna di database
        $user->update($validatedData);

        // 4. Kembalikan ke halaman profil dengan pesan sukses
        return redirect()->route('buyer.profile.show')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Memperbarui password pengguna.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validasi
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Password lama yang Anda masukkan salah.');
                }
            }],
            'new_password' => ['required', 'string', Password::min(8)->mixedCase()->numbers(), 'confirmed'],
        ]);

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('buyer.profile.show')->with('success', 'Password Anda berhasil diubah!');
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
}

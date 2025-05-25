<?php
// app/Http/Controllers/Buyer/AuthController.php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Display the buyer login view.
     */
    public function showLoginForm()
    {
        return view('buyer.login');
    }

    /**
     * Display Profile Page
     */
    public function showProfile()
    {
        $user = auth()->user();
        return view('buyer.profile', compact('user'));
    }

    /**
     * Update from Profile Page
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'required|string|max:15',
            'nik' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'province' => 'required|string',
            'regency' => 'required|string',
            'district' => 'required|string',
            'village' => 'required|string',
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nik' => $request->nik,
            'address' => $request->address,
            'province' => $request->province,
            'regency' => $request->regency,
            'district' => $request->district,
            'village' => $request->village,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
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

            if (Auth::user()->isBuyer()) {
                return redirect()->intended('/buyer/categoryselect');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Kredensial ini tidak memiliki akses sebagai pembeli.',
                ]);
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
            'role' => 'buyer',
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect('/');
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
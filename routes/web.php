<?php

// routes/web.php

// Namespace tidak diperlukan di sini jika file ini berada di root 'routes'
// namespace routes\web; 

use App\Http\Controllers\ProfileController; // Ini mungkin tidak terpakai jika Anda menggunakan BuyerAuthController untuk semua profil buyer
use App\Http\Controllers\Buyer\AuthController as BuyerAuthController;
use App\Http\Controllers\Issuer\AuthController as IssuerAuthController;
use App\Http\Controllers\Buyer\MarketplaceController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Buyer Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/buyer/login', [BuyerAuthController::class, 'showLoginForm'])->name('buyer.login');
    Route::post('/buyer/login', [BuyerAuthController::class, 'login']);
    Route::get('/buyer/register', [BuyerAuthController::class, 'showRegistrationForm'])->name('buyer.register');
    Route::post('/buyer/register', [BuyerAuthController::class, 'register']);
});

// Protected Buyer Routes
Route::middleware(['auth', 'App\Http\Middleware\CheckRole:buyer'])->prefix('buyer')->group(function () {
    Route::get('/checkout', function () {
        return view('buyer.checkout');
    })->name('buyer.checkout');

    Route::get('/categoryselect', function () {
        return view('buyer.categoryselect');
    })->name('buyer.categoryselect');

    Route::get('/dashboard', function () {
        return view('dashboard'); // Pastikan view 'dashboard' ini ada atau sesuaikan path-nya
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [BuyerAuthController::class, 'showProfile'])->name('profile.show');
    Route::post('/profile', [BuyerAuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/edit', [BuyerAuthController::class, 'showProfile'])->name('profile.edit'); // Biasanya ini juga mengarah ke form edit atau showProfile yang sama

    // --- TAMBAHKAN ROUTE BARU UNTUK UPDATE PASSWORD DI SINI ---
    Route::post('/profile/password', [BuyerAuthController::class, 'updatePassword'])->name('profile.updatePassword');
    // ---------------------------------------------------------
});

// Issuer Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/issuer/login', [IssuerAuthController::class, 'showLoginForm'])->name('issuer.login');
    Route::post('/issuer/login', [IssuerAuthController::class, 'login']);   
    Route::get('/issuer/register', [IssuerAuthController::class, 'showRegistrationForm'])->name('issuer.register');
    Route::post('/issuer/register', [IssuerAuthController::class, 'register']);
});

// Protected Issuer Routes
// Perbaiki 'role:issuer' menjadi 'App\Http\Middleware\CheckRole:issuer' jika middleware Anda seperti itu
Route::middleware(['auth', 'App\Http\Middleware\CheckRole:issuer'])->prefix('issuer')->group(function () { 
    Route::get('/dashboard', function () {
        return view('issuer.dashboard');
    })->name('issuer.dashboard');
});

// Auth routes for both
Route::middleware('auth')->group(function () {
    Route::post('/logout', function() {
        // Pastikan method isIssuer() ada di model User Anda atau sesuaikan logikanya
        if (auth()->user()->role === 'issuer') { // Contoh jika Anda memiliki kolom 'role'
            return app()->make(IssuerAuthController::class)->logout(request());
        } else {
            return app()->make(BuyerAuthController::class)->logout(request());
        }
    })->name('logout');
});

// Generatormap Route
Route::get('/generatormap', function () {
    return view('generatormap');
})->name('generatormap');

// Marketplace Route
Route::match(['get', 'post'], '/buyer/marketplace', [MarketplaceController::class, 'index'])->name('marketplace');

// Welcome Page Route
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Routes untuk kompatibilitas (redirect ke modal)
Route::get('/terms', function () {
    return redirect()->route('buyer.register')->with('openModal', 'terms');
})->name('terms');

Route::get('/privacy', function () {
    return redirect()->route('buyer.register')->with('openModal', 'privacy');  
})->name('privacy');
<?php
// routes/web.php

namespace routes\web;

use App\Http\Controllers\ProfileController;
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
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [BuyerAuthController::class, 'showProfile'])->name('profile.show');
    Route::post('/profile', [BuyerAuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/edit', [BuyerAuthController::class, 'showProfile'])->name('profile.edit');
});

// Issuer Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/issuer/login', [IssuerAuthController::class, 'showLoginForm'])->name('issuer.login');
    Route::post('/issuer/login', [IssuerAuthController::class, 'login']);   
    Route::get('/issuer/register', [IssuerAuthController::class, 'showRegistrationForm'])->name('issuer.register');
    Route::post('/issuer/register', [IssuerAuthController::class, 'register']);
});

// Protected Issuer Routes
Route::middleware(['auth', 'role:issuer'])->prefix('issuer')->group(function () {
    Route::get('/dashboard', function () {
        return view('issuer.dashboard');
    })->name('issuer.dashboard');
});

// Auth routes for both
Route::middleware('auth')->group(function () {
    Route::post('/logout', function() {
        if (auth()->user()->isIssuer()) {
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
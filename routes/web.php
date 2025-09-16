<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Buyer\AuthController as BuyerAuthController;
use App\Http\Controllers\Issuer\AuthController as IssuerAuthController;
use App\Http\Controllers\Generator\AuthController as GeneratorAuthController;
use App\Http\Controllers\Buyer\MarketplaceController;
use App\Http\Controllers\Buyer\ProductDetailController;
use App\Http\Controllers\Buyer\CheckoutController;
use App\Http\Controllers\Generator\PowerPlantController; 
use App\Http\Controllers\Admin\VerificationController;


// ===== PUBLIC ROUTES =====
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/generatormap', function () {
    return view('generatormap');
})->name('generatormap');

// ... Rute publik lainnya jika ada ...


// ===== AUTHENTICATION & REGISTRATION ROUTES =====
Route::middleware('guest')->group(function () {
    // Satu Pintu Login Universal
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Rute Registrasi tetap terpisah
    Route::get('/buyer/register', [BuyerAuthController::class, 'showRegistrationForm'])->name('buyer.register');
    Route::post('/buyer/register', [BuyerAuthController::class, 'register']);

    Route::get('/issuer/register', [IssuerAuthController::class, 'showRegistrationForm'])->name('issuer.register');
    Route::post('/issuer/register', [IssuerAuthController::class, 'register']);

    Route::get('/generator/register', [GeneratorAuthController::class, 'showRegistrationForm'])->name('generator.register');
    Route::post('/generator/register', [GeneratorAuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});


// ===== PROTECTED BUYER ROUTES =====
Route::middleware(['auth', 'App\Http\Middleware\CheckRole:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('/welcome'); // Pastikan ini view dashboard buyer
    })->name('dashboard');
    
    Route::get('/categoryselect', function () {
        return view('buyer.categoryselect');
    })->name('categoryselect');

    // Route untuk menampilkan daftar produk di marketplace
    Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace');

    // Route untuk menampilkan halaman detail SATU produk (URL diubah agar tidak bentrok)
    Route::get('/product/{powerPlant}', [ProductDetailController::class, 'show'])->name('marketplace.show');

    Route::get('/orders', [CheckoutController::class, 'index'])->name('orders.index');

    Route::get('/orders/{order}', [CheckoutController::class, 'showOrder'])->name('orders.show');
    Route::post('/checkout', [CheckoutController::class, 'processOrder'])->name('checkout.process');
    Route::post('/orders/{order}/confirm', [CheckoutController::class, 'confirmPayment'])->name('orders.confirm');

    Route::get('/profile', [BuyerAuthController::class, 'showProfile'])->name('profile.show');
    Route::post('/profile', [BuyerAuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/edit', [BuyerAuthController::class, 'showProfile'])->name('profile.edit');
    Route::post('/profile/password', [BuyerAuthController::class, 'updatePassword'])->name('profile.updatePassword');

    Route::get('/checkout/company-details', [CheckoutController::class, 'createCompanyForm'])->name('checkout.company.create');
    Route::post('/checkout/company-details', [CheckoutController::class, 'storeCompanyForm'])->name('checkout.company.store');

    Route::post('/checkout/select-category/{certificate}', [App\Http\Controllers\Buyer\CheckoutController::class, 'storeCategoryAndProceed'])->name('checkout.storeCategoryAndProceed');
    Route::get('/checkout/summary', [App\Http\Controllers\Buyer\CheckoutController::class, 'summary'])->name('checkout.summary');
});


// ===== PROTECTED ISSUER ROUTES =====
Route::middleware(['auth', 'App\Http\Middleware\CheckRole:issuer'])->prefix('issuer')->name('issuer.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Issuer\DashboardController::class, 'index'])->name('dashboard');

    Route::post('/reports/{report}/issue', [App\Http\Controllers\Issuer\CertificateController::class, 'issue'])->name('reports.issue');
    Route::post('/reports/{report}/reject', [App\Http\Controllers\Issuer\CertificateController::class, 'reject'])->name('reports.reject');

    Route::put('/power-plants/{powerPlant}', [PowerPlantController::class, 'update'])->name('power-plant.update');

    Route::post('/orders/{orderId}/approve', [App\Http\Controllers\Issuer\DashboardController::class, 'verifyPayment'])->name('orders.approvePayment');
    Route::post('/orders/{orderId}/reject', [App\Http\Controllers\Issuer\DashboardController::class, 'rejectPayment'])->name('orders.rejectPayment');
});


// ===== PROTECTED GENERATOR ROUTES =====
Route::middleware(['auth', 'App\Http\Middleware\CheckRole:generator'])->prefix('generator')->name('generator.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Generator\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/reports', [App\Http\Controllers\Generator\EnergyReportController::class, 'store'])->name('reports.store');
    Route::put('/power-plants/{powerPlant}', [App\Http\Controllers\Generator\PowerPlantController::class, 'update'])->name('power-plant.update');
    Route::put('/power-plants/{powerPlant}', [PowerPlantController::class, 'update'])->name('power-plant.update');
});


// ===== PROTECTED ADMIN ROUTES =====
Route::middleware(['auth', 'App\Http\Middleware\CheckRole:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\VerificationController::class, 'index'])->name('dashboard');
    Route::get('/users/{userId}/details-json', [App\Http\Controllers\Admin\VerificationController::class, 'getJsonDetails'])->name('users.getJsonDetails');
    Route::post('/users/{user}/approve', [App\Http\Controllers\Admin\VerificationController::class, 'approve'])->name('users.approve');
    Route::post('/users/{user}/reject', [App\Http\Controllers\Admin\VerificationController::class, 'reject'])->name('users.reject');
    Route::get('/admin/documents/{user}', [VerificationController::class, 'showDocument'])
        ->name('admin.documents.show');
});
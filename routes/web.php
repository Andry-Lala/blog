<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\InvestmentImageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\Admin\ExchangeRateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Test route for debugging
require_once __DIR__.'/test.php';

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Information routes
    Route::get('/informations', [InformationController::class, 'index'])->name('informations.index');

    // Theme routes
    Route::post('/theme/switch', [ThemeController::class, 'switch'])->name('theme.switch');

    // Client management routes
    Route::resource('clients', ClientController::class);
    Route::patch('/clients/{client}/verify', [ClientController::class, 'verify'])->name('clients.verify');
    Route::patch('/clients/{client}/unverify', [ClientController::class, 'unverify'])->name('clients.unverify');

    // Investment routes
    Route::resource('investments', InvestmentController::class);
    Route::post('/investments/{investment}/approve', [InvestmentController::class, 'approve'])->name('investments.approve')->middleware('admin');
    Route::post('/investments/{investment}/reject', [InvestmentController::class, 'reject'])->name('investments.reject')->middleware('admin');
   Route::get('/investments/{investment}/invoice', [InvestmentController::class, 'generateInvoice'])->name('investments.invoice');

    // Investment image routes
    Route::get('/investments/{investment}/id-photo', [InvestmentImageController::class, 'showIdPhoto'])->name('investments.id_photo');
    Route::get('/investments/{investment}/transaction-proof', [InvestmentImageController::class, 'showTransactionProof'])->name('investments.transaction_proof');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [NotificationController::class, 'getUnread'])->name('notifications.unread');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Admin exchange rate routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/exchange-rates', [ExchangeRateController::class, 'index'])->name('exchange-rates.index');
        Route::post('/exchange-rates/update-rate', [ExchangeRateController::class, 'updateRate'])->name('exchange-rates.update-rate');
        Route::get('/exchange-rates/current', [ExchangeRateController::class, 'getCurrentRates'])->name('exchange-rates.current');
        Route::post('/exchange-rates/store-type', [ExchangeRateController::class, 'storeInvestmentType'])->name('exchange-rates.store-type');
        Route::put('/exchange-rates/update-type/{investmentType}', [ExchangeRateController::class, 'updateInvestmentType'])->name('exchange-rates.update-type');
        Route::delete('/exchange-rates/destroy-type/{investmentType}', [ExchangeRateController::class, 'destroyInvestmentType'])->name('exchange-rates.destroy-type');
    });
});

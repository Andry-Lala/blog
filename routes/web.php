<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\ThemeController;
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
    Route::post('/investments/{investment}/approve', [InvestmentController::class, 'approve'])->name('investments.approve');
    Route::post('/investments/{investment}/reject', [InvestmentController::class, 'reject'])->name('investments.reject');
});

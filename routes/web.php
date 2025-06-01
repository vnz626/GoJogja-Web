<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\TourPackageController; // <-- Tambahkan ini

// Rute Halaman Utama
Route::get('/', [HomeController::class, 'index']);

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Profil (dilindungi middleware 'auth')
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil', [ProfileController::class, 'update'])->name('profile.update');
});

// Rute Rental Kendaraan
Route::get('/rental-kendaraan', [RentalController::class, 'index'])->name('rental.index');

// Rute Paket Wisata <-- Tambahkan ini
Route::get('/paket-wisata', [TourPackageController::class, 'index'])->name('paket-wisata.index');

// Rute untuk halaman lainnya
Route::get('/blog-wisata', [BlogController::class, 'index'])->name('blog-wisata.index');

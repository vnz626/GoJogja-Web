<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TourPackageController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminRentalController;
use App\Http\Controllers\Admin\AdminWisataController;
use App\Http\Controllers\Admin\AdminDashboardController;

// =========================
// 🔷 ROUTE UTAMA (UMUM)
// =========================
Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================
// 🔒 ROUTE USER (AUTH USER BIASA)
// =========================
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profil/password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
    Route::post('/profil', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
});

// =========================
// 🚗 RENTAL & WISATA
// =========================
Route::get('/rental-kendaraan', [RentalController::class, 'index'])->name('rental.index');
Route::get('/rental-kendaraan/{idOrSlug}', [RentalController::class, 'show'])->name('rental.show');

Route::get('/paket-wisata', [TourPackageController::class, 'index'])->name('paket-wisata.index');
Route::get('/wisata/{destination}', [DestinationController::class, 'publicShow'])->name('wisata.show');

// =========================
// 📖 BLOG (UNTUK USER)
// =========================
Route::resource('blogs', BlogController::class);

// =========================
// 🛠️ ADMIN ROUTES
// =========================
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Blog khusus admin
    Route::get('/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs.index');

    // CRUD Wisata
    Route::resource('destinations', DestinationController::class)
        ->except(['show'])
        ->names([
        'index' => 'admin.wisata.index',
        'create' => 'admin.wisata.create',
        'store' => 'admin.wisata.store',
        'edit' => 'admin.wisata.edit',
        'update' => 'admin.wisata.update',
        'destroy' => 'admin.wisata.destroy',
    ]);

    // // CRUD Rental eror ketikka di upcommen si user tidak bisa lihat detail
    // Route::resource('rental', AdminRentalController::class)->names([
    //     'index' => 'admin.rental.index',
    //     'create' => 'admin.rental.create',
    //     'store' => 'admin.rental.store',
    //     'edit' => 'admin.rental.edit',
    //     'update' => 'admin.rental.update',
    //     'destroy' => 'admin.rental.destroy',
    //     'show' => 'admin.rental.show',
    // ]);

    Route::get('/admin/get-subcategories/{categoryId}', [AdminWisataController::class, 'getSubcategories']);

    // Route::resource('destinations', DestinationController::class)
    //     ->except(['show']);
});

require __DIR__.'/auth.php';

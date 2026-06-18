<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BandingkanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MobilController as AdminMobilController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\MerekController as AdminMerekController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ──────────────────────────────────────────────────────────
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
Route::get('/mobil/{slug}', [MobilController::class, 'show'])->name('mobil.show');
Route::get('/bandingkan', [BandingkanController::class, 'index'])->name('bandingkan');


// Static pages
Route::view('/tentang', 'pages.tentang')->name('tentang');
Route::view('/kontak', 'pages.kontak')->name('kontak');

// ─── Authenticated Routes (Global) ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Riwayat Booking
    Route::get('/riwayat-booking', [BookingController::class, 'history'])->name('booking.history');

    // Booking Test Drive
    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/sukses/{booking}', [BookingController::class, 'sukses'])->name('booking.sukses');
});

// ─── Admin Routes (protected) ────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Mobil CRUD
    Route::get('/mobil', [AdminMobilController::class, 'index'])->name('mobil.index');
    Route::get('/mobil/create', [AdminMobilController::class, 'create'])->name('mobil.create');
    Route::post('/mobil', [AdminMobilController::class, 'store'])->name('mobil.store');
    Route::get('/mobil/{mobil}/edit', [AdminMobilController::class, 'edit'])->name('mobil.edit');
    Route::put('/mobil/{mobil}', [AdminMobilController::class, 'update'])->name('mobil.update');
    Route::delete('/mobil/{mobil}', [AdminMobilController::class, 'destroy'])->name('mobil.destroy');
    Route::post('/mobil/{id}/restore', [AdminMobilController::class, 'restore'])->name('mobil.restore');
    Route::post('/mobil/{mobil}/duplicate', [AdminMobilController::class, 'duplicate'])->name('mobil.duplicate');
    Route::post('/mobil/{mobil}/toggle-featured', [AdminMobilController::class, 'toggleFeatured'])->name('mobil.toggle-featured');

    // Kategori CRUD
    Route::resource('kategori', AdminKategoriController::class)->except(['show']);

    // Merek CRUD
    Route::resource('merek', AdminMerekController::class)->except(['show']);

    // Banner CRUD
    Route::resource('banner', AdminBannerController::class)->except(['show']);

    // Booking management
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create', [AdminBookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [AdminBookingController::class, 'store'])->name('booking.store');
    Route::patch('/booking/{booking}', [AdminBookingController::class, 'update'])->name('booking.update');
    Route::get('/booking/export', [AdminBookingController::class, 'export'])->name('booking.export');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');


});

// Redirect /login and /dashboard (Breeze default) to admin
Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'))->middleware('auth')->name('dashboard');

require __DIR__.'/auth.php';

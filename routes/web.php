<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// For Publik Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Must Login
Route::middleware('auth')->group(function () {
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/{laptop}', [CatalogController::class, 'show'])->name('catalog.show');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Only admin 
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('brands', BrandController::class)->except('show');
});

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaptopConditionController;
use App\Http\Controllers\LaptopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;


// For Publik Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Must Login
Route::middleware('auth')->group(function () {
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/{laptop}', [CatalogController::class, 'show'])->name('catalog.show');

    // Booking & transaksi pembeli
    Route::get('/booking/{laptop}', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/booking/{laptop}', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::post('/transactions/{transaction}/proof', [TransactionController::class, 'uploadProof'])->name('transactions.proof.store');
    Route::get('/transactions/{transaction}/proof', [TransactionController::class, 'proof'])->name('transactions.proof.show');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Only admin 
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('brands', BrandController::class)->except('show');
    Route::resource('laptops', LaptopController::class)->except('show');
    Route::resource('conditions', LaptopConditionController::class)->except('show');

    // Dashboard transaksi admin
    Route::prefix('admin/transactions')->name('admin.transactions.')->group(function () {
        Route::get('/', [AdminTransactionController::class, 'index'])->name('index');
        Route::get('/{transaction}', [AdminTransactionController::class, 'show'])->name('show');
        Route::post('/{transaction}/verify', [AdminTransactionController::class, 'verify'])->name('verify');
        Route::post('/{transaction}/complete', [AdminTransactionController::class, 'complete'])->name('complete');
        Route::post('/{transaction}/cancel', [AdminTransactionController::class, 'cancel'])->name('cancel');
    });
});

require __DIR__ . '/auth.php';

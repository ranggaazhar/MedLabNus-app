<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PabrikanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\SpesifikasiController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
   
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ========== PABRIKAN ROUTES ==========
    Route::get('/pabrikan', [PabrikanController::class, 'index'])->name('pabrikan.index');
    Route::get('/pabrikan/create', [PabrikanController::class, 'create'])->name('pabrikan.create');
    Route::post('/pabrikan', [PabrikanController::class, 'store'])->name('pabrikan.store');
    Route::get('/pabrikan/{pabrikan}', [PabrikanController::class, 'show'])->name('pabrikan.show');
    Route::get('/pabrikan/{pabrikan}/edit', [PabrikanController::class, 'edit'])->name('pabrikan.edit');
    Route::put('/pabrikan/{pabrikan}', [PabrikanController::class, 'update'])->name('pabrikan.update');
    Route::patch('/pabrikan/{pabrikan}', [PabrikanController::class, 'update'])->name('pabrikan.update.patch');
    Route::delete('/pabrikan/{pabrikan}', [PabrikanController::class, 'destroy'])->name('pabrikan.destroy');

    // ========== PRODUK ROUTES ==========
    // Map produk index to dashboard controller so dashboard displays product list
    Route::get('/produk', [DashboardController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');
    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::patch('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update.patch');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // ========== SPESIFIKASI ROUTES ==========
    Route::get('/spesifikasi', [SpesifikasiController::class, 'index'])->name('spesifikasi.index');
    Route::get('/spesifikasi/create', [SpesifikasiController::class, 'create'])->name('spesifikasi.create');
    Route::post('/spesifikasi', [SpesifikasiController::class, 'store'])->name('spesifikasi.store');
    Route::get('/spesifikasi/{spesifikasi}', [SpesifikasiController::class, 'show'])->name('spesifikasi.show');
    Route::get('/spesifikasi/{spesifikasi}/edit', [SpesifikasiController::class, 'edit'])->name('spesifikasi.edit');
    Route::put('/spesifikasi/{spesifikasi}', [SpesifikasiController::class, 'update'])->name('spesifikasi.update');
    Route::patch('/spesifikasi/{spesifikasi}', [SpesifikasiController::class, 'update'])->name('spesifikasi.update.patch');
    Route::delete('/spesifikasi/{spesifikasi}', [SpesifikasiController::class, 'destroy'])->name('spesifikasi.destroy');
});

require __DIR__.'/auth.php';

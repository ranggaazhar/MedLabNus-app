<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PabrikanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPenawaranController;
use App\Http\Controllers\Admin\StokMutasiController;
use App\Http\Controllers\SpesifikasiController;
use App\Http\Controllers\User\PenawaranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminInvoiceController;



Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/products', [ProdukController::class, 'publicIndex'])->name('products.public');
Route::get('/products/{produk_id}', [ProdukController::class, 'publicShow'])->name('products.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth:admin', 'verified'])
    ->name('dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


Route::post('/penawaran/store', [PenawaranController::class, 'store'])->name('penawaran.store');

// Tempat pelanggan melihat daftar produk yang mereka pilih sebelum di-submit
Route::get('/keranjang', [PenawaranController::class, 'keranjang'])->name('penawaran.keranjang');


Route::middleware('auth:admin')->group(function () {


    Route::get('/produk/export', [ProdukController::class, 'export'])->name('produk.export');
    Route::post('/produk/check-nama', [ProdukController::class, 'checkNamaProduk'])->name('produk.checkNama');
    Route::post('/pabrikan/check-nama', [PabrikanController::class, 'checkNamaPabrikan'])->name('pabrikan.checkNama');

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

    Route::get('/logs', [LogController::class, 'index'])->name('log.index');
    Route::get('/logs/{id}', [LogController::class, 'show'])->name('log.show');
    Route::get('/stok-mutasi', [StokMutasiController::class, 'index'])->name('stok-mutasi.index');

    Route::get('/penawaran', [AdminPenawaranController::class, 'index'])->name('admin.penawaran.index');
    Route::get('/penawaran/{id}', [AdminPenawaranController::class, 'show'])->name('admin.penawaran.show');
    Route::patch('/penawaran/{id}/status', [AdminPenawaranController::class, 'updateStatus'])->name('admin.penawaran.updateStatus');
    Route::delete('/penawaran/{id}', [AdminPenawaranController::class, 'destroy'])->name('admin.penawaran.destroy');


    // 1. Read (Daftar Utama & Detail)
    Route::get('invoices', [AdminInvoiceController::class, 'index'])->name('admin.invoice.index');

    Route::get('invoices/create', [AdminInvoiceController::class, 'create'])->name('admin.invoice.create');
    Route::get('invoices/{id}', [AdminInvoiceController::class, 'show'])->name('admin.invoice.show');

    // 2. Create (Form & Proses Simpan)

    Route::post('invoices', [AdminInvoiceController::class, 'store'])->name('admin.invoice.store');

    // 3. Update Status Pembayaran (Lunas / Batal)
    Route::patch('invoices/{id}/update-status', [AdminInvoiceController::class, 'updateStatus'])->name('admin.invoice.update-status');

    // 4. Delete (Hapus Permanen / Audit Trail)
    Route::delete('invoices/{id}', [AdminInvoiceController::class, 'destroy'])->name('admin.invoice.destroy');

    // 5. Fitur Cetak / Unduh Dokumen PDF
    Route::get('invoices/{id}/download-pdf', [AdminInvoiceController::class, 'generatePdf'])->name('admin.invoice.download-pdf');
    // Letakkan route ini di dalam group middleware admin kamu, di atas route {id}
    Route::patch('invoices/{id}/cancel', [AdminInvoiceController::class, 'cancel'])->name('admin.invoice.cancel');
});

require __DIR__ . '/auth.php';

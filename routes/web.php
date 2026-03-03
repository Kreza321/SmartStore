<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Models\Produk;
use App\Models\Order;
use App\Exports\ProdukExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes - Amin Jaya Smart Store
|--------------------------------------------------------------------------
*/

// --- HALAMAN USER ---
// Menampilkan Katalog Produk dan Tracking Pesanan
Route::get('/', function () {
    return view('user.index', [
        'produks' => Produk::all(),
        'orders'  => Order::with('produk')->latest()->get()
    ]);
});

// --- HALAMAN ADMIN ---
// Dashboard Admin: Analitik, Grafik, dan Kelola Pesanan
Route::get('/admin', function () {
    return view('admin.index', [
        'produks'    => Produk::all(),
        'orders'     => Order::with('produk')->latest()->get(),
        'users' => \App\Models\User::all(),
        'brands'     => Produk::pluck('brand'),
        'stokCounts' => Produk::pluck('stok')
    ]);
});

// --- AKSI & FITUR ADMIN ---
// Download Laporan Stok Excel
Route::get('/download-stok', function () {
    return Excel::download(new ProdukExport, 'laporan-stok-aminjaya.xlsx');
});

// CRUD Produk (Store, Update, Destroy)
Route::resource('admin/produk', ProdukController::class);

// Update Status & Tanggal Pengiriman oleh Admin
Route::put('/admin/order/{id}', [ProdukController::class, 'updateOrder']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
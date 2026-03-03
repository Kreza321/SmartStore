<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Models\Produk; // Perbaikan di sini: Hapus folder API

// Route Checkout
Route::post('/checkout/{id}', [ProdukController::class, 'checkout']);


// Route lainnya
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/baju', function () {
    $data = Produk::all();
    return response()->json([
        'status' => 'success',
        'data' => $data
    ]);
});
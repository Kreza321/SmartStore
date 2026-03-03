<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        // Mengambil semua data baju
        $produks = Produk::all();
        
        // Mengembalikan data dalam format JSON agar bisa dibaca Python/Web
        return response()->json([
            'status' => 'success',
            'data' => $produks
        ]);
    }
}

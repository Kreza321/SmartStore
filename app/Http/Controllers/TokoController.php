<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class TokoController extends Controller
{
    public function index()
    {
        // Data untuk Katalog User
        $produks = Produk::all();

        // Data untuk Grafik Admin (Menghitung stok per Brand)
        $brands = Produk::pluck('brand')->toArray();
        $stokCounts = Produk::pluck('stok')->toArray();

        return view('welcome', compact('produks', 'brands', 'stokCounts'));
    }
}

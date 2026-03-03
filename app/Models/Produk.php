<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Produk;

class Produk extends Model
{
    protected $fillable = ['nama_baju', 'brand', 'kategori', 'ukuran', 'stok', 'harga', 'image'];
}

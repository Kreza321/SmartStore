<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // Daftarkan kolom agar bisa diisi saat checkout
    protected $fillable = [
        'produk_id', 
        'nama_pembeli', 
        'alamat', 
        'kurir', 
        'pembayaran', 
        'status', 
        'tanggal_pengiriman'
    ];

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_baju' => 'Uniqlo U Crew Neck',
                'brand'     => 'Uniqlo',
                'kategori'  => 'Atasan',
                'ukuran'    => 'L',
                'stok'      => 45,
                'harga'     => 149000,
                'image'     => 'https://images.unsplash.com/photo-1769000066691-6a5015513bcb?q=80&w=764&auto=format&fit=crop'
            ],
            [
                'nama_baju' => 'H&M Slim Fit Shirt',
                'brand'     => 'H&M',
                'kategori'  => 'Kemeja',
                'ukuran'    => 'M',
                'stok'      => 12,
                'harga'     => 299000,
                'image'     => 'https://plus.unsplash.com/premium_photo-1683140435505-afb6f1738d11?w=600&auto=format&fit=crop'
            ],
            [
                'nama_baju' => 'Levi\'s 501 Original',
                'brand'     => 'Levi\'s',
                'kategori'  => 'Bawahan',
                'ukuran'    => '32',
                'stok'      => 8,
                'harga'     => 899000,
                'image'     => 'https://plus.unsplash.com/premium_photo-1668127212806-0b69765d50b6?w=600&auto=format&fit=crop'
            ],
            [
                'nama_baju' => 'Zara Oversized Hoodie',
                'brand'     => 'Zara',
                'kategori'  => 'Outerwear',
                'ukuran'    => 'XL',
                'stok'      => 20,
                'harga'     => 549000,
                'image'     => 'https://plus.unsplash.com/premium_photo-1690341214258-18cb88438805?w=600&auto=format&fit=crop'
            ],
            [
                'nama_baju' => 'Erigo Coach Jacket',
                'brand'     => 'Erigo',
                'kategori'  => 'Outerwear',
                'ukuran'    => 'L',
                'stok'      => 35,
                'harga'     => 250000,
                'image'     => 'https://images.unsplash.com/photo-1602562887763-851fa56061e3?w=600&auto=format&fit=crop'
            ],
            [
                'nama_baju' => 'Cardinal Chino Pants',
                'brand'     => 'Cardinal',
                'kategori'  => 'Bawahan',
                'ukuran'    => '34',
                'stok'      => 15,
                'harga'     => 350000,
                'image'     => 'https://plus.unsplash.com/premium_photo-1669824377759-a5c2760ffec5?w=600&auto=format&fit=crop'
            ],
        ];

        foreach ($data as $item) {
            Produk::create($item);
        }
    }
}
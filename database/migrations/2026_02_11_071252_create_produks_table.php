<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_baju');
            $table->string('brand'); // Contoh: Kaos Oversize
            $table->string('kategori');  // Contoh: Atasan, Bawahan, Jaket
            $table->string('ukuran');    // S, M, L, XL
            $table->integer('stok');     // Jumlah stok
            $table->decimal('harga', 10, 2);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Order;

class ProdukController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'nama_baju' => 'required',
            'brand' => 'required',
            'kategori'  => 'required',
            'ukuran'    => 'required',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'image' => 'nullable|url'
        ]);

        Produk::create($request->all());
        return redirect()->back()->with('success', 'Barang baru berhasil ditambahin, Bos!');
    }

    public function destroy($id) {
        Produk::destroy($id);
        return redirect()->back()->with('success', 'Barang udah dihapus!');
    }

    public function checkout(Request $request, $id) {
        try {
            $produk = Produk::find($id);
            if ($produk && $produk->stok > 0) {
                $produk->stok -= 1;
                $produk->save();

                // Simpan data ke riwayat pesanan
                Order::create([
                    'produk_id' => $id,
                    'alamat' => $request->alamat,
                    'kurir' => $request->kurir,
                    'pembayaran' => $request->bayar,
                    'status' => 'Diproses'
                ]);

                return response()->json(['status' => 'success', 'produk' => $produk->nama_baju]);
            }
            return response()->json(['status' => 'error', 'message' => 'Stok abis!'], 400);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // Tambahkan fungsi untuk Admin update tanggal & status
    public function updateOrder(Request $request, $id) {
        $order = Order::find($id);
        $order->update([
            'status' => $request->status,
            'tanggal_pengiriman' => $request->tanggal_pengiriman
        ]);
        return redirect()->back()->with('success', 'Data pengiriman diupdate!');
    }
}
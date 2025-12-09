<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Detail_Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    // ini nanti akan dipanggil dari form "Lanjut Pembayaran"
    public function store(Request $request)
    {
        // sementara: kita anggap form kirim field ini
        $data = $request->validate([
            'nama'         => 'required|string|max:255',
            'nomor_ponsel' => 'nullable|string|max:50',
            'email'        => 'nullable|email',
            'nomor_meja'   => 'required|string|max:50',
            'cart'         => 'required|string', // JSON keranjang
        ]);

        // decode cart
        $cart = json_decode($data['cart'], true);

        if (!$cart || !is_array($cart) || count($cart) === 0) {
            return back()->with('error', 'Keranjang kosong.');
        }

        // 1. simpan pelanggan
        $pelanggan = Pelanggan::create([
            'nama'         => $data['nama'],
            'nomor_ponsel' => $data['nomor_ponsel'] ?? null,
            'email'        => $data['email'] ?? null,
            'nomor_meja'   => $data['nomor_meja'],
        ]);

        // 2. hitung total harga dari cart
        $total = 0;
        foreach ($cart as $item) {
            $jumlah = $item['quantity'] ?? 0;
            $harga  = $item['price'] ?? 0;
            $total += $jumlah * $harga;
        }

        // 3. simpan pesanan
        $pesanan = Pesanan::create([
            'pelanggan_id' => $pelanggan->id,
            'total_harga'  => $total,
            'status'       => 'pending', // nanti bisa diupdate jadi 'dibayar'
        ]);

        // 4. simpan detail pesanan
        foreach ($cart as $item) {
            $jumlah = $item['quantity'] ?? 0;
            $harga  = $item['price'] ?? 0;

            if ($jumlah <= 0) {
                continue;
            }

            Detail_Pesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id'    => $item['id'],      // id menu dari DB
                'jumlah'     => $jumlah,
                'subtotal'   => $jumlah * $harga,
            ]);
        }

        // 5. setelah semua tersimpan, arahkan ke halaman Pembayaran
        return redirect()->route('Pembayaran', ['pesanan' => $pesanan->id]);
    }

    public function show(Pesanan $pesanan)
    {
        // muat relasi pelanggan + detail + menu,
        // biar nanti di view bisa akses $pesanan->pelanggan, $pesanan->details
        $pesanan->load(['pelanggan', 'details.menu']);

        return view('Pembayaran', [
            'pesanan' => $pesanan,
        ]);
    }


}

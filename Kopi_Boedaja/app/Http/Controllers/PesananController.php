<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Detail_Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PesananController extends Controller
{
    // dipanggil dari form "Lanjut Pembayaran"
    public function store(Request $request)
    {
        // sekarang cuma butuh cart
        $data = $request->validate([
            'cart' => 'required|string', // JSON keranjang
        ]);

        // decode cart
        $cart = json_decode($data['cart'], true);

        if (!$cart || !is_array($cart) || count($cart) === 0) {
            return back()->with('error', 'Keranjang kosong.');
        }

        // 1. untuk saat ini: guest checkout, tidak ada pelanggan
        $pelangganId = Auth::check() ? Auth::id() : null;

        // 2. hitung total harga dari cart
        $total = 0;
        foreach ($cart as $item) {
            $jumlah = $item['quantity'] ?? 0;
            $harga  = $item['price'] ?? 0;
            $total += $jumlah * $harga;
        }

        // 3. simpan pesanan
        $pesanan = Pesanan::create([
            'pelanggan_id' => $pelangganId, // boleh null (sudah di-migration)
            'total_harga'  => $total,
            'status'       => 'pending',
            'catatan' => $request->input('catatan', null),
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

        // 5. redirect ke halaman Pembayaran (kode pesanan)
        return redirect()->route('Pembayaran', ['pesanan' => $pesanan->id]);
    }

    public function show(Pesanan $pesanan)
    {
        // pelanggan boleh null, tapi detail & menu tetap diload
        $pesanan->load(['pelanggan', 'details.menu']);

        return view('Pembayaran', [
            'pesanan' => $pesanan,
        ]);
    }

    public function riwayat()
    {
        // user pasti login karena route pakai middleware auth
        $user = Auth::user();

        // ambil pesanan yang DIMILIKI user ini
        $pesanans = Pesanan::where('pelanggan_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat', compact('pesanans'));
    }

}

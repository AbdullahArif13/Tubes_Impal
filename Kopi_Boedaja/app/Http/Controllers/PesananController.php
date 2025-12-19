<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Detail_Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Promosi;


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

        // 3. PROMO KHUSUS USER LOGIN
        $diskon = 0;

        if (Auth::check()) {
            $promo = Promosi::where('aktif', true)
                ->whereDate('tanggal_berlaku', '<=', now())
                ->whereDate('tanggal_berakhir', '>=', now())
                ->first();

            if ($promo) {
                if ($promo->tipe === 'percent') {
                    $diskon = ($promo->nilai / 100) * $total;

                    if ($promo->maks_potongan && $diskon > $promo->maks_potongan) {
                        $diskon = $promo->maks_potongan;
                    }
                } elseif ($promo->tipe === 'fixed') {
                    $diskon = $promo->nilai;
                }

                if ($diskon > $total) {
                    $diskon = $total;
                }
            }
        }

        $totalSetelahDiskon = $total - $diskon;

        // 4. simpan pesanan
        $pesanan = Pesanan::create([
            'pelanggan_id' => null,
            'total_harga'  => $totalSetelahDiskon,
            'status'       => 'pending',
            'catatan'      => Auth::check() ? 'Promo digunakan' : null,
        ]);


        // 5. redirect ke halaman Pembayaran (kode pesanan)
        return redirect()->route('Pembayaran', ['pesanan' => $pesanan->id]);
    }

     public function show(Pesanan $pesanan)
    {
        // load relasi detail + menu (pelanggan boleh null)
        $pesanan->load(['details.menu', 'pelanggan']);

        // subtotal asli (sebelum diskon)
        $subtotal = $pesanan->details->sum('subtotal');

        // diskon = selisih subtotal dengan total_harga
        $diskon = max(0, $subtotal - $pesanan->total_harga);

        return view('Pembayaran', [
            'pesanan'  => $pesanan,
            'subtotal' => $subtotal,
            'diskon'   => $diskon,
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

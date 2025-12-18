<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PromoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Public: menu & checkout (guest boleh pesan).
| Auth: register/login/logout (tidak wajib sebelum pesan).
| Pembayaran detail ditampilkan setelah pesanan disimpan.
|
*/

/*
|---------------------
| Public / Guest routes
|---------------------
*/

// Halaman Menu (homepage)
Route::get('/', [MenuController::class, 'index'])->name('menu');

// Rincian Pesanan (lihat keranjang sebelum bayar)
Route::get('/RincianPesanan', function () {
    return view('RincianPesanan');
})->name('RincianPesanan');

// Rincian Pembayaran (halaman checkout) - GET
Route::get('/RincianPembayaran', function () {
    return view('RincianPembayaran');
})->name('RincianPembayaran');

// Rincian Pembayaran - POST -> simpan pesanan (guest atau user)
Route::post('/RincianPembayaran', [PesananController::class, 'store'])
    ->name('pesanan.store');

// Halaman Pembayaran final / detail pesanan
// (Pertimbangkan menambahkan middleware/cek akses jika perlu)
Route::get('/Pembayaran/{pesanan}', [PesananController::class, 'show'])
    ->name('Pembayaran');


/*
|---------------------
| Auth routes
|---------------------
*/

// Register (form + action)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login (form + action)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|---------------------
| Feature routes
|---------------------
*/

Route::middleware('auth:web')->group(function () {
    Route::get('/promo', [PromoController::class, 'index'])
        ->name('promo.index');

    Route::get('/riwayat-pesanan', [PesananController::class, 'riwayat'])
        ->name('pesanan.riwayat');
});

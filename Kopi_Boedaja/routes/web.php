<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;


// 1. Halaman Menu
Route::get('/', [MenuController::class, 'index'])->name('menu');

// 2. Halaman Rincian Pesanan
Route::get('/RincianPesanan', function () {
    return view('RincianPesanan'); // rincian-pesanan.blade.php
})->name('RincianPesanan');

// 3. Halaman Rincian Pembayaran
Route::get('/RincianPembayaran', function () {
    return view('RincianPembayaran'); // RincianPembayaran.blade.php
})->name('RincianPembayaran');

// 3b. Proses submit Rincian Pembayaran -> SIMPAN ke DB
Route::post('/RincianPembayaran', [PesananController::class, 'store'])
    ->name('pesanan.store');
    
// 4. Halaman Pembayaran Final (GET)
Route::get('/Pembayaran/{pesanan}', [PesananController::class, 'show'])
    ->name('Pembayaran');

// 5. Proses submit pembayaran (POST)
//Route::post('/Pembayaran', function () {
//    return view('Pembayaran');
//})->name('Pembayaran.submit');

// =========================
// ROUTE SIDEBAR MENU
// =========================

// Halaman Login
Route::get('/login', function () {
    return view('auth.login'); // buat file ini
})->name('login');

// Halaman Register
Route::get('/register', function () {
    return view('auth.register'); // buat file ini
})->name('register');

// Halaman Promo
Route::get('/promo', function () {
    return view('promo.index'); // buat file ini
})->name('promo.index');

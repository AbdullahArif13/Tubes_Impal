<?php

use Illuminate\Support\Facades\Route;

// 1. Halaman Menu
Route::get('/', function () {
    return view('menu'); // menu.blade.php
})->name('menu');

// 2. Halaman Rincian Pesanan
Route::get('/RincianPesanan', function () {
    return view('RincianPesanan'); // rincian-pesanan.blade.php
})->name('RincianPesanan');

// 3. Halaman Rincian Pembayaran
Route::get('/RincianPembayaran', function () {
    return view('RincianPembayaran'); // RincianPembayaran.blade.php
})->name('RincianPembayaran');

// 4. Halaman Pembayaran Final (GET)
Route::get('/Pembayaran', function () {
    return view('Pembayaran');
})->name('Pembayaran');

// 5. Proses submit pembayaran (POST)
Route::post('/Pembayaran', function () {
    return view('Pembayaran');
})->name('Pembayaran.submit');


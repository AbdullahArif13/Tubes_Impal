<?php

use Illuminate\Support\Facades\Route;

// ... (mungkin ada route lain seperti route '/_')

// Ini adalah route untuk halaman login Anda
Route::get('/login', function () {
    // 'login' di sini mengacu ke file:
    // resources/views/login.blade.php
    return view('login'); 
});

// (Nanti kita akan tambahkan route register di sini)

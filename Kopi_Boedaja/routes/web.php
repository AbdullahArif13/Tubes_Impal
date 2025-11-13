<?php

use Illuminate\Support\Facades\Route;

// Halaman utama → redirect ke menu
Route::get('/', fn() => redirect()->route('menu'));

// Halaman Menu
Route::get('/menu', fn() => view('pages.menu'))->name('menu');

// Halaman Cart
Route::get('/cart', fn() => view('pages.cart'))->name('cart');

// Halaman Profil
Route::get('/profile', fn() => view('pages.profile'))->name('profile');

// Halaman Payment
Route::get('/payment', fn() => view('pages.payment'))->name('payment');

// Halaman Order Confirmation
Route::get('/order-confirmation', fn() => view('pages.order-confirmation'))->name('order.confirmation');

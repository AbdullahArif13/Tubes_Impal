@extends('layout.app')

@section('content')
@php
  $cart = session('cart', [
    ['id'=>1, 'name'=>'Kopi Hitam', 'price'=>12000, 'quantity'=>1],
    ['id'=>2, 'name'=>'Croissant', 'price'=>10000, 'quantity'=>2],
  ]);

  $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
  $deliveryFee = 1000;
  $tax = 2300;
  $total = $subtotal + $deliveryFee + $tax;
@endphp

@if(count($cart) == 0)
  <div class="pb-32 bg-gray-50 min-h-screen">
    <div class="bg-white border-b border-gray-200 p-4">
      <h2 class="text-xl font-bold text-center">Pesanan</h2>
    </div>
    <div class="flex items-center justify-center h-64">
      <p class="text-gray-500 text-lg">Keranjang belanja kosong</p>
    </div>
  </div>
@else
  <div class="pb-32 bg-gray-50 min-h-screen">
    {{-- Header --}}
    <div class="bg-white border-b border-gray-200 p-4">
      <h2 class="text-xl font-bold text-center">Pesanan</h2>
    </div>

    {{-- Delivery Type --}}
    <div class="p-4">
      <div class="bg-gray-100 rounded-lg p-3 flex items-center justify-between">
        <span class="font-medium">Tipe Pemesanan</span>
        <div class="flex items-center gap-2">
          <span>Makan di tempat</span>
          <span class="text-green-600">✓</span>
        </div>
      </div>
    </div>

    {{-- Cart Items --}}
    <div class="px-4">
      <h2 class="font-bold text-lg mb-3">Item yang dipesan ({{ count($cart) }})</h2>
      <div class="space-y-3">
        @foreach ($cart as $item)
          <div class="bg-white rounded-lg p-4 border border-gray-200">
            <div class="flex justify-between items-start mb-3">
              <h3 class="font-bold text-gray-800">{{ $item['name'] }}</h3>
              <button class="text-gray-400 hover:text-red-500 text-lg">✏️ Ubah</button>
            </div>
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                <button class="w-6 h-6 flex items-center justify-center text-gray-600 hover:text-gray-800">−</button>
                <span class="w-6 text-center">{{ $item['quantity'] }}</span>
                <button class="w-6 h-6 flex items-center justify-center text-gray-600 hover:text-gray-800">+</button>
              </div>
              <span class="font-bold text-green-700">
                Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
              </span>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Order Summary --}}
    <div class="mx-4 mt-6 bg-white rounded-lg p-4 border border-gray-200">
      <h3 class="font-bold text-lg mb-4">Rincian Pembayaran</h3>
      <div class="space-y-3 mb-4 border-b border-gray-200 pb-4">
        <div class="flex justify-between text-gray-600">
          <span>Subtotal</span>
          <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-gray-600">
          <span>Biaya Tambahan</span>
          <span>Rp{{ number_format($deliveryFee, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-gray-600">
          <span>Biaya lainnya</span>
          <span>Rp{{ number_format($tax, 0, ',', '.') }}</span>
        </div>
      </div>
      <div class="flex justify-between font-bold text-lg">
        <span>Total</span>
        <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
      </div>
    </div>

    {{-- Checkout Button --}}
    <div class="px-4 mt-6 pb-4">
      <button class="w-full bg-teal-700 text-white py-3 rounded-lg font-bold hover:bg-teal-800 transition-colors">
        Lanjut Pembayaran
      </button>
    </div>
  </div>
@endif
@endsection

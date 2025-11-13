@extends('layouts.app')

@section('content')
<div class="pb-32 bg-gray-50 min-h-screen">
  <!-- Header -->
  <div class="bg-white border-b border-gray-200 p-4">
    <h1 class="text-xl font-bold text-center">Ringkasan Pesanan</h1>
  </div>

  <!-- Delivery Type -->
  <div class="p-4">
    <div class="bg-gray-100 rounded-lg p-3 flex items-center justify-between">
      <span class="font-medium">Tipe Pemesanan</span>
      <div class="flex items-center gap-2">
        <span>Makan di tempat</span>
        <span class="text-green-600">✓</span>
      </div>
    </div>
  </div>

  <!-- Order Number -->
  <div class="mx-4 mt-4 bg-white rounded-lg p-4 border border-gray-200 text-center">
    <p class="text-sm text-gray-600 mb-2">Nomor Pesanan</p>
    <p class="text-3xl font-bold text-gray-800 font-mono">CZK7RTWZ</p>
    <p class="text-xs text-gray-500 mt-2">Tunjukkan nomor ini ke kasir kami</p>
  </div>

  <!-- Order Items -->
  <div class="mx-4 mt-4">
    <h2 class="font-bold text-lg mb-3">Item yang dipesan (2)</h2>
    <div class="space-y-2">
      <div class="bg-white rounded-lg p-3 flex justify-between items-center border border-gray-200">
        <div>
          <h3 class="font-bold text-gray-800">Cappuccino</h3>
          <p class="text-sm text-gray-600">x1</p>
        </div>
        <span class="font-bold text-green-700">Rp15.000</span>
      </div>
      <div class="bg-white rounded-lg p-3 flex justify-between items-center border border-gray-200">
        <div>
          <h3 class="font-bold text-gray-800">Roti Coklat</h3>
          <p class="text-sm text-gray-600">x1</p>
        </div>
        <span class="font-bold text-green-700">Rp3.000</span>
      </div>
    </div>
  </div>

  <!-- Order Summary -->
  <div class="mx-4 mt-4 bg-white rounded-lg p-4 border border-gray-200">
    <h3 class="font-bold text-lg mb-4">Rincian Pembayaran</h3>
    <div class="space-y-3 mb-4 border-b border-gray-200 pb-4">
      <div class="flex justify-between text-gray-600"><span>Subtotal</span><span>Rp15.000</span></div>
      <div class="flex justify-between text-gray-600"><span>Biaya Tambahan</span><span>Rp1.000</span></div>
      <div class="flex justify-between text-gray-600"><span>Biaya lainnya</span><span>Rp2.300</span></div>
    </div>
    <div class="flex justify-between font-bold text-lg"><span>Total</span><span>Rp18.300</span></div>
  </div>

  <!-- Customer Info -->
  <div class="mx-4 mt-4 bg-white rounded-lg p-4 border border-gray-200 mb-4">
    <h3 class="font-bold text-lg mb-3">Informasi Pemesan</h3>
    <div class="space-y-2 text-sm">
      <div><p class="text-gray-600">Nama</p><p class="font-bold text-gray-800">Hanif Haidar</p></div>
      <div><p class="text-gray-600">Nomor Ponsel</p><p class="font-bold text-gray-800">0812-3456-7890</p></div>
      <div><p class="text-gray-600">Email</p><p class="font-bold text-gray-800">adakahseratus@gmail.com</p></div>
      <div><p class="text-gray-600">Nomor Meja</p><p class="font-bold text-gray-800">Lantai 1 - 28</p></div>
    </div>
  </div>

  <!-- New Order -->
  <div class="px-4">
    <a href="{{ route('menu') }}"
       class="block text-center bg-teal-700 text-white py-3 rounded-lg font-bold hover:bg-teal-800 transition-colors">
      Pesan Baru
    </a>
  </div>
</div>
@endsection

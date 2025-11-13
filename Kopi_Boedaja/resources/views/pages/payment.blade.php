@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen pb-40"> <!-- Tambah padding bawah agar tidak ketimpa nav -->
  
  <!-- Header -->
  <header class="bg-white border-b border-gray-200 p-4">
    <h1 class="text-xl font-bold text-center">Pembayaran</h1>
  </header>

  <!-- Delivery Type -->
  <section class="p-4">
    <div class="bg-gray-100 rounded-lg p-3 flex items-center justify-between">
      <span class="font-medium">Tipe Pemesanan</span>
      <div class="flex items-center gap-2">
        <span>Makan di tempat</span>
        <span class="text-green-600 font-bold">✓</span>
      </div>
    </div>
  </section>

  <!-- Form -->
  <form action="{{ route('order.confirmation') }}" method="GET" class="px-4 space-y-4 mt-4 mb-24">
    <!-- Informasi Pemesan -->
    <div class="bg-white rounded-lg p-4 shadow-sm">
      <h3 class="font-bold text-lg mb-4">Informasi Pemesan</h3>

      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Nama Lengkap<span class="text-red-500">*</span>
          </label>
          <input type="text" name="name" value="Hanif Haidar" required
                 class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-700 focus:outline-none">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Nomor Ponsel<span class="text-red-500">*</span>
          </label>
          <input type="tel" name="phone" value="0812-3456-7890" required
                 class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-700 focus:outline-none">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Kirim struk ke email<span class="text-red-500">*</span>
          </label>
          <input type="email" name="email" value="adakahseratus@gmail.com" required
                 class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-700 focus:outline-none">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">
            Nomor Meja<span class="text-red-500">*</span>
          </label>
          <input type="text" name="tableNumber" value="Lantai 1 - 28" required
                 class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-700 focus:outline-none">
        </div>
      </div>
    </div>

    <!-- Rincian Pesanan -->
    <div class="bg-white rounded-lg p-4 shadow-sm">
      <h3 class="font-bold text-lg mb-4">Rincian Pesanan</h3>
      <div class="space-y-2 text-sm text-gray-600 mb-4 border-b border-gray-200 pb-4">
        <div class="flex justify-between"><span>Subtotal</span><span>Rp15.000</span></div>
        <div class="flex justify-between"><span>Biaya Tambahan</span><span>Rp1.000</span></div>
        <div class="flex justify-between"><span>Biaya lainnya</span><span>Rp2.300</span></div>
      </div>
      <div class="flex justify-between font-bold text-lg">
        <span>Total</span><span>Rp18.300</span>
      </div>
    </div>

    <!-- Tombol -->
    <div class="fixed bottom-16 left-0 right-0 bg-white border-t border-gray-200 p-4">
      <div class="flex justify-between items-center mb-4">
        <div>
          <p class="text-sm text-gray-600">Total Pembayaran</p>
          <p class="text-2xl font-bold text-gray-800">Rp18.300</p>
        </div>
      </div>
      <button type="submit"
              class="w-full bg-teal-700 text-white py-3 rounded-lg font-bold hover:bg-teal-800 transition-colors">
        Lanjut Pembayaran
      </button>
    </div>
  </form>
</div>
@endsection

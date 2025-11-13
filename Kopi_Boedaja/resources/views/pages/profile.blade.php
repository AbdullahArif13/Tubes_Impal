@extends('layouts.app')

@section('content')
<div class="pb-32 bg-gray-50 min-h-screen">
  <!-- Header -->
  <div class="bg-white border-b border-gray-200 p-4">
    <h1 class="text-2xl font-bold">Profil</h1>
  </div>

  <!-- Profile Section -->
  <div class="bg-white p-4 border-b border-gray-200">
    <div class="flex items-center gap-4 mb-4">
      <div class="w-16 h-16 bg-gray-300 rounded-full"></div>
      <div class="flex-1">
        <h2 class="font-bold text-lg">Masuk sebagai tamu</h2>
        <p class="text-sm text-gray-600">Login untuk melihat riwayat pesanan</p>
      </div>
    </div>
  </div>

  <!-- Menu Options -->
  <div class="p-4 space-y-2">
    <a href="#" class="block bg-white border-2 border-gray-300 rounded-lg p-4 hover:bg-gray-50 transition-colors flex items-center gap-3">
      <span class="text-2xl">🛒</span>
      <span class="font-bold">Pesanan saya</span>
    </a>
    <a href="#" class="block bg-white border-2 border-gray-300 rounded-lg p-4 hover:bg-gray-50 transition-colors flex items-center gap-3">
      <span class="text-2xl">❤️</span>
      <span class="font-bold">Favorit saya</span>
    </a>
    <a href="#" class="block bg-white border-2 border-gray-300 rounded-lg p-4 hover:bg-gray-50 transition-colors flex items-center gap-3">
      <span class="text-2xl">⚙️</span>
      <span class="font-bold">Pengaturan</span>
    </a>
  </div>

  <!-- Order History -->
  <div class="p-4">
    <h3 class="font-bold text-lg mb-3">Riwayat Pesanan</h3>
    <div class="space-y-2">
      <!-- Contoh order -->
      <div class="bg-white rounded-lg p-4 border border-gray-200">
        <p class="text-sm text-gray-600">Order #CZK7RTWZ</p>
        <p class="font-bold text-gray-800">Total: Rp18.300</p>
      </div>
    </div>
  </div>
</div>
@endsection

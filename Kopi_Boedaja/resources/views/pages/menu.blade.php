@extends('layouts.app')

@section('content')
<div class="pb-32">
  {{-- Header --}}
  <div class="bg-green-700 text-white p-4">
    <h1 class="text-2xl font-bold">KOPI BOEDAJA</h1>
    <p class="text-sm opacity-90">Nomor Meja: Lantai 1 - 28</p>
  </div>

  {{-- Category Tabs --}}
  @php
    $categories = ['Hot Series', 'Cold Series', 'Small Bite'];
    $selected = request()->get('category', 'Hot Series');
    $menuItems = [
      ['id' => 1, 'name' => 'Kopi Hitam', 'price' => 12000, 'category' => 'Hot Series', 'image' => '☕'],
      ['id' => 2, 'name' => 'Es Kopi Susu', 'price' => 15000, 'category' => 'Cold Series', 'image' => '🧊'],
      ['id' => 3, 'name' => 'Croissant', 'price' => 10000, 'category' => 'Small Bite', 'image' => '🥐'],
    ];

    $filtered = collect($menuItems)->where('category', $selected);
  @endphp

  <div class="flex gap-2 overflow-x-auto p-4 bg-white border-b border-gray-200">
    @foreach ($categories as $category)
      <a href="{{ route('menu', ['category' => $category]) }}"
         class="px-4 py-2 whitespace-nowrap rounded-full font-medium transition-colors
         {{ $selected == $category ? 'bg-green-700 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
         {{ $category == 'Hot Series' ? '☕' : ($category == 'Cold Series' ? '🧊' : '🥐') }} {{ $category }}
      </a>
    @endforeach
  </div>

  {{-- Menu Items Grid --}}
  <div class="grid grid-cols-2 gap-4 p-4">
    @foreach ($filtered as $item)
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-orange-100 h-32 flex items-center justify-center text-5xl">
          {{ $item['image'] }}
        </div>
        <div class="p-3">
          <h3 class="font-bold text-sm text-gray-800">{{ $item['name'] }}</h3>
          <p class="text-green-700 font-bold mt-2">
            Rp{{ number_format($item['price'], 0, ',', '.') }}
          </p>
          <button
            class="w-full mt-3 bg-white border-2 border-green-700 text-green-700 py-2 rounded font-medium hover:bg-green-50 transition-colors">
            Tambahkan
          </button>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection

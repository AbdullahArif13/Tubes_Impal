<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 flex justify-around items-center h-20 shadow-md">
  {{-- Tombol Menu --}}
  <a 
    href="{{ route('menu') }}"
    class="flex flex-col items-center justify-center flex-1 h-full transition-colors
      {{ request()->is('menu') || request()->is('/') ? 'text-green-700' : 'text-gray-600 hover:text-gray-800' }}">
    <span class="text-2xl">☕</span>
    <span class="text-xs mt-1">Menu</span>
  </a>

  {{-- Tombol Pesanan --}}
  <a 
    href="{{ route('cart') }}"
    class="flex flex-col items-center justify-center flex-1 h-full relative transition-colors
      {{ request()->is('cart') ? 'text-green-700' : 'text-gray-600 hover:text-gray-800' }}">
    <span class="text-2xl">🛒</span>
    
    {{-- Badge jumlah pesanan --}}
    @if(isset($cartCount) && $cartCount > 0)
      <span class="absolute top-1 right-8 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
        {{ $cartCount }}
      </span>
    @endif

    <span class="text-xs mt-1">Pesanan</span>
  </a>

  {{-- Tombol Profil --}}
  <a 
    href="{{ route('profile') }}"
    class="flex flex-col items-center justify-center flex-1 h-full transition-colors
      {{ request()->is('profile') ? 'text-green-700' : 'text-gray-600 hover:text-gray-800' }}">
    <span class="text-2xl">👤</span>
    <span class="text-xs mt-1">Profil</span>
  </a>
</nav>

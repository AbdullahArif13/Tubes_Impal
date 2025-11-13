<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kopi Boedaja</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col bg-gray-50">
  <div class="flex-grow">
    @yield('content')
  </div>

  {{-- Bottom Navigation --}}
  @php
    $cartCount = session('cartCount', 0);
  @endphp
  @include('components.bottom-navigation', ['cartCount' => $cartCount])
</body>
</html>

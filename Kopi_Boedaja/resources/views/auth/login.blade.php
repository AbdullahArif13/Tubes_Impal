<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Kopi Boedaja</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="w-full max-w-md">
    <div class="bg-white rounded-xl shadow px-8 py-8">

      <h1 class="text-2xl font-extrabold text-[#0C6B49] text-center mb-2">LOGIN</h1>
      <p class="text-center text-gray-600 mb-6 text-sm">Selamat datang kembali di Kopi Boedaja</p>

      {{-- Success flash (mis. setelah register) --}}
      @if(session('success'))
        <div class="mb-4 text-sm text-green-700">
          {{ session('success') }}
        </div>
      @endif

      {{-- General error (mis. auth fail) --}}
      @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
          {{ $errors->first() }}
        </div>
      @endif

      <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf

        <div>
          <label class="block text-[#0C6B49] font-semibold mb-1">Email</label>
          <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            class="w-full px-4 py-3 rounded-lg bg-[#F1F5F9] focus:outline-none focus:ring-2 focus:ring-[#0F8A5F]" />
        </div>

        <div>
          <label class="block text-[#0C6B49] font-semibold mb-1">Password</label>

          <div class="relative">
            <input
              id="passwordInput"
              type="password"
              name="password"
              required
              class="w-full px-4 py-3 rounded-lg bg-[#F1F5F9] focus:outline-none focus:ring-2 focus:ring-[#0F8A5F]" />

            <button type="button" id="togglePassword"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-gray-500 px-2 py-1 rounded">
              Tampilkan
            </button>
          </div>
        </div>

        <div class="flex items-center justify-between text-sm text-gray-600">
          <label class="inline-flex items-center">
            <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-[#0F8A5F]" {{ old('remember') ? 'checked' : '' }}>
            <span class="ml-2">Ingat saya</span>
          </label>

          <a href="#" class="text-[#0F8A5F]">Lupa password?</a>
        </div>

        <button type="submit"
                class="w-full mt-2 bg-[#0F8A5F] text-white py-3 rounded-lg font-bold hover:bg-[#0d744f] transition">
          Masuk
        </button>
      </form>

      <p class="text-center text-sm text-gray-600 mt-5">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-[#0F8A5F] font-semibold">Daftar</a>
      </p>
    </div>
  </div>

  <script>
    // Toggle show/hide password (nice-to-have)
    (function () {
      const pw = document.getElementById('passwordInput');
      const btn = document.getElementById('togglePassword');
      if (!pw || !btn) return;
      btn.addEventListener('click', function () {
        if (pw.type === 'password') {
          pw.type = 'text';
          btn.textContent = 'Sembunyikan';
        } else {
          pw.type = 'password';
          btn.textContent = 'Tampilkan';
        }
      });
    })();
  </script>
</body>
</html>

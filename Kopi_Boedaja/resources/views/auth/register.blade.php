<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Kopi Boedaja</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-xl shadow px-6 py-8">

            <h1 class="text-center text-2xl font-bold text-[#0C6B49] mb-2">
                REGISTRASI
            </h1>
            <p class="text-center text-gray-600 mb-6 text-sm">Buat akun baru di Kopi Boedaja</p>

            {{-- Show success message --}}
            @if(session('success'))
                <div class="mb-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Show validation errors --}}
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm font-semibold text-[#0C6B49]">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full mt-1 px-4 py-3 rounded-lg bg-[#F1F5F9] focus:outline-none focus:ring-2 focus:ring-[#0F8A5F]" />
                </div>

                <div>
                    <label class="text-sm font-semibold text-[#0C6B49]">Telephone</label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}" required placeholder="08xxxxxxxxxx"
                        class="w-full mt-1 px-4 py-3 rounded-lg bg-[#F1F5F9] focus:outline-none focus:ring-2 focus:ring-[#0F8A5F]" />
                </div>

                <div>
                    <label class="text-sm font-semibold text-[#0C6B49]">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full mt-1 px-4 py-3 rounded-lg bg-[#F1F5F9] focus:outline-none focus:ring-2 focus:ring-[#0F8A5F]" />
                </div>

                <div>
                    <label class="text-sm font-semibold text-[#0C6B49]">Password</label>
                    <input type="password" name="password" required
                        class="w-full mt-1 px-4 py-3 rounded-lg bg-[#F1F5F9] focus:outline-none focus:ring-2 focus:ring-[#0F8A5F]" />
                </div>

                <div>
                    <label class="text-sm font-semibold text-[#0C6B49]">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full mt-1 px-4 py-3 rounded-lg bg-[#F1F5F9] focus:outline-none focus:ring-2 focus:ring-[#0F8A5F]" />
                </div>

                <button type="submit"
                        class="w-full bg-[#0F8A5F] text-white py-3 rounded-lg font-bold hover:bg-[#0d744f] transition">
                    Daftar
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 mt-4">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#0F8A5F] font-semibold">Login</a>
            </p>
        </div>
    </div>

    {{-- Optional: quick debug helper (tampilkan network error di console) --}}
    <script>
        // Jika form submit seakan-akan "tidak ada yg terjadi", buka devtools Network tab
        // dan lihat apakah ada POST ke /register serta responsnya.
        // Ini hanya comment helper — tidak mengubah perilaku form.
    </script>
</body>
</html>

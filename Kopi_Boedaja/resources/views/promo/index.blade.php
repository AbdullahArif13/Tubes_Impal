<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Promo - Kopi Boedaja</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-xl">
    <h1 class="text-2xl font-bold mb-4 text-center">Promo Kopi Boedaja</h1>

    @if ($promos->isEmpty())
        <p class="text-center text-gray-500">
            Belum ada promo saat ini 😄
        </p>
    @else
        <div class="space-y-4">
            @foreach ($promos as $promo)
                <div class="border rounded-lg p-4">
                    <h2 class="font-bold text-lg">{{ $promo->nama_promosi }}</h2>
                    <p class="text-sm text-gray-600">{{ $promo->deskripsi }}</p>

                    <p class="mt-2 font-semibold text-green-700">
                        @if ($promo->tipe === 'percent')
                            Diskon {{ $promo->nilai }}%
                            @if ($promo->maks_potongan)
                                (maks Rp{{ number_format($promo->maks_potongan) }})
                            @endif
                        @elseif ($promo->tipe === 'fixed')
                            Potongan Rp{{ number_format($promo->nilai) }}
                        @else
                            Beli {{ $promo->buy_x }} Gratis {{ $promo->get_y }}
                        @endif
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Berlaku sampai {{ \Carbon\Carbon::parse($promo->tanggal_berakhir)->format('d M Y') }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('menu') }}"
           class="text-blue-600 hover:underline">
            ← Kembali ke menu
        </a>
    </div>
</div>

</body>
</html>

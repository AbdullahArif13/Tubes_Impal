<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-4">

<div class="max-w-3xl mx-auto">

    <h1 class="text-2xl font-bold text-[#0C6B49] mb-6">
        Riwayat Pesanan
    </h1>

    @if($pesanans->isEmpty())
        <div class="bg-white p-4 rounded-lg shadow text-gray-600">
            Kamu belum punya riwayat pesanan.
        </div>
    @else
        <div class="space-y-4">
            @foreach($pesanans as $pesanan)
                <a href="{{ route('Pembayaran', $pesanan->id) }}"
                   class="block bg-white p-4 rounded-lg shadow hover:bg-gray-50">

                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold">
                                Pesanan #KBDJ{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $pesanan->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="font-bold text-[#0C6B49]">
                                Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ ucfirst($pesanan->status ?? 'pending') }}
                            </p>
                        </div>
                    </div>

                </a>
            @endforeach
        </div>
    @endif

    <a href="{{ route('menu') }}"
    class="inline-flex items-center gap-2 mb-4 text-sm font-semibold text-gray-600 hover:text-[#0C6B49]">
        ← Kembali ke Menu
    </a>

</div>

</body>
</html>

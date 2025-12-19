<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-900 min-h-screen p-6 text-white font-sans">
<div class="max-w-3xl mx-auto">

    <a href="{{ route('menu') }}" 
       class="inline-flex items-center px-3 py-1.5 mb-6 text-xs font-medium bg-white/10 hover:bg-white/20 border border-white/30 rounded-full transition-all text-white">
        ← Kembali ke Menu
    </a>

    <h1 class="text-3xl font-bold mb-8">
        Riwayat Pesanan
    </h1>

    @if($pesanans->isEmpty())
        <div class="bg-white p-6 rounded-2xl shadow-xl text-gray-800">
            <p>Kamu belum punya riwayat pesanan.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($pesanans as $pesanan)
                <a href="{{ route('Pembayaran', $pesanan->id) }}"
                   class="block bg-white p-5 rounded-2xl shadow-lg hover:scale-[1.01] transition-transform duration-200">

                    <div class="flex justify-between items-center text-gray-800">
                        <div>
                            <p class="font-bold text-lg text-[#0C6B49]">
                                #KBDJ{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $pesanan->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="font-black text-xl text-gray-900">
                                Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </p>
                            <span class="inline-block px-3 py-1 mt-1 text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-500 rounded-full">
                                {{ $pesanan->status ?? 'pending' }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>

</body>
</html>
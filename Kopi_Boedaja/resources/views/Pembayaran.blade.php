<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen pb-28 sm:pb-32">

    {{-- Header --}}
    <div class="bg-white sticky top-0 z-50 px-4 sm:px-6 lg:px-8 py-3 flex items-center gap-4 border-b border-gray-200">
        <a href="{{ route('RincianPesanan') }}" class="p-2 hover:bg-gray-100 rounded-lg transition flex-shrink-0">
            ←
        </a>
        <h1 class="text-lg sm:text-xl font-bold flex-1 text-center">Pembayaran</h1>
        <div class="w-8"></div>
    </div>

    @php
        // data dinamis dari DB
        $subtotal      = $pesanan->total_harga ?? 0;
        $serviceCharge = 1000;
        $discount      = 0;
        $otherFees     = 2300;

        // nomor pesanan dari id pesanan
        $orderNumber = 'KBDJ' . str_pad($pesanan->id, 5, '0', STR_PAD_LEFT);

        $total = $subtotal + $serviceCharge + $otherFees - $discount;
    @endphp

    <div class="px-4 sm:px-6 lg:px-8 py-6 max-w-2xl mx-auto">

        {{-- Tipe Pemesanan --}}
        <div class="bg-white rounded-lg border border-gray-300 px-4 sm:px-5 py-3 mb-6 flex items-center justify-between gap-4">
            <span class="font-semibold text-gray-700 text-sm sm:text-base">Tipe Pemesanan</span>
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="text-gray-700 text-xs sm:text-sm">Makan di tempat</span>
                <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full border-2 border-green-600 flex items-center justify-center flex-shrink-0">
                    <div class="w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-green-600"></div>
                </div>
            </div>
        </div>

        {{-- (Opsional) Info meja / nama pemesan --}}
        @if($pesanan->pelanggan ?? false)
            <div class="bg-white rounded-lg border border-gray-300 px-4 sm:px-5 py-3 mb-6 flex flex-col gap-1 text-sm sm:text-base">
                <div class="flex justify-between">
                    <span class="text-gray-600">Atas nama</span>
                    <span class="font-semibold">{{ $pesanan->pelanggan->nama }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Nomor meja</span>
                    <span class="font-semibold">{{ $pesanan->pelanggan->nomor_meja }}</span>
                </div>
            </div>
        @endif

        {{-- Nomor Pesanan --}}
        <div class="mb-6">
            <h2 class="text-base sm:text-lg font-bold mb-4">Nomor Pesanan</h2>
            <div class="bg-white rounded-lg border border-gray-300 px-6 sm:px-8 py-6 sm:py-8 text-center">
                <p class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-wider break-all">
                    {{ $orderNumber }}
                </p>
            </div>
            <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-4 mt-4 flex gap-3">
                <span class="text-lg sm:text-xl flex-shrink-0">⚠️</span>
                <p class="text-xs sm:text-sm text-gray-800">
                    Silahkan tunjukkan 8 digit nomor pesanan ke staff kasir kami.
                </p>
            </div>
        </div>

        {{-- Rincian Pembayaran --}}
        <div class="bg-white rounded-2xl p-5 sm:p-6 mb-6">
            <h2 class="text-center font-bold text-base sm:text-lg lg:text-xl mb-6">Rincian Pesanan</h2>

            <div class="space-y-4">
                <div class="flex justify-between items-center gap-4 text-sm sm:text-base">
                    <span class="text-gray-700">Subtotal</span>
                    <span class="font-semibold text-right">
                        Rp{{ number_format($subtotal, 0, ',', '.') }}
                    </span>
                </div>

                <div class="border-t border-gray-200 pt-4 flex justify-between items-center gap-4 text-sm sm:text-base">
                    <span class="text-gray-700">Biaya Tambahan</span>
                    <span class="font-semibold text-right">
                        Rp{{ number_format($serviceCharge, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between items-center gap-4 text-sm sm:text-base">
                    <span class="text-gray-700">Pembulatan</span>
                    <span class="font-semibold text-right">
                        Rp{{ number_format($discount, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between items-center gap-4 text-sm sm:text-base">
                    <span class="text-gray-700">Biaya lainnya</span>
                    <span class="font-semibold text-right">
                        Rp{{ number_format($otherFees, 0, ',', '.') }}
                    </span>
                </div>

                <div class="border-t border-gray-300 pt-4 flex justify-between items-center gap-4">
                    <span class="text-base sm:text-lg font-bold">Total</span>
                    <span class="text-base sm:text-lg font-bold text-right">
                        Rp{{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Pesan Baru --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 sm:px-6 lg:px-8 py-4">
        <div class="max-w-2xl mx-auto">
            <a href="{{ route('menu') }}"
               class="block w-full text-center bg-teal-700 text-white py-3 rounded-lg font-bold hover:bg-teal-800 transition text-sm sm:text-base">
                Pesan Baru
            </a>
        </div>
    </div>

</body>
</html>

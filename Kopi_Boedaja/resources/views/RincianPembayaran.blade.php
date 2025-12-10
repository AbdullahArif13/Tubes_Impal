<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen pb-28 sm:pb-32">

    <!-- Header -->
    <div class="bg-white sticky top-0 z-50 px-4 sm:px-6 lg:px-8 py-3 flex items-center gap-4 border-b border-gray-200">
        <a href="{{ route('RincianPesanan') }}" class="p-2 hover:bg-gray-100 rounded-lg transition flex-shrink-0">
            <!-- ChevronLeft Icon -->
            ←
        </a>
        <h1 class="text-lg sm:text-xl font-bold flex-1 text-center">Pembayaran</h1>
        <div class="w-8"></div>
    </div>

    <form action="{{ route('pesanan.store') }}" method="POST" class="px-4 sm:px-6 lg:px-8 py-6 max-w-2xl mx-auto">
        @csrf

        {{-- cart dalam bentuk JSON, akan diisi dari localStorage via JS --}}
        <input type="hidden" name="cart" id="cart-input">

        <!-- Tipe Pemesanan -->
        <div class="bg-white rounded-lg border border-gray-300 px-4 sm:px-5 py-3 mb-6 flex items-center justify-between gap-4">
            <span class="font-semibold text-gray-700 text-sm sm:text-base">Tipe Pemesanan</span>
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="text-gray-700 text-xs sm:text-sm">Makan di tempat</span>
                <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full border-2 border-green-600 flex items-center justify-center">
                    <div class="w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-green-600"></div>
                </div>
            </div>
        </div>

        <!-- Ringkasan (tanpa form identitas) -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 mb-6">
            <h2 class="text-base sm:text-lg font-bold mb-4">Ringkasan Pesanan</h2>

            <div class="space-y-3 text-sm sm:text-base">
                <div class="flex justify-between">
                    <span class="text-gray-700">Subtotal</span>
                    <span id="subtotal-text" class="font-semibold">Rp0</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700">Biaya Tambahan</span>
                    <span id="service-charge-text" class="font-semibold">Rp1.000</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700">Pembulatan</span>
                    <span id="discount-text" class="font-semibold">Rp0</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700">Biaya lainnya</span>
                    <span id="other-fees-text" class="font-semibold">Rp2.300</span>
                </div>

                <div class="border-t border-gray-200 pt-4 flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span id="total-text">Rp0</span>
                </div>
            </div>
        </div>

        <!-- Total + Button -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 sm:px-6 lg:px-8 py-4">
            <div class="max-w-2xl mx-auto">
                <div class="mb-2">
                    <p class="text-gray-600 text-xs sm:text-sm">Total Pembayaran</p>
                    <p id="total-bottom-text" class="text-xl sm:text-2xl font-bold">Rp0</p>
                </div>
                <button 
                    type="submit"
                    class="w-full bg-blue-900 text-white py-3 rounded-lg font-bold hover:bg-blue-950 transition text-sm sm:text-base"
                >
                    Lanjut Pembayaran
                </button>
            </div>
        </div>

    </form>

    <script>
        // ambil keranjang dari localStorage
        document.addEventListener('DOMContentLoaded', function () {
            const cartInput          = document.getElementById('cart-input');
            const subtotalText       = document.getElementById('subtotal-text');
            const serviceChargeText  = document.getElementById('service-charge-text');
            const discountText       = document.getElementById('discount-text');
            const otherFeesText      = document.getElementById('other-fees-text');
            const totalText          = document.getElementById('total-text');
            const totalBottomText    = document.getElementById('total-bottom-text');

            const serviceCharge = 1000;
            const otherFees     = 2300;
            const discount      = 0;

            function formatRupiah(number) {
                return 'Rp' + (number || 0).toLocaleString('id-ID');
            }

            const rawCart = localStorage.getItem('cart') || '{}';
            let cart;

            try {
                cart = JSON.parse(rawCart);
            } catch (e) {
                cart = {};
            }

            const items = Object.values(cart);

            // isi hidden input cart
            cartInput.value = JSON.stringify(cart);

            if (!items.length) {
                const total = serviceCharge + otherFees - discount;
                subtotalText.textContent    = formatRupiah(0);
                serviceChargeText.textContent = formatRupiah(serviceCharge);
                discountText.textContent    = formatRupiah(discount);
                otherFeesText.textContent   = formatRupiah(otherFees);
                totalText.textContent       = formatRupiah(total);
                totalBottomText.textContent = formatRupiah(total);
                return;
            }

            // hitung subtotal dari cart
            let subtotal = 0;
            items.forEach(item => {
                const qty   = item.quantity || 0;
                const price = item.price || 0;
                subtotal += qty * price;
            });

            const total = subtotal + serviceCharge + otherFees - discount;

            subtotalText.textContent      = formatRupiah(subtotal);
            serviceChargeText.textContent = formatRupiah(serviceCharge);
            discountText.textContent      = formatRupiah(discount);
            otherFeesText.textContent     = formatRupiah(otherFees);
            totalText.textContent         = formatRupiah(total);
            totalBottomText.textContent   = formatRupiah(total);
        });
    </script>
</body>
</html>

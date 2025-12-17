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

        <!-- Delivery Type -->
        <div class="bg-white rounded-lg border px-4 py-3 mb-6">
            <p class="text-sm text-gray-500">Tipe Pemesanan</p>
            <p id="orderTypeText" class="text-lg font-bold text-green-700">
                <!-- akan diisi via JavaScript -->
                -
            </p>
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

        <!-- ================= DISKON ================= -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 mb-6">

        <h2 class="text-base sm:text-lg font-bold mb-3">Promo & Diskon</h2>

        @auth
            {{-- USER LOGIN --}}
            <div id="discount-area" class="text-sm text-gray-600">
            {{-- default, nanti diisi JS --}}
            <p>Tidak ada diskon yang berlaku kali ini</p>
            </div>
        @else
            {{-- BELUM LOGIN --}}
            <div
            onclick="openLoginPromoModal()"
            class="cursor-pointer border border-dashed border-gray-300 rounded-lg p-4 text-center text-sm text-gray-600 hover:bg-gray-50">
            🎁 Klik untuk lihat promo
            </div>
        @endauth

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
document.addEventListener('DOMContentLoaded', function () {
    // ---------- BAGIAN: TAMPILAN TIPE PEMESANAN ----------
    (function showOrderType() {
        const orderTypeTextEl = document.getElementById('orderTypeText');
        if (!orderTypeTextEl) return;

        const orderType = localStorage.getItem('kopi_boedaja_order_type') || 'dine_in';
        const mejaRaw   = localStorage.getItem('kopi_boedaja_meja');

        let text = '';
        if (orderType === 'take_away') {
            text = 'Dibawa Pulang';
        } else {
            if (mejaRaw) {
                try {
                    const data = JSON.parse(mejaRaw);
                    // safe guard: pastikan ada lantai & meja
                    const lantai = (data && data.lantai) ? data.lantai : null;
                    const meja   = (data && data.meja) ? data.meja : null;
                    if (lantai && meja) {
                        text = `Makan di tempat — Lantai ${lantai}, Meja ${meja}`;
                    } else {
                        text = 'Makan di tempat';
                    }
                } catch (e) {
                    text = 'Makan di tempat';
                }
            } else {
                text = 'Makan di tempat';
            }
        }

        orderTypeTextEl.textContent = text;
    })();

    // ---------- BAGIAN: RINCIAN PEMBAYARAN (CART) ----------
    (function paymentSummary() {
        const cartInput          = document.getElementById('cart-input'); // hidden input (optional)
        const subtotalText       = document.getElementById('subtotal-text');
        const serviceChargeText  = document.getElementById('service-charge-text');
        const discountText       = document.getElementById('discount-text');
        const otherFeesText      = document.getElementById('other-fees-text');
        const totalText          = document.getElementById('total-text');
        const totalBottomText    = document.getElementById('total-bottom-text');

        // guard: jika elemen tidak ada, hentikan bagian ini
        if (!subtotalText || !serviceChargeText || !discountText || !otherFeesText || !totalText || !totalBottomText) {
            return;
        }

        const serviceCharge = 1000;
        const otherFees     = 2300;
        const discount      = 0;

        function formatRupiah(number) {
            return 'Rp' + (number || 0).toLocaleString('id-ID');
        }

        // AMAN: ambil isi localStorage tanpa default string yang dapat menutupi error
        const rawCart = localStorage.getItem('cart'); // null jika tidak ada
        let cart = {};
        let items = [];

        if (rawCart === null) {
            // tidak ada cart di localStorage
            cart = {};
            items = [];
        } else {
            try {
                cart = JSON.parse(rawCart);
                // safety: pastikan cart adalah object
                if (!cart || typeof cart !== 'object') {
                    cart = {};
                    items = [];
                } else {
                    items = Object.values(cart);
                }
            } catch (e) {
                // JSON corrupt — jangan overwrite localStorage di sini; tampilkan kosong
                cart = {};
                items = [];
                console.warn('Gagal parse cart dari localStorage:', e);
            }
        }

        // Hanya isi hidden input jika cart ada isinya — mencegah overwrite dengan "{}" saat kosong.
        if (cartInput) {
            if (items.length) {
                cartInput.value = JSON.stringify(cart);
            } else {
                // opsional: kosongkan hidden input (atau biarkan tetap apa adanya)
                // cartInput.value = '';
            }
        }

        // jika cart kosong, tampilkan nilai dasar
        if (!items.length) {
            const total = serviceCharge + otherFees - discount;
            subtotalText.textContent       = formatRupiah(0);
            serviceChargeText.textContent  = formatRupiah(serviceCharge);
            discountText.textContent       = formatRupiah(discount);
            otherFeesText.textContent      = formatRupiah(otherFees);
            totalText.textContent          = formatRupiah(total);
            totalBottomText.textContent    = formatRupiah(total);
            return;
        }

        // hitung subtotal dari cart
        let subtotal = 0;
        items.forEach(item => {
            const qty   = Number(item.quantity) || 0;
            const price = Number(item.price) || 0;
            subtotal += qty * price;
        });

        const total = subtotal + serviceCharge + otherFees - discount;

        subtotalText.textContent       = formatRupiah(subtotal);
        serviceChargeText.textContent  = formatRupiah(serviceCharge);
        discountText.textContent       = formatRupiah(discount);
        otherFeesText.textContent      = formatRupiah(otherFees);
        totalText.textContent          = formatRupiah(total);
        totalBottomText.textContent    = formatRupiah(total);
    })();
});
</script>

</body>
</html>

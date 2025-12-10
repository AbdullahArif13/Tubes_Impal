<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rincian Pesanan</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<main class="bg-gray-100 min-h-screen pb-28 sm:pb-32">

    <!-- Header -->
    <div class="bg-white sticky top-0 z-50 px-4 py-3 flex items-center gap-4 border-b border-gray-200">
        <a href="/" class="p-2 hover:bg-gray-100 rounded-lg transition flex-shrink-0">
            ←
        </a>
        <h1 class="text-lg sm:text-xl font-bold flex-1 text-center">Pesanan</h1>
        <div class="w-8"></div>
    </div>

    <div class="px-4 py-6 max-w-4xl mx-auto">

        <!-- Delivery Type -->
        <div class="bg-white rounded-lg border px-4 py-3 mb-6">
            <p class="text-sm text-gray-500">Tipe Pemesanan</p>
            <p id="orderTypeText" class="text-lg font-bold text-green-700">
                <!-- akan diisi via JavaScript -->
                -
            </p>
        </div>


        <!-- Items Section -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">
                    Item yang dipesan <span id="total-items-text" class="text-gray-600">(0)</span>
                </h2>
                <button class="border-2 border-gray-800 text-gray-800 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-gray-800 hover:text-white transition">
                    + Tambah
                </button>
            </div>

            <div id="items-container" class="space-y-6 text-sm text-gray-500">
                {{-- diisi via JavaScript --}}
                <p>Keranjang masih kosong.</p>
            </div>
        </div>

        <!-- Payment Breakdown -->
        <div class="bg-white rounded-2xl p-6 mb-6">
            <h2 class="text-center font-bold text-xl mb-6">Rincian Pembayaran</h2>

            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-700">Subtotal</span>
                    <span id="subtotal-text" class="font-semibold">Rp0</span>
                </div>

                <div class="border-t pt-4 flex justify-between">
                    <span class="text-gray-700">Biaya Tambahan</span>
                    <span id="service-charge-text" class="font-semibold">Rp1.000</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700">Pembulatan</span>
                    <span id="discount-text" class="font-semibold">Rp0</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700">Biaya Lainnya</span>
                    <span id="other-fees-text" class="font-semibold">Rp2.300</span>
                </div>

                <div class="border-t pt-4 flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span id="total-text">Rp0</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Continue Payment Button -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t px-4 py-4">
        <div class="max-w-4xl mx-auto">
            <div class="mb-2">
                <p class="text-gray-600 text-sm">Total Pembayaran</p>
                <p id="total-bottom-text" class="text-2xl font-bold">Rp0</p>
            </div>

            {{-- sementara tetap GET ke halaman isi data pelanggan --}}
            <a href="{{ route('RincianPembayaran') }}"
               class="w-full block bg-green-700 text-white text-center py-3 rounded-lg font-bold hover:bg-blue-950 transition">
                Lanjut Pembayaran
            </a>
        </div>
    </div>

</main>

<script>
        // === TAMPILKAN TIPE PEMESANAN DARI HALAMAN UTAMA ===
    document.addEventListener('DOMContentLoaded', function () {
        const orderTypeTextEl = document.getElementById('orderTypeText');
        if (!orderTypeTextEl) return;

        // baca dari localStorage (diset di halaman utama)
        const orderType = localStorage.getItem('kopi_boedaja_order_type') || 'dine_in';
        const mejaRaw   = localStorage.getItem('kopi_boedaja_meja');

        let text = '';

        if (orderType === 'take_away') {
            text = 'Dibawa Pulang';
        } else {
            // dine in
            if (mejaRaw) {
                try {
                    const data = JSON.parse(mejaRaw);
                    text = `Makan di tempat — Lantai ${data.lantai}, Meja ${data.meja}`;
                } catch (e) {
                    text = 'Makan di tempat';
                }
            } else {
                text = 'Makan di tempat';
            }
        }

        orderTypeTextEl.textContent = text;
    });
    // Ambil cart dari localStorage (diisi dari halaman menu)
    // Struktur cart yang kita pakai di menu.blade: { [id]: {id, name, price, quantity, ...} }
    const rawCart = localStorage.getItem('cart') || '{}';
    const cartObj = JSON.parse(rawCart);
    const items = Object.values(cartObj);

    const serviceCharge = 1000;
    const otherFees = 2300;
    const discount = 0;

    function formatRupiah(number) {
        return 'Rp' + (number || 0).toLocaleString('id-ID');
    }

    const itemsContainer = document.getElementById('items-container');
    const totalItemsText = document.getElementById('total-items-text');
    const subtotalText = document.getElementById('subtotal-text');
    const serviceChargeText = document.getElementById('service-charge-text');
    const otherFeesText = document.getElementById('other-fees-text');
    const discountText = document.getElementById('discount-text');
    const totalText = document.getElementById('total-text');
    const totalBottomText = document.getElementById('total-bottom-text');

    if (!items.length) {
        itemsContainer.innerHTML = '<p>Keranjang masih kosong.</p>';
        totalItemsText.textContent = '(0)';
        subtotalText.textContent = formatRupiah(0);
        serviceChargeText.textContent = formatRupiah(serviceCharge);
        otherFeesText.textContent = formatRupiah(otherFees);
        discountText.textContent = formatRupiah(discount);
        const total = serviceCharge + otherFees - discount;
        totalText.textContent = formatRupiah(total);
        totalBottomText.textContent = formatRupiah(total);
    } else {
        // hitung subtotal & total item
        let subtotal = 0;
        let totalItems = 0;

        items.forEach(item => {
            const qty = item.quantity || 0;
            const price = item.price || 0;
            subtotal += qty * price;
            totalItems += qty;
        });

        // render list item
        itemsContainer.innerHTML = items.map(item => {
            const qty = item.quantity || 0;
            const price = item.price || 0;
            const notes = item.notes || 'Belum menambah catatan';

            return `
                <div class="border-b border-gray-300 pb-6">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg">${item.name}</h3>
                            <p class="text-gray-500 text-sm">
                                ${notes}
                            </p>
                        </div>
                        <button class="text-blue-600 hover:text-blue-800">✎</button>
                    </div>

                    <div class="flex justify-between items-center">
                        <p class="text-lg font-bold">${formatRupiah(price)}</p>

                        <div class="flex items-center gap-3 bg-gray-100 rounded-lg p-2">
                            <button disabled class="w-8 h-8 flex items-center justify-center rounded text-gray-400">−</button>
                            <span class="w-4 text-center font-bold text-base">${qty}</span>
                            <button disabled class="w-8 h-8 flex items-center justify-center rounded text-gray-400">+</button>
                        </div>
                    </div>

                    <div class="mt-2 text-gray-500 text-sm flex items-center gap-2">
                        <span>✏️</span>
                        <span>Tambah catatan lainnya</span>
                    </div>
                </div>
            `;
        }).join('');

        totalItemsText.textContent = `(${totalItems})`;
        subtotalText.textContent = formatRupiah(subtotal);
        serviceChargeText.textContent = formatRupiah(serviceCharge);
        otherFeesText.textContent = formatRupiah(otherFees);
        discountText.textContent = formatRupiah(discount);

        const total = subtotal + serviceCharge + otherFees - discount;
        totalText.textContent = formatRupiah(total);
        totalBottomText.textContent = formatRupiah(total);
    }
</script>

</body>
</html>

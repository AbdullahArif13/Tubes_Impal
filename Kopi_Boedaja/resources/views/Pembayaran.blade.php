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

        <!-- Delivery Type -->
        <div class="bg-white rounded-lg border px-4 py-3 mb-6">
            <p class="text-sm text-gray-500">Tipe Pemesanan</p>
            <p id="orderTypeText" class="text-lg font-bold text-green-700">
                <!-- akan diisi via JavaScript -->
                -
            </p>
        </div>

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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // ----- 1) Isi teks tipe pemesanan -----
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
                    const lantai = data && (data.lantai ?? data.floor ?? data.level);
                    const meja   = data && (data.meja ?? data.table ?? data.no);
                    if (lantai && meja) {
                        text = `Makan di tempat — Lantai ${lantai}, Meja ${meja}`;
                    } else {
                        text = 'Makan di tempat';
                    }
                } catch (e) {
                    console.warn('Gagal parse kopi_boedaja_meja:', e);
                    text = 'Makan di tempat';
                }
            } else {
                text = 'Makan di tempat';
            }
        }

        orderTypeTextEl.textContent = text;
    })();

    // ----- 2) Click-to-copy untuk nomor pesanan + toast -----
    (function enableCopyOrderNumber() {
        const orderNumberEl = document.querySelector('.break-all');
        if (!orderNumberEl) return;

        // buat area klik yang tidak mengubah layout
        const wrapper = document.createElement('div');
        wrapper.style.cursor = 'pointer';
        wrapper.style.display = 'inline-block';
        wrapper.style.width = '100%';
        wrapper.style.textAlign = 'center';

        // pindahkan node nomor ke wrapper (preserve styling)
        orderNumberEl.parentNode.replaceChild(wrapper, orderNumberEl);
        wrapper.appendChild(orderNumberEl);

        // toast sederhana (reuse jika sudah ada)
        function showToast(msg) {
            const existing = document.getElementById('kb-toast');
            if (existing) {
                existing.remove();
            }
            const t = document.createElement('div');
            t.id = 'kb-toast';
            t.textContent = msg;
            // styling
            t.style.position = 'fixed';
            t.style.right = '1rem';
            t.style.bottom = '4.5rem';
            t.style.zIndex = 9999;
            t.style.padding = '10px 14px';
            t.style.borderRadius = '12px';
            t.style.background = 'rgba(0,0,0,0.82)';
            t.style.color = 'white';
            t.style.fontSize = '13px';
            t.style.boxShadow = '0 6px 18px rgba(0,0,0,0.12)';
            t.style.opacity = '0';
            t.style.transition = 'opacity 160ms ease';
            document.body.appendChild(t);
            // fade in
            requestAnimationFrame(() => { t.style.opacity = '1'; });
            setTimeout(() => {
                t.style.opacity = '0';
                setTimeout(() => t.remove(), 220);
            }, 1600);
        }

        // klik wrapper => copy teks
        wrapper.addEventListener('click', async function () {
            const text = orderNumberEl.textContent.trim();
            if (!text) return;

            try {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    await navigator.clipboard.writeText(text);
                    showToast('Nomor pesanan disalin!');
                } else {
                    // fallback legacy
                    const range = document.createRange();
                    range.selectNodeContents(orderNumberEl);
                    const sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(range);
                    document.execCommand('copy');
                    sel.removeAllRanges();
                    showToast('Nomor pesanan disalin!');
                }
            } catch (err) {
                console.warn('Gagal menyalin ke clipboard:', err);
                // coba fallback manual sekali lagi
                try {
                    const range = document.createRange();
                    range.selectNodeContents(orderNumberEl);
                    const sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(range);
                    document.execCommand('copy');
                    sel.removeAllRanges();
                    showToast('Nomor pesanan disalin!');
                } catch (e) {
                    showToast('Gagal menyalin');
                }
            }
        });

        // opsional: hint kecil saat hover (desktop)
        wrapper.addEventListener('mouseenter', function () {
            wrapper.title = 'Klik untuk menyalin nomor pesanan';
        });
    })();

    // ----- catatan keamanan/safety -----
    // Script ini hanya membaca dari localStorage; tidak menulis atau menghapus.
});
</script>



</body>
</html>

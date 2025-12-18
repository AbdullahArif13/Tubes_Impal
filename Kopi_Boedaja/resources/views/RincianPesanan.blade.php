<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rincian Pesanan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<main class="min-h-screen pb-32">

  <!-- HEADER -->
  <div class="bg-white sticky top-0 z-50 px-4 py-3 flex items-center border-b">
    <a href="/" class="p-2 rounded hover:bg-gray-100">←</a>
    <h1 class="flex-1 text-center font-bold text-lg">Pesanan</h1>
    <div class="w-8"></div>
  </div>

  <div class="px-4 py-6 max-w-4xl mx-auto">

    <!-- TIPE PEMESANAN -->
    <div class="bg-white rounded-lg border px-4 py-3 mb-6">
      <p class="text-sm text-gray-500">Tipe Pemesanan</p>
      <p id="orderTypeText" class="text-lg font-bold text-green-700">-</p>
    </div>

    <!-- ITEMS -->
    <div class="mb-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-lg">
          Item yang dipesan <span id="total-items-text" class="text-gray-500">(0)</span>
        </h2>
        <a href="{{ route('menu') }}"
           class="border-2 border-gray-800 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 hover:text-white">
          + Tambah Menu Lain
        </a>
      </div>

      <div id="items-container" class="space-y-6 text-sm text-gray-600">
        <p>Keranjang masih kosong.</p>
      </div>
    </div>

  </div>

  <!-- FOOTER -->
  <div id="checkout-footer"
     class="fixed bottom-0 left-0 right-0 bg-blue-900 text-white py-3 px-4 border-t shadow-lg">
  <div class="max-w-7xl mx-auto flex justify-between items-center gap-4">

    <div class="flex items-center gap-3 flex-1 min-w-0">
      <div class="relative">
        <i data-lucide="shopping-cart" class="w-8 h-8"></i>
        <span id="cart-count"
              class="absolute -top-2 -right-2 bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">
          0
        </span>
      </div>

      <div>
        <p class="text-blue-200 text-xs">Total</p>
        <p id="cart-total" class="text-lg font-bold">Rp0</p>
      </div>
    </div>

    <a href="{{ route('RincianPembayaran') }}"
       class="bg-white text-blue-900 px-6 py-2 rounded-lg font-bold">
      CHECK OUT
    </a>

  </div>
</div>


</main>

<!-- ================= MODAL CATATAN ================= -->
<div id="optionModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
  <div class="bg-white rounded-xl p-5 w-full max-w-2xl mx-4">

    <h3 class="font-bold text-lg mb-4">Catatan Pesanan</h3>

    <div class="flex gap-6">

      <!-- KIRI -->
      <div class="flex-1 space-y-4">

        <div id="iceSection">
          <p class="font-semibold mb-2">Ice Level</p>
          <div class="flex gap-4">
            <label><input type="radio" name="ice" value="Less Ice"> Less</label>
            <label><input type="radio" name="ice" value="Normal Ice" checked> Normal</label>
            <label><input type="radio" name="ice" value="More Ice"> More</label>
          </div>
        </div>

        <div id="reheatSection">
          <p class="font-semibold mb-2">Reheat</p>
          <div class="flex gap-4">
            <label><input type="radio" name="reheat" value="Reheat"> Reheat</label>
            <label><input type="radio" name="reheat" value="No Reheat" checked> No Reheat</label>
          </div>
        </div>

      </div>

      <!-- KANAN -->
        <div id="sugarSection" class="flex-1">
        <p class="font-semibold mb-2">Sugar Level</p>
        <div class="flex flex-wrap gap-4">
            <label><input type="radio" name="sugar" value="No Sugar"> No</label>
            <label><input type="radio" name="sugar" value="Less Sugar"> Less</label>
            <label><input type="radio" name="sugar" value="Normal Sugar" checked> Normal</label>
            <label><input type="radio" name="sugar" value="More Sugar"> More</label>
        </div>
        </div>
    </div>

    <div class="flex justify-end gap-3 mt-6">
      <button onclick="closeOptionModal()" class="text-gray-600">Batal</button>
      <button onclick="saveOption()" class="bg-green-700 text-white px-5 py-2 rounded-lg font-bold">
        Simpan
      </button>
    </div>

  </div>
</div>

<!-- ================= SCRIPT ================= -->
<script>
/* ===== TAMPILKAN TIPE PEMESANAN ===== */
const orderTypeTextEl = document.getElementById('orderTypeText');
const orderType = localStorage.getItem('kopi_boedaja_order_type') || 'dine_in';
const mejaRaw = localStorage.getItem('kopi_boedaja_meja');

if (orderType === 'take_away') {
  orderTypeTextEl.textContent = 'Dibawa Pulang';
} else if (mejaRaw) {
  const m = JSON.parse(mejaRaw);
  orderTypeTextEl.textContent = `Makan di tempat — Lantai ${m.lantai}, Meja ${m.meja}`;
} else {
  orderTypeTextEl.textContent = 'Makan di tempat';
}

/* ===== RENDER CART ===== */
const cart = JSON.parse(localStorage.getItem('cart') || '{}');
const items = Object.values(cart);

const itemsContainer = document.getElementById('items-container');
const totalItemsText = document.getElementById('total-items-text');
const totalBottomText = document.getElementById('total-bottom-text');
const totalPriceText = document.getElementById('total-price-text');

if (!items.length) {
  itemsContainer.innerHTML = '<p>Keranjang masih kosong.</p>';
} else {
  let totalQty = 0;
  let totalPrice = 0;

  itemsContainer.innerHTML = items.map(item => {
    totalQty += item.quantity;
    totalPrice += item.price * item.quantity;
    const noteText = item.note
      ? Object.values(item.note).filter(Boolean).join(' • ')
      : 'Tambah catatan lainnya';

    return `
      <div class="border-b pb-6">
        <h3 class="font-bold text-lg">${item.name}</h3>

        <div class="flex justify-between items-center mt-2">
          <p class="font-bold text-lg">Rp${item.price.toLocaleString('id-ID')}</p>
            <div class="flex items-center gap-2 bg-gray-100 rounded-lg px-2 py-1">
            <button onclick="decreaseQty('${item.id}')"
                    class="w-6 h-6 rounded bg-white border text-gray-700">−</button>

            <span class="font-bold w-4 text-center">${item.quantity}</span>

            <button onclick="increaseQty('${item.id}')"
                    class="w-6 h-6 rounded bg-white border text-gray-700">+</button>
            </div>
        </div>

        <div class="mt-2 text-green-700 cursor-pointer text-sm"
             onclick="openOptionModal('${item.id}', '${item.kategori}')">
          ✏️ ${noteText}
        </div>
      </div>
    `;
  }).join('');

  totalItemsText.textContent = `(${totalQty})`;
  totalBottomText.textContent = `${totalQty} item`;
  totalPriceText.textContent = `Rp${totalPrice.toLocaleString('id-ID')}`;
}

/* ===== MODAL LOGIC ===== */
let currentItemId = null;

function openOptionModal(itemId, kategori) {
  currentItemId = itemId;

  const ice = document.getElementById('iceSection');
  const sugar = document.getElementById('sugarSection');
  const reheat = document.getElementById('reheatSection');

  // reset semua
  ice.style.display = 'none';
  sugar.style.display = 'none';
  reheat.style.display = 'none';

  if (kategori === 'cold') {
    ice.style.display = 'block';
    sugar.style.display = 'block';
  }

  if (kategori === 'hot') {
    sugar.style.display = 'block';
  }

  if (kategori === 'small_bites') {
    reheat.style.display = 'block';
  }

  document.getElementById('optionModal').classList.remove('hidden');
  document.getElementById('optionModal').classList.add('flex');
}

function closeOptionModal() {
  document.getElementById('optionModal').classList.add('hidden');
  document.getElementById('optionModal').classList.remove('flex');
}

function saveOption() {
  const cart = JSON.parse(localStorage.getItem('cart') || '{}');
  if (!cart[currentItemId]) return;

  const kategori = cart[currentItemId].kategori;

  let note = {};

  if (kategori === 'cold') {
    note.ice = document.querySelector('input[name="ice"]:checked')?.value || null;
    note.sugar = document.querySelector('input[name="sugar"]:checked')?.value || null;
  }

  if (kategori === 'hot') {
    note.sugar = document.querySelector('input[name="sugar"]:checked')?.value || null;
  }

  if (kategori === 'small_bites') {
    note.reheat = document.querySelector('input[name="reheat"]:checked')?.value || null;
  }

  cart[currentItemId].note = note;

  localStorage.setItem('cart', JSON.stringify(cart));
  closeOptionModal();
  location.reload(); // biar UI langsung sinkron
}

function increaseQty(id) {
  const cart = JSON.parse(localStorage.getItem('cart') || '{}');
  if (!cart[id]) return;

  cart[id].quantity += 1;
  localStorage.setItem('cart', JSON.stringify(cart));
  location.reload();
}

function decreaseQty(id) {
  const cart = JSON.parse(localStorage.getItem('cart') || '{}');
  if (!cart[id]) return;

  cart[id].quantity -= 1;

  if (cart[id].quantity <= 0) {
    delete cart[id]; // hapus item kalau 0
  }

  localStorage.setItem('cart', JSON.stringify(cart));
  location.reload();
}
</script>

</body>
</html>

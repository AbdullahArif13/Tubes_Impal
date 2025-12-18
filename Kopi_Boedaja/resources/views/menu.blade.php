<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kopi Boedaja</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Lucide Icons CDN -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- TOP BUTTONS -->
  <div class="bg-gray-100 sticky top-0 z-50 px-4 py-3 flex justify-end gap-3 w-full">
    <button id="menu-search-btn"
            class="w-10 h-10 rounded-full bg-white shadow flex items-center justify-center hover:shadow-lg"> 
      <i data-lucide="search" class="w-5 h-5"></i> 
    </button>
    <button id="open-sidebar"
            class="w-10 h-10 rounded-full bg-white shadow flex items-center justify-center hover:shadow-lg">
      <i data-lucide="menu" class="w-5 h-5"></i>
    </button>
  </div>

  <div id="search-popup"
      class="hidden fixed top-20 right-4 left-4 bg-white rounded-xl shadow-lg p-3 z-50">
    <input id="search-input"
          type="text"
          placeholder="Cari menu..."
          class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-green-300">
  </div>
  
    <!-- OVERLAY -->
  <div id="sidebar-backdrop"
       class="fixed inset-0 bg-black/40 z-40 hidden"></div>

  <!-- SIDEBAR -->
  <div id="sidebar"
       class="fixed inset-y-0 right-0 w-72 bg-green-900 text-white shadow-xl transform translate-x-full
              transition-transform duration-300 z-50 flex flex-col">

    <!-- HEADER SIDEBAR -->
    <div class="p-4 border-b border-green-700 flex items-center justify-between">
      <h3 class="font-bold text-lg tracking-wide">KOPI BOEDAJA</h3>
      <button id="close-sidebar"
              class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-green-800">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>

    <!-- BODY SIDEBAR -->
     <div class="p-4 flex flex-col gap-3">
      @auth
      <div class="flex items-center gap-2">
          <span class="text-green-200 text-sm">Halo,</span>
          <span class="font-semibold text-white truncate">
              {{ Auth::user()->name }}
          </span>
      </div>
      @else
          <a href="{{ route('login') }}"
            class="w-full py-2 px-3 rounded-lg bg-white text-green-900 font-semibold text-left hover:bg-gray-100">
              Masuk untuk info promo!
          </a>
      @endauth

      @if(auth('web')->check())
          <a href="{{ route('promo.index') }}"
            class="w-full py-2 px-3 rounded-lg border border-green-700 font-semibold text-left hover:bg-green-800">
              Lihat Promo
          </a>
      @else
          <a href="{{ route('login') }}"
            class="w-full py-2 px-3 rounded-lg border border-green-700 font-semibold text-left hover:bg-green-800">
              Lihat Promo
          </a>
      @endif



      @if(auth('web')->check())
          <a href="{{ route('pesanan.riwayat') }}"
            class="w-full py-2 px-3 rounded-lg border border-green-700 font-semibold text-left hover:bg-green-800">
              Riwayat Pesanan
          </a>
      @else
          <a href="{{ route('login') }}"
            class="w-full py-2 px-3 rounded-lg border border-green-700 font-semibold text-left hover:bg-green-800">
              Riwayat Pesanan
          </a>
      @endif


          {{-- LOGOUT (HANYA MUNCUL SAAT LOGIN) --}}
      @auth
       <div class="mt-6">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full py-2 px-3 rounded-lg bg-white text-green-900
                       hover:bg-gray-100 text-left text-sm">
                Logout
            </button>
          </form>
        </div>
      @endauth


    </div>
  </div>


  <div class="px-4 pt-6 max-w-7xl mx-auto">

    <!-- HEADER IMAGE -->
    <div class="w-full h-40 rounded-lg overflow-hidden mb-6 bg-gray-300">
      <img src="/cozy-coffee-shop.jpg" class="w-full h-full object-cover" />
    </div>

    <!-- STORE INFO -->
    <div class="sticky top-16 bg-gray-100 z-40 mb-6">
      <div class="bg-white border border-gray-300 rounded-3xl px-4 py-3 relative">

        <!-- TEXT CENTER -->
        <div class="text-center w-full pr-12">
          <h2 class="text-lg font-bold truncate">KOPI BOEDAJA</h2>
          <p class="text-gray-600 text-xs">Buka hari ini 09.00 - 21.00</p>
        </div>
      </div>
    </div>

    <!-- TABS + NOMOR MEJA -->
    <div class="sticky top-28 z-30 bg-gray-100 mb-6">
      <!-- PILIH TIPE PESANAN -->
      <div class="flex gap-2 mb-2">
        <button id="dineInBtn"
                class="flex-1 px-3 py-2 rounded-lg text-sm font-semibold bg-green-700 text-white">
          Makan di tempat
        </button>
        <button id="takeAwayBtn"
                class="flex-1 px-3 py-2 rounded-lg text-sm font-semibold bg-white text-green-700 border border-green-700">
          Bawa Pulang
        </button>
      </div>

      <!-- PILIH MEJA (hanya dipakai kalau makan di tempat) -->
      <button id="mejaButton"
              class="w-full bg-green-700 text-white py-2 px-4 rounded-lg text-center mb-4 font-bold text-sm">
        <span id="mejaLabel">Pilih Lantai & Nomor Meja</span>
      </button>

      <div class="flex items-center justify-center gap-3 overflow-x-auto pb-2">
        <button onclick="setTab('hot')" id="btn-hot" class="px-3 py-2 rounded-full font-semibold bg-gray-800 text-white">
          ☕ Hot Series
        </button>

        <button onclick="setTab('cold')" id="btn-cold" class="px-3 py-2 rounded-full font-semibold bg-white border text-gray-700">
          🧊 Cold Series
        </button>

        <button onclick="setTab('small')" id="btn-small" class="px-3 py-2 rounded-full font-semibold bg-white border text-gray-700">
          🍰 Small Bite
        </button>
      </div>
    </div>

    <!-- PRODUCT LIST -->
    <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-32"></div>

  </div>

  <!-- MODAL PILIH MEJA -->
  <div id="mejaModal"
      class="fixed inset-0 bg-black/40 z-40 hidden items-center justify-center">
    <div class="bg-white rounded-2xl p-4 w-full max-w-sm mx-4">
      <h3 class="font-semibold text-lg mb-3 text-gray-800">Pilih Meja</h3>

      <div class="mb-3">
        <label class="block text-sm mb-1 text-gray-700">Lantai</label>
        <select id="lantaiSelect"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
          <option value="1">Lantai 1</option>
          <option value="2">Lantai 2</option>
        </select>
      </div>

      <div class="mb-4">
        <label class="block text-sm mb-1 text-gray-700">Nomor Meja</label>
        <select id="mejaSelect"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
          <!-- diisi via JS -->
        </select>
      </div>

      <div class="flex justify-end gap-2">
        <button id="mejaCancel"
                class="px-3 py-1.5 text-sm rounded-lg text-gray-700 hover:bg-gray-100">
          Batal
        </button>
        <button id="mejaSave"
                class="px-3 py-1.5 text-sm rounded-lg bg-green-700 text-white font-semibold hover:bg-green-800">
          Simpan
        </button>
      </div>
    </div>
  </div>

  <!-- CHECKOUT FOOTER -->
  <div id="checkout-footer" class="fixed bottom-0 left-0 right-0 bg-blue-900 text-white py-3 px-4 border-t shadow-lg hidden">
    <div class="max-w-7xl mx-auto flex justify-between items-center gap-4">

      <div class="flex items-center gap-3 flex-1 min-w-0">
        <div class="relative">
          <i data-lucide="shopping-cart" class="w-8 h-8"></i>
          <span id="cart-count" class="absolute -top-2 -right-2 bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">
            0
          </span>
        </div>

        <div>
          <p class="text-blue-200 text-xs">Total</p>
          <p id="cart-total" class="text-lg font-bold">Rp0</p>
        </div>
      </div>

      <button id="checkout-btn"
              class="bg-white text-blue-900 px-6 py-2 rounded-lg font-bold hover:bg-gray-100">
        CHECK OUT
      </button>
    </div>
  </div>

  <!-- SCRIPT LOGIC -->
  <script>
    lucide.createIcons();

    // === PRODUCTS dari database (dikirim oleh controller sebagai $menus) ===
    // Format: [{id, name, price, image, kategori}, ...]
    // asset('storage/...') dibuat di server sehingga path absolute benar
    const products = {!! json_encode(
        $menus->map(function($m){
            return [
              'id' => (string)$m->id,
              'name' => $m->nama,
              'price' => (int)$m->harga,
              // asumsi gambarnya ada di storage/app/public/menus/
              'image' => $m->gambar_produk ? asset('storage/menus/'.$m->gambar_produk) : asset('images/placeholder.png'),
              'kategori' => $m->kategori ?? null
            ];
        })
    ) !!};

    // jika produk kosong, tampilkan pesan
    if (!products || products.length === 0) {
      document.getElementById('product-list').innerHTML = '<p class="text-gray-500">Tidak ada menu tersedia.</p>';
    }

    let cart = JSON.parse(localStorage.getItem('cart')) || {};
    let activeTab = "hot";

    function setTab(tab) {
      activeTab = tab;

      document.querySelectorAll("[id^=btn-]").forEach(btn => {
        btn.classList.remove("bg-gray-800", "text-white");
        btn.classList.add("bg-white", "text-gray-700", "border");
      });

      document.querySelector(`#btn-${tab}`).classList.remove("bg-white", "text-gray-700", "border");
      document.querySelector(`#btn-${tab}`).classList.add("bg-gray-800", "text-white");

      loadProducts(); // reload berdasarkan tab
    }

    function loadProducts() {
      const container = document.getElementById("product-list");
      container.innerHTML = "";

      // filter berdasarkan tab (kategori)
      const filtered = products.filter(p => {
        if (activeTab === 'hot') return p.kategori === 'hot';
        if (activeTab === 'cold') return p.kategori === 'cold';
        if (activeTab === 'small') return p.kategori === 'small_bites' || p.kategori === 'small-bites' || p.kategori === 'small';
        return true;
      });

      // jika tidak ada produk di tab tersebut
      if (filtered.length === 0) {
        container.innerHTML = '<p class="text-gray-500">Tidak ada menu pada kategori ini.</p>';
        return;
      }

      filtered.forEach(p => {
        const qty = cart[p.id] ? cart[p.id].quantity : 0;

        container.innerHTML += `
          <div class="menu-card bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-xl flex flex-col"
            data-name="${p.name.toLowerCase()}">
            <div class="h-40 bg-gray-200">
              <img src="${p.image}" class="w-full h-full object-cover" alt="${p.name}" />
            </div>

            <div class="p-4 flex flex-col flex-grow">
              <h3 class="text-lg font-bold mb-2">${p.name}</h3>
              <p class="text-lg font-bold text-green-700 mb-4">Rp${Number(p.price).toLocaleString('id-ID')}</p>

              ${qty === 0 ? `
                <button onclick="addToCart('${p.id}')" class="w-full border-2 border-green-700 text-green-700 py-2 rounded-full font-bold hover:bg-green-700 hover:text-white">
                  Tambahkan
                </button>
              ` : `
                <div class="flex items-center justify-center gap-3">
                  <button onclick="decrease('${p.id}')" class="w-10 h-10 border-2 border-gray-400 rounded-full flex items-center justify-center hover:bg-gray-400 hover:text-white">
                    <i data-lucide="minus"></i>
                  </button>

                  <span class="text-lg font-bold">${qty}</span>

                  <button onclick="increase('${p.id}')" class="w-10 h-10 border-2 border-gray-400 rounded-full flex items-center justify-center hover:bg-gray-400 hover:text-white">
                    <i data-lucide="plus"></i>
                  </button>
                </div>
              `}
            </div>
          </div>
        `;
      });

      lucide.createIcons();
    }

    function addToCart(id) {
      const product = products.find(p => p.id === id);
      cart[id] = { ...product, quantity: 1 };
      updateCart();
    }

    function increase(id) {
      cart[id].quantity++;
      updateCart();
    }

    function decrease(id) {
      cart[id].quantity--;
      if (cart[id].quantity <= 0) delete cart[id];
      updateCart();
    }

    function updateCart() {
      loadProducts();

      const totalItems = Object.values(cart).reduce((a, b) => a + b.quantity, 0);
      const totalPrice = Object.values(cart).reduce((a, b) => a + (b.price * b.quantity), 0);

      document.getElementById("cart-count").innerText = totalItems;
      document.getElementById("cart-total").innerText = "Rp" + totalPrice.toLocaleString('id-ID');

      document.getElementById("checkout-footer").style.display = totalItems > 0 ? "block" : "none";

      localStorage.setItem('cart', JSON.stringify(cart));
    }

    // load awal
    loadProducts();

    // === LOGIKA PILIH MEJA ===
    const mejaButton = document.getElementById("mejaButton");
    const mejaLabel  = document.getElementById("mejaLabel");
    const mejaModal  = document.getElementById("mejaModal");
    const lantaiSelect = document.getElementById("lantaiSelect");
    const mejaSelect   = document.getElementById("mejaSelect");
    const mejaCancel   = document.getElementById("mejaCancel");
    const mejaSave     = document.getElementById("mejaSave");

    // isi pilihan meja 1..30
    for (let i = 1; i <= 30; i++) {
      const opt = document.createElement("option");
      opt.value = i;
      opt.textContent = `Meja ${i}`;
      mejaSelect.appendChild(opt);
    }

    // load dari localStorage kalau sudah pernah pilih
    const savedMeja = localStorage.getItem("kopi_boedaja_meja");
    if (savedMeja) {
      try {
        const data = JSON.parse(savedMeja);
        if (data.lantai) lantaiSelect.value = data.lantai;
        if (data.meja) mejaSelect.value = data.meja;
        mejaLabel.textContent = `Nomor Meja: Lantai ${data.lantai} - ${data.meja}`;
      } catch (e) {
        console.error(e);
      }
    }

    // buka modal
    if (mejaButton) {
      mejaButton.addEventListener("click", () => {
        mejaModal.classList.remove("hidden");
        mejaModal.classList.add("flex");
      });
    }

    // tutup modal tanpa simpan
    if (mejaCancel) {
      mejaCancel.addEventListener("click", () => {
        mejaModal.classList.add("hidden");
        mejaModal.classList.remove("flex");
      });
    }

    // simpan pilihan
    if (mejaSave) {
      mejaSave.addEventListener("click", () => {
        const lantai = lantaiSelect.value;
        const meja   = mejaSelect.value;

        mejaLabel.textContent = `Nomor Meja: Lantai ${lantai} - ${meja}`;

        // simpan ke localStorage supaya keingat kalau buka lagi
        localStorage.setItem(
          "kopi_boedaja_meja",
          JSON.stringify({ lantai, meja })
        );

        mejaModal.classList.add("hidden");
        mejaModal.classList.remove("flex");
      });
    }

    // === TIPE PESANAN: MAKAN DI TEMPAT / TAKE AWAY ===
    let orderType = localStorage.getItem('kopi_boedaja_order_type') || 'dine_in';

    const dineInBtn   = document.getElementById('dineInBtn');
    const takeAwayBtn = document.getElementById('takeAwayBtn');
    const mejaBtn     = document.getElementById('mejaButton');

    function syncOrderTypeButtons() {
      if (!dineInBtn || !takeAwayBtn) return;

      if (orderType === 'dine_in') {
        dineInBtn.classList.add('bg-green-700','text-white');
        dineInBtn.classList.remove('bg-white','text-green-700','border','border-green-700');

        takeAwayBtn.classList.add('bg-white','text-green-700','border','border-green-700');
        takeAwayBtn.classList.remove('bg-green-700','text-white');

        if (mejaBtn) {
          mejaBtn.disabled = false;
          mejaBtn.classList.remove('opacity-60','cursor-not-allowed');
        }
      } else {
        // take away
        takeAwayBtn.classList.add('bg-green-700','text-white');
        takeAwayBtn.classList.remove('bg-white','text-green-700','border','border-green-700');

        dineInBtn.classList.add('bg-white','text-green-700','border','border-green-700');
        dineInBtn.classList.remove('bg-green-700','text-white');

        if (mejaBtn) {
          mejaBtn.disabled = true;
          mejaBtn.classList.add('opacity-60','cursor-not-allowed');
        }
      }
    }

    if (dineInBtn) {
      dineInBtn.addEventListener('click', () => {
        orderType = 'dine_in';
        localStorage.setItem('kopi_boedaja_order_type', orderType);
        syncOrderTypeButtons();
      });
    }

    if (takeAwayBtn) {
      takeAwayBtn.addEventListener('click', () => {
        orderType = 'take_away';
        localStorage.setItem('kopi_boedaja_order_type', orderType);
        syncOrderTypeButtons();
      });
    }

    // panggil sekali saat load
    syncOrderTypeButtons();

    const checkoutBtn = document.getElementById('checkout-btn');
    const checkoutUrl = "{{ route('RincianPesanan') }}";

    if (checkoutBtn) {
      checkoutBtn.addEventListener('click', () => {
        const totalItems = Object.values(cart).reduce((a, b) => a + b.quantity, 0);
        if (totalItems === 0) {
          return; // harusnya tombolnya gak muncul kalau 0, tapi jaga-jaga
        }

        if (orderType === 'dine_in') {
          const mejaData = localStorage.getItem('kopi_boedaja_meja');
          if (!mejaData) {
            alert('Silakan pilih lantai & nomor meja terlebih dahulu.');
            document.getElementById('mejaButton')
                    .scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
          }
        }

        // simpan tipe pesanan (kalau halaman rincian butuh)
        localStorage.setItem('kopi_boedaja_order_type', orderType);

        // lanjut ke halaman rincian pesanan
        window.location.href = checkoutUrl;
      });
    }


        // === SIDEBAR LOGIC ===
    const sidebar = document.getElementById("sidebar");
    const sidebarBackdrop = document.getElementById("sidebar-backdrop");
    const openSidebarBtn = document.getElementById("open-sidebar");
    const closeSidebarBtn = document.getElementById("close-sidebar");

    function openSidebar() {
      sidebar.classList.remove("translate-x-full");
      sidebarBackdrop.classList.remove("hidden");
    }

    function closeSidebar() {
      sidebar.classList.add("translate-x-full");
      sidebarBackdrop.classList.add("hidden");
    }

    openSidebarBtn.addEventListener("click", () => {
      openSidebar();
      lucide.createIcons(); // pastikan icon "x" kebaca
    });

    closeSidebarBtn.addEventListener("click", closeSidebar);
    sidebarBackdrop.addEventListener("click", closeSidebar);
  </script>

  <script>
    const searchBtn = document.getElementById("menu-search-btn");
    const searchPopup = document.getElementById("search-popup");
    const searchInput = document.getElementById("search-input");

    searchBtn.addEventListener("click", () => {
      searchPopup.classList.toggle("hidden");
      searchInput.focus();
    });

    searchInput.addEventListener("input", function () {
      const keyword = this.value.toLowerCase();
      const cards = document.querySelectorAll(".menu-card");

      cards.forEach(card => {
        const name = card.dataset.name;
        card.style.display = name.includes(keyword) ? "flex" : "none";
      });
    });
  </script>

  

</body>
</html>

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
    <button class="w-10 h-10 rounded-full bg-white shadow flex items-center justify-center hover:shadow-lg"> 
      <i data-lucide="search" class="w-5 h-5"></i> 
    </button>
    <button id="open-sidebar"
            class="w-10 h-10 rounded-full bg-white shadow flex items-center justify-center hover:shadow-lg">
      <i data-lucide="menu" class="w-5 h-5"></i>
    </button>
  </div>
  
    <!-- OVERLAY -->
  <div id="sidebar-backdrop"
       class="fixed inset-0 bg-black/40 z-40 hidden"></div>

  <!-- SIDEBAR -->
  <div id="sidebar"
       class="fixed inset-y-0 right-0 w-72 bg-white shadow-xl transform translate-x-full
              transition-transform duration-300 z-50 flex flex-col">

    <!-- HEADER SIDEBAR -->
    <div class="p-4 border-b flex items-center justify-between">
      <h3 class="font-bold text-lg">Menu</h3>
      <button id="close-sidebar"
              class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-100">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>

    <!-- BODY SIDEBAR -->
    <div class="p-4 flex flex-col gap-3">
      <a href="{{ route('login') }}"
         class="w-full py-2 px-3 rounded-lg border font-semibold text-left hover:bg-gray-50">
        Login
      </a>

      <a href="{{ route('register') }}"
         class="w-full py-2 px-3 rounded-lg border font-semibold text-left hover:bg-gray-50">
        Sign Up
      </a>

      <a href="{{ route('promo.index') }}"
         class="w-full py-2 px-3 rounded-lg border font-semibold text-left hover:bg-gray-50">
        Lihat Promo
      </a>
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
          <p class="text-gray-600 text-xs">Buka hari ini 00.00 - 23.59</p>
        </div>
      </div>
    </div>

    <!-- TABS + NOMOR MEJA -->
    <div class="sticky top-28 z-30 bg-gray-100 mb-6">
      <div class="bg-green-700 text-white py-2 px-4 rounded-lg text-center mb-4 font-bold text-sm">
        Nomor Meja: Lantai 1 - 28
      </div>

      <div class="flex items-center gap-3 overflow-x-auto pb-2">
        <button class="text-gray-700 min-w-[40px] hover:text-gray-900">
          <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        <div class="border-r border-gray-400 h-6"></div>

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

      <a href="{{ route('RincianPesanan') }}" >
        <button class="bg-white text-blue-900 px-6 py-2 rounded-lg font-bold hover:bg-gray-100">
          CHECK OUT
        </button>
      </a>
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

    let cart = {};
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
          <div class="bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-xl flex flex-col">
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

  

</body>
</html>

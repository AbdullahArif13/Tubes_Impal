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
        <a href="{{ url()->previous() }}" class="p-2 hover:bg-gray-100 rounded-lg transition flex-shrink-0">
            <!-- ChevronLeft Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-lg sm:text-xl font-bold flex-1 text-center">Pembayaran</h1>
        <div class="w-8"></div>
    </div>

    <form action="{{ route('Pembayaran.submit') }}" method="POST" class="px-4 sm:px-6 lg:px-8 py-6 max-w-2xl mx-auto">
        @csrf
        
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

        <!-- Informasi Pemesan -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 mb-6">
            <h2 class="text-base sm:text-lg font-bold mb-6">Informasi Pemesan</h2>

            <!-- Nama Lengkap -->
            <div class="mb-6">
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                    Nama Lengkap<span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-3 bg-gray-100 rounded-lg px-4 py-3 border border-gray-300">
                    <input 
                        type="text" 
                        name="fullName" 
                        placeholder="Hanif Haidar"
                        class="bg-transparent flex-1 outline-none text-sm sm:text-base text-gray-800"
                        required
                    >
                </div>
            </div>

            <!-- Nomor Ponsel -->
            <div class="mb-6">
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                    Nomor Ponsel <span class="text-gray-400 text-xs">(untuk info promo)</span>
                </label>
                <div class="flex items-center gap-3 bg-gray-100 rounded-lg px-4 py-3 border border-gray-300">
                    <input 
                        type="tel" 
                        name="phone"
                        placeholder="0812-3456-7890"
                        class="bg-transparent flex-1 outline-none text-sm sm:text-base text-gray-800"
                        required
                    >
                </div>
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                    Kirim struk ke email
                </label>
                <div class="flex items-center gap-3 bg-gray-100 rounded-lg px-4 py-3 border border-gray-300">
                    <input 
                        type="email" 
                        name="email"
                        placeholder="adakahseratus@gmail.com"
                        class="bg-transparent flex-1 outline-none text-sm sm:text-base text-gray-800"
                    >
                </div>
            </div>

            <!-- Nomor Meja -->
            <div class="mb-6">
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                    Nomor Meja<span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-3 bg-gray-100 rounded-lg px-4 py-3 border border-gray-300">
                    <input 
                        type="text" 
                        name="tableNumber"
                        placeholder="Lantai 1 - 28"
                        class="bg-transparent flex-1 outline-none text-sm sm:text-base text-gray-800"
                        required
                    >
                </div>
            </div>
        </div>

        <!-- Total + Button -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 sm:px-6 lg:px-8 py-4">
            <div class="max-w-2xl mx-auto">
                <div class="mb-2">
                    <p class="text-gray-600 text-xs sm:text-sm">Total Pembayaran</p>
                    <p class="text-xl sm:text-2xl font-bold">Rp{{ number_format($total ?? 0) }}</p>
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
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Promo - Kopi Boedaja</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-xl">
        <h1 class="text-2xl font-bold mb-4 text-center">Promo Kopi Boedaja</h1>
        <p class="text-center text-gray-500">
            Belum ada promo saat ini. 😄  
            (Nanti bisa diisi list promo dalam bentuk card.)
        </p>

        <div class="mt-6 text-center">
            <a href="{{ route('menu') }}"
               class="text-blue-600 hover:underline">
                ← Kembali ke menu
            </a>
        </div>
    </div>
</body>
</html>

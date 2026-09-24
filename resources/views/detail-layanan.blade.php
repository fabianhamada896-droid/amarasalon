<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Layanan - Amara Salon & Dekor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-white shadow p-4 flex justify-between items-center px-8">
        <h1 class="text-2xl font-bold text-pink-600">AMARA SALON & DEKOR</h1>
        <nav class="space-x-6 font-medium">
            <a href="{{ route('home') }}" class="hover:text-pink-600">Beranda</a>
            <a href="{{ route('layanan.index') }}" class="hover:text-pink-600">Layanan</a>
        </nav>
    </header>

    <main class="container mx-auto p-8 max-w-2xl">
        <div class="bg-white rounded-xl shadow-md p-8 border border-gray-100">
            <span class="text-xs font-semibold bg-pink-100 text-pink-600 px-3 py-1 rounded-full uppercase">{{ $layanan->kategori }}</span>
            <h2 class="text-3xl font-bold mt-4 mb-2">{{ $layanan->nama_layanan }}</h2>
            <p class="text-pink-600 font-bold text-2xl mb-6">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</p>
            
            <div class="border-t border-b py-4 my-4 space-y-2">
                <p class="text-gray-700"><strong>Estimasi Durasi:</strong> {{ $layanan->durasi }} Menit</p>
                <p class="text-gray-700"><strong>Deskripsi:</strong></p>
                <p class="text-gray-600 leading-relaxed">{{ $layanan->deskripsi }}</p>
            </div>

            <div class="flex justify-between items-center mt-8">
                <a href="{{ route('layanan.index') }}" class="text-gray-600 hover:underline">← Kembali ke Daftar Layanan</a>
                <button class="bg-pink-600 hover:bg-pink-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                    Booking Layanan Ini
                </button>
            </div>
        </div>
    </main>
</body>
</html>
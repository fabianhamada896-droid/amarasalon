<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Layanan - Amara Salon & Dekor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
   <!-- Navbar dengan Tombol Back di Sebelah Kiri Logo -->
<header class="bg-white shadow p-4 flex justify-between items-center px-8">
    <div class="flex items-center space-x-4">
        <!-- Tombol Back / Panah Kembali -->
        <a href="javascript:history.back()" class="text-gray-600 hover:text-pink-600 transition p-1 rounded-full hover:bg-gray-100" title="Kembali">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <!-- Logo Brand -->
        <h1 class="text-2xl font-bold text-pink-600">AMARA SALON & DEKOR</h1>
    </div>

    <!-- Menu Kanan -->
    <nav class="flex items-center space-x-6 font-medium">
        <div class="space-x-6">
            <a href="{{ route('home') }}" class="hover:text-pink-600">Beranda</a>
            <a href="{{ route('layanan.index') }}" class="hover:text-pink-600">Layanan</a>
            <a href="{{ route('dekorasi.index') }}" class="hover:text-pink-600">Dekorasi</a>
        </div>
        <a href="{{ route('login') }}" class="border border-pink-600 text-pink-600 hover:bg-pink-50 px-4 py-1.5 rounded-lg text-sm font-semibold transition">
            Login
        </a>
    </nav>
</header>

    <!-- Konten Detail Layanan -->
    <main class="container mx-auto px-8 py-10 max-w-4xl">
        
        <!-- Tombol Kembali -->
        <div class="mb-6">
            <a href="{{ route('layanan.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-pink-600 transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Layanan
            </a>
        </div>

        <!-- Kartu Detail -->
        <div class="bg-white rounded-3xl shadow-md overflow-hidden border border-gray-100">
            
            {{-- FOTO UTAMA UKURAN BESAR --}}
            @if($layanan->foto)
                <div class="w-full h-80 bg-gray-100 overflow-hidden">
                    <img src="{{ asset('storage/' . $layanan->foto) }}" alt="{{ $layanan->nama_layanan }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-full h-80 bg-gray-100 flex items-center justify-center text-gray-400 text-base font-medium">
                    Tidak Ada Foto Tersedia
                </div>
            @endif

            <div class="p-8 sm:p-10">
                <span class="inline-block bg-pink-100 text-pink-600 text-xs font-bold px-3 py-1 rounded-full uppercase mb-4">
                    {{ $layanan->kategori }}
                </span>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">{{ $layanan->nama_layanan }}</h2>
                <p class="text-gray-600 text-base leading-relaxed mb-6">{{ $layanan->deskripsi }}</p>

                <div class="flex items-center justify-between border-t border-gray-100 pt-6">
                    <div>
                        <span class="text-xs text-gray-500 block">Harga Layanan</span>
                        <span class="text-2xl font-bold text-pink-600">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 block">Estimasi Durasi</span>
                        <span class="text-lg font-semibold text-gray-800">{{ $layanan->durasi }} Menit</span>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('booking.create', $layanan->id_layanan) }}" class="block w-full text-center bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3.5 rounded-xl transition shadow">
                        Booking Layanan Ini
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
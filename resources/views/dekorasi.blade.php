<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Dekorasi - Amara Salon & Dekor</title>
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
        <a href="#" class="border border-pink-600 text-pink-600 hover:bg-pink-50 px-4 py-1.5 rounded-lg text-sm font-semibold transition">
            Login
        </a>
    </nav>
</header>

    <!-- Konten Utama Dekorasi -->
    <main class="container mx-auto px-6 py-12">
        <!-- Header Section -->
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Katalog Dekorasi Pilihan</h2>
            <p class="text-lg text-gray-600 leading-relaxed">Wujudkan konsep acara dan pernikahan impian Anda bersama koleksi dekorasi terbaik kami.</p>
        </div>

        <!-- Grid Katalog Dekorasi -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($dekorasis as $dekorasi)
            <div class="bg-white rounded-3xl shadow-lg p-8 flex flex-col justify-between border border-gray-50 hover:border-pink-100 transition-all duration-300 group">
                <div>
                    <!-- Badge Jenis Dekorasi -->
                    <div class="inline-block bg-pink-50 text-pink-600 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider mb-6">
                        {{ $dekorasi->jenis_dekorasi }}
                    </div>
                    <!-- Nama Paket -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-pink-700 transition-colors">
                        {{ $dekorasi->nama_paket }}
                    </h3>
                    <!-- Deskripsi -->
                    <p class="text-gray-600 text-base leading-relaxed mb-8 line-clamp-3">
                        {{ $dekorasi->deskripsi }}
                    </p>
                </div>
                
                <div>
                    <!-- Harga -->
                    <div class="flex items-end justify-between mb-8">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 font-medium mb-0.5">Mulai dari</span>
                            <span class="text-3xl font-extrabold text-pink-600 tracking-tight">
                                Rp {{ number_format($dekorasi->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                   <a href="{{ route('booking.create', $dekorasi->id_dekorasi) }}?type=dekorasi" class="bg-pink-600 text-white px-4 py-2 rounded-xl">
                        Pesan Dekorasi Ini
                    </a>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 mt-24 py-10 text-center text-sm text-gray-500">
        <div class="container mx-auto px-6">
            &copy; 2026 Amara Salon & Dekor. All rights reserved.
        </div>
    </footer>
</body>
</html>
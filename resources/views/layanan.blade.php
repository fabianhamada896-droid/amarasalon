<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Layanan - Amara Salon & Dekor</title>
    <!-- Menggunakan CDN Tailwind, pastikan versi terbaru -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Jika menggunakan font kustom, import di sini -->
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <!-- Navbar -->
    <header class="bg-white sticky top-0 z-50 border-b border-gray-100 shadow-sm">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-pink-600 tracking-tight">AMARA<span class="text-pink-400">.</span></a>
            <div class="space-x-8 font-medium text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-pink-600 transition">Beranda</a>
                <a href="{{ route('layanan.index') }}" class="text-pink-600 font-semibold">Layanan</a>
                <a href="{{ route('dekorasi.index') }}" class="hover:text-pink-600 transition">Dekorasi</a>
                <a href="#kontak" class="hover:text-pink-600 transition">Kontak</a>
            </div>
            <a href="#" class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-2.5 rounded-full font-semibold text-sm transition duration-200">
                Booking Sekarang
            </a>
        </nav>
    </header>

    <!-- Konten Utama Layanan -->
    <main class="container mx-auto px-6 py-12">
        <!-- Header Section -->
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">Daftar Layanan Kami</h2>
            <p class="text-lg text-gray-600 leading-relaxed">Pilih perawatan kecantikan terbaik dari tim profesional kami untuk mempercantik setiap momen spesial Anda.</p>
        </div>

        <!-- Grid Layanan (Card List) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($layanans as $layanan)
            <div class="bg-white rounded-3xl shadow-lg p-8 flex flex-col justify-between border border-gray-50 hover:border-pink-100 transition-all duration-300 group">
                <!-- Bagian Atas Card -->
                <div>
                    <!-- Kategori (Label) -->
                    <div class="inline-block bg-pink-50 text-pink-600 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider mb-6">
                        {{ $layanan->kategori }}
                    </div>
                    <!-- Judul Layanan -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-pink-700 transition-colors">
                        {{ $layanan->nama_layanan }}
                    </h3>
                    <!-- Deskripsi Singkat -->
                    <p class="text-gray-600 text-base leading-relaxed mb-8 line-clamp-3">
                        {{ $layanan->deskripsi }}
                    </p>
                </div>
                
                <!-- Bagian Bawah Card (Harga & Tombol) -->
                <div>
                    <div class="flex items-end justify-between mb-8">
                        <!-- Harga -->
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 font-medium mb-0.5">Mulai dari</span>
                            <span class="text-3xl font-extrabold text-pink-600 tracking-tight">
                                Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                            </span>
                        </div>
                        <!-- Durasi -->
                        <div class="flex items-center gap-2 text-sm text-gray-500 bg-gray-100/60 px-4 py-2 rounded-full">
                            <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-medium">{{ $layanan->durasi }} <span class="font-normal text-gray-500">Menit</span></span>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <a href="{{ route('layanan.detail', $layanan->id_layanan) }}" class="block w-full text-center bg-pink-600 hover:bg-pink-700 text-white font-semibold py-4 px-6 rounded-2xl transition duration-200 transform group-hover:-translate-y-0.5 shadow-md group-hover:shadow-pink-200/50">
                        Lihat Detail & Pesan
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <!-- Footer Sederhana -->
    <footer class="bg-gray-100 mt-24 py-10 text-center text-sm text-gray-500">
        <div class="container mx-auto px-6">
            &copy; 2026 Amara Salon & Dekor. All rights reserved.
        </div>
    </footer>
</body>
</html>
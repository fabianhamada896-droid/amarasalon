<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pemesanan - Amara Salon & Dekor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <!-- Navbar dengan Tombol Back di Sebelah Kiri Logo -->
    <header class="bg-white shadow p-4 flex justify-between items-center px-8">
        <div class="flex items-center space-x-4">
            <a href="javascript:history.back()" class="text-gray-600 hover:text-pink-600 transition p-1 rounded-full hover:bg-gray-100" title="Kembali">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-pink-600">AMARA SALON & DEKOR</h1>
        </div>
        <nav class="flex items-center space-x-6 font-medium">
            <div class="space-x-6">
                <a href="{{ route('home') }}" class="hover:text-pink-600">Beranda</a>
                <a href="{{ route('layanan.index') }}" class="hover:text-pink-600">Layanan</a>
                <a href="{{ route('dekorasi.index') }}" class="hover:text-pink-600">Dekorasi</a>
            </div>
        </nav>
    </header>

    <!-- Konten Utama Detail & Form Booking -->
    <main class="container mx-auto px-6 py-10 max-w-2xl">
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-50">
            
            <!-- Bagian Foto (Mirip Detail Layanan) -->
            @if($item->foto)
                <div class="w-full h-72 bg-gray-100 overflow-hidden">
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_item }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="w-full h-72 bg-gray-100 flex items-center justify-center text-gray-400 font-medium">
                    Tidak Ada Foto Tersedia
                </div>
            @endif

            <!-- Konten Detail & Form -->
            <div class="p-8">
                <!-- Badge Kategori -->
                <div class="inline-block bg-pink-50 text-pink-600 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-4">
                    {{ $item->kategori_item }}
                </div>

                <!-- Nama Item -->
                <h2 class="text-3xl font-extrabold text-gray-900 mb-2">
                    {{ $item->nama_item }}
                </h2>

                <!-- Deskripsi (Opsional, kalau datanya ada di controller) -->
                @if(isset($item->deskripsi))
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        {{ $item->deskripsi }}
                    </p>
                @else
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Silakan lengkapi formulir tanggal dan catatan di bawah untuk melanjutkan pemesanan paket ini.
                    </p>
                @endif

                <!-- Harga -->
                <div class="flex items-center justify-between py-4 border-t border-b border-gray-100 mb-8">
                    <div>
                        <span class="text-xs text-gray-400 font-medium block">Total Harga</span>
                        <span class="text-2xl font-extrabold text-pink-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Form Input Booking -->
                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    <!-- Mengirim ID item umum dan Tipe ke Controller -->
                    <input type="hidden" name="id_item" value="{{ $item->id_dekorasi ?? $item->id_layanan }}">
                    <input type="hidden" name="tipe" value="{{ $tipe }}">

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal & Waktu Acara</label>
                        <input type="date" name="tanggal_acara" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-pink-600 transition">
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea name="catatan" rows="4" placeholder="Tuliskan catatan khusus untuk pesanan Anda..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-pink-600 transition"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-4 px-6 rounded-2xl transition duration-200 shadow-md shadow-pink-200">
                        Konfirmasi & Kirim Pesanan
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
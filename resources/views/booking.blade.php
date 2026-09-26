<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Booking - Amara Salon & Dekor</title>
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

    <!-- Konten Form Booking -->
    <main class="container mx-auto px-8 py-10 max-w-2xl">
        <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-50">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Formulir Pemesanan</h2>
            <p class="text-gray-600 mb-8">Lengkapi detail di bawah ini untuk memesan pilihan Anda.</p>

            <!-- Ringkasan Item (Sudah disamakan jadi $item->nama_item dan $item->kategori_item di Controller) -->
            <div class="bg-pink-50 rounded-2xl p-6 mb-8 border border-pink-100">
                <span class="text-xs bg-pink-200 text-pink-700 font-bold px-3 py-1 rounded-full uppercase">
                    {{ $item->kategori_item }}
                </span>
                <h3 class="text-xl font-bold text-gray-900 mt-3 mb-1">
                    {{ $item->nama_item }}
                </h3>
                <p class="text-pink-600 font-extrabold text-lg">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
            </div>

            <!-- Form Input -->
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
    </main>
</body>
</html>
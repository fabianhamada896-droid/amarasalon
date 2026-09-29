<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Amara Salon & Dekor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    <!-- Header / Navbar -->
    <header class="bg-white shadow p-4 flex justify-between items-center px-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-pink-600 transition p-1 rounded-full hover:bg-gray-100" title="Kembali ke Beranda">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-pink-600">AMARA SALON & DEKOR</h1>
        </div>
        <nav class="flex items-center space-x-6 font-medium">
            <a href="{{ route('home') }}" class="hover:text-pink-600">Beranda</a>
            <a href="{{ route('layanan.index') }}" class="hover:text-pink-600">Layanan</a>
            <a href="{{ route('dekorasi.index') }}" class="hover:text-pink-600">Dekorasi</a>
            <a href="{{ route('booking.riwayat') }}" class="text-pink-600 font-bold">Riwayat Pesanan</a>
        </nav>
    </header>

    <!-- Content -->
    <main class="container mx-auto px-8 py-10 max-w-4xl">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Riwayat Pesanan Anda</h2>
        <p class="text-gray-600 mb-8">Daftar pesanan layanan salon dan dekorasi yang telah Anda buat.</p>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($bookings->isEmpty())
            <div class="bg-white rounded-3xl shadow-lg p-12 text-center border border-gray-100">
                <h3 class="text-lg font-bold text-gray-700 mb-1">Belum ada pesanan</h3>
                <p class="text-gray-500 mb-6">Yuk, mulai pesan layanan salon atau dekorasi impianmu!</p>
                <a href="{{ route('home') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-semibold px-6 py-3 rounded-xl transition">
                    Jelajahi Katalog
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($bookings as $b)
                    <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <div class="flex items-center space-x-3 mb-2">
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-pink-100 text-pink-700 uppercase">
                                    {{ $b->kode_booking }}
                                </span>
                                @if($b->status_booking == 'Menunggu')
                                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">Menunggu Konfirmasi</span>
                                @elseif($b->status_booking == 'Dikonfirmasi')
                                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-blue-100 text-blue-700">Dikonfirmasi</span>
                                @else
                                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-green-100 text-green-700">{{ $b->status_booking }}</span>
                                @endif
                            </div>
                            
                            <p class="text-sm text-gray-500 mb-1">📅 Tanggal Acara: <span class="font-semibold text-gray-800">{{ date('d M Y', strtotime($b->tanggal_booking)) }}</span></p>
                            <p class="text-sm text-gray-500 mb-2">📝 Catatan: <span class="italic text-gray-700">{{ $b->catatan ?: 'Tidak ada catatan' }}</span></p>
                            
                            <p class="text-pink-600 font-extrabold text-lg">Rp {{ number_format($b->total_harga, 0, ',', '.') }}</p>
                        </div>

                        <!-- Kolom Upload / Status Bukti Transfer -->
                        <div class="w-full md:w-64">
                            @if($b->pembayarans->isNotEmpty())
                                @php
                                    $pembayaranTerakhir = $b->pembayarans->last();
                                @endphp
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 text-center">
                                    <span class="text-xs text-gray-500 block mb-1">Status Pembayaran:</span>
                                    @if($pembayaranTerakhir->status_pembayaran == 'Pending')
                                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 block">Bukti Diterima (Pending)</span>
                                    @elseif($pembayaranTerakhir->status_pembayaran == 'Valid')
                                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-green-100 text-green-800 block">Pembayaran Valid</span>
                                    @else
                                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-red-100 text-red-800 block">Ditolak</span>
                                    @endif
                                </div>
                            @else
                                <form action="{{ route('booking.uploadPembayaran', $b->id_booking) }}" method="POST" enctype="multipart/form-data" class="bg-pink-50/50 p-3 rounded-2xl border border-pink-100">
                                    @csrf
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Upload Bukti Transfer</label>
                                    <input type="file" name="bukti_pembayaran" required class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-pink-600 file:text-white hover:file:bg-pink-700 mb-2 cursor-pointer">
                                    <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold text-xs py-2 rounded-xl transition">
                                        Kirim Bukti
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amara Salon & Dekor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-pink-600">AMARA SALON & DEKOR</h1>
        <nav class="space-x-4">
            <a href="{{ route('home') }}" class="hover:text-pink-600">Beranda</a>
            <a href="{{ route('layanan.index') }}" class="hover:text-pink-600">Layanan</a>
            <a href="{{ route('dekorasi.index') }}" class="hover:text-pink-600">Dekorasi</a>
            <a href="{{ route('booking.riwayat') }}" class="hover:text-pink-600">Riwayat Pesanan</a>
            @guest
                <!-- Tampil jika belum login -->
                <a href="{{ route('login') }}" class="border border-pink-600 text-pink-600 hover:bg-pink-50 px-4 py-1.5 rounded-lg text-sm font-semibold transition">
                    Login
                </a>
            @endguest

            @auth
                <!-- Tampil jika sudah login -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-1.5 rounded-lg text-sm font-semibold transition">
                        Logout ({{ Auth::user()->name }})
                    </button>
                </form>
            @endauth        
        </nav>
    </header>

    <main class="container mx-auto p-6 text-center my-12">
        <h2 class="text-4xl font-extrabold mb-4">Make Your Special Moment More Beautiful</h2>
        <p class="text-lg text-gray-600 mb-8">Salon & Dekorasi untuk setiap momen berharga Anda.</p>
        <a href="{{ route('layanan.index') }}" class="bg-pink-600 text-white px-6 py-3 rounded-xl font-semibold text-lg shadow-lg">Booking Sekarang</a>
    </main>
</body>
</html>
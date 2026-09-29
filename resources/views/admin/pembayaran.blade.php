<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pembayaran - Admin Amara Salon</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">
    <div class="min-h-screen flex flex-col">
        <!-- Header / Navbar Admin -->
        <header class="bg-white shadow px-8 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-pink-600">Admin - Amara Salon & Dekor</h1>
            <nav class="space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-pink-600">Dashboard</a>
                <a href="{{ route('admin.pembayaran.index') }}" class="hover:text-pink-600">Verifikasi Pembayaran</a>
                <a href="{{ route('home') }}" class="hover:text-pink-600">Lihat Website</a>
                <a href="{{ route('admin.katalog.index') }}" class="hover:text-pink-600">Kelola Katalog</a>
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

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-8 flex-1">
            <h2 class="text-2xl font-bold mb-2">Daftar Pembayaran Masuk</h2>
            <p class="text-gray-600 mb-6">Periksa bukti transfer dari pelanggan dan konfirmasi status pembayarannya.</p>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs text-gray-500 uppercase tracking-wider">
                            <th class="p-4">Kode Booking</th>
                            <th class="p-4">Tanggal Bayar</th>
                            <th class="p-4">Jumlah Bayar</th>
                            <th class="p-4">Bukti Transfer</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($pembayarans as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-pink-600">
                                    {{ $p->booking->kode_booking ?? '-' }}
                                </td>
                                <td class="p-4 text-gray-600">
                                    {{ date('d M Y H:i', strtotime($p->tanggal_bayar)) }}
                                </td>
                                <td class="p-4 font-semibold">
                                    Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                </td>
                                <td class="p-4">
                                    @if($p->bukti_pembayaran)
                                       <a href="{{ Storage::url('bukti_pembayaran/' . $p->bukti_pembayaran) }}" target="_blank" class="inline-flex items-center text-pink-600 hover:underline font-semibold">
                                            🔍 Lihat Foto
                                        </a>
                                    @else
                                        <span class="text-gray-400">Tidak ada file</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if($p->status_pembayaran == 'Pending')
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($p->status_pembayaran == 'Valid')
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">Valid</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    @if($p->status_pembayaran == 'Pending')
                                        <div class="flex justify-center space-x-2">
                                            <!-- Form Setujui -->
                                            <form action="{{ route('admin.pembayaran.verifikasi', $p->id_pembayaran) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="Valid">
                                                <button type="submit" onclick="return confirm('Konfirmasi pembayaran ini valid?')" class="bg-green-600 hover:bg-green-700 text-white font-bold px-3 py-1.5 rounded-lg text-xs transition">
                                                     Terima (Valid)
                                                </button>
                                            </form>

                                            <!-- Form Tolak -->
                                            <form action="{{ route('admin.pembayaran.verifikasi', $p->id_pembayaran) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" onclick="return confirm('Tolak pembayaran ini?')" class="bg-red-600 hover:bg-red-700 text-white font-bold px-3 py-1.5 rounded-lg text-xs transition">
                                                     Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Selesai Diverifikasi</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-500">
                                    Belum ada data pembayaran yang masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
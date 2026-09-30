<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Katalog - Amara Salon & Decoration</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
     <header class="bg-white shadow px-8 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-pink-600">Admin - Amara Salon & Dekor</h1>
            <nav class="space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-pink-600">Dashboard</a>
                <a href="{{ route('admin.pembayaran.index') }}" class="hover:text-pink-600">Verifikasi Pembayaran</a>
                <a href="{{ route('home') }}" class="hover:text-pink-600">Lihat Website</a>
                <a href="{{ route('admin.katalog.index') }}" class="hover:text-pink-600">Kelola Katalog</a>
            </nav>
        </header>

<div class="container mx-auto px-6 py-8 flex-1">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Kelola Katalog (Layanan & Dekorasi)</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Layout Utama: Dibagi 2 Kolom (Kiri: Layanan, Kanan: Dekorasi) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- ================= KOLOM KIRI: LAYANAN ================= --}}
        <div class="space-y-6">
            {{-- Form Tambah Layanan --}}
            <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-pink-600 mb-4">➕ Tambah Layanan Baru</h3>
                {{-- PASTIKAN ENCTYPE ADA DI SINI --}}
                <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Layanan</label>
                        <input type="text" name="nama_layanan" placeholder="Contoh: Makeup Pengantin" required class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Kategori</label>
                        <input type="text" name="kategori" placeholder="Contoh: Salon / Perawatan" required class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" placeholder="Contoh: 1500000" min="0" required class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Durasi (Menit)</label>
                        <input type="number" name="durasi" placeholder="Contoh: 90" min="0" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Foto Layanan</label>
                        <input type="file" name="foto" accept="image/*" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500 bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2 rounded-xl transition text-sm">Simpan Layanan</button>
                </form>
            </div>

            {{-- Daftar Layanan Salon --}}
            <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Layanan Salon</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="border-b text-gray-500">
                                <th class="py-2 px-3">Foto</th>
                                <th class="py-2 px-3">Nama</th>
                                <th class="py-2 px-3">Harga / Durasi</th>
                                <th class="py-2 px-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($layanans as $l)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-3">
                                    @if($l->foto)
                                        <img src="{{ asset('storage/' . $l->foto) }}" alt="{{ $l->nama_layanan }}" class="w-12 h-12 object-cover rounded-lg">
                                    @else
                                        <span class="text-xs text-gray-400 italic">No Image</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 font-medium text-gray-900">{{ $l->nama_layanan }}</td>
                                <td class="py-3 px-3">
                                    <div class="text-pink-600 font-semibold">Rp {{ number_format($l->harga, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-400">⏱️ {{ $l->durasi ?? '-' }} Menit</div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <form action="{{ route('admin.layanan.destroy', $l->id_layanan ?? $l->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ================= KOLOM KANAN: DEKORASI ================= --}}
        <div class="space-y-6">
            {{-- Form Tambah Dekorasi --}}
            <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">
                <h3 class="text-xl font-bold text-pink-600 mb-4">➕ Tambah Paket Dekorasi</h3>
                <form action="{{ route('admin.dekorasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Paket</label>
                        <input type="text" name="nama_paket" placeholder="Contoh: Paket VIP / Standar" required class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Dekorasi</label>
                        <input type="text" name="jenis_dekorasi" placeholder="Contoh: Akad Nikah / Resepsi" required class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" placeholder="Contoh: 10000000" min="0" required class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Estimasi Pengerjaan</label>
                        <input type="text" name="estimasi_pengerjaan" placeholder="Contoh: 1 Hari / 5 Jam" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Kelengkapan Paket / Item</label>
                        <input type="text" name="kelengkapan" placeholder="Contoh: Backdrop, Bunga Segar, Kursi Pengantin" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Foto Dekorasi</label>
                        <input type="file" name="foto" accept="image/*" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500 bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:outline-pink-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2 rounded-xl transition text-sm">Simpan Dekorasi</button>
                </form>
            </div>

            {{-- Daftar Paket Dekorasi --}}
            <div class="bg-white rounded-3xl shadow-md p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Paket Dekorasi</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="border-b text-gray-500">
                                <th class="py-2 px-3">Foto</th>
                                <th class="py-2 px-3">Nama Paket / Jenis</th>
                                <th class="py-2 px-3">Harga / Detail</th>
                                <th class="py-2 px-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dekorasis as $d)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-3">
                                    @if($d->foto)
                                        <img src="{{ asset('storage/' . $d->foto) }}" alt="{{ $d->nama_paket }}" class="w-12 h-12 object-cover rounded-lg">
                                    @else
                                        <span class="text-xs text-gray-400 italic">No Image</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3">
                                    <div class="font-medium text-gray-900">{{ $d->nama_paket }}</div>
                                    <div class="text-xs text-gray-500">Jenis: {{ $d->jenis_dekorasi }}</div>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="text-pink-600 font-semibold">Rp {{ number_format($d->harga, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-400">🛠 {{ $d->estimasi_pengerjaan ?? '-' }}</div>
                                    <div class="text-xs text-gray-500 truncate max-w-xs" title="{{ $d->kelengkapan }}">📦 {{ $d->kelengkapan ?? '-' }}</div>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <form action="{{ route('admin.dekorasi.destroy', $d->id_dekorasi ?? $d->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dekorasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
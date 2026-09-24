<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Amara Salon</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Dashboard Admin Amara Salon</h1>
        
        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500">Booking Baru</p>
                <h3 class="text-2xl font-bold">{{ $totalBookingBaru }}</h3>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500">Menunggu</p>
                <h3 class="text-2xl font-bold">{{ $totalMenunggu }}</h3>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500">Dikonfirmasi</p>
                <h3 class="text-2xl font-bold">{{ $totalDikonfirmasi }}</h3>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500">Ditolak</p>
                <h3 class="text-2xl font-bold">{{ $totalDitolak }}</h3>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-xl font-bold mb-4">Daftar Booking Terbaru</h2>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="p-2">Kode</th>
                        <th class="p-2">Pelanggan</th>
                        <th class="p-2">Tanggal</th>
                        <th class="p-2">Total Harga</th>
                        <th class="p-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $b)
                    <tr class="border-b">
                        <td class="p-2 font-semibold">{{ $b->kode_booking }}</td>
                        <td class="p-2">{{ $b->user->name ?? '-' }}</td>
                        <td class="p-2">{{ $b->tanggal_booking }}</td>
                        <td class="p-2">Rp {{ number_format($b->total_harga, 0, ',', '.') }}</td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded text-sm {{ $b->status_booking == 'Dikonfirmasi' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $b->status_booking }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
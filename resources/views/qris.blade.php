<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Pembayaran QRIS - Amara Salon & Dekor</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-gray-100 font-sans antialiased text-gray-800">

    <div class="min-h-screen flex flex-col">


        <!-- ================================================= -->
        <!-- HEADER -->
        <!-- ================================================= -->

        <header class="bg-white shadow-sm">

            <div class="max-w-6xl mx-auto px-6 py-4">

                <div class="flex items-center justify-between">


                    <!-- LOGO / NAMA -->

                    <a
                        href="{{ route('home') }}"
                        class="text-xl font-bold text-pink-600">

                        Amara Salon & Dekor

                    </a>


                    <!-- RIWAYAT -->

                    <a
                        href="{{ route('booking.riwayat') }}"
                        class="text-sm font-semibold text-gray-600 hover:text-pink-600">

                        Riwayat Pesanan

                    </a>

                </div>

            </div>

        </header>



        <!-- ================================================= -->
        <!-- MAIN -->
        <!-- ================================================= -->

        <main class="flex-1 py-10 px-4">

            <div class="max-w-md mx-auto">


                <!-- ================================================= -->
                <!-- CARD UTAMA -->
                <!-- ================================================= -->

                <div
                    class="bg-white rounded-3xl shadow-lg overflow-hidden">


                    <!-- HEADER CARD -->

                    <div
                        class="bg-gradient-to-r from-pink-600 to-pink-500 px-6 py-7 text-center text-white">

                        <div
                            class="w-14 h-14 mx-auto mb-4 rounded-full bg-white/20 flex items-center justify-center">

                            <span class="text-2xl">
                                💳
                            </span>

                        </div>


                        <h1 class="text-2xl font-bold">

                            Pembayaran QRIS

                        </h1>


                        <p class="text-pink-100 text-sm mt-2">

                            Scan QRIS untuk menyelesaikan pembayaran

                        </p>

                    </div>



                    <!-- ================================================= -->
                    <!-- DETAIL BOOKING -->
                    <!-- ================================================= -->

                    <div class="p-6">


                        <div
                            class="bg-gray-50 rounded-2xl p-4 mb-6">


                            <!-- KODE BOOKING -->

                            <div class="flex justify-between items-center mb-3">

                                <span class="text-sm text-gray-500">

                                    Kode Booking

                                </span>

                                <span class="font-bold text-pink-600">

                                    {{ $booking->kode_booking }}

                                </span>

                            </div>


                            <!-- TANGGAL -->

                            <div class="flex justify-between items-center mb-3">

                                <span class="text-sm text-gray-500">

                                    Tanggal Acara

                                </span>

                                <span class="font-semibold text-gray-700">

                                    {{ date('d M Y', strtotime($booking->tanggal_booking)) }}

                                </span>

                            </div>


                            <!-- STATUS -->

                            <div class="flex justify-between items-center">

                                <span class="text-sm text-gray-500">

                                    Status

                                </span>


                                @if($booking->status_booking == 'Menunggu')

                                    <span
                                        class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700">

                                        Menunggu

                                    </span>

                                @elseif($booking->status_booking == 'Dikonfirmasi')

                                    <span
                                        class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">

                                        Dikonfirmasi

                                    </span>

                                @elseif($booking->status_booking == 'Ditolak')

                                    <span
                                        class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">

                                        Ditolak

                                    </span>

                                @else

                                    <span
                                        class="px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-700">

                                        {{ $booking->status_booking }}

                                    </span>

                                @endif

                            </div>

                        </div>



                        <!-- ================================================= -->
                        <!-- TOTAL PEMBAYARAN -->
                        <!-- ================================================= -->

                        <div class="text-center mb-6">

                            <p class="text-sm text-gray-500 mb-1">

                                Total Pembayaran

                            </p>


                            <p class="text-3xl font-bold text-pink-600">

                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}

                            </p>

                        </div>



                        <!-- ================================================= -->
                        <!-- QRIS -->
                        <!-- ================================================= -->

                        <div class="text-center">


                            <p class="font-bold text-gray-800 mb-4">

                                Scan QRIS Berikut

                            </p>


                            <div
                                class="bg-white border-2 border-gray-200 rounded-2xl p-4">

                                <img
                                    src="{{ asset('storage/qris/qris.jpeg') }}"
                                    alt="QRIS Amara Salon & Dekor"
                                    class="w-full max-w-xs mx-auto object-contain">

                            </div>


                            <p class="text-xs text-gray-500 mt-3">

                                Pastikan nominal pembayaran sesuai dengan tagihan.

                            </p>

                        </div>



                        <!-- ================================================= -->
                        <!-- PETUNJUK -->
                        <!-- ================================================= -->

                        <div class="mt-7">


                            <h2 class="font-bold text-gray-800 mb-4">

                                Cara Pembayaran

                            </h2>


                            <div class="space-y-4">


                                <!-- STEP 1 -->

                                <div class="flex gap-3">

                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold">

                                        1

                                    </div>


                                    <div>

                                        <p class="font-semibold text-sm">

                                            Buka aplikasi pembayaran

                                        </p>

                                        <p class="text-xs text-gray-500 mt-1">

                                            Gunakan mobile banking atau e-wallet yang mendukung QRIS.

                                        </p>

                                    </div>

                                </div>



                                <!-- STEP 2 -->

                                <div class="flex gap-3">

                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold">

                                        2

                                    </div>


                                    <div>

                                        <p class="font-semibold text-sm">

                                            Scan QRIS

                                        </p>

                                        <p class="text-xs text-gray-500 mt-1">

                                            Arahkan kamera aplikasi pembayaran ke QRIS di atas.

                                        </p>

                                    </div>

                                </div>



                                <!-- STEP 3 -->

                                <div class="flex gap-3">

                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold">

                                        3

                                    </div>


                                    <div>

                                        <p class="font-semibold text-sm">

                                            Masukkan nominal

                                        </p>

                                        <p class="text-xs text-gray-500 mt-1">

                                            Pastikan nominalnya sesuai dengan total pembayaran.

                                        </p>

                                    </div>

                                </div>



                                <!-- STEP 4 -->

                                <div class="flex gap-3">

                                    <div
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold">

                                        4

                                    </div>


                                    <div>

                                        <p class="font-semibold text-sm">

                                            Simpan bukti pembayaran

                                        </p>

                                        <p class="text-xs text-gray-500 mt-1">

                                            Setelah pembayaran berhasil, screenshot atau simpan bukti transaksi.

                                        </p>

                                    </div>

                                </div>



                            </div>

                        </div>



                        <!-- ================================================= -->
                        <!-- TOMBOL UPLOAD -->
                        <!-- ================================================= -->

                        <div class="mt-8">


                            @if($pembayaran && $pembayaran->status_pembayaran == 'Pending')

                                <div
                                    class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">

                                    <p class="text-sm font-semibold text-yellow-800">

                                        Bukti pembayaran sedang diverifikasi.

                                    </p>

                                    <p class="text-xs text-yellow-700 mt-1">

                                        Silakan tunggu konfirmasi dari admin.

                                    </p>

                                </div>


                            @elseif($pembayaran && $pembayaran->status_pembayaran == 'Valid')

                                <div
                                    class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">

                                    <p class="text-sm font-semibold text-green-800">

                                        ✓ Pembayaran sudah diverifikasi.

                                    </p>

                                </div>


                            @elseif($pembayaran && $pembayaran->status_pembayaran == 'Ditolak')

                                <div
                                    class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 text-center">

                                    <p class="text-sm font-semibold text-red-800">

                                        Pembayaran sebelumnya ditolak.

                                    </p>

                                    <p class="text-xs text-red-700 mt-1">

                                        Silakan lakukan pembayaran kembali dan upload bukti baru.

                                    </p>

                                </div>


                                <!-- FORM UPLOAD -->

                                <form
                                    action="{{ route('booking.uploadPembayaran', $booking->id_booking) }}"
                                    method="POST"
                                    enctype="multipart/form-data">

                                    @csrf

                                    <label
                                        class="block text-sm font-semibold text-gray-700 mb-2">

                                        Upload Bukti Pembayaran

                                    </label>


                                    <input
                                        type="file"
                                        name="bukti_pembayaran"
                                        accept="image/jpeg,image/png,image/jpg"
                                        required
                                        class="w-full border border-gray-300 rounded-xl px-3 py-3 text-sm bg-white">


                                    <p class="text-xs text-gray-500 mt-2">

                                        Format JPG, JPEG, atau PNG. Maksimal 2 MB.

                                    </p>


                                    <button
                                        type="submit"
                                        class="w-full mt-4 bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 rounded-xl transition">

                                        Upload Bukti Pembayaran

                                    </button>

                                </form>


                            @else

                                <!-- FORM UPLOAD -->

                                <form
                                    action="{{ route('booking.uploadPembayaran', $booking->id_booking) }}"
                                    method="POST"
                                    enctype="multipart/form-data">

                                    @csrf


                                    <label
                                        class="block text-sm font-semibold text-gray-700 mb-2">

                                        Upload Bukti Pembayaran

                                    </label>


                                    <input
                                        type="file"
                                        name="bukti_pembayaran"
                                        accept="image/jpeg,image/png,image/jpg"
                                        required
                                        class="w-full border border-gray-300 rounded-xl px-3 py-3 text-sm bg-white">


                                    <p class="text-xs text-gray-500 mt-2">

                                        Format JPG, JPEG, atau PNG. Maksimal 2 MB.

                                    </p>


                                    <button
                                        type="submit"
                                        class="w-full mt-4 bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 rounded-xl transition">

                                        Upload Bukti Pembayaran

                                    </button>

                                </form>

                            @endif

                        </div>



                        <!-- ================================================= -->
                        <!-- KEMBALI -->
                        <!-- ================================================= -->

                        <div class="mt-4">

                            <a
                                href="{{ route('booking.riwayat') }}"
                                class="block text-center w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition">

                                ← Kembali ke Riwayat Pesanan

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </main>



        <!-- ================================================= -->
        <!-- FOOTER -->
        <!-- ================================================= -->

        <footer class="text-center text-sm text-gray-500 py-6">

            © {{ date('Y') }} Amara Salon & Dekor

        </footer>

    </div>

</body>

</html>

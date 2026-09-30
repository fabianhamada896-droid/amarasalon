<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Dekorasi - Amara Salon & Dekor</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-800">

    <!-- ================= NAVBAR ================= -->

    <header class="bg-white shadow p-4 flex justify-between items-center px-8">

        <div class="flex items-center space-x-4">

            <!-- Tombol Back -->
            <a
                href="javascript:history.back()"
                class="text-gray-600 hover:text-pink-600 transition p-1 rounded-full hover:bg-gray-100"
                title="Kembali"
            >

                <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"
                    />

                </svg>

            </a>

            <!-- Logo -->
            <h1 class="text-2xl font-bold text-pink-600">
                AMARA SALON & DEKOR
            </h1>

        </div>


        <!-- Menu -->
        <nav class="flex items-center space-x-6 font-medium">

            <div class="space-x-6">

                <a
                    href="{{ route('home') }}"
                    class="hover:text-pink-600"
                >
                    Beranda
                </a>

                <a
                    href="{{ route('layanan.index') }}"
                    class="hover:text-pink-600"
                >
                    Layanan
                </a>

                <a
                    href="{{ route('dekorasi.index') }}"
                    class="hover:text-pink-600"
                >
                    Dekorasi
                </a>

            </div>


            @guest

                <a
                    href="{{ route('login') }}"
                    class="border border-pink-600 text-pink-600 hover:bg-pink-50 px-4 py-1.5 rounded-lg text-sm font-semibold transition"
                >
                    Login
                </a>

            @endguest


            @auth

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="inline"
                >

                    @csrf

                    <button
                        type="submit"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-1.5 rounded-lg text-sm font-semibold transition"
                    >
                        Logout ({{ Auth::user()->name }})
                    </button>

                </form>

            @endauth

        </nav>

    </header>


    <!-- ================= KONTEN ================= -->

    <main class="container mx-auto px-6 py-12">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-16">

            <h2 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Katalog Dekorasi Pilihan
            </h2>

            <p class="text-lg text-gray-600 leading-relaxed">
                Wujudkan konsep acara dan pernikahan impian Anda bersama
                koleksi dekorasi terbaik kami.
            </p>

        </div>


        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($dekorasis as $dekorasi)

                <div
                    class="bg-white rounded-3xl shadow-lg flex flex-col justify-between border border-gray-50 hover:border-pink-100 transition-all duration-300 group overflow-hidden"
                >

                    <!-- ================= FOTO ================= -->

                    @if($dekorasi->foto)

                        <div class="w-full h-48 overflow-hidden bg-gray-100">

                            <img
                                src="{{ asset('storage/' . $dekorasi->foto) }}"
                                alt="{{ $dekorasi->nama_paket }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            >

                        </div>

                    @else

                        <div
                            class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400 text-sm font-medium"
                        >
                            Tidak Ada Foto
                        </div>

                    @endif


                    <!-- ================= INFORMASI ================= -->

                    <div class="p-8 flex flex-col justify-between flex-grow">

                        <div>

                            <!-- Jenis Dekorasi -->
                            <div
                                class="inline-block bg-pink-50 text-pink-600 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider mb-4"
                            >
                                {{ $dekorasi->jenis_dekorasi }}
                            </div>


                            <!-- Nama Paket -->
                            <h3
                                class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-pink-700 transition-colors"
                            >
                                {{ $dekorasi->nama_paket }}
                            </h3>


                            <!-- Deskripsi -->
                            <p
                                class="text-gray-600 text-base leading-relaxed mb-6 line-clamp-3"
                            >
                                {{ $dekorasi->deskripsi ?? 'Paket dekorasi dari Amara Salon & Dekor.' }}
                            </p>

                        </div>


                        <!-- Harga -->
                        <div>

                            <div
                                class="flex items-end justify-between mb-6 pt-4 border-t border-gray-100"
                            >

                                <div class="flex flex-col">

                                    <span class="text-xs text-gray-500 font-medium mb-0.5">
                                        Mulai dari
                                    </span>

                                    <span
                                        class="text-2xl font-extrabold text-pink-600 tracking-tight"
                                    >
                                        Rp {{ number_format($dekorasi->harga, 0, ',', '.') }}
                                    </span>

                                </div>

                            </div>


                            <!-- Tombol -->
                            <a
                                href="{{ route('booking.create', $dekorasi->id_dekorasi) }}?type=dekorasi"
                                class="block w-full text-center bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3.5 px-6 rounded-2xl transition duration-200 shadow-md"
                            >
                                Pesan Dekorasi Ini
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </main>


    <!-- ================= FOOTER ================= -->

    <footer class="bg-gray-100 mt-24 py-10 text-center text-sm text-gray-500">

        <div class="container mx-auto px-6">

            &copy; 2026 Amara Salon & Dekor.
            All rights reserved.

        </div>

    </footer>

</body>

</html>
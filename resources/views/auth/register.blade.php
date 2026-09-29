<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Amara Salon & Dekorasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 flex items-center justify-center min-h-screen py-10">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-pink-100">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-pink-600">Amara Salon</h1>
            <p class="text-gray-500 text-sm mt-1">Buat akun baru</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-pink-400 focus:outline-none">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-pink-400 focus:outline-none">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Nomor WhatsApp / HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="081234567890" required class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-pink-400 focus:outline-none">
                @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-pink-400 focus:outline-none">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-pink-400 focus:outline-none">
            </div>

            <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-2.5 rounded-xl transition shadow-md mt-2">
                Daftar Akun
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-pink-600 font-semibold hover:underline">Masuk di sini</a>
        </p>
    </div>
</body>
</html>
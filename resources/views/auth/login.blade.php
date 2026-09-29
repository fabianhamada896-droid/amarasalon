<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Amara Salon & Dekorasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-pink-100">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-pink-600">Amara Salon</h1>
            <p class="text-gray-500 text-sm mt-1">Masuk ke akun Anda</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg text-sm mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-pink-400 focus:outline-none @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-pink-400 focus:outline-none">
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-pink-600 focus:ring-pink-500 mr-2"> Ingat Saya
                </label>
            </div>

            <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-2.5 rounded-xl transition shadow-md">
                Masuk
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Belum punya akun? <a href="{{ route('register') }}" class="text-pink-600 font-semibold hover:underline">Daftar sekarang</a>
        </p>
    </div>
</body>
</html>
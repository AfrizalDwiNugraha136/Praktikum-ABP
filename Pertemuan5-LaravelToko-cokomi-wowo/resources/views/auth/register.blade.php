<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Toko Cokomi & Wowo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .bg-pattern {
            background-color: #1C1410;
            background-image: radial-gradient(circle at 20% 50%, rgba(217,119,6,0.15) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(217,119,6,0.1) 0%, transparent 40%);
        }
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(20px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fade-up { animation: fadeUp 0.5s ease both; }
    </style>
</head>
<body class="min-h-screen bg-pattern flex items-center justify-center p-4">

    <div class="w-full max-w-sm fade-up">

        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500 rounded-2xl mb-4 shadow-lg shadow-amber-900/30">
                <span class="text-3xl">🏪</span>
            </div>
            <h1 class="font-display text-3xl text-white mb-1">Toko Cokomi<br>& Wowo</h1>
            <p class="text-amber-400 text-sm">Daftarkan akun baru</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-6">
            <h2 class="font-display text-xl text-gray-800 mb-5 text-center">Buat Akun</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                           placeholder="Pak Cokomi"
                           class="w-full border @error('name') border-red-400 @else border-gray-200 @enderror
                                  rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="email@toko.test"
                           class="w-full border @error('email') border-red-400 @else border-gray-200 @enderror
                                  rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           placeholder="Min. 8 karakter"
                           class="w-full border @error('password') border-red-400 @else border-gray-200 @enderror
                                  rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                           placeholder="Ulangi password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                </div>

                <button type="submit"
                        class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 rounded-xl text-sm transition-colors shadow-sm">
                    Daftar →
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-5">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-amber-600 hover:text-amber-800 font-medium">Masuk di sini</a>
            </p>
        </div>
    </div>
</body>
</html>

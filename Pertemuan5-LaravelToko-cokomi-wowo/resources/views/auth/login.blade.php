<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Toko Cokomi & Wowo</title>
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

        {{-- Logo & Judul --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500 rounded-2xl mb-4 shadow-lg shadow-amber-900/30">
                <span class="text-3xl">🏪</span>
            </div>
            <h1 class="font-display text-3xl text-white mb-1">Toko Cokomi<br>& Wowo</h1>
            <p class="text-amber-400 text-sm">Sistem Inventari Toko</p>
        </div>

        {{-- Card Login --}}
        <div class="bg-white rounded-2xl shadow-2xl p-6">
            <h2 class="font-display text-xl text-gray-800 mb-5 text-center">Masuk ke Akun</h2>

            {{-- Session Error --}}
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="cokomi@toko.test"
                           class="w-full border @error('email') border-red-400 bg-red-50 @else border-gray-200 @enderror
                                  rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           placeholder="••••••••"
                           class="w-full border @error('password') border-red-400 @else border-gray-200 @enderror
                                  rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="rounded text-amber-500 focus:ring-amber-300">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-amber-600 hover:text-amber-800">Lupa password?</a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 rounded-xl text-sm transition-colors shadow-sm mt-2">
                    Masuk →
                </button>
            </form>

            {{-- Divider --}}
            <div class="relative my-5">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-100"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-white px-3 text-xs text-gray-400">Akun demo</span>
                </div>
            </div>

            {{-- Demo accounts hint --}}
            <div class="space-y-2 text-xs">
                <div class="flex items-center justify-between bg-amber-50 border border-amber-100 rounded-lg px-3 py-2">
                    <span class="text-amber-800 font-medium">👨‍💼 Pak Cokomi</span>
                    <span class="text-amber-600 font-mono">cokomi@toko.test / cokomi123</span>
                </div>
                <div class="flex items-center justify-between bg-amber-50 border border-amber-100 rounded-lg px-3 py-2">
                    <span class="text-amber-800 font-medium">🧑‍💼 Mas Wowo</span>
                    <span class="text-amber-600 font-mono">wowo@toko.test / wowo123</span>
                </div>
            </div>

            {{-- Register link --}}
            @if (Route::has('register'))
                <p class="text-center text-xs text-gray-400 mt-5">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-amber-600 hover:text-amber-800 font-medium">Daftar sekarang</a>
                </p>
            @endif
        </div>

        <p class="text-center text-xs text-gray-600 mt-6">
            © {{ date('Y') }} Toko Cokomi & Wowo — Purbalingga 🏪
        </p>
    </div>

</body>
</html>

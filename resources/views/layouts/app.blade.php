<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Toko Cokomi & Wowo') — Inventari</title>

    {{-- Google Fonts: Playfair Display + DM Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js CDN --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ── Custom CSS Variables ── */
        :root {
            --cream:   #FDF8F0;
            --warm:    #F5EDD8;
            --brown:   #6B4C2A;
            --amber:   #D97706;
            --green:   #16A34A;
            --red:     #DC2626;
            --ink:     #1C1410;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--cream);
            color: var(--ink);
        }

        h1, h2, .font-display {
            font-family: 'Playfair Display', serif;
        }

        /* ── Sidebar ── */
        .sidebar {
            background: var(--ink);
            min-height: 100vh;
        }

        /* ── Tabel zebra ── */
        tbody tr:nth-child(even) {
            background-color: #FEFCF8;
        }

        /* ── Badge stok ── */
        .badge-ok       { background:#DCFCE7; color:#15803D; }
        .badge-low      { background:#FEF9C3; color:#A16207; }
        .badge-out      { background:#FEE2E2; color:#B91C1C; }

        /* ── Animasi fade in ── */
        @keyframes fadeSlide {
            from { opacity:0; transform:translateY(10px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fade-in { animation: fadeSlide 0.35s ease both; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width:6px; }
        ::-webkit-scrollbar-track { background:#F5EDD8; }
        ::-webkit-scrollbar-thumb { background:#D97706; border-radius:3px; }
    </style>
    @stack('styles')
</head>
<body class="flex" x-data="{ sidebarOpen: false }">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar w-64 flex-shrink-0 hidden md:flex flex-col px-4 py-6 gap-2">

        {{-- Logo --}}
        <div class="mb-6 px-2">
            <div class="text-amber-400 text-xs font-semibold tracking-widest uppercase mb-1">Inventari</div>
            <h1 class="font-display text-white text-2xl leading-tight">Toko<br>Cokomi & Wowo</h1>
            <div class="mt-2 h-0.5 w-10 bg-amber-500 rounded"></div>
        </div>

        {{-- Nav --}}
        <nav class="flex flex-col gap-1 flex-1">
            <a href="{{ route('products.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('products.*') ? 'bg-amber-500 text-white' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}
                      transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
                Produk
            </a>
        </nav>

        {{-- User info --}}
        <div class="border-t border-white/10 pt-4 mt-4">
            <div class="flex items-center gap-3 px-2 mb-3">
                <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <div class="text-white text-sm font-medium leading-tight">{{ Auth::user()->name ?? '' }}</div>
                    <div class="text-gray-400 text-xs">{{ Auth::user()->email ?? '' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-3 py-2 text-xs text-gray-400 hover:text-red-400 hover:bg-white/5 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN ── --}}
    <main class="flex-1 flex flex-col min-h-screen">

        {{-- Topbar mobile --}}
        <header class="md:hidden flex items-center justify-between px-4 py-3 bg-white border-b border-amber-100">
            <span class="font-display text-lg text-amber-700">Toko C&W</span>
            <button @click="sidebarOpen=!sidebarOpen" class="text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(()=>show=false, 4000)"
             class="fade-in mx-6 mt-4 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button @click="show=false" class="text-green-500 hover:text-green-700 ml-4">✕</button>
        </div>
        @endif

        @if(session('error'))
        <div x-data="{ show: true }" x-show="show"
             class="fade-in mx-6 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm flex items-center justify-between">
            <span>{{ session('error') }}</span>
            <button @click="show=false" class="text-red-500 hover:text-red-700 ml-4">✕</button>
        </div>
        @endif

        {{-- Page Content --}}
        <div class="flex-1 p-6">
            @yield('content')
        </div>

        <footer class="text-center text-xs text-gray-400 py-4 border-t border-amber-100">
            © {{ date('Y') }} Toko Cokomi & Wowo — Purbalingga, Jawa Tengah 🏪
        </footer>
    </main>

    @stack('scripts')
</body>
</html>

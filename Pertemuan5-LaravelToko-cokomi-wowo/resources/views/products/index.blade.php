@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="fade-in" x-data="{ deleteModal: false, deleteId: null, deleteName: '' }">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="font-display text-3xl text-amber-900">Inventari Produk</h2>
            <p class="text-sm text-gray-500 mt-0.5">Toko Cokomi & Wowo — Kelola stok dengan mudah</p>
        </div>
        <a href="{{ route('products.create') }}"
           class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold px-5 py-2.5 rounded-xl shadow-sm transition-colors text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Produk
        </a>
    </div>

    {{-- ── Stats Cards ── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @php
            $statCards = [
                ['label'=>'Total Produk',  'value'=>$stats['total'],     'color'=>'bg-amber-50 border-amber-200',  'text'=>'text-amber-700'],
                ['label'=>'Aktif',         'value'=>$stats['active'],    'color'=>'bg-green-50 border-green-200',  'text'=>'text-green-700'],
                ['label'=>'Stok Menipis',  'value'=>$stats['low_stock'], 'color'=>'bg-yellow-50 border-yellow-200','text'=>'text-yellow-700'],
                ['label'=>'Stok Habis',    'value'=>$stats['out'],       'color'=>'bg-red-50 border-red-200',      'text'=>'text-red-700'],
            ];
        @endphp
        @foreach($statCards as $card)
        <div class="{{ $card['color'] }} border rounded-xl px-4 py-3">
            <div class="text-xs text-gray-500 mb-1">{{ $card['label'] }}</div>
            <div class="font-display text-2xl {{ $card['text'] }} font-bold">{{ $card['value'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- ── Filter & Search ── --}}
    <form method="GET" action="{{ route('products.index') }}"
          class="bg-white border border-amber-100 rounded-2xl p-4 mb-4 flex flex-wrap gap-3 items-end shadow-sm">

        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs text-gray-500 mb-1">Cari Produk</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Nama atau kode SKU..."
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300">
        </div>

        <div>
            <label class="block text-xs text-gray-500 mb-1">Kategori</label>
            <select name="category"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300">
                <option value="">Semua Kategori</option>
                @foreach($categories as $key => $label)
                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs text-gray-500 mb-1">Status</label>
            <select name="status"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300">
                <option value="">Semua Status</option>
                <option value="active"    {{ request('status') == 'active'    ? 'selected' : '' }}>Aktif</option>
                <option value="inactive"  {{ request('status') == 'inactive'  ? 'selected' : '' }}>Nonaktif</option>
                <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Stok Menipis</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Filter
            </button>
            @if(request()->hasAny(['search','category','status']))
            <a href="{{ route('products.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Reset
            </a>
            @endif
        </div>
    </form>

    {{-- ── Tabel Data ── --}}
    <div class="bg-white border border-amber-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-amber-50 border-b border-amber-100 text-left">
                        <th class="px-4 py-3 text-xs font-semibold text-amber-800 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-xs font-semibold text-amber-800 uppercase tracking-wider">Produk</th>
                        <th class="px-4 py-3 text-xs font-semibold text-amber-800 uppercase tracking-wider">Kategori</th>
                        <th class="px-4 py-3 text-xs font-semibold text-amber-800 uppercase tracking-wider">Harga</th>
                        <th class="px-4 py-3 text-xs font-semibold text-amber-800 uppercase tracking-wider">Stok</th>
                        <th class="px-4 py-3 text-xs font-semibold text-amber-800 uppercase tracking-wider">Satuan</th>
                        <th class="px-4 py-3 text-xs font-semibold text-amber-800 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-xs font-semibold text-amber-800 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-50">
                    @forelse($products as $i => $product)
                    <tr class="hover:bg-amber-50/50 transition-colors">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $products->firstItem() + $i }}</td>
                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-800">{{ $product->name }}</div>
                            <div class="text-xs text-gray-400 font-mono mt-0.5">{{ $product->sku }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-xs">
                                {{ $product->category }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-semibold text-gray-700">
                            {{ $product->formatted_price }}
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $stockClass = $product->stock === 0
                                    ? 'badge-out'
                                    : ($product->isLowStock() ? 'badge-low' : 'badge-ok');
                            @endphp
                            <span class="{{ $stockClass }} px-2 py-0.5 rounded-full text-xs font-semibold">
                                {{ $product->stock }}
                                @if($product->isLowStock() && $product->stock > 0)
                                    ⚠️
                                @elseif($product->stock === 0)
                                    ❌
                                @endif
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs">{{ $product->unit }}</td>
                        <td class="px-4 py-3">
                            @if($product->is_active)
                                <span class="badge-ok px-2 py-0.5 rounded-full text-xs font-semibold">Aktif</span>
                            @else
                                <span class="badge-out px-2 py-0.5 rounded-full text-xs font-semibold">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('products.edit', $product) }}"
                                   class="text-amber-600 hover:text-amber-800 p-1.5 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                {{-- Delete --}}
                                <button @click="deleteModal=true; deleteId={{ $product->id }}; deleteName='{{ addslashes($product->name) }}'"
                                        class="text-red-400 hover:text-red-600 p-1.5 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-16 text-center text-gray-400">
                            <div class="text-4xl mb-3">📦</div>
                            <p class="font-semibold text-gray-500">Belum ada produk</p>
                            <p class="text-sm mt-1">Tambahkan produk pertama untuk toko Anda</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
        <div class="px-4 py-3 border-t border-amber-50 flex items-center justify-between">
            <p class="text-xs text-gray-500">
                Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }} produk
            </p>
            {{ $products->links() }}
        </div>
        @endif
    </div>

    {{-- ── Delete Confirmation Modal ── --}}
    <div x-show="deleteModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
         @click.self="deleteModal=false">

        <div x-show="deleteModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full">

            <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            <h3 class="font-display text-xl text-center text-gray-800 mb-2">Hapus Produk?</h3>
            <p class="text-sm text-center text-gray-500 mb-6">
                Produk <span class="font-semibold text-gray-700" x-text='"\"" + deleteName + "\""'></span>
                akan dihapus. Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex gap-3">
                <button @click="deleteModal=false"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl text-sm transition-colors">
                    Batal
                </button>
                <form :action="'/products/' + deleteId" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

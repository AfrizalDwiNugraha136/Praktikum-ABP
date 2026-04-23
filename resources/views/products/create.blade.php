@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="fade-in max-w-2xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('products.index') }}" class="hover:text-amber-600 transition-colors">Produk</a>
        <span>›</span>
        <span class="text-gray-600 font-medium">Tambah Baru</span>
    </div>

    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">

        {{-- Header Form --}}
        <div class="bg-amber-500 px-6 py-5">
            <h2 class="font-display text-2xl text-white">Tambah Produk Baru</h2>
            <p class="text-amber-100 text-sm mt-1">Isi informasi lengkap produk yang akan dijual di toko</p>
        </div>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            {{-- Error Summary --}}
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">
                <p class="font-semibold mb-1">Ada {{ $errors->count() }} kesalahan:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- ── Informasi Utama ── --}}
            <div>
                <h3 class="font-semibold text-gray-700 text-sm uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-5 h-5 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-xs font-bold">1</span>
                    Informasi Utama
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Nama --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Produk <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="Contoh: Indomie Goreng"
                               class="w-full border @error('name') border-red-400 @else border-gray-200 @enderror
                                      rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- SKU --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kode SKU <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="sku" value="{{ old('sku', 'SKU-') }}"
                               placeholder="SKU-001"
                               class="w-full border @error('sku') border-red-400 @else border-gray-200 @enderror
                                      rounded-xl px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                        @error('sku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kategori <span class="text-red-400">*</span>
                        </label>
                        <select name="category"
                                class="w-full border @error('category') border-red-400 @else border-gray-200 @enderror
                                       rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="3" placeholder="Deskripsi singkat produk (opsional)..."
                                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition resize-none">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <hr class="border-amber-50">

            {{-- ── Harga & Stok ── --}}
            <div>
                <h3 class="font-semibold text-gray-700 text-sm uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-5 h-5 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-xs font-bold">2</span>
                    Harga & Stok
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    {{-- Harga Jual --}}
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Harga Jual (Rp) <span class="text-red-400">*</span>
                        </label>
                        <input type="number" name="price" value="{{ old('price') }}" min="0" step="100"
                               placeholder="15000"
                               class="w-full border @error('price') border-red-400 @else border-gray-200 @enderror
                                      rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                        @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Harga Modal --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Modal (Rp)</label>
                        <input type="number" name="cost_price" value="{{ old('cost_price') }}" min="0" step="100"
                               placeholder="12000"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                    </div>

                    {{-- Satuan --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Satuan <span class="text-red-400">*</span>
                        </label>
                        <select name="unit"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                            @foreach($units as $unit)
                                <option value="{{ $unit }}" {{ old('unit', 'pcs') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Stok Awal <span class="text-red-400">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0"
                               class="w-full border @error('stock') border-red-400 @else border-gray-200 @enderror
                                      rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                        @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Stok Minimum --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Stok Minimum <span class="text-red-400">*</span>
                            <span class="text-gray-400 font-normal">(alert)</span>
                        </label>
                        <input type="number" name="min_stock" value="{{ old('min_stock', 5) }}" min="0"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-300 transition">
                    </div>
                </div>
            </div>

            <hr class="border-amber-50">

            {{-- ── Pengaturan ── --}}
            <div>
                <h3 class="font-semibold text-gray-700 text-sm uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-5 h-5 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-xs font-bold">3</span>
                    Pengaturan
                </h3>
                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', '1') ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-amber-500 focus:ring-amber-300">
                    <label for="is_active" class="text-sm text-gray-700">
                        Produk <strong>Aktif</strong> (tampil & bisa dijual)
                    </label>
                </div>
            </div>

            {{-- ── Action Buttons ── --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 rounded-xl text-sm transition-colors shadow-sm">
                    💾 Simpan Produk
                </button>
                <a href="{{ route('products.index') }}"
                   class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl text-sm transition-colors text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Detail: ' . $product->name)

@section('content')
<div class="fade-in max-w-2xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('products.index') }}" class="hover:text-amber-600 transition-colors">Produk</a>
        <span>›</span>
        <span class="text-gray-600 font-medium">{{ $product->name }}</span>
    </div>

    <div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-amber-50 flex items-start justify-between gap-4">
            <div>
                <h2 class="font-display text-2xl text-amber-900">{{ $product->name }}</h2>
                <span class="font-mono text-xs text-gray-400 bg-gray-50 border border-gray-100 px-2 py-0.5 rounded mt-1 inline-block">
                    {{ $product->sku }}
                </span>
            </div>
            <div class="flex gap-2 flex-shrink-0">
                <a href="{{ route('products.edit', $product) }}"
                   class="bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                    Edit
                </a>
            </div>
        </div>

        <div class="p-6 grid grid-cols-2 gap-6">

            {{-- Harga Jual --}}
            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                <div class="text-xs text-amber-600 font-semibold uppercase tracking-wider mb-1">Harga Jual</div>
                <div class="font-display text-2xl text-amber-800">{{ $product->formatted_price }}</div>
                <div class="text-xs text-gray-500 mt-0.5">per {{ $product->unit }}</div>
            </div>

            {{-- Stok --}}
            <div class="rounded-xl p-4 border
                @if($product->stock === 0) bg-red-50 border-red-100
                @elseif($product->isLowStock()) bg-yellow-50 border-yellow-100
                @else bg-green-50 border-green-100 @endif">
                <div class="text-xs font-semibold uppercase tracking-wider mb-1
                    @if($product->stock === 0) text-red-500
                    @elseif($product->isLowStock()) text-yellow-600
                    @else text-green-600 @endif">Stok</div>
                <div class="font-display text-2xl
                    @if($product->stock === 0) text-red-700
                    @elseif($product->isLowStock()) text-yellow-700
                    @else text-green-700 @endif">
                    {{ $product->stock }}
                    <span class="text-sm font-sans font-normal">{{ $product->unit }}</span>
                </div>
                <div class="text-xs text-gray-500 mt-0.5">Min: {{ $product->min_stock }} {{ $product->unit }}</div>
            </div>

            {{-- Info lain --}}
            <div class="col-span-2 space-y-3">
                @php
                    $rows = [
                        ['Kategori',     $product->category],
                        ['Harga Modal',  $product->formatted_cost_price],
                        ['Keuntungan',   $product->profit ? 'Rp ' . number_format($product->profit, 0, ',', '.') . ' / ' . $product->unit : '-'],
                        ['Status',       $product->is_active ? '✅ Aktif' : '❌ Nonaktif'],
                        ['Diinput oleh', $product->user->name ?? '-'],
                        ['Dibuat',       $product->created_at->format('d M Y, H:i')],
                        ['Terakhir diperbarui', $product->updated_at->format('d M Y, H:i')],
                    ];
                @endphp
                @foreach($rows as [$label, $value])
                <div class="flex items-center justify-between py-2 border-b border-gray-50 text-sm">
                    <span class="text-gray-400">{{ $label }}</span>
                    <span class="text-gray-700 font-medium">{{ $value }}</span>
                </div>
                @endforeach

                @if($product->description)
                <div class="pt-2">
                    <div class="text-xs text-gray-400 mb-1">Deskripsi</div>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $product->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="px-6 pb-6">
            <a href="{{ route('products.index') }}"
               class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl text-sm transition-colors">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection

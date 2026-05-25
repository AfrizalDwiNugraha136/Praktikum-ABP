<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * ProductController - CRUD lengkap untuk manajemen produk toko
 *
 * Routes yang dilayani:
 *   GET    /products          → index()   (daftar produk)
 *   GET    /products/create   → create()  (form tambah)
 *   POST   /products          → store()   (simpan baru)
 *   GET    /products/{id}     → show()    (detail produk)
 *   GET    /products/{id}/edit→ edit()    (form edit)
 *   PUT    /products/{id}     → update()  (simpan perubahan)
 *   DELETE /products/{id}     → destroy() (hapus produk)
 */
class ProductController extends Controller
{
    /**
     * Validasi rules yang dipakai di store & update
     */
    private function validationRules(?int $productId = null): array
    {
        return [
            'name'        => 'required|string|max:255',
            'sku'         => ['required', 'string', 'max:50',
                              Rule::unique('products', 'sku')->ignore($productId)->whereNull('deleted_at')],
            'description' => 'nullable|string|max:1000',
            'category'    => ['required', Rule::in(array_keys(Product::categories()))],
            'price'       => 'required|numeric|min:0',
            'cost_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'min_stock'   => 'required|integer|min:0',
            'unit'        => ['required', Rule::in(Product::units())],
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'   => 'boolean',
        ];
    }

    /**
     * GET /products - Tampilkan daftar produk dengan filter & search
     */
    public function index(Request $request)
    {
        $query = Product::with('user')->latest();

        // Filter pencarian
        if ($search = $request->get('search')) {
            $query->search($search);
        }

        // Filter kategori
        if ($category = $request->get('category')) {
            $query->byCategory($category);
        }

        // Filter status
        if ($request->has('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($status === 'low_stock') {
                $query->lowStock();
            }
        }

        $products   = $query->paginate(15)->withQueryString();
        $categories = Product::categories();

        // Statistik ringkas untuk dashboard mini
        $stats = [
            'total'     => Product::count(),
            'active'    => Product::active()->count(),
            'low_stock' => Product::lowStock()->count(),
            'out'       => Product::where('stock', 0)->count(),
        ];

        return view('products.index', compact('products', 'categories', 'stats'));
    }

    /**
     * GET /products/create - Form tambah produk baru
     */
    public function create()
    {
        $categories = Product::categories();
        $units      = Product::units();
        return view('products.create', compact('categories', 'units'));
    }

    /**
     * POST /products - Simpan produk baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['user_id']   = Auth::id();
        $validated['is_active'] = $request->boolean('is_active');

        $product = Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', "Produk \"{$product->name}\" berhasil ditambahkan! 🎉");
    }

    /**
     * GET /products/{product} - Detail produk
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * GET /products/{product}/edit - Form edit produk
     */
    public function edit(Product $product)
    {
        $categories = Product::categories();
        $units      = Product::units();
        return view('products.edit', compact('product', 'categories', 'units'));
    }

    /**
     * PUT /products/{product} - Update data produk
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate($this->validationRules($product->id));

        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', "Produk \"{$product->name}\" berhasil diperbarui! ✅");
    }

    /**
     * DELETE /products/{product} - Hapus produk (soft delete)
     */
    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete(); // Soft delete — data masih ada di DB

        return redirect()
            ->route('products.index')
            ->with('success', "Produk \"{$name}\" berhasil dihapus.");
    }
}

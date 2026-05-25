<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Product - Representasi data produk di toko Pak Cokomi & Mas Wowo
 *
 * @property int $id
 * @property string $name
 * @property string $sku
 * @property string|null $description
 * @property string $category
 * @property float $price
 * @property float|null $cost_price
 * @property int $stock
 * @property int $min_stock
 * @property string $unit
 * @property string|null $image
 * @property bool $is_active
 * @property int $user_id
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Kolom yang boleh diisi secara mass assignment
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'category',
        'price',
        'cost_price',
        'stock',
        'min_stock',
        'unit',
        'image',
        'is_active',
        'user_id',
    ];

    /**
     * Cast tipe data otomatis
     */
    protected $casts = [
        'price'      => 'decimal:2',
        'cost_price' => 'decimal:2',
        'is_active'  => 'boolean',
        'stock'      => 'integer',
        'min_stock'  => 'integer',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    /**
     * Produk dimiliki oleh satu user (yang menginput)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Accessor / Helper ────────────────────────────────────

    /**
     * Format harga ke format Rupiah
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Format harga modal ke format Rupiah
     */
    public function getFormattedCostPriceAttribute(): string
    {
        if (!$this->cost_price) return '-';
        return 'Rp ' . number_format($this->cost_price, 0, ',', '.');
    }

    /**
     * Cek apakah stok produk sudah di bawah batas minimum
     */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }

    /**
     * Hitung keuntungan per unit (jika harga modal tersedia)
     */
    public function getProfitAttribute(): ?float
    {
        if (!$this->cost_price) return null;
        return $this->price - $this->cost_price;
    }

    /**
     * Daftar kategori yang tersedia di toko
     */
    public static function categories(): array
    {
        return [
            'Makanan'        => 'Makanan',
            'Minuman'        => 'Minuman',
            'Sembako'        => 'Sembako',
            'Kebersihan'     => 'Kebersihan & Perawatan',
            'Elektronik'     => 'Elektronik',
            'Pakaian'        => 'Pakaian',
            'Alat Tulis'     => 'Alat Tulis & Kantor',
            'Kesehatan'      => 'Kesehatan',
            'Lainnya'        => 'Lainnya',
        ];
    }

    /**
     * Daftar satuan yang tersedia
     */
    public static function units(): array
    {
        return ['pcs', 'kg', 'gram', 'liter', 'ml', 'pak', 'lusin', 'karton', 'dus', 'botol', 'kaleng'];
    }

    // ─── Scope Query ─────────────────────────────────────────

    /**
     * Scope: hanya produk aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: produk dengan stok menipis
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'min_stock');
    }

    /**
     * Scope: filter berdasarkan kategori
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: pencarian nama atau SKU
     */
    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('sku', 'like', "%{$keyword}%")
              ->orWhere('description', 'like', "%{$keyword}%");
        });
    }
}

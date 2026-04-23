<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory untuk generate data produk dummy
 * Dipakai oleh ProductSeeder untuk mengisi tabel products
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Data produk sample untuk toko sembako / warung kelontong
     * ala toko Pak Cokomi & Mas Wowo di Purbalingga 😄
     */
    private array $produkSembako = [
        ['name' => 'Beras Premium Pandan Wangi', 'category' => 'Sembako', 'unit' => 'kg',   'price' => 14000,  'cost' => 12500],
        ['name' => 'Gula Pasir Gulaku',          'category' => 'Sembako', 'unit' => 'kg',   'price' => 16000,  'cost' => 14500],
        ['name' => 'Minyak Goreng Bimoli 2L',    'category' => 'Sembako', 'unit' => 'botol','price' => 38000,  'cost' => 34000],
        ['name' => 'Tepung Terigu Segitiga',     'category' => 'Sembako', 'unit' => 'kg',   'price' => 12000,  'cost' => 10500],
        ['name' => 'Garam Dapur Cap Kapal',      'category' => 'Sembako', 'unit' => 'pcs',  'price' => 3000,   'cost' => 2500],
        ['name' => 'Telur Ayam Negeri',          'category' => 'Makanan', 'unit' => 'kg',   'price' => 29000,  'cost' => 26000],
        ['name' => 'Mie Instan Indomie Goreng',  'category' => 'Makanan', 'unit' => 'pcs',  'price' => 3500,   'cost' => 3000],
        ['name' => 'Mie Instan Indomie Kuah',    'category' => 'Makanan', 'unit' => 'pcs',  'price' => 3500,   'cost' => 3000],
        ['name' => 'Kecap Manis ABC 135ml',      'category' => 'Makanan', 'unit' => 'botol','price' => 8500,   'cost' => 7500],
        ['name' => 'Saus Sambal Indofood',       'category' => 'Makanan', 'unit' => 'botol','price' => 9000,   'cost' => 7800],
        ['name' => 'Snack Chitato 68gr',         'category' => 'Makanan', 'unit' => 'pcs',  'price' => 10000,  'cost' => 8500],
        ['name' => 'Biskuit Roma Kelapa',        'category' => 'Makanan', 'unit' => 'pak',  'price' => 7000,   'cost' => 6000],
        ['name' => 'Kopi Kapal Api Special',     'category' => 'Minuman', 'unit' => 'pcs',  'price' => 2500,   'cost' => 2000],
        ['name' => 'Teh Celup Sariwangi',        'category' => 'Minuman', 'unit' => 'pak',  'price' => 15000,  'cost' => 13000],
        ['name' => 'Susu Kental Manis Frisian',  'category' => 'Minuman', 'unit' => 'kaleng','price'=> 14000,  'cost' => 12500],
        ['name' => 'Air Mineral Aqua 600ml',     'category' => 'Minuman', 'unit' => 'botol','price' => 4000,   'cost' => 3200],
        ['name' => 'Minuman Teh Botol Sosro',    'category' => 'Minuman', 'unit' => 'botol','price' => 6000,   'cost' => 5000],
        ['name' => 'Sabun Mandi Lifebuoy',       'category' => 'Kebersihan','unit'=> 'pcs', 'price' => 6500,   'cost' => 5500],
        ['name' => 'Shampo Sunsilk 170ml',       'category' => 'Kebersihan','unit'=> 'botol','price'=> 22000,  'cost' => 19000],
        ['name' => 'Sabun Cuci Rinso 1kg',       'category' => 'Kebersihan','unit'=> 'pak', 'price' => 21000,  'cost' => 18500],
        ['name' => 'Deterjen Cair Soklin',       'category' => 'Kebersihan','unit'=> 'botol','price'=> 19000,  'cost' => 16500],
        ['name' => 'Pasta Gigi Pepsodent 190g',  'category' => 'Kebersihan','unit'=> 'pcs', 'price' => 18000,  'cost' => 15500],
        ['name' => 'Tissue Paseo 250 lembar',    'category' => 'Kebersihan','unit'=> 'pak', 'price' => 12000,  'cost' => 10000],
        ['name' => 'Paracetamol 500mg Strip',    'category' => 'Kesehatan','unit' => 'pcs', 'price' => 6000,   'cost' => 4500],
        ['name' => 'Betadine 30ml',              'category' => 'Kesehatan','unit' => 'botol','price'=> 25000,  'cost' => 21000],
        ['name' => 'Plester Hansaplast isi 10',  'category' => 'Kesehatan','unit' => 'pak', 'price' => 8000,   'cost' => 6500],
        ['name' => 'Pulpen BallPen Pilot',       'category' => 'Alat Tulis','unit'=> 'pcs', 'price' => 5000,   'cost' => 3500],
        ['name' => 'Buku Tulis Sidu 58 lembar',  'category' => 'Alat Tulis','unit'=> 'pcs', 'price' => 4500,   'cost' => 3500],
        ['name' => 'Amplop Coklat Surat',        'category' => 'Alat Tulis','unit'=> 'pak', 'price' => 5000,   'cost' => 4000],
        ['name' => 'Baterai ABC AA isi 2',       'category' => 'Elektronik','unit'=> 'pak', 'price' => 9000,   'cost' => 7500],
    ];

    private int $index = 0;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Ambil data dari list produk sample (rotate jika habis)
        $produk = $this->produkSembako[$this->index % count($this->produkSembako)];
        $this->index++;

        return [
            'name'        => $produk['name'],
            'sku'         => strtoupper('SKU-' . fake()->unique()->bothify('??###')),
            'description' => fake()->optional(0.7)->sentence(10),
            'category'    => $produk['category'],
            'price'       => $produk['price'],
            'cost_price'  => $produk['cost'],
            'stock'       => fake()->numberBetween(0, 200),
            'min_stock'   => fake()->numberBetween(5, 20),
            'unit'        => $produk['unit'],
            'image'       => null,
            'is_active'   => fake()->boolean(85), // 85% aktif
            'user_id'     => User::inRandomOrder()->first()?->id ?? 1,
        ];
    }

    /**
     * State: produk dengan stok kosong
     */
    public function outOfStock(): static
    {
        return $this->state(['stock' => 0, 'is_active' => false]);
    }

    /**
     * State: produk dengan stok menipis
     */
    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => fake()->numberBetween(1, $attributes['min_stock']),
        ]);
    }

    /**
     * State: produk aktif
     */
    public function active(): static
    {
        return $this->state(['is_active' => true]);
    }
}

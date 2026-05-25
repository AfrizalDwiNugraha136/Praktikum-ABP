<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * ProductSeeder - Isi tabel products dengan data dummy produk toko
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user dulu
        if (User::count() === 0) {
            $this->call(UserSeeder::class);
        }

        // Buat 30 produk regular
        Product::factory(30)->create();

        // Buat 5 produk dengan stok menipis (biar ada alert)
        Product::factory(5)->lowStock()->create();

        // Buat 3 produk habis stok
        Product::factory(3)->outOfStock()->create();

        $total = Product::count();
        $this->command->info("✅ Product seeder selesai! Total: {$total} produk dibuat.");
    }
}

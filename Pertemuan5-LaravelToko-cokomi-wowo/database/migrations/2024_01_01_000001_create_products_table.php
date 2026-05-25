<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel products untuk inventari toko Pak Cokomi & Mas Wowo
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // Nama produk
            $table->string('sku')->unique();                 // Kode produk unik
            $table->text('description')->nullable();         // Deskripsi produk
            $table->string('category');                      // Kategori produk
            $table->decimal('price', 15, 2);                 // Harga jual (Rupiah)
            $table->decimal('cost_price', 15, 2)->nullable();// Harga modal
            $table->integer('stock')->default(0);            // Stok tersedia
            $table->integer('min_stock')->default(5);        // Stok minimum (alert)
            $table->string('unit')->default('pcs');          // Satuan (pcs, kg, liter, dll)
            $table->string('image')->nullable();             // Path gambar produk
            $table->boolean('is_active')->default(true);     // Status aktif/nonaktif
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang input
            $table->timestamps();
            $table->softDeletes();                           // Soft delete (data aman)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

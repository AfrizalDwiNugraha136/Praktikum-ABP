<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder - Entry point semua seeder
 * Jalankan: php artisan db:seed
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Mulai seeding database Toko Cokomi & Wowo...');

        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
        ]);

        $this->command->info('🎉 Database berhasil di-seed! Toko siap buka!');
    }
}

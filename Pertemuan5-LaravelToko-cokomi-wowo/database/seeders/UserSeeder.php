<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * UserSeeder - Buat akun default untuk Pak Cokomi dan Mas Wowo
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Akun Pak Cokomi (Pemilik Toko) ──────────────────────
        User::updateOrCreate(
            ['email' => 'cokomi@toko.test'],
            [
                'name'              => 'Pak Cokomi',
                'email'             => 'cokomi@toko.test',
                'password'          => Hash::make('cokomi123'),
                'email_verified_at' => now(),
            ]
        );

        // ── Akun Mas Wowo (Staff Kasir) ──────────────────────────
        User::updateOrCreate(
            ['email' => 'wowo@toko.test'],
            [
                'name'              => 'Mas Wowo',
                'email'             => 'wowo@toko.test',
                'password'          => Hash::make('wowo123'),
                'email_verified_at' => now(),
            ]
        );

        // ── Extra user dummy (opsional) ──────────────────────────
        User::factory(3)->create();

        $this->command->info('✅ User seeder selesai!');
        $this->command->table(
            ['Nama', 'Email', 'Password'],
            [
                ['Pak Cokomi', 'cokomi@toko.test', 'cokomi123'],
                ['Mas Wowo',   'wowo@toko.test',   'wowo123'],
            ]
        );
    }
}

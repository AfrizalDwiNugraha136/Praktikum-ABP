#!/bin/bash
# ============================================================
# install.sh — Setup cepat Toko Cokomi & Wowo
# Jalankan: bash install.sh
# ============================================================

echo ""
echo "🏪 =============================================="
echo "   Toko Cokomi & Wowo — Setup Script"
echo "   Purbalingga, Jawa Tengah"
echo "================================================"
echo ""

# 1. Buat project Laravel baru
echo "📦 Membuat project Laravel 11..."
composer create-project laravel/laravel toko-cokomi-wowo
cd toko-cokomi-wowo

# 2. Install Breeze
echo "🔐 Install Laravel Breeze..."
composer require laravel/breeze --dev
php artisan breeze:install blade --quiet
npm install
npm run build

# 3. Copy file project
echo "📂 Menyalin file project..."
# (Salin semua file dari folder ini ke project)

# 4. Setup .env
cp .env.example .env
php artisan key:generate

# 5. Setup database SQLite (untuk development cepat)
touch database/database.sqlite
sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
sed -i 's/DB_DATABASE=laravel/# DB_DATABASE=laravel/' .env

# 6. Migrasi + Seeder
echo "🌱 Menjalankan migrasi dan seeder..."
php artisan migrate --seed

echo ""
echo "✅ =============================================="
echo "   Setup selesai! 🎉"
echo ""
echo "   Akun yang tersedia:"
echo "   👤 Pak Cokomi  → cokomi@toko.test / cokomi123"
echo "   👤 Mas Wowo    → wowo@toko.test / wowo123"
echo ""
echo "   Jalankan server:"
echo "   php artisan serve"
echo ""
echo "   Buka: http://localhost:8000"
echo "================================================"

# 🏪 Toko Cokomi & Wowo — Sistem Inventari

> Aplikasi manajemen inventari berbasis web untuk toko kelontong Pak Cokomi dan Mas Wowo di Purbalingga, Jawa Tengah.

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php)
![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-CDN-38B2AC?logo=tailwind-css)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0)
![License](https://img.shields.io/badge/license-MIT-green)

---

## 📋 Daftar Isi

- [Tentang Project](#-tentang-project)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Instalasi](#-instalasi)
- [Akun Default](#-akun-default-seeder)
- [Struktur Project](#-struktur-project)
- [Skema Database](#-skema-database)
- [Panduan Penggunaan](#-panduan-penggunaan)
- [API Routes](#-routes)

---

## 🧡 Tentang Project

Toko Cokomi & Wowo adalah sistem inventari sederhana yang dibangun untuk membantu Pak Cokomi dan Mas Wowo mengelola stok produk toko mereka secara digital. Dibuat menggunakan **Laravel 11** dengan sistem autentikasi **Laravel Breeze**, produk dikelola melalui CRUD yang intuitif.

---

## ✨ Fitur Utama

| Fitur | Keterangan |
|-------|------------|
| 🔐 Autentikasi | Login/Register/Logout via Laravel Breeze |
| 📦 CRUD Produk | Tambah, lihat, edit, hapus produk |
| 🔍 Filter & Pencarian | Filter berdasar kategori, status, dan keyword |
| ⚠️ Alert Stok Menipis | Otomatis deteksi stok di bawah batas minimum |
| 🗑️ Soft Delete | Data aman, bisa dipulihkan |
| 📊 Statistik Ringkas | Total produk, aktif, menipis, habis |
| 📄 Pagination | Navigasi halaman data produk |
| 🌱 Database Seeder | 38 data produk dummy siap pakai |
| 🧩 Factory | Generate data dummy fleksibel |

---

## 🛠️ Tech Stack

- **Backend**: Laravel 11, PHP 8.2+
- **Auth**: Laravel Breeze (blade + session)
- **Database**: MySQL / SQLite
- **Frontend**: Blade Templates, Tailwind CSS (CDN), Alpine.js (CDN)
- **Fonts**: Playfair Display (display), DM Sans (body)
- **Tools**: Eloquent ORM, Soft Deletes, Database Factory & Seeder

---

## 🚀 Instalasi

### Prasyarat

- PHP 8.2+
- Composer
- MySQL atau SQLite
- Node.js (opsional, untuk compile assets)

### Langkah-langkah

```bash
# 1. Clone atau buat project Laravel baru
composer create-project laravel/laravel toko-cokomi-wowo
cd toko-cokomi-wowo

# 2. Install Laravel Breeze
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev

# 3. Salin semua file dari project ini ke lokasi yang sesuai
#    (lihat Struktur Project di bawah)

# 4. Konfigurasi .env
cp .env.example .env
php artisan key:generate

# 5. Atur database di .env
# DB_CONNECTION=mysql
# DB_DATABASE=toko_cokomi_wowo
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Jalankan migrasi + seeder
php artisan migrate --seed

# 7. Jalankan server
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## 👤 Akun Default (Seeder)

Setelah menjalankan `php artisan migrate --seed`, dua akun berikut otomatis tersedia:

| Nama | Email | Password | Role |
|------|-------|----------|------|
| **Pak Cokomi** | cokomi@toko.test | cokomi123 | Pemilik |
| **Mas Wowo** | wowo@toko.test | wowo123 | Staff Kasir |

> 💡 Keduanya dapat login dan menggunakan semua fitur inventari.

---

## 📁 Struktur Project

```
toko-cokomi-wowo/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/               ← Controller auth (Breeze)
│   │       └── ProductController.php ← CRUD produk
│   ├── Models/
│   │   ├── User.php
│   │   └── Product.php             ← Model produk + accessor + scope
│   └── Providers/
│       └── AppServiceProvider.php  ← Register pagination view
│
├── database/
│   ├── factories/
│   │   └── ProductFactory.php      ← Factory dengan 30 produk sample
│   ├── migrations/
│   │   └── ..._create_products_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php          ← Buat akun Cokomi & Wowo
│       └── ProductSeeder.php       ← Isi 38 produk dummy
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php       ← Layout utama (sidebar + nav)
│       ├── products/
│       │   ├── index.blade.php     ← Tabel data + modal hapus
│       │   ├── create.blade.php    ← Form tambah produk
│       │   └── edit.blade.php      ← Form edit produk
│       └── vendor/pagination/
│           └── tailwind.blade.php  ← Custom pagination
│
└── routes/
    └── web.php                     ← Route definitions
```

---

## 🗄️ Skema Database

### Tabel `users` (bawaan Laravel)

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK | |
| name | varchar(255) | Nama pengguna |
| email | varchar(255) unique | Email login |
| password | varchar(255) | Password ter-hash |
| email_verified_at | timestamp nullable | |
| created_at / updated_at | timestamp | |

### Tabel `products`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint PK | |
| name | varchar(255) | Nama produk |
| sku | varchar(50) unique | Kode produk |
| description | text nullable | Deskripsi produk |
| category | varchar(100) | Kategori (Makanan, Minuman, dll) |
| price | decimal(15,2) | Harga jual (Rupiah) |
| cost_price | decimal(15,2) nullable | Harga modal |
| stock | integer | Stok saat ini |
| min_stock | integer | Batas stok minimum (trigger alert) |
| unit | varchar(20) | Satuan (pcs, kg, liter, dll) |
| image | varchar(255) nullable | Path gambar produk |
| is_active | boolean | Status aktif/nonaktif |
| user_id | FK → users | Siapa yang menginput |
| deleted_at | timestamp nullable | Soft delete |
| created_at / updated_at | timestamp | |

---

## 📖 Panduan Penggunaan

### Login
1. Buka http://localhost:8000
2. Login menggunakan akun Pak Cokomi atau Mas Wowo

### Menambah Produk
1. Klik tombol **"+ Tambah Produk"** di halaman utama
2. Isi informasi produk (nama, SKU, kategori, harga, stok)
3. Centang "Produk Aktif" agar produk tampil
4. Klik **"Simpan Produk"**

### Edit Produk
1. Di tabel produk, klik ikon ✏️ pada baris produk
2. Ubah informasi yang diinginkan
3. Klik **"Simpan Perubahan"**

### Hapus Produk
1. Klik ikon 🗑️ pada baris produk
2. Konfirmasi modal akan muncul
3. Klik **"Ya, Hapus"** untuk konfirmasi (soft delete)

### Filter Produk
- Gunakan form filter di atas tabel untuk:
  - Cari berdasarkan nama / SKU
  - Filter berdasar kategori
  - Filter status (Aktif / Nonaktif / Stok Menipis)

---

## 🛤️ Routes

| Method | URI | Action | Keterangan |
|--------|-----|--------|------------|
| GET | `/` | redirect | Redirect ke /products |
| GET | `/products` | index | Daftar produk |
| GET | `/products/create` | create | Form tambah |
| POST | `/products` | store | Simpan produk baru |
| GET | `/products/{id}` | show | Detail produk |
| GET | `/products/{id}/edit` | edit | Form edit |
| PUT | `/products/{id}` | update | Simpan perubahan |
| DELETE | `/products/{id}` | destroy | Hapus produk |
| GET | `/login` | | Halaman login |
| POST | `/logout` | | Logout |

> Semua route products dilindungi middleware `auth`.

---

## 🧪 Menjalankan Seeder Ulang

```bash
# Reset database dan seed ulang
php artisan migrate:fresh --seed

# Hanya jalankan seeder (tanpa reset)
php artisan db:seed

# Seeder spesifik
php artisan db:seed --class=ProductSeeder
```

---

## 🤝 Kontribusi

Dibeveloped dengan ❤️ untuk Pak Cokomi dan Mas Wowo.

---

## 📄 Lisensi

Afrizal Dwi Nugraha-2311102136

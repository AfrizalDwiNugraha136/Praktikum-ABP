# Laporan Praktikum: State Management Keranjang Belanja dengan BLoC/Cubit

**Nama:** [Afrizal Dwi Nugraha]  
**NIM:** [23111020136]  

## 1. Tujuan Praktikum
Membangun aplikasi Flutter sederhana yang mengimplementasikan state management menggunakan BLoC (secara spesifik menggunakan `Cubit` untuk kesederhanaan) untuk mengelola data keranjang belanja (cart). Aplikasi ini memuat daftar produk dan keranjang belanja dengan penghitungan total harga dan jumlah item secara real-time.

## 2. Penjelasan Implementasi BLoC/Cubit

Pada aplikasi ini, state management dilakukan menggunakan pola Cubit (bagian dari package `flutter_bloc`). Cubit dipilih karena pengelolaannya lebih ringkas dibandingkan BLoC tradisional (menggunakan fungsi langsung alih-alih event).

### A. Model Data (`Product`)
Model data merepresentasikan item yang dapat ditambahkan ke keranjang. Model ini memiliki atribut `id`, `name`, `price`, dan `imageUrl`.

### B. State Management (`CartCubit`)
`CartCubit` meng-extend `Cubit<List<Product>>`. State awal berupa *list kosong* `[]` yang menandakan keranjang kosong. 
- **Fungsi `addToCart`**: Menerima objek `Product`, menyalin state *list* yang ada saat ini, menambahkan produk baru ke dalamnya, dan memanggil `emit()` untuk memperbarui state aplikasi.
- **Fungsi `removeFromCart`**: Mencari objek `Product` di dalam state *list* saat ini, menghapusnya, dan memanggil `emit()`.

### C. UI dan Integrasi BLoC
- **`BlocProvider`**: Ditempatkan di level teratas aplikasi (di dalam `MyApp`) untuk menginisialisasi `CartCubit`. Hal ini memastikan bahwa state keranjang dapat diakses dari halaman mana saja (baik dari `ProductListPage` maupun `CartPage`).
- **`BlocBuilder`**: 
  - Digunakan pada `ProductListPage` (di dalam AppBar) untuk menampilkan **badge/jumlah item** keranjang. Setiap kali state di dalam `CartCubit` berubah (ada barang masuk/keluar), `BlocBuilder` akan memicu *re-build* widget tersebut secara otomatis (real-time).
  - Digunakan pada `CartPage` untuk merender seluruh *list* item yang ada di dalam keranjang, sekaligus melakukan iterasi list untuk menjumlahkan total harga belanjaan.

## 3. Screenshot Tampilan Aplikasi

- **[Tampilan Daftar Produk]**
![alt text](<Daftar produk.jpeg>)

- **[Tampilan Menambahkan Produk ke Keranjang]**
![alt text](<Keranjang Produk.jpeg>)

- **[Tampilan Keranjang dan Jumlah Item Real-Time]**
![alt text](<notif Keranjang.jpeg>)

## 4. Kesimpulan
Penggunaan `flutter_bloc` (khususnya Cubit) pada pengelolaan keranjang belanja membuat pemisahan antara UI dan logika bisnis (Business Logic) menjadi sangat jelas. Pembaruan komponen UI seperti badge jumlah item dan daftar produk di keranjang dapat terjadi secara *reactive* dan *real-time* tanpa harus menggunakan `setState()` secara manual atau passing data melalui *constructor*.

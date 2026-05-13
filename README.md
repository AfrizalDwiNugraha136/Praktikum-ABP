Tugas Praktikum Flutter - Pemrograman Aplikasi Bergerak
Proyek ini merupakan implementasi berbagai macam widget dasar di Flutter seperti Stack, Container, ListView, dan GridView. Aplikasi ini dibangun sebagai bagian dari tugas mata kuliah di Telkom University Purwokerto.

Identitas Mahasiswa
Nama: Afrizal Dwi Nugraha

NIM: 2311102136

Kelas: S1 Software Engineering (Angkatan 2023)

Fitur dan Implementasi Widget
Berdasarkan tampilan pada aplikasi (image_2ad140.jpg), berikut adalah komponen yang diimplementasikan:

AppBar & Scaffold: Menggunakan identitas mahasiswa pada bagian judul aplikasi sebagai identifikasi tugas.

Stack & Container: Menggabungkan beberapa widget secara bertumpuk. Widget Container digunakan untuk memberikan latar belakang warna dan padding, sementara Stack memungkinkan teks berada di atas elemen visual lainnya.

ListView (Manual & Builder): Menampilkan daftar item secara vertikal. Implementasi mencakup penggunaan ListView manual untuk item statis dan potensi penggunaan ListView.builder untuk data yang dinamis.

GridView: Menampilkan data dalam bentuk kisi (grid) dengan susunan kolom yang rapi, ideal untuk tata letak galeri atau menu.

Detail Teknis
Bahasa Pemrograman: Dart

Framework: Flutter

Target Perangkat: Xiaomi 23122PCD1G (POCO X6 5G)

Environment: Android Studio (Windows)

Cara Menjalankan Proyek
Pastikan Flutter SDK sudah terpasang dan terkonfigurasi di Path sistem (D:\flutter\bin).

Hubungkan perangkat Android dengan fitur USB Debugging dan Install via USB yang aktif.

Jalankan perintah berikut di terminal:

Bash
flutter pub get
flutter run
Cuplikan Layar
<img width="1917" height="1197" alt="SS tugas Fluter" src="https://github.com/user-attachments/assets/4018105b-80a8-47e6-a9bb-158bf231a3d5" />

Catatan Pengembang:
Proyek ini sempat mengalami kendala memori pada build daemon Gradle, namun berhasil diatasi dengan memindahkan beban eksekusi dari emulator ke perangkat fisik (POCO X6 5G).

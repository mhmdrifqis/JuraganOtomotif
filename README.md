# 🚗 Juragan Otomotif

Juragan Otomotif adalah sebuah sistem informasi berbasis web yang dirancang untuk mengelola stok, penjualan, dan informasi detail mengenai unit mobil. Aplikasi ini dikembangkan menggunakan **Laravel** dan dilengkapi dengan panel admin untuk memudahkan pengelolaan data operasional.

## ✨ Fitur Utama

- **Manajemen Unit Mobil**: Tambah, edit, hapus, dan lihat daftar stok mobil.
- **Galeri Foto**: Mendukung upload foto utama dan foto galeri (multiple photos) untuk setiap unit.
- **Kategorisasi & Merek**: Pengelompokan mobil berdasarkan merek dan kategori.
- **Spesifikasi Detail**: Pencatatan spesifikasi lengkap seperti Tahun, KM, Transmisi, Bahan Bakar, dan CC Mesin.
- **Status & Harga**: Pengaturan harga, status ketersediaan, dan fitur "Mobil Unggulan" (Featured) untuk ditampilkan di halaman beranda.
- **Panel Admin yang Intuitif**: Antarmuka administrator yang mudah digunakan dan responsif.

## 🛠️ Teknologi yang Digunakan

- **Framework**: Laravel
- **Database**: MySQL
- **Styling/Frontend**: CSS / Blade Templates

## 🚀 Panduan Instalasi (Lokal)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi Juragan Otomotif di komputer Anda secara lokal.

### Persyaratan Sistem

- PHP >= 8.1
- Composer
- MySQL / MariaDB (misalnya menggunakan Laragon/XAMPP)

### Langkah-langkah

1. **Buka folder proyek**
   Buka terminal/CMD dan arahkan ke folder proyek Anda.

    ```bash
    cd c:\laragon\www\JuraganOtomotif
    ```

2. **Install Dependensi PHP**
   Jika Anda baru pertama kali memindahkan proyek ini atau belum menginstall dependensi:

    ```bash
    composer install
    ```

3. **Konfigurasi Environment**
   Pastikan Anda sudah memiliki file `.env` (bisa dengan menyalin dari `.env.example`).
   Sesuaikan konfigurasi database Anda di dalam file `.env`:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=juragan_otomotif # Sesuaikan dengan nama database Anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4. **Generate Application Key** (Jika baru clone/setup)

    ```bash
    php artisan key:generate
    ```

5. **Link Storage**
   Agar foto mobil yang diupload dapat diakses:

    ```bash
    php artisan storage:link
    ```

6. **Migrasi Database & Seeder**
   Jalankan perintah ini untuk membuat tabel (pastikan database sudah dibuat di phpMyAdmin/Laragon):

    ```bash
    php artisan migrate --seed
    ```

7. **Jalankan Aplikasi**
    ```bash
    php artisan serve
    ```
    Aplikasi dapat diakses melalui browser di alamat: `http://127.0.0.1:8000`

## 👨‍💻 Pengembang

Aplikasi ini dikembangkan oleh:

- **Muhammad Rifqi Saifulloh** (221011400528)
  <!-- - **Ahmad Baihaqi** (221011402031) -->

---

_Dibuat untuk mempermudah operasional manajemen showroom Juragan Otomotif._

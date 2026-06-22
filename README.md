# 🏔️ Project Gunung

Aplikasi web berbasis **Laravel 13** untuk manajemen dan rental perlengkapan gunung. Dibangun dengan Tailwind CSS, Alpine.js, dan Vite.

---

## 🧰 Persyaratan Sistem

Sebelum memulai, pastikan kamu sudah menginstal semua tools berikut:

| Tool | Versi Minimum | Keterangan |
|------|--------------|------------|
| [Laragon](https://laragon.org/download/) | Full / Portable | PHP, MySQL, Apache sudah termasuk |
| PHP | **8.3+** | Sudah ada di dalam Laragon |
| Composer | Latest | Sudah ada di dalam Laragon |
| Node.js | **18+** | Download di [nodejs.org](https://nodejs.org) |
| Git | Latest | Download di [git-scm.com](https://git-scm.com) |

> **Catatan:** Laragon sudah menyertakan PHP, Composer, MySQL, dan Apache secara otomatis. Kamu hanya perlu menginstal Node.js dan Git secara terpisah.

---

## 🚀 Langkah-langkah Menjalankan Proyek

### 1. Clone / Salin Proyek ke Folder Laragon

Laragon secara default membaca proyek dari folder `C:\laragon\www`. Salin atau clone proyek ke dalam folder tersebut.

**Jika menggunakan Git:**
```bash
cd C:\laragon\www
git clone <URL_REPOSITORY_KAMU> project-gunung
```

**Jika sudah ada folder proyeknya**, cukup pindahkan/salin folder `project-gunung` ke:
```
C:\laragon\www\project-gunung
```

---

### 2. Buka Terminal Laragon

Ada dua cara membuka terminal di Laragon:

- Klik kanan ikon **Laragon di system tray** → pilih **Terminal**
- Atau tekan tombol **Terminal** di jendela Laragon

---

### 3. Masuk ke Folder Proyek

```bash
cd C:\laragon\www\project-gunung
```

---

### 4. Install Dependensi PHP (Composer)

```bash
composer install
```

> Tunggu hingga semua package terunduh. Proses ini membutuhkan koneksi internet dan mungkin memakan waktu beberapa menit.

---

### 5. Salin File Environment

```bash
copy .env.example .env
```

> Di terminal Linux/macOS, gunakan: `cp .env.example .env`

---

### 6. Generate Application Key

```bash
php artisan key:generate
```

---

### 7. Konfigurasi Database

Proyek ini menggunakan **SQLite** secara default (tidak perlu setup MySQL).

Buat file database SQLite:
```bash
# Jika belum ada file database.sqlite di folder database/
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
```

Pastikan file `.env` memiliki konfigurasi berikut:
```env
DB_CONNECTION=sqlite
# DB_HOST, DB_PORT, DB_DATABASE, dll dibiarkan ter-comment (#)
```

> **Opsional - Jika ingin pakai MySQL:**
> 1. Buka phpMyAdmin via Laragon (klik **Database** → **phpMyAdmin**)
> 2. Buat database baru, misalnya: `project_gunung`
> 3. Edit file `.env`:
>    ```env
>    DB_CONNECTION=mysql
>    DB_HOST=127.0.0.1
>    DB_PORT=3306
>    DB_DATABASE=project_gunung
>    DB_USERNAME=root
>    DB_PASSWORD=
>    ```

---

### 8. Jalankan Migrasi Database

```bash
php artisan migrate
```

> Ini akan membuat semua tabel yang dibutuhkan aplikasi. Ketik `yes` jika ada konfirmasi.

---

### 9. (Opsional) Jalankan Seeder

```bash
php artisan db:seed
```

> Mengisi database dengan data awal/contoh.

---

### 10. Install Dependensi Node.js (npm)

```bash
npm install
```

> Ini akan menginstal Vite, Tailwind CSS, Alpine.js, dan semua dependensi frontend.

---

### 11. Jalankan Aplikasi

Kamu punya **dua pilihan** untuk menjalankan aplikasi:

#### ✅ Pilihan A — Menggunakan Virtual Host Laragon (Direkomendasikan)

Laragon secara otomatis membuat virtual host untuk setiap folder di `C:\laragon\www`.

1. **Start Laragon** — klik tombol **Start All**
2. **Jalankan Vite** di terminal:
   ```bash
   npm run dev
   ```
3. Buka browser dan akses:
   ```
   http://project-gunung.test
   ```

> Laragon otomatis menambahkan domain `.test` untuk setiap folder proyek. Jika tidak bisa diakses, pastikan Apache & MySQL sudah berjalan (indikator hijau di Laragon).

#### ✅ Pilihan B — Menggunakan `php artisan serve`

Jalankan dua terminal secara bersamaan:

**Terminal 1 — Backend:**
```bash
php artisan serve
```

**Terminal 2 — Frontend:**
```bash
npm run dev
```

Kemudian buka browser dan akses:
```
http://localhost:8000
```

---

## 🛠️ Perintah Berguna Lainnya

| Perintah | Fungsi |
|----------|--------|
| `php artisan migrate:fresh` | Reset & buat ulang semua tabel |
| `php artisan migrate:fresh --seed` | Reset tabel + isi data awal |
| `php artisan cache:clear` | Bersihkan cache aplikasi |
| `php artisan config:clear` | Bersihkan cache konfigurasi |
| `php artisan route:list` | Tampilkan semua route yang terdaftar |
| `npm run build` | Build aset frontend untuk production |

---

## 📂 Struktur Direktori Penting

```
project-gunung/
├── app/                  # Logic aplikasi (Models, Controllers, dll)
│   ├── Http/
│   │   └── Controllers/  # Semua controller
│   └── Models/           # Semua model Eloquent
├── database/
│   ├── migrations/       # File migrasi tabel database
│   └── seeders/          # File seeder data awal
├── resources/
│   ├── css/              # File CSS (Tailwind)
│   ├── js/               # File JavaScript (Alpine.js)
│   └── views/            # Template Blade (HTML)
│       └── layouts/      # Layout utama & navigasi
├── routes/
│   └── web.php           # Definisi semua route web
├── public/               # File publik (entry point web server)
├── .env                  # Konfigurasi environment (tidak di-commit ke Git)
├── .env.example          # Template konfigurasi environment
├── composer.json         # Dependensi PHP
├── package.json          # Dependensi Node.js
└── vite.config.js        # Konfigurasi Vite
```

---

## ❗ Troubleshooting

### Error: `Vite manifest not found`
Frontend belum di-build. Jalankan:
```bash
npm run dev   # untuk development
# atau
npm run build # untuk production
```

### Error: `php_pdo_sqlite` extension not enabled
1. Buka Laragon → klik kanan → **PHP** → **php.ini**
2. Cari baris `;extension=pdo_sqlite` dan hapus tanda titik koma (`;`)
3. Restart Laragon

### Error: `key not set` atau halaman error 500
Pastikan sudah generate key:
```bash
php artisan key:generate
```

### Error: `SQLSTATE: unable to open database file`
Buat file database SQLite secara manual:
```bash
touch database/database.sqlite
```

### Halaman tidak ditemukan / 404 setelah login
```bash
php artisan route:cache
php artisan config:cache
```

### Permission error pada folder `storage/`
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 👥 Kontribusi

1. Buat branch baru: `git checkout -b fitur/nama-fitur`
2. Commit perubahan: `git commit -m "feat: tambah fitur X"`
3. Push ke repository: `git push origin fitur/nama-fitur`
4. Buat Pull Request

---

## 📄 Lisensi

Proyek ini bersifat private dan hanya untuk keperluan internal.

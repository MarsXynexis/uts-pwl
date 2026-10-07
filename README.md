# Sistem Manajemen Akun & Hak Akses (UTS PWL)

Dokumentasi proyek aplikasi web PHP Native MVC untuk Ujian Tengah Semester (UTS) mata kuliah Pemrograman Web Lanjut, Jurusan Teknik Informatika dan Komputer, Politeknik Negeri Jakarta.

---

## 1. Deskripsi Sistem

Aplikasi ini digunakan untuk mengelola data akun pengguna, tipe akun (role), dan jenis aksi (hak akses) menggunakan PHP Native dengan pola MVC tanpa framework.

### Fitur Utama:
1. **Autentikasi**:
   - Login menggunakan email dan password.
   - Proteksi sesi (`authCheck`) agar halaman tidak bisa diakses sebelum login.
   - Logout dan pembersihan session.
2. **Manajemen Akun**:
   - Menampilkan daftar akun beserta tipe akun dan status (Aktif/Nonaktif).
   - Pencarian data akun.
   - Tambah akun baru (tipe akun dan identitas NIM/NIP).
   - Edit data akun dan ubah password (opsional).
   - Hapus akun (soft delete).
   - Proteksi akun: user tidak bisa menghapus akun sendiri yang sedang dipakai login.
3. **Manajemen Tipe Akun**:
   - Menampilkan daftar tipe akun (Admin, Dosen, Mahasiswa).
   - Tambah dan edit tipe akun (validasi nama unik).
   - Hapus tipe akun (soft delete, dicegah jika sedang dipakai akun).
4. **Manajemen Jenis Aksi**:
   - Menampilkan daftar jenis aksi (Create, Read, Update, Delete).
   - Pencarian data aksi.
   - Tambah, edit, dan hapus jenis aksi (soft delete).

---

## 2. Kebutuhan Sistem & Basis Data

### Kebutuhan Perangkat Lunak & Antarmuka:
- Backend: PHP >= 8.0 (ekstensi PDO MySQL)
- Web Server: Apache (mod_rewrite aktif)
- Database: MySQL / MariaDB
- Template UI: NiceAdmin (Bootstrap 5)
- Ikon: Bootstrap Icons
- Notifikasi: SweetAlert2

### Basis Data:
Nama database sesuai format soal:  
`PBL_{JURUSAN}_{ANGKATAN}_{KELAS}_{NAMA}` (contoh: `PBL_TI_2025_3C_NAMA`).

Setiap tabel menggunakan primary key UUID (`VARCHAR(36)`) serta kolom `created_at`, `updated_at`, dan `deleted_at`.

### Skema Tabel:

```text
+--------------------------------------------------------------------------+
|                                accounts                                  |
+--------------------------------------------------------------------------+
| id                     VARCHAR(36) [PK, UUID]                            |
| name                   VARCHAR(128)                                      |
| email                  VARCHAR(128) [UNIQUE]                             |
| password               TEXT                                              |
| account_type_id        VARCHAR(36) [FK -> account_type.id]               |
| status                 VARCHAR(128)                                      |
| identification_number  VARCHAR(128)                                      |
| identification_type    ENUM('NIM', 'NIP')                                |
| created_at             DATETIME                                          |
| updated_at             DATETIME                                          |
| deleted_at             DATETIME [NULLable]                               |
+--------------------------------------------------------------------------+
                                     |
                                     | (relasi ke account_type)
                                     v
+------------------------------------+      +------------------------------+
|            account_type            |      |           actions            |
+------------------------------------+      +------------------------------+
| id           VARCHAR(36) [PK, UUID]|      | id           VARCHAR(36) [PK]|
| name         VARCHAR(128)          |      | name         VARCHAR(128)    |
| description  TEXT                  |      | description  TEXT            |
| created_at   DATETIME              |      | created_at   DATETIME        |
| updated_at   DATETIME              |      | updated_at   DATETIME        |
| deleted_at   DATETIME [NULLable]   |      | deleted_at   DATETIME [NULL] |
+------------------------------------+      +------------------------------+
```

---

## 3. Konsep MVC & Logika Fitur

### Alur MVC:

```text
[ Browser ] -> index.php -> core/App.php -> controllers/ -> models/ & views/ -> [ Browser ]
```

- `index.php`: Entry point utama aplikasi.
- `core/App.php`: Router URL (`/controller/method/parameter`).
- `core/Controller.php`: Base controller (render view, load model, redirect, proteksi login).
- `core/Database.php`: Wrapper database PDO (prepared statements).
- `controllers/`: Logika alur proses dan validasi form.
- `models/`: Query database dan filter soft delete (`deleted_at IS NULL`).
- `views/`: File tampilan HTML/PHP.

### Logika Fitur:
1. **Password**: Di-hash dengan `password_hash()` dan diverifikasi saat login dengan `password_verify()`.
2. **Soft Delete**: Data yang dihapus diisi kolom `deleted_at = NOW()`, query SELECT memfilter `WHERE deleted_at IS NULL`.
3. **Auto-Restore**: Jika menginput data unik yang sudah berstatus soft delete, sistem me-restore data lama (`deleted_at = NULL`) dan memperbarui isinya agar tidak terjadi error duplicate entry.
4. **Proteksi Hapus**: User tidak bisa menghapus akun sendiri, dan tipe akun yang masih dipakai akun aktif tidak bisa dihapus.

---

## 4. Panduan Setup

1. **Clone Repositori**:
   Simpan di folder web server (`htdocs` / `www`):
   ```bash
   git clone https://github.com/MarsXynexis/uts-pwl.git
   ```

2. **Konfigurasi File `.env`**:
   Salin `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Sesuaikan konfigurasi database di file `.env`:
   ```env
   DB_HOST=localhost
   DB_PORT=3306
   DB_NAME=PBL_TI_2025_3C_NAMA
   DB_USER=root
   DB_PASS=
   ```

3. **Import Basis Data**:
   - Buat database di phpMyAdmin sesuai nama di `.env`.
   - Import file `database.sql` ke database tersebut.

4. **Jalankan Aplikasi**:
   - Pastikan Apache dan MySQL aktif.
   - Buka browser dan akses: `http://localhost/uts-pwl`

Akun login pengujian:
- Email: `admin@pnj.ac.id`

---

## 5. Struktur Direktori Proyek

```text
uts-pwl/
├── .NiceAdmin_TemplateUI/   # Template NiceAdmin
├── assets/                  # File CSS, JS, gambar
│   ├── css/                 # style.css
│   ├── js/                  # main.js
│   └── vendor/              # Bootstrap 5, Bootstrap Icons, SweetAlert2
├── controllers/             # Controller
│   ├── AccountController.php
│   ├── AccountTypeController.php
│   ├── ActionController.php
│   ├── AuthController.php
│   └── HomeController.php
├── core/                    # Inti MVC
│   ├── App.php              # Router URL
│   ├── Controller.php       # Base controller
│   └── Database.php         # PDO wrapper
├── models/                  # Model (query database)
│   ├── Account.php
│   ├── AccountType.php
│   └── Action.php
├── views/                   # Tampilan
│   ├── account/             # Modul Akun
│   ├── account-type/        # Modul Tipe Akun
│   ├── action/              # Modul Jenis Aksi
│   ├── auth/                # Halaman login
│   └── layouts/             # Layout (header, sidebar, footer)
├── .env.example             # Contoh file konfigurasi
├── database.sql             # Skema dan data awal database
├── index.php                # Entry point aplikasi
└── README.md                # Dokumentasi sistem
```

---

## 6. Demo Aplikasi

Link Demo: https://drive.google.com/drive/folders/1h7aJO9U5QosoAojdVfl2WTQopITQZIFR

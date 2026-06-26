# SIAK - Sistem Informasi Akademik Sederhana

Aplikasi web berbasis **Laravel** yang mensimulasikan Sistem Informasi Akademik (SIAKAD) sederhana. Dibuat sebagai Tugas Besar Mata Kuliah Web II.

🔗 **Link Hosting:** [ kikisiak.page.gd ] disarankan jangan buka di edge

---

## Identitas

- **Nama:** [Moh Fadilah Rizki]
- **NPM:** [5520124085]
- **Kelas:** [IF-C 24]

---

## Deskripsi Aplikasi

SIAK adalah aplikasi pengelolaan data akademik kampus secara sederhana, mencakup pengelolaan data Dosen, Mahasiswa, Matakuliah, Jadwal Perkuliahan, hingga Kartu Rencana Studi (KRS). Aplikasi ini memiliki dua jenis pengguna dengan hak akses berbeda:

- **Admin** — dapat mengelola seluruh data (Dosen, Mahasiswa, Matakuliah, Jadwal, KRS)
- **Mahasiswa** — hanya dapat melihat jadwal kuliah sesuai matakuliah yang diambil, mengisi KRS, dan melihat KRS miliknya sendiri

---

## Fitur Utama

### Autentikasi & Otorisasi
- Login & Logout (Laravel Breeze)
- 2 role pengguna: **Admin** dan **Mahasiswa**, masing-masing dengan hak akses berbeda (dibatasi via Middleware)
- Ubah password sendiri lewat halaman Dashboard
- Reset password mahasiswa oleh Admin
- Reset password Admin lewat mekanisme darurat (untuk keperluan hosting gratisan/shared tanpa akses SSH)

### Manajemen Data (CRUD)
- **Dosen** — Tambah, Edit, Hapus, Lihat Detail
- **Mahasiswa** — Tambah, Edit, Hapus, Lihat Detail (otomatis membuat akun login untuk setiap mahasiswa baru)
- **Matakuliah** — Tambah, Edit, Hapus, Lihat Detail
- **Jadwal** — Tambah, Edit, Hapus, Lihat Detail (relasi ke Dosen & Matakuliah, termasuk penentuan kelas, hari, dan jam)
- **KRS** — Tambah (ambil matakuliah + kelas), Hapus, Lihat Detail (relasi ke Mahasiswa & Matakuliah)

### Validasi
Setiap form dilengkapi validasi Laravel (required, unique, exists, dll) beserta pesan error yang jelas.

### Bonus
- 🔍 Pencarian & filter data pada setiap halaman daftar
- 📄 Pagination pada setiap halaman daftar
- 📊 Dashboard statistik (jumlah Dosen, Mahasiswa, Matakuliah, Jadwal, KRS untuk Admin; statistik pribadi untuk Mahasiswa)
- 📑 Export data KRS ke PDF dan Excel

---

## Penjelasan Fungsi Tiap Halaman

| Halaman | Fungsi |
|---|---|
| **Login** | Autentikasi pengguna (Admin/Mahasiswa) untuk masuk ke sistem |
| **Dashboard** | Menampilkan ringkasan statistik data akademik (Admin) atau statistik pribadi (Mahasiswa), serta form ubah password |
| **Dosen** | Kelola data dosen pengampu matakuliah (khusus Admin) |
| **Mahasiswa** | Kelola data mahasiswa beserta dosen walinya, termasuk reset password akun mahasiswa (khusus Admin) |
| **Matakuliah** | Kelola data matakuliah dan jumlah SKS (khusus Admin) |
| **Jadwal** | Kelola jadwal perkuliahan (Admin); Mahasiswa hanya dapat melihat jadwal dari matakuliah dan kelas yang telah diambil di KRS |
| **KRS** | Pengelolaan Kartu Rencana Studi. Admin dapat mengelola KRS seluruh mahasiswa; Mahasiswa hanya dapat mengelola KRS miliknya sendiri, termasuk export ke PDF/Excel |

---

## Teknologi yang Digunakan

- **Laravel** (PHP Framework)
- **Laravel Breeze** (Autentikasi)
- **MySQL** (Database)
- **Bootstrap** (UI Framework)
- **Eloquent ORM** & **Eloquent Relationship**
- **Migration** & **Seeder**
- **Middleware** (Role-based access control)
- **barryvdh/laravel-dompdf** (Export PDF)
- **maatwebsite/excel** (Export Excel)

---

## Struktur Relasi Database (ERD)

- **dosen** — memiliki banyak **mahasiswa** (sebagai dosen wali) dan **jadwal**
- **mahasiswa** — memiliki banyak **krs**
- **matakuliah** — memiliki banyak **jadwal** dan **krs**
- **jadwal** — terhubung ke **dosen** dan **matakuliah**
- **krs** — terhubung ke **mahasiswa** dan **matakuliah**

---

## Cara Menjalankan di Lokal

```bash
# Clone repository
git clone [link-repo]
cd [nama-folder-project]

# Install dependency
composer install
npm install && npm run build

# Konfigurasi environment
cp .env.example .env
php artisan key:generate
# Sesuaikan konfigurasi database di file .env

# Migrasi & seeding database
php artisan migrate:fresh --seed

# Jalankan server
php artisan serve
```

### Akun Default (hasil seeder)
| Role | Email | Password |
|---|---|---|
| Admin | admin@gmail.com | password |
| Mahasiswa | [npm_mahasiswa]
              5520124085@gmail.com | password |

---

## Screenshot Aplikasi

| Halaman | Screenshot |
|---|---|
| Login | `screenshots/login.png` |
| Dashboard Admin | `screenshots/dashboard-admin.png` |
| Dashboard Mahasiswa | `screenshots/dashboard-mahasiswa.png` |
| Dosen | `screenshots/dosen.png` |
| Mahasiswa | `screenshots/mahasiswa.png` |
| Matakuliah | `screenshots/matakuliah.png` |
| Jadwal | `screenshots/jadwal.png` |
| KRS | `screenshots/krs.png` |

---

## Pembuat

Dibuat oleh **[Moh Fadilah Rizki]** sebagai Tugas Besar Mata Kuliah Web II (IF53413).

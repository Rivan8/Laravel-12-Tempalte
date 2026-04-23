# AGENTS.md - Project Documentation & Guide

Dokumen ini adalah panduan utama bagi AI (Antigravity) untuk memahami konteks, struktur, dan aturan pengembangan dalam repositori ini.

## 1. Tech Stack Summary
- **Framework Utama**: Laravel 12.0
- **Bahasa Pemrograman**: PHP 8.2+
- **Frontend Framework**: Tailwind CSS (v3.1+ / v4.0 Vite integration)
- **JS Framework/Library**: Alpine.js, Axios
- **Asset Bundler**: Vite 7.0
- **Database**: MySQL (relational)
- **Templating Engine**: Blade
- **Package Managers**: Composer (PHP), NPM (JS)
- **Fitur Tambahan**: 
  - Laravel Breeze (Authentication)
  - Laravel Sanctum (API Auth)
  - Barryvdh DomPDF (PDF Generation)
  - Expo (Mobile Support integration)

## 2. Struktur Folder Utama
- `/app`
  - `/Http/Controllers`: Logika bisnis dan penanganan request.
  - `/Models`: Definisi model Eloquent dan relasi database.
  - `/Http/Requests`: Validasi form request.
- `/database`
  - `/migrations`: Definisi skema database.
  - `/seeders`: Data awal untuk testing/development.
- `/resources`
  - `/views`: File Blade untuk UI (Admin & User).
  - `/css`: File CSS utama (Tailwind entry point).
  - `/js`: Logika JavaScript (Alpine.js setup).
- `/routes`
  - `web.php`: Rute aplikasi web.
  - `api.php`: Rute API.
- `/public`: Aset statis yang dapat diakses publik.

## 3. Aturan Coding & Design Guidelines
### Styling (CSS)
- **Wajib menggunakan Tailwind CSS**. Hindari menulis inline styles atau vanilla CSS di file `.css` kecuali sangat mendesak.
- **Aesthetics**: Gunakan desain yang premium, modern, dan clean. Gunakan gradasi halus, bayangan (shadow), dan rounded corners yang konsisten.
- **Warna**: Gunakan palet warna yang harmonis. Font utama menggunakan `Inter` dan untuk heading menggunakan `Poppins` (seperti yang dikonfigurasi di `tailwind.config.js`).
- **Responsive**: Pastikan semua UI yang dibuat bersifat mobile-friendly.

### Backend (PHP/Laravel)
- Ikuti standar PSR-12.
- Gunakan Eloquent untuk interaksi database.
- Validasi data selalu dilakukan di level Controller atau FormRequest.
- Gunakan Resource Controllers jika memungkinkan untuk konsistensi.

### Frontend Logic
- Gunakan **Alpine.js** untuk interaktivitas ringan (modal, dropdown, toggle).
- Gunakan **Blade Components** untuk elemen UI yang berulang.

## 4. Skema Database (Ringkasan)

### `users`
- `id`, `nama_lengkap`, `jenis_kelamin` (Laki-laki/Perempuan), `email` (unique), `no_hp`, `role` (Admin, Fasilitator, Member), `password`.

### `kelas` (Kursus/Classes)
- `id`, `nama_kelas`, `kategori`, `deskripsi`, `gambar`, `prasyarat`, `link_quiz`, `download_files`.

### `materis` (Lessons/Materials)
- `id`, `kelas_id` (FK), `judul`, `deskripsi`, `video_url`, `urutan`, `pembicara`.

### `batches`
- `id`, `kelas_id` (FK), `nama_batch`, `start_date`, `is_active`.

### `kelas_users` (Enrollment/Pivot)
- `id`, `user_id` (FK), `kelas_id` (FK), `batch_id` (FK), `status` ('requested', 'in_progress', 'completed', 'rejected'), `rejection_reason`.

### `materi_users` (Progress Tracking)
- `id`, `user_id` (FK), `materi_id` (FK), `is_completed` (boolean).

---
*Catatan: Selalu periksa file migrasi terbaru untuk perubahan skema yang lebih detail.*

# GreenBin Secure

Aplikasi web manajemen sampah yang aman untuk pengujian keamanan jaringan (Red Team vs Blue Team).

## Teknologi

- Laravel 10
- PHP 8.1
- MySQL
- Bootstrap 5
- Eloquent ORM

## Fitur Keamanan

1. **Password Hashing** - bcrypt
2. **Session Management** - Timeout 15 menit, logout hapus session
3. **Input Validation** - Laravel Validation
4. **SQL Injection Protection** - Eloquent ORM
5. **XSS Protection** - Blade escaped output `{{ }}`
6. **CSRF Protection** - Token CSRF di semua form
7. **Rate Limiting Login** - 5x gagal -> lock 5 menit
8. **Role Based Access Control** - Middleware per role
9. **Secure File Upload** - Hanya jpg/jpeg/png, maks 2MB, UUID rename, MIME validation
10. **Security Headers** - X-Frame-Options, X-Content-Type-Options, Referrer-Policy, CSP

## Akun Default

| Role     | Username | Password      |
|----------|----------|---------------|
| ADMIN    | admin    | Admin123!     |
| PETUGAS  | petugas  | Petugas123!   |
| WARGA    | warga    | Warga123!     |

## Cara Install

```bash
# 1. Clone project
git clone https://github.com/username/greenbin-secure.git
cd greenbin-secure

# 2. Install dependencies
composer install

# 3. Copy environment
copy .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Buat database MySQL
# Buat database bernama greenbin_secure

# 6. Edit .env
# DB_CONNECTION=mysql
# DB_DATABASE=greenbin_secure
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Migrasi dan seeder
php artisan migrate --seed

# 8. Buat storage link
php artisan storage:link

# 9. Jalankan server
php artisan serve

# 10. Buka browser
# http://localhost:8000
```

## Struktur Role

- **ADMIN**: Kelola user, lihat semua setoran, lihat activity log
- **PETUGAS**: Lihat setoran, approve/reject setoran
- **WARGA**: Registrasi, tambah setoran, upload foto, riwayat setoran

## Catatan Keamanan untuk Blue Team

- Semua input sudah divalidasi
- File upload terbatas dan direname UUID
- Session timeout 15 menit
- Akun terkunci setelah 5x gagal login
- RBAC strict via middleware
- Semua aktivitas tercatat di activity_logs

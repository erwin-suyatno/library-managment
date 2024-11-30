# Library Management System API

## About
Library Management System API adalah sistem backend yang dibangun dengan Laravel untuk mengelola perpustakaan modern. Sistem ini menyediakan API endpoints untuk manajemen buku, peminjaman, dan pengembalian dengan fitur perhitungan denda otomatis.

## Tech Stack
- PHP 8.2+
- Laravel 11.x
- MySQL
- Laravel Sanctum untuk autentikasi

## Key Features
- 🔐 Autentikasi dengan Laravel Sanctum
- 📚 Manajemen Buku (CRUD)
- 📖 Sistem Peminjaman Buku
- 💰 Perhitungan Denda Otomatis
- 🚀 API Documentation
- ⚡ Rate Limiting
- 🔍 Search & Filter

## Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- Laravel CLI

## Installation

1. Clone repository
```bash
git clone https://github.com/yourusername/library-managment.git
cd library-managment
```

2. Install dependencies
```bash
composer install
```

3. Copy .env.example to .env
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library-managment
DB_USERNAME=root
DB_PASSWORD=
```

5. Run migrations
```bash
php artisan migrate
```

6. Start server
```bash
php artisan serve
```
Server akan berjalan di http://localhost:8000

## Documentation
Dokumentasi lengkap tersedia di folder /docs:

- [API Documentation](/docs/DOC_API.md) - Detail endpoints dan penggunaan API
- [Code Standards](/docs/DOC_STANDART_CODE.md) - Coding standards dan best practices

## API Endpoints Overview

### Authentication API
- POST /api/auth/register - Register user baru
- POST /api/auth/login - Login user
- POST /api/auth/logout - Logout user

### Book API
- GET /api/books - List semua buku
- POST /api/books - Tambah buku baru
- GET /api/books/{id} - Detail buku
- PUT /api/books/{id} - Update buku
- DELETE /api/books/{id} - Hapus buku

### Loan API
- GET /api/loans - List semua peminjaman
- POST /api/loans - Pinjam buku
- PUT /api/loans/{loan_id}/return - Kembalikan buku

## Testing
Untuk menjalankan test, jalankan perintah berikut:
```bash
php artisan test
```

## Security
- Autentikasi menggunakan Laravel Sanctum
- Rate limiting: 60 requests/minute
- Validasi input ketat
- Password hashing
- Protected routes

## Contributing
- Fork repository
- Buat branch baru (git checkout -b feature/AmazingFeature)
- Commit changes (git commit -m 'Add some AmazingFeature')
- Push ke branch (git push origin feature/AmazingFeature)
- Buat Pull Request

## Contact
Erwin Suyatno - erwinsuyatno.es@gmail.com

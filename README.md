# Library Management System

Library Management System adalah aplikasi web modern yang dirancang untuk memudahkan pengelolaan perpustakaan secara efisien dan efektif. Sistem ini menyediakan fitur lengkap untuk manajemen buku, peminjaman, dan pengelolaan anggota perpustakaan.

### ✨ Highlights
- Interface modern dan mudah digunakan
- Sistem peminjaman dan pengembalian yang efisien
- Manajemen buku dan anggota yang komprehensif
- Pencarian buku yang cepat
- Laporan dan statistik perpustakaan

## 🚀 Features

- 📚 Book Management
  - Add, edit, and delete books
  - Upload book covers
  - Track book availability

- 👥 User Management
  - User authentication
  - Role-based access control (Admin/User)
  - User registration
  - User management for admins (view, edit, delete users)

- 📖 Borrowing System
  - Borrow books
  - Return books
  - Track borrowed books
  - Borrowing history

- 🔒 Password Reset
  - Users can reset their passwords via email verification.

## 🛠️ Tech Stack

### Backend
- Laravel 10
- MySQL
- PHP 8.1+
- Laravel Sanctum for authentication

### Frontend
- Vue 3 with Composition API
- TypeScript
- Tailwind CSS
- Pinia for state management
- Vue Router

## 📋 Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js (v14 or higher)
- MySQL
- npm or yarn

## 🔧 Installation

### Backend Setup

1. Navigate to backend directory
```bash
cd backend
```

2. Install dependencies
```bash
composer install
```

3. Create and configure .env
```bash
cp .env.example .env
# Configure your database settings
```

4. Generate application key
```bash
php artisan key:generate
```

5. Run migrations and seeders
```bash
php artisan migrate --seed
```

6. Start the server
```bash
php artisan serve
```

### Frontend Setup

1. Navigate to frontend directory
```bash
cd frontend
```

2. Install dependencies
```bash
npm install
# or
yarn install
```

3. Configure .env
```bash
VITE_API_URL=http://localhost:9000/api
```

4. Start development server
```bash
npm run dev
# or
yarn dev
```

## 📁 Project Structure

```
library-management/
├── backend/                 # Laravel backend
│   ├── app/
│   ├── database/
│   ├── routes/
│   └── ...
│
└── frontend/               # Vue.js frontend
    ├── src/
    │   ├── components/
    │   ├── views/
    │   ├── stores/
    │   └── ...
    └── ...
```

## 🔐 Authentication

The system supports two types of users:
- Regular users: Can browse and borrow books
- Admin users: Full access to manage books and users

## 📱 Key Components

### Frontend
- Book listing and management
- User authentication
- Borrowed books tracking
- Responsive design

### Backend
- RESTful API endpoints
- Authentication middleware
- File upload handling
- Database management

## 🔄 API Endpoints

### Authentication
- POST /api/auth/login
- POST /api/auth/register
- GET /api/auth/user

### Books
- GET /api/books
- POST /api/books
- PUT /api/books/{id}
- DELETE /api/books/{id}

### Loans
- GET /api/loans
- POST /api/loans/borrow
- PUT /api/loans/{id}/return

### Users
- GET /api/users
- GET /api/users/{id}
- PUT /api/users/{id}
- GET /api/users/check-email/{email}
- GET /api/users/email/{email}
- DELETE /api/users/{id}
- PUT /api/users/reset-password

## 🔨 Development

### Backend
```bash
# Run tests
php artisan test

# Database refresh
php artisan migrate:fresh --seed


# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed

# RUN with docker compose
docker-compose up -d

# Stop docker compose
docker-compose down

# Build docker compose
docker-compose build --no-cache

# Run docker compose migrations and seeders
docker-compose exec app php artisan migrate:fresh --seed
```

### Frontend
```bash
# Build for production
npm run build

# Type checking
npm run type-check

# Linting
npm run lint

# Run Local
npm run dev
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📄 License

This project is licensed under the MIT License.

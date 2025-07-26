# 🚀 Quick Installation Guide

## Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+
- Git

## Installation Steps

### 1. Clone & Setup
```bash
git clone <repository-url>
cd laravel-test-acq
composer install
npm install
```

### 2. Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration
Edit `.env` file:
```env
DB_DATABASE=laravel_ecommerce
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Create database:
```bash
mysql -u root -p
CREATE DATABASE laravel_ecommerce;
exit
```

### 4. Setup Database
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

### 5. Build & Run
```bash
npm run dev
php artisan serve
```

## 🎯 Access the Application

- **Website**: http://127.0.0.1:8000
- **Admin**: admin@admin.com / password
- **Customer**: customer@example.com / password

## 🐛 Quick Fixes

**Permission Issues:**
```bash
chmod -R 775 storage bootstrap/cache
```

**Cache Issues:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

**Database Reset:**
```bash
php artisan migrate:fresh --seed
```

For detailed troubleshooting, see the main [README.md](README.md) file. 
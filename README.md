# 🛒 Laravel Ecommerce Platform

A comprehensive ecommerce platform built with Laravel 12.0, featuring a modern Bootstrap frontend, complete admin panel, and customer management system.

![Laravel](https://img.shields.io/badge/Laravel-12.0-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange.svg)

## 📋 Table of Contents

- [Features](#-features)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Database Setup](#-database-setup)
- [Login Credentials](#-login-credentials)
- [Usage](#-usage)
- [API Endpoints](#-api-endpoints)
- [File Structure](#-file-structure)
- [Technologies Used](#-technologies-used)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### 🛍️ **Frontend/Customer Features**
- **Product Catalog** - Browse products with beautiful image galleries
- **Advanced Filtering** - Filter by category, price range, and search
- **Shopping Cart** - Add, update, remove items with real-time calculations
- **Secure Checkout** - Complete order placement with shipping information
- **Customer Dashboard** - Order history and purchase analytics
- **Order Tracking** - Track order status and view detailed information
- **User Profile** - Update personal information and preferences
- **Responsive Design** - Works perfectly on desktop, tablet, and mobile

### 🏢 **Admin Panel Features**
- **Dashboard Analytics** - Sales statistics and performance metrics
- **Product Management** - Full CRUD operations with image uploads
- **Category Management** - Organize products into categories
- **Order Management** - Process orders and update statuses
- **Customer Management** - View customer details and order history
- **Invoice Generation** - PDF invoices for orders
- **Advanced Reporting** - Export reports in PDF, Excel formats
- **Role-Based Access** - Secure admin authentication

### 🔧 **Technical Features**
- **Modern UI** - Bootstrap 5.3 with Font Awesome icons
- **File Uploads** - Support for local and external images
- **PDF Generation** - DomPDF for invoices and reports
- **Excel Export** - Maatwebsite/Excel for data export
- **Role Management** - Spatie Laravel Permission
- **Database Relationships** - Properly structured with foreign keys
- **Input Validation** - Comprehensive form validation
- **Security** - CSRF protection and authorization policies

## 🔧 Requirements

Before installing, ensure your system meets these requirements:

- **PHP**: 8.2 or higher
- **Composer**: Latest version
- **Node.js**: 18.0 or higher
- **NPM**: 8.0 or higher
- **MySQL**: 8.0 or higher
- **Git**: Latest version

### PHP Extensions Required:
```bash
php -m | grep -E "(openssl|pdo|mbstring|tokenizer|xml|ctype|json|bcmath|fileinfo|gd)"
```

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd laravel-test-acq
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node.js Dependencies
```bash
npm install
```

### 4. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure Database
Edit the `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_ecommerce
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Create Database
```bash
# Create database (MySQL command line)
mysql -u root -p
CREATE DATABASE laravel_ecommerce;
exit
```

### 7. Run Migrations and Seeders
```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Create storage link for file uploads
php artisan storage:link
```

### 8. Build Frontend Assets
```bash
# Development build
npm run dev

# Or production build
npm run build
```

### 9. Start the Development Server
```bash
php artisan serve
```

The application will be available at: `http://127.0.0.1:8000`

## ⚙️ Configuration

### Additional Package Setup

The project uses several Laravel packages that are automatically configured:

1. **Laravel Breeze** - Authentication scaffolding
2. **Spatie Laravel Permission** - Role and permission management
3. **DomPDF** - PDF generation
4. **Maatwebsite Excel** - Excel export functionality
5. **Intervention Image** - Image processing

### File Storage Configuration

The project supports both local file storage and external image URLs:

```php
// config/filesystems.php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
```

## 🗄️ Database Setup

### Migration Files
The project includes migrations for:
- Users (with roles and permissions)
- Categories
- Products
- Shopping Cart
- Orders and Order Items
- Role and Permission tables

### Seeded Data
After running `php artisan db:seed`, you'll have:
- **Admin user**: admin@admin.com / password
- **Customer user**: customer@example.com / password
- **5 Categories**: Electronics, Clothing, Books, Home & Garden, Sports
- **10 Sample Products** with real images from Unsplash
- **Roles and Permissions** for admin and customer access

## 🔑 Login Credentials

### Admin Access
- **Email**: `admin@admin.com`
- **Password**: `password`
- **Access**: Full admin panel with all features

### Customer Access
- **Email**: `customer@example.com`
- **Password**: `password`
- **Access**: Customer dashboard and shopping features

### Admin Panel URL
After logging in as admin, access the admin panel at: `http://127.0.0.1:8000/admin/dashboard`

## 🎯 Usage

### For Customers:
1. **Browse Products**: Visit the homepage to see product catalog
2. **Filter Products**: Use category, price, and search filters
3. **Add to Cart**: Click "Add to Cart" on any product
4. **Checkout**: Review cart and complete purchase
5. **Track Orders**: View order history in customer dashboard

### For Admins:
1. **Login**: Use admin credentials to access admin panel
2. **Manage Products**: Add, edit, delete products with images
3. **Process Orders**: Update order statuses and generate invoices
4. **View Analytics**: Monitor sales and customer data
5. **Generate Reports**: Export data in various formats

## 🌐 API Endpoints

### Public Routes
```
GET  /                          # Homepage (redirects to products)
GET  /products                  # Product listing
GET  /products/{id}             # Product details
GET  /login                     # Login page
GET  /register                  # Registration page
```

### Authenticated Customer Routes
```
GET  /customer/dashboard        # Customer dashboard
GET  /customer/orders           # Order history
GET  /customer/orders/{id}      # Order details
GET  /cart                      # Shopping cart
POST /cart/add/{product}        # Add to cart
GET  /checkout                  # Checkout page
POST /checkout                  # Place order
```

### Admin Routes (Requires Admin Role)
```
GET  /admin/dashboard           # Admin dashboard
GET  /admin/products            # Product management
GET  /admin/categories          # Category management
GET  /admin/orders              # Order management
GET  /admin/customers           # Customer management
GET  /admin/reports             # Reports and analytics
```

## 📁 File Structure

```
laravel-test-acq/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Admin controllers
│   │   │   ├── Customer/        # Customer controllers
│   │   │   └── ...              # Other controllers
│   │   ├── Middleware/          # Custom middleware
│   │   └── Requests/            # Form requests
│   ├── Models/                  # Eloquent models
│   ├── Policies/                # Authorization policies
│   └── Exports/                 # Excel export classes
├── database/
│   ├── migrations/              # Database migrations
│   ├── seeders/                 # Database seeders
│   └── factories/               # Model factories
├── resources/
│   ├── views/
│   │   ├── admin/               # Admin panel views
│   │   ├── customer/            # Customer views
│   │   ├── products/            # Product views
│   │   ├── cart/                # Shopping cart views
│   │   └── layouts/             # Layout templates
│   ├── css/                     # Stylesheets
│   └── js/                      # JavaScript files
├── public/
│   └── storage/                 # Public file storage
├── routes/
│   ├── web.php                  # Web routes
│   └── auth.php                 # Authentication routes
└── storage/
    └── app/public/              # Private file storage
```

## 🛠️ Technologies Used

### Backend
- **Laravel 12.0** - PHP Framework
- **PHP 8.2+** - Programming Language
- **MySQL 8.0** - Database
- **Laravel Breeze** - Authentication
- **Spatie Permission** - Role Management

### Frontend
- **Bootstrap 5.3** - CSS Framework
- **Font Awesome 6** - Icons
- **Flatpickr** - Date Picker
- **Vanilla JavaScript** - Frontend Logic

### Additional Packages
- **DomPDF** - PDF Generation
- **Maatwebsite/Excel** - Excel Export
- **Intervention Image** - Image Processing

## 🐛 Troubleshooting

### Common Issues and Solutions

#### 1. **Database Connection Error**
```bash
# Check database credentials in .env file
# Ensure MySQL service is running
sudo service mysql start  # Linux
brew services start mysql # macOS
```

#### 2. **Permission Denied Errors**
```bash
# Fix storage and cache permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache  # Linux
```

#### 3. **Images Not Displaying**
```bash
# Create storage symlink
php artisan storage:link

# Check if public/storage exists
ls -la public/storage
```

#### 4. **Composer Install Fails**
```bash
# Update composer
composer self-update

# Clear composer cache
composer clear-cache

# Install with verbose output
composer install -v
```

#### 5. **NPM Build Errors**
```bash
# Clear NPM cache
npm cache clean --force

# Delete node_modules and reinstall
rm -rf node_modules package-lock.json
npm install
```

#### 6. **Migration Errors**
```bash
# Reset database and re-run migrations
php artisan migrate:fresh --seed

# Check database connection
php artisan tinker
DB::connection()->getPdo();
```

#### 7. **Admin Panel Not Accessible**
```bash
# Clear application cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Re-seed roles and permissions
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=AdminSeeder
```

### Environment-Specific Issues

#### **Development Environment**
- Ensure `.env` file exists and is properly configured
- Run `php artisan key:generate` if APP_KEY is missing
- Check file permissions on storage directories

#### **Production Environment**
- Set `APP_ENV=production` and `APP_DEBUG=false`
- Use `npm run build` for optimized assets
- Configure proper database credentials
- Set up SSL certificates for HTTPS

### Performance Optimization

```bash
# Cache configuration for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize composer autoloader
composer install --optimize-autoloader --no-dev
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 📞 Support

If you encounter any issues or need assistance:

1. Check the [Troubleshooting](#-troubleshooting) section
2. Review Laravel documentation: https://laravel.com/docs
3. Create an issue in the repository
4. Contact the development team


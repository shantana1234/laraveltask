<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Public Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Authenticated Customer Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Cart Routes
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Checkout Routes
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('order.place');
    
    // Customer Dashboard Routes
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/orders', [CustomerDashboardController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [CustomerDashboardController::class, 'orderDetails'])->name('orders.show');
        Route::get('/reports', [CustomerDashboardController::class, 'reports'])->name('reports');
    });
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Category Management
    Route::resource('categories', AdminCategoryController::class);
    
    // Product Management
    Route::resource('products', AdminProductController::class);
    
    // Order Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/{order}/invoice', [AdminOrderController::class, 'generateInvoice'])->name('orders.invoice');
    
    // Customer Management
    Route::get('/customers', [AdminOrderController::class, 'customers'])->name('customers.index');
    Route::get('/customers/{user}', [AdminOrderController::class, 'customerDetails'])->name('customers.show');
    
    // Reports
    Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
    Route::get('/reports/export', [AdminDashboardController::class, 'exportReports'])->name('reports.export');
});

require __DIR__.'/auth.php';

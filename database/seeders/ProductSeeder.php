<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electronics = Category::where('name', 'Electronics')->first();
        $clothing = Category::where('name', 'Clothing')->first();
        $books = Category::where('name', 'Books')->first();
        $homeGarden = Category::where('name', 'Home & Garden')->first();
        $sports = Category::where('name', 'Sports & Outdoor')->first();

        $products = [
            // Electronics
            [
                'category_id' => $electronics->id,
                'name' => 'Smartphone XYZ',
                'description' => 'Latest smartphone with advanced features, 6.1-inch display, dual camera system, and all-day battery life.',
                'price' => 699.99,
                'sale_price' => 599.99,
                'sku' => 'PHONE-001',
                'stock' => 50,
                'status' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1565849904461-04a58ad377e0?w=400&h=400&fit=crop'
                ],
            ],
            [
                'category_id' => $electronics->id,
                'name' => 'Laptop ABC',
                'description' => 'High-performance laptop for work and gaming with Intel i7 processor, 16GB RAM, and 512GB SSD.',
                'price' => 1299.99,
                'sku' => 'LAPTOP-001',
                'stock' => 25,
                'status' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=400&h=400&fit=crop'
                ],
            ],
            [
                'category_id' => $electronics->id,
                'name' => 'Wireless Headphones',
                'description' => 'Premium wireless headphones with noise cancellation, 30-hour battery life, and superior sound quality.',
                'price' => 199.99,
                'sale_price' => 149.99,
                'sku' => 'HEADPHONE-001',
                'stock' => 100,
                'status' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=400&h=400&fit=crop'
                ],
            ],

            // Clothing
            [
                'category_id' => $clothing->id,
                'name' => 'Cotton T-Shirt',
                'description' => 'Comfortable 100% cotton t-shirt for everyday wear. Available in multiple colors and sizes.',
                'price' => 29.99,
                'sku' => 'TSHIRT-001',
                'stock' => 200,
                'status' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=400&fit=crop'
                ],
            ],
            [
                'category_id' => $clothing->id,
                'name' => 'Denim Jeans',
                'description' => 'Classic blue denim jeans with perfect fit and premium quality fabric. Durable and stylish.',
                'price' => 79.99,
                'sale_price' => 59.99,
                'sku' => 'JEANS-001',
                'stock' => 150,
                'status' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=400&h=400&fit=crop'
                ],
            ],

            // Books
            [
                'category_id' => $books->id,
                'name' => 'Laravel Programming Guide',
                'description' => 'Complete guide to Laravel web development. Learn to build modern web applications with step-by-step tutorials.',
                'price' => 49.99,
                'sku' => 'BOOK-001',
                'stock' => 75,
                'status' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop'
                ],
            ],
            [
                'category_id' => $books->id,
                'name' => 'JavaScript Essentials',
                'description' => 'Essential guide to modern JavaScript programming. Master ES6+, async programming, and web APIs.',
                'price' => 39.99,
                'sale_price' => 29.99,
                'sku' => 'BOOK-002',
                'stock' => 80,
                'status' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=400&h=400&fit=crop'
                ],
            ],

            // Home & Garden
            [
                'category_id' => $homeGarden->id,
                'name' => 'Garden Tools Set',
                'description' => 'Complete set of garden tools for home gardening. Includes spade, rake, pruning shears, and watering can.',
                'price' => 89.99,
                'sku' => 'GARDEN-001',
                'stock' => 60,
                'status' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?w=400&h=400&fit=crop'
                ],
            ],

            // Sports & Outdoor
            [
                'category_id' => $sports->id,
                'name' => 'Running Shoes',
                'description' => 'Professional running shoes for athletes. Lightweight design with superior cushioning and support.',
                'price' => 129.99,
                'sale_price' => 99.99,
                'sku' => 'SHOES-001',
                'stock' => 120,
                'status' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&h=400&fit=crop'
                ],
            ],
            [
                'category_id' => $sports->id,
                'name' => 'Yoga Mat',
                'description' => 'Non-slip yoga mat for home workouts. Premium quality with excellent grip and cushioning.',
                'price' => 24.99,
                'sku' => 'YOGA-001',
                'stock' => 90,
                'status' => true,
                'images' => [
                    'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1571019613540-996a420494c0?w=400&h=400&fit=crop'
                ],
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

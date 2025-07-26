<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and accessories',
                'image' => 'https://images.unsplash.com/photo-1468495244123-6c6c332eeece?w=400&h=300&fit=crop',
                'status' => true,
            ],
            [
                'name' => 'Clothing',
                'description' => 'Fashion and apparel',
                'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=400&h=300&fit=crop',
                'status' => true,
            ],
            [
                'name' => 'Books',
                'description' => 'Books and educational materials',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop',
                'status' => true,
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home improvement and garden supplies',
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400&h=300&fit=crop',
                'status' => true,
            ],
            [
                'name' => 'Sports & Outdoor',
                'description' => 'Sports equipment and outdoor gear',
                'image' => 'https://images.unsplash.com/photo-1571019613540-996a420494c0?w=400&h=300&fit=crop',
                'status' => true,
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

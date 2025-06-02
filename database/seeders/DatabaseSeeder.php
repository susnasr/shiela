<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create/update admin user (safe for existing data)
        User::updateOrCreate(
            ['email' => 'admin@sheila.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'is_admin' => true,
            ]
        );

        // Seed categories
        $categories = [
            ['name' => 'Shirts', 'description' => 'Upper wear'],
            ['name' => 'Pants', 'description' => 'Down wear'],
            ['name' => 'Essentials', 'description' => 'Needy stuff'],
            ['name' => 'Drips', 'description' => 'GenZ stuff'],
        ];

        $categoryIds = [];
        foreach ($categories as $category) {
            $categoryIds[$category['name']] = Category::updateOrCreate(
                ['name' => $category['name']],
                [
                    'slug' => Str::slug($category['name']),
                    'description' => $category['description'],
                ]
            )->id;
        }

        // Create/update sample products (safe for existing data)
        Product::updateOrCreate(
            ['name' => 'T-shirt'],
            [
                'description' => 'Gen-z stuff.',
                'price' => 49.99,
                'stock' => 100,
                'status' => 'approved',
                'image' => 'F0623103999_2.webp',
                'is_featured' => true,
                'category_id' => $categoryIds['Pants'], // Dynamically use Pants category
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Iqbal ka shaheen'],
            [
                'description' => 'Mishta hn shuwa gin gin.',
                'price' => 61.99,
                'stock' => 50,
                'status' => 'approved',
                'image' => 'ccc.png',
                'is_featured' => true,
                'category_id' => $categoryIds['Essentials'], // Dynamically use Essentials category
            ]
        );

        // Additional safety: Mark random existing products as featured
        Product::whereIn('id', [1, 3, 5])->update(['is_featured' => true]);

        // Seed blog posts
        $fashionTipsCategory = $categoryIds['Fashion Tips'] ?? Category::updateOrCreate(
            ['name' => 'Fashion Tips'],
            ['slug' => 'fashion-tips', 'description' => 'Fashion advice']
        )->id;

        $outfitIdeasCategory = $categoryIds['Outfit Ideas'] ?? Category::updateOrCreate(
            ['name' => 'Outfit Ideas'],
            ['slug' => 'outfit-ideas', 'description' => 'Outfit inspiration']
        )->id;

        Post::create([
            'title' => 'Top 5 Outfit Trends for 2025',
            'content' => 'Discover the latest outfit trends for this year, featuring bold colors and sustainable fabrics...',
            'slug' => 'top-5-outfit-trends-2025',
            'category_id' => $fashionTipsCategory,
        ]);

        Post::create([
            'title' => 'How to Style Casual Outfits',
            'content' => 'Learn how to mix and match casual pieces for a chic look...',
            'slug' => 'how-to-style-casual-outfits',
            'category_id' => $outfitIdeasCategory,
        ]);

        // Call additional seeder (if needed, but likely redundant with User seeding above)
        $this->call(AdminUserSeeder::class);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Ensure categories exist (assuming CategorySeeder runs first)
        $category1 = Category::where('slug', 'fashion-tips')->first();
        if (!$category1) {
            $category1 = Category::create(['name' => 'Fashion Tips', 'slug' => 'fashion-tips']);
        }
        $category2 = Category::where('slug', 'outfit-ideas')->first();
        if (!$category2) {
            $category2 = Category::create(['name' => 'Outfit Ideas', 'slug' => 'outfit-ideas']);
        }

        // Create sample posts
        Post::create([
            'title' => 'Top 5 Outfit Trends for 2025',
            'content' => 'Discover the latest outfit trends for this year, featuring bold colors and sustainable fabrics...',
            'slug' => 'top-5-outfit-trends-2025',
            'category_id' => $category1->id,
        ]);

        Post::create([
            'title' => 'How to Style Casual Outfits',
            'content' => 'Learn how to mix and match casual pieces for a chic look...',
            'slug' => 'how-to-style-casual-outfits',
            'category_id' => $category2->id,
        ]);
    }
}

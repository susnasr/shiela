<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Seed blog categories
        $blogCategories = [
            ['name' => 'General', 'description' => 'General topics and updates'],
            ['name' => 'Trendy', 'description' => 'Trend news and innovations'],
            ['name' => 'Lifestyle', 'description' => 'Lifestyle and wellbeing'],
            ['name' => 'Fashion', 'description' => 'Fashion trends and style guides'],
        ];

        $createdCategories = [];

        foreach ($blogCategories as $category) {
            $createdCategory = BlogCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}

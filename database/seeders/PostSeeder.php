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
            ['name' => 'General',],
            ['name' => 'Trendy', ],
            ['name' => 'Lifestyle', ],
            ['name' => 'Fashion',],
        ];

        $createdCategories = [];

        foreach ($blogCategories as $category) {
            $createdCategory = BlogCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
            ]);
        }
    }
}

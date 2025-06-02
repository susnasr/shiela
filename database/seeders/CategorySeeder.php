<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Shirts', 'description' => 'Upper wear'],
            ['name' => 'Pants', 'description' => 'Down wear'],
            ['name' => 'Essentials', 'description' => 'Needy stuff'],
            ['name' => 'Drips', 'description' => 'GenZ stuff'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}

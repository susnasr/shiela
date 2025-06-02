<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'slug' => \Illuminate\Support\Str::slug($this->faker->unique()->words(3, true)), // <-- fixed
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'stock_quantity' => $this->faker->numberBetween(5, 50),
            'category_id' => function () {
                return Category::query()->inRandomOrder()->first()->id
                    ?? Category::factory()->create()->id;
            },
            'image' => null,
            'images' => [],
        ];
    }
}

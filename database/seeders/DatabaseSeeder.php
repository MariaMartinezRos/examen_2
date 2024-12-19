<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(15)->create()->each(function ($category) {
            Subcategory::factory(5)->create(['category_id' => $category->id])->each(function ($subcategory) {
                Product::factory(20)->create()->each(function ($product) use ($subcategory) {
                    $product->subcategories()->attach($subcategory->id);
                });
            });
        });
    }
}

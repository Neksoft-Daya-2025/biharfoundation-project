<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ProductCategory::pluck('id', 'slug');

        $products = [
            [
                'name' => 'Bakkeljauw',
                'description' => 'Salted codfish with rice, vegetables and Surinamese herbs',
                'price' => 14.50,
                'category_id' => $categories['fish'] ?? null,
                'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=2070&auto=format&fit=crop',
                'allergens' => ['Fish', 'Gluten', 'Eggs', 'Milk/Lactose'],
                'is_popular' => true,
                'is_available' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Pom',
                'description' => 'Traditional Surinamese dish with pomtajer and chicken',
                'price' => 15.00,
                'category_id' => $categories['fish'] ?? null,
                'image' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=2081&auto=format&fit=crop',
                'allergens' => ['Gluten', 'Eggs', 'Milk/Lactose'],
                'is_popular' => true,
                'is_available' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Chinese Tayer',
                'description' => 'Traditional Surinamese soup with tayer leaves and fresh herbs',
                'price' => 14.50,
                'category_id' => $categories['soup'] ?? null,
                'image' => null,
                'allergens' => null,
                'is_popular' => false,
                'is_available' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Moksi Alesi',
                'description' => 'Roasted rice with meat, vegetables and Surinamese spices',
                'price' => 12.00,
                'category_id' => $categories['moksi'] ?? null,
                'image' => null,
                'allergens' => null,
                'is_popular' => false,
                'is_available' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Nasi Oven Chicken',
                'description' => 'Fried rice with oven chicken and fresh vegetables',
                'price' => 12.00,
                'category_id' => $categories['rice'] ?? null,
                'image' => null,
                'allergens' => null,
                'is_popular' => false,
                'is_available' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('price')->constrained('product_categories')->nullOnDelete();
        });

        // Create default categories from existing product categories
        $slugs = DB::table('products')->distinct()->pluck('category')->filter()->unique()->values();
        $defaults = [
            'fish' => 'Fish Dishes',
            'soup' => 'Soup Dishes',
            'moksi' => "Moksi Alesi's",
            'rice' => 'Rice Dishes',
            'bami' => 'Bami/Nasi',
            'drinks' => 'Drinks',
            'snacks' => 'Snacks',
            'desserts' => 'Desserts',
            'extras' => 'Extras',
        ];
        $sortOrder = 0;
        foreach ($slugs as $slug) {
            $name = $defaults[$slug] ?? ucfirst($slug);
            if (! DB::table('product_categories')->where('slug', $slug)->exists()) {
                DB::table('product_categories')->insert([
                    'name' => $name,
                    'slug' => $slug,
                    'sort_order' => $sortOrder++,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        foreach ($defaults as $slug => $name) {
            if (! DB::table('product_categories')->where('slug', $slug)->exists()) {
                DB::table('product_categories')->insert([
                    'name' => $name,
                    'slug' => $slug,
                    'sort_order' => $sortOrder++,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Set category_id on products from existing category string
        $categories = DB::table('product_categories')->pluck('id', 'slug');
        foreach (DB::table('products')->get() as $product) {
            $catId = $categories[$product->category] ?? null;
            if ($catId) {
                DB::table('products')->where('id', $product->id)->update(['category_id' => $catId]);
            }
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->nullable()->after('price');
        });
        $categories = DB::table('product_categories')->pluck('slug', 'id');
        foreach (DB::table('products')->get() as $product) {
            $slug = $categories[$product->category_id] ?? 'other';
            DB::table('products')->where('id', $product->id)->update(['category' => $slug]);
        }
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};

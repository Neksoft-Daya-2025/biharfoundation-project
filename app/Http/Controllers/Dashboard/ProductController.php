<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('productCategory')->orderBy('sort_order')->orderBy('name')->get();
        return view('dashboard.products', ['products' => $products]);
    }

    public function create()
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        return view('dashboard.product-form', ['product' => null, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);
        $data['allergens'] = $this->parseAllergens($request->input('allergens'));
        $data['is_popular'] = $request->boolean('is_popular');
        $data['is_available'] = $request->boolean('is_available');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        Product::create($data);
        return redirect()->route('dashboard.products')->with('success', 'Product created.');
    }

    public function show(Product $product)
    {
        return view('dashboard.product-show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        return view('dashboard.product-form', ['product' => $product, 'categories' => $categories]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request);
        $data['allergens'] = $this->parseAllergens($request->input('allergens'));
        $data['is_popular'] = $request->boolean('is_popular');
        $data['is_available'] = $request->boolean('is_available');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $product->update($data);
        return redirect()->route('dashboard.products')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard.products')->with('success', 'Product deleted.');
    }

    /**
     * Bulk delete selected products
     */
    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids)) {
            $ids = array_filter(explode(',', $ids));
        }
        $ids = array_map('intval', array_filter($ids));
        if (empty($ids)) {
            return redirect()->route('dashboard.products')->with('error', 'No products selected.');
        }
        Product::whereIn('id', $ids)->delete();
        $count = count($ids);
        return redirect()->route('dashboard.products')->with('success', $count === 1 ? 'Product deleted.' : "{$count} products deleted.");
    }

    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }

    private function parseAllergens($input): ?array
    {
        if (empty($input)) {
            return null;
        }
        if (is_array($input)) {
            return array_values(array_filter(array_map('trim', $input)));
        }
        $list = array_map('trim', explode(',', $input));
        return array_values(array_filter($list)) ?: null;
    }
}

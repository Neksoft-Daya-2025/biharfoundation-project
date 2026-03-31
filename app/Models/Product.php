<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'image',
        'allergens',
        'is_popular',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'allergens' => 'array',
        'is_popular' => 'boolean',
        'is_available' => 'boolean',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /** Slug for filtering (e.g. on services page). Backward compat: product.category still works. */
    public function getCategoryAttribute(): string
    {
        return $this->productCategory?->slug ?? '';
    }
}

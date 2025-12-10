<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'in_stock',
        'rating',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'in_stock' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where('name', 'LIKE', "%{$search}%");
    }

    public function scopePriceRange(Builder $query, ?float $priceFrom, ?float $priceTo): Builder
    {
        if (!is_null($priceFrom)) {
            $query->where('price', '>=', $priceFrom);
        }

        if (!is_null($priceTo)) {
            $query->where('price', '<=', $priceTo);
        }

        return $query;
    }

    public function scopeByCategory(Builder $query, ?int $categoryId): Builder
    {
        if (is_null($categoryId)) {
            return $query;
        }

        return $query->where('category_id', $categoryId);
    }

    public function scopeInStock(Builder $query, ?string $inStock): Builder
    {
        if (is_null($inStock)) {
            return $query;
        }

        $value = filter_var($inStock, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        
        if (!is_null($value)) {
            $query->where('in_stock', $value);
        }

        return $query;
    }

    public function scopeMinRating(Builder $query, ?float $ratingFrom): Builder
    {
        if (is_null($ratingFrom)) {
            return $query;
        }

        return $query->where('rating', '>=', $ratingFrom);
    }

    public function scopeSort(Builder $query, ?string $sort): Builder
    {
        return match($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'rating_desc' => $query->orderBy('rating', 'desc'),
            'newest' => $query->orderBy('created_at', 'desc'),
            default => $query->orderBy('id', 'asc'),
        };
    }
}

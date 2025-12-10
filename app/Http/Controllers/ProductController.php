<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(ProductFilterRequest $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);

        $products = Product::query()
            ->with('category')
            ->search($request->input('q'))
            ->priceRange(
                $request->input('price_from'),
                $request->input('price_to')
            )
            ->byCategory($request->input('category_id'))
            ->inStock($request->input('in_stock'))
            ->minRating($request->input('rating_from'))
            ->sort($request->input('sort', 'newest'))
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'from' => $products->firstItem(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'to' => $products->lastItem(),
                'total' => $products->total(),
            ],
            'links' => [
                'first' => $products->url(1),
                'last' => $products->url($products->lastPage()),
                'prev' => $products->previousPageUrl(),
                'next' => $products->nextPageUrl(),
            ],
        ]);
    }
}

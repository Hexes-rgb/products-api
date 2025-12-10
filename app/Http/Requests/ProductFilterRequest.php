<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => 'nullable|string|max:255',
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|min:0|gte:price_from',
            'category_id' => 'nullable|integer|exists:categories,id',
            'in_stock' => 'nullable|string|in:true,false,1,0',
            'rating_from' => 'nullable|numeric|min:0|max:5',
            'sort' => 'nullable|string|in:price_asc,price_desc,rating_desc,newest',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'q.string' => 'Search query must be a string',
            'price_from.numeric' => 'Price from must be a number',
            'price_to.numeric' => 'Price to must be a number',
            'price_to.gte' => 'Price to must be greater than or equal to price from',
            'category_id.exists' => 'Category does not exist',
            'in_stock.in' => 'In stock must be true or false',
            'rating_from.min' => 'Rating must be at least 0',
            'rating_from.max' => 'Rating must be at most 5',
            'sort.in' => 'Sort must be one of: price_asc, price_desc, rating_desc, newest',
            'per_page.max' => 'Maximum items per page is 100',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}

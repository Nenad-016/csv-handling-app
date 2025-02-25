<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'product_number' => [
                'required',
                'string',
                Rule::unique('products', 'product_number')->ignore($productId),
            ],
            'category_id' => ['required', 'exists:categories,id'],
            'manufacturer_name' => ['required', 'string'],
            'upc' => [
                'required',
                'string',
                Rule::unique('products', 'upc')->ignore($productId),
            ],
            'sku' => [
                'required',
                'string',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'regular_price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lte:regular_price'],
            'description' => ['nullable', 'string'],
        ];
    }
}

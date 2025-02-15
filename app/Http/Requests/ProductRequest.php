<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_number' => ['required', 'string', 'unique:products,product_number'],
            'category_id' => ['required', 'exists:categories,id'],
            'manufacturer_name' => ['required', 'string'],
            'upc' => ['required', 'string', 'unique:products,upc'],
            'sku' => ['required', 'string', 'unique:products,sku'],
            'regular_price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lte:regular_price'],
            'description' => ['nullable', 'string'],
        ];
    }
}

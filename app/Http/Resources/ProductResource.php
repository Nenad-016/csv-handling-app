<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'product_number' => $this->product_number,
            'category_id' => $this->category_id,
            'manufacturer_name' => $this->manufacturer_name,
            'upc' => $this->upc,
            'sku' => $this->sku,
            'regular_price' => $this->regular_price,
            'sale_price' => $this->sale_price,
            'description' => $this->description,
        ];
    }
}

<?php

namespace App\DTOs;

class ProductDTO
{
    public function __construct(
        public string $product_number,
        public int $category_id,
        public string $manufacturer_name,
        public string $upc,
        public string $sku,
        public float $regular_price,
        public float $sale_price,
        public ?string $description = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            product_number: $data['product_number'],
            category_id: $data['category_id'],
            manufacturer_name: $data['manufacturer_name'],
            upc: $data['upc'],
            sku: $data['sku'],
            regular_price: (float) $data['regular_price'],
            sale_price: (float) $data['sale_price'],
            description: $data['description'] ?? null
        );
    }
}

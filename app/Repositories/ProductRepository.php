<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\DTOs\ProductDTO;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private Product $model
    ) {}

public function getAll(): Collection
{
    return $this->model->all();
}

public function show(Product $product): Product
{
    return $product;
}

public function findByCategory(Category $category): Collection
{
    return $this->model->where('category_id', $category->id)->get();
}

public function update(Product $product, ProductDTO $data): ?Product
{
    $product->update([
       'product_number'    => $data->product_number,
       'category_id'       => $data->category_id,
       'manufacturer_name' => $data->manufacturer_name,
       'upc'               => $data->upc,
       'sku'               => $data->sku,
       'regular_price'     => $data->regular_price,
       'sale_price'        => $data->sale_price,
       'description'       => $data->description,
   ]);

    return $product->fresh();
}

public function delete(Product $product): bool
{
    return (bool) $product->delete();
}
}

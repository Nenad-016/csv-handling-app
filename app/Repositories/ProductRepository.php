<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    protected Product $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

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

    public function update(Product $product, array $data): ?Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product): bool
    {
        return (bool) $product->delete();
    }
}

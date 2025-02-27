<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\DTOs\ProductDTO;

interface ProductRepositoryInterface
{
    public function getAll(): Collection;
    public function show(Product $product): Product;
    public function findByCategory(Category $category): Collection;
    public function update(Product $product, ProductDTO $data): ?Product;
    public function delete(Product $product): bool;
}

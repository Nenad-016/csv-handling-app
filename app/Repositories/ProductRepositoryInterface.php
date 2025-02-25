<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAll(): Collection;
    public function show(Product $product): Product;
    public function findByCategory(Category $category): Collection;
    public function update(Product $product, array $data): ?Product;
    public function delete(Product $product): bool;
}

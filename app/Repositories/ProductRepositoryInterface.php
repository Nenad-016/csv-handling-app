<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAll(): Collection;
    public function findById($id): ?Product;
    public function findByCategory($categoryId): Collection|Product|null;
    public function update($id, array $data): ?Product;
    public function delete($id): bool;
}


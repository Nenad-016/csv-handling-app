<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function getAll(): Collection;
    public function show(Category $category): Category;
    public function update(Category $category, array $data): ?Category;
    public function delete(Category $category): bool;
}

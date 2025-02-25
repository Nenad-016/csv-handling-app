<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function show(Category $category): Category
    {
        return $category;
    }

    public function update(Category $category, array $data): ?Category
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category): bool
    {
        return (bool) $category->delete();
    }
}

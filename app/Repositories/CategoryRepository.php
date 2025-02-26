<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\DTOs\CategoryDTO;


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

    public function update(Category $category, CategoryDTO $data): ?Category
    {
        $category->update([
            'name' => $data->name,
            'deparment_name' => $data->deparment_name,
        ]);

        return $category->fresh();
    }

    public function delete(Category $category): bool
    {
        return (bool) $category->delete();
    }
}

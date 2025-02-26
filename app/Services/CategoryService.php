<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\DTOs\CategoryDTO;

class CategoryService
{
    public function __construct(
        private  CategoryRepositoryInterface $categoryRepository
    ) {}

public function getCategories(): Collection
{
    return $this->categoryRepository->getAll();
}

public function getCategory(Category $category): Category
{
    return $this->categoryRepository->show($category);
}

public function updateCategory(Category $category, CategoryDTO $data): ?Category
{
    return $this->categoryRepository->update($category, $data);
}

public function deleteCategory(Category $category): bool
{
    return $this->categoryRepository->delete($category);
}
}

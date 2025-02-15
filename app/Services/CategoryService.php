<?php


namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    public function updateCategory($id, array $data): void 
    {

        $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory($id): void
    {
        $this->categoryRepository->delete($id);
    }

}

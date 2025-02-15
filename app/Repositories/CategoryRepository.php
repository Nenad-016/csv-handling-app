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

    public function findById($id): Category
    {
        return $this->model->find($id);
    }

    public function update($id, array $data): ?Category
    {
        $category = $this->model->find($id);
        if ($category) {
            $category->update($data);
            return $category;
        }
        return null;
    }

    public function delete($id): bool
    {
        $category = $this->model->find($id);
        if ($category) {
            $category->delete();
            return true;
        }
        return false;
    }
}

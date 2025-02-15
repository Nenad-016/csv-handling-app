<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
  protected $model;

   public function __construct(Product $product)
    {
      $this->model = $product;
    }

    public function getAll(): Collection
    {
      return $this->model->all();
    }

    public function findByCategory($categoryId): Product|Collection|null
    {
        $products = $this->model->where('category_id', $categoryId)->get();

        if ($products->count() === 1) {
            return $products->first();
        }

        return $products->isNotEmpty() ? $products : null;
    }

    public function update($id, array $data): ?Product
    {
      $product = $this->model->find($id);
      if (!$product) {
          return null;
      }

      $product->update($data);

      return $product;
    }

    public function delete($id): bool
    {
      $product = $this->model->find($id);
        if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }
}

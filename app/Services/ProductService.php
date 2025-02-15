<?php

namespace App\Services;

use App\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function getProductsByCategory($categoryId): Collection|Product|null
    {
        return $this->productRepository->findByCategory($categoryId);
    }

    public function updateProduct($id, array $data): ?Product
    {
        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct($id): bool
    {
        return $this->productRepository->delete($id);
    }
}

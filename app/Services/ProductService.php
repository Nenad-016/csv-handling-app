<?php

namespace App\Services;

use App\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Carbon\Carbon;
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

    public function getProductById($id): ?Product
    {
        return $this->productRepository->findById($id);
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

    public function exportProductsByCategory($categoryId): string
    {
        $products = $this->productRepository->findByCategory($categoryId);

        if ($products->isEmpty()) {
            throw new \Exception("No products found for this category.");
        }

        $categoryName = $products->first()->category->name ?? 'unknown';

        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '_', $categoryName));

        $timestamp = Carbon::now()->format('Y_m_d-H_i');

        $filename = "{$slug}_{$timestamp}.csv";

        $directory = storage_path('app/exports');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        $filepath = $directory . DIRECTORY_SEPARATOR . $filename;

        $file = fopen($filepath, 'w');

        fputcsv($file, [
            'ID',
            'Product Number',
            'Category ID',
            'Manufacturer Name',
            'UPC',
            'SKU',
            'Regular Price',
            'Sale Price',
            'Description'
        ]);

        foreach ($products as $product) {
            fputcsv($file, [
                $product->id,
                $product->product_number,
                $product->category_id,
                $product->manufacturer_name,
                $product->upc,
                $product->sku,
                $product->regular_price,
                $product->sale_price,
                $product->description,
            ]);
        }

        fclose($file);

        return $filepath;
    }
}

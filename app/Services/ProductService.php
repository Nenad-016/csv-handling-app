<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Repositories\ProductRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(): Collection
    {
        return $this->productRepository->getAll();
    }

    public function getProduct(Product $product): Product
    {
        return $this->productRepository->show($product);
    }

    public function getProductsByCategory(Category $category): Collection
    {
        return $this->productRepository->findByCategory($category);
    }

    public function updateProduct(Product $product, array $data): ?Product
    {
        return $this->productRepository->update($product, $data);
    }

    public function deleteProduct(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }

    public function exportProductsByCategory(Category $category): string
    {
        $products = $this->productRepository->findByCategory($category);

        if ($products->isEmpty()) {
            throw new \Exception("No products found for this category.");
        }

        $categoryName = $products->first()?->category?->name ?? 'unknown';

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

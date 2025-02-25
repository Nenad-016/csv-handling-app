<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    use ResponseTrait;

    private ProductService $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function index(): Response
    {
        try {
            $products = $this->productService->getAllProducts();
            if ($products->isEmpty()) {
                return $this->response(404, 'Resource not found');
            }
        } catch (\Exception $e) {
            return $this->response(400, $e->getMessage());
        }

        return $this->response(
            200,
            'Products retrieved successfully',
            ProductResource::collection($products)
        );
    }

    public function show(Product $product): Response
    {
        try {
            $product = $this->productService->getProduct($product);
            if (!$product) {
                return $this->response(404, 'Product not found');
            }
        } catch (\Exception $e) {
            return $this->response(400, $e->getMessage());
        }

        return $this->response(
            200,
            'Product retrieved successfully',
            new ProductResource($product)
        );
    }

    public function showByCategory(Category $category): Response
    {
        try {
            $products = $this->productService->getProductsByCategory($category);
            if ($products->isEmpty()) {
                return $this->response(404, 'No products found for this category');
            }
        } catch (\Exception $e) {
            return $this->response(400, $e->getMessage());
        }

        return $this->response(
            200,
            'Products retrieved successfully',
            ProductResource::collection($products)
        );
    }

    public function update(Product $product, ProductRequest $request): Response
    {
        $data = $request->only([
            'product_number',
            'category_id',
            'manufacturer_name',
            'upc',
            'sku',
            'regular_price',
            'sale_price',
            'description'
        ]);

        try {
            $updatedProduct = $this->productService->updateProduct($product, $data);
            if (!$updatedProduct) {
                return $this->response(404, 'Product not found');
            }
        } catch (\Exception $e) {
            return $this->response(400, 'Failed to update product: ' . $e->getMessage());
        }

        return $this->response(
            200,
            'Product updated successfully',
            new ProductResource($updatedProduct)
        );
    }

    public function destroy(Product $product): Response
    {
        try {
            $deleted = $this->productService->deleteProduct($product);
            if (!$deleted) {
                return $this->response(404, 'Product not found');
            }
        } catch (\Exception $e) {
            return $this->response(400, 'Failed to delete product: ' . $e->getMessage());
        }

        return $this->response(200, 'Product deleted successfully');
    }

    public function exportByCategory(Category $category): JsonResponse
    {
        try {
            $filepath = $this->productService->exportProductsByCategory($category);
            $filename = basename($filepath);

            return response()->json([
                'message' => 'Products exported successfully.',
                'csv_path_in_project' => url('/storage/csv/' . $filename),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to export products: ' . $e->getMessage(),
            ], 400);
        }
    }
}

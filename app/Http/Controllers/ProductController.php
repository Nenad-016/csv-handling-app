<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use App\DTOs\ProductDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private ProductService $productService
    ) {}

public function index(): Response
{
    try {
        $products = $this->productService->getAllProducts();
        return $products->isEmpty()
            ? $this->response(404, 'Resource not found')
            : $this->response(200, 'Products retrieved successfully', ProductResource::collection($products));
    } catch (\Exception $e) {
        return $this->response(400, $e->getMessage());
    }
}

public function show(Product $product): Response
{
    return $this->response(
        200,
        'Product retrieved successfully',
        new ProductResource($this->productService->getProduct($product))
    );
}

public function showByCategory(Category $category): Response
{
    $products = $this->productService->getProductsByCategory($category);
    return $products->isEmpty()
        ? $this->response(404, 'No products found for this category')
        : $this->response(200, 'Products retrieved successfully', ProductResource::collection($products));
}

public function update(Product $product, ProductRequest $request): Response
{
    try {
        $updatedProduct = $this->productService->updateProduct($product, ProductDTO::fromArray($request->validated()));
        return $this->response(200, 'Product updated successfully', new ProductResource($updatedProduct));
    } catch (\Exception $e) {
        return $this->response(400, 'Failed to update product: ' . $e->getMessage());
    }
}

public function destroy(Product $product): Response
{
    return $this->productService->deleteProduct($product)
        ? $this->response(200, 'Product deleted successfully')
        : $this->response(404, 'Product not found');
}

public function exportByCategory(Category $category): JsonResponse
{
    try {
        $filepath = $this->productService->exportProductsByCategory($category);
        return response()->json([
            'message' => 'Products exported successfully.',
            'csv_path_in_project' => url('/storage/csv/' . basename($filepath)),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to export products: ' . $e->getMessage(),
        ], 400);
    }
}
}

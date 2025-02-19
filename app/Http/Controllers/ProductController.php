<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Traits\ResponseTrait;
use App\Services\ProductService;

class ProductController extends Controller
{
    use ResponseTrait;

    private ProductService $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function index()
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

    public function show($id)
    {
        try {
            $product = $this->productService->getProductById($id);
            if (!$product) {
                return $this->response(404, 'Product not found');
            }
        } catch (\Exception $e) {
            return $this->response(400, $e->getMessage());
        }

        return $this->response(200, 'Product retrieved successfully', new ProductResource($product));
    }

    public function showByCategory($categoryId)
    {
        try {
            $products = $this->productService->getProductsByCategory($categoryId);
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

    public function update($id, ProductRequest $request)
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
            $product = $this->productService->updateProduct($id, $data);
            if (!$product) {
                return $this->response(404, 'Product not found');
            }
        } catch (\Exception $e) {
            return $this->response(400, 'Failed to update product: ' . $e->getMessage());
        }

        return $this->response(200, 'Product updated successfully', new ProductResource($product));
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->productService->deleteProduct($id);
            if (!$deleted) {
                return $this->response(404, 'Product not found');
            }
        } catch (\Exception $e) {
            return $this->response(400, 'Failed to delete product: ' . $e->getMessage());
        }

        return $this->response(200, 'Product deleted successfully');
    }

    public function exportByCategory($categoryId)
    {
        try {
            $filepath = $this->productService->exportProductsByCategory($categoryId);
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

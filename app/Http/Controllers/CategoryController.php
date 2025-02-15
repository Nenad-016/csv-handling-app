<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\ResponseTrait;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    use ResponseTrait;

    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {
            $categories = $this->categoryService->getCategories();
            if ($categories->isEmpty()) {
                return $this->response(404, 'Resource not found');
            }
        } catch (\Exception $e) {
            return $this->response(400, $e->getMessage());
        }
            return $this->response(
                200,
                'Categories retrieved successfully',
                CategoryResource::collection($categories)
            );
    }

    public function update($id, CategoryRequest $request)
    {
        $data = $request->only(['name', 'deparment_name']);

        try {
            $this->categoryService->updateCategory($id, $data);
        } catch (\Exception $e) {
            return $this->response(400, 'Failed to update category: ' . $e->getMessage());
        }

        return $this->response(200, 'Category updated successfully');
    }

    public function destroy($id)
    {
        try {
            $this->categoryService->deleteCategory($id);
        } catch (\Exception $e) {
            return $this->response(400, 'Failed to delete category: ' . $e->getMessage());
        }

        return $this->response(200, 'Category deleted successfully');
    }
}

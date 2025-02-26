<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Response;
use App\DTOs\CategoryDTO;

class CategoryController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private CategoryService $categoryService
    ) {}

public function index(): Response
{
    try {
        $categories = $this->categoryService->getCategories();
        return $categories->isEmpty()
            ? $this->response(404, 'Resource not found')
            : $this->response(200, 'Categories retrieved successfully', CategoryResource::collection($categories));
    } catch (\Exception $e) {
        return $this->response(400, $e->getMessage());
    }
}

public function show(Category $category): Response
{
    return $this->response(
        200,
        'Category record retrieved successfully',
        new CategoryResource($this->categoryService->getCategory($category))
    );
}

public function update(Category $category, CategoryRequest $request): Response
{
    try {
        $this->categoryService->updateCategory($category, CategoryDTO::fromArray($request->validated()));
        return $this->response(200, 'Category updated successfully');
    } catch (\Exception $e) {
        return $this->response(400, 'Failed to update category: ' . $e->getMessage());
    }
}

public function destroy(Category $category): Response
{
    try {
        $this->categoryService->deleteCategory($category);
        return $this->response(200, 'Category deleted successfully');
    } catch (\Exception $e) {
        return $this->response(400, 'Failed to delete category: ' . $e->getMessage());
    }
}
}

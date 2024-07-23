<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    use ApiResponser;

    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {
            $categories = $this->categoryService->getAllCategories();
            return $this->successResponse(CategoryResource::collection($categories), 'Categories retrieved successfully');
        } catch (\Exception $e) {
            throw CustomException::serverError($e->getMessage());
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = $this->categoryService->createCategory($request->validated());
            return $this->successResponse(new CategoryResource($category), 'Category created successfully', 201);
        } catch (\Exception $e) {
            throw CustomException::serverError($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            return $this->successResponse(new CategoryResource($category), 'Category retrieved successfully');
        } catch (ModelNotFoundException $e) {
            throw CustomException::notFound('Category not found');
        } catch (\Exception $e) {
            throw CustomException::serverError($e->getMessage());
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = $this->categoryService->updateCategory($id, $request->validated());
            return $this->successResponse(new CategoryResource($category), 'Category updated successfully');
        } catch (ModelNotFoundException $e) {
            throw CustomException::notFound('Category not found');
        } catch (\Exception $e) {
            throw CustomException::serverError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return $this->successResponse(null, 'Category deleted successfully');
        } catch (ModelNotFoundException $e) {
            throw CustomException::notFound('Category not found');
        } catch (\Exception $e) {
            throw CustomException::serverError($e->getMessage());
        }
    }
}

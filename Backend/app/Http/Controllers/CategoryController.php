<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        if ($categories) {
            return ApiResponse::sendResponse(200, 'All Categories', CategoryResource::collection($categories));
        }
        return ApiResponse::sendResponse(404, 'There are no  Categories');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validatedData = $request->validated();
        $record = Category::create($validatedData);
        if ($record) {
            return ApiResponse::sendResponse(201, 'Category Created Successfully', new CategoryResource($record));
        }
        return ApiResponse::sendResponse(500, 'Fail to create Category');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Category::findOrFail($id);
        if ($data) {
            return ApiResponse::sendResponse(200, 'Category', new CategoryResource($data));
        }
        return ApiResponse::sendResponse(404, 'Can`t find this Category');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return ApiResponse::sendResponse(404, 'Category not found');
        }
        $validatedData = $request->validated();
        $category->fill($validatedData);
        if (!$category->save()) {
            return ApiResponse::sendResponse(500, 'Failed to update category');
        }
        return ApiResponse::sendResponse(200, 'Category updated successfully', new CategoryResource($category));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if (!$category->delete()) {
            return ApiResponse::sendResponse(500, 'Failed to delete category');
        }
        return ApiResponse::sendResponse(200, 'Category Deleted Successfully');
    }
}

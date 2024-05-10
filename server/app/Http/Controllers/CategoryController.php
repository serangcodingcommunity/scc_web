<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();

        return response()->json([
            "data" => $category
        ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            "title" => ['required', 'unique:categories,title'],
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $slug = strtolower(slugify($request->input('title')));
        $category = Category::create([
            'title' => $request->input('title'),
            'slug' => $slug,
        ]);

        return response()->json([
            "message" => "Category created successfully",
            "data" => $category
        ], 201);
    }

    public function show(Request $request, Category $category)
    {
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json([
                "error" => "Category not found"
            ], 404);
        }

        return response()->json([
            "data" => $category
        ], 200);
    }

    public function update(Request $request, Category $category)
    {
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json([
                "error" => "Category not found"
            ], 404);
        }

        $validatedData = Validator::make($request->all(), [
            "title" => ['required', Rule::unique('categories')->ignore($category->id)],
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $newSlug = strtolower(slugify($request->input('title')));

        Category::where('id', $request->id)->update([
            'title' => $request->input('title'),
            'slug' => $newSlug
        ]);

        $updatedCategory = Category::find($request->id);

        return response()->json([
            "message" => "Category updated successfully",
            "data" => $updatedCategory
        ], 200);
    }

    public function destroy(Request $request, Category $category)
    {
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json([
                "error" => "Category not found"
            ], 404);
        }

        $relatedPostsCount = $category->posts()->count();
        if ($relatedPostsCount > 0) {
            return response()->json([
                "error" => "Category still related to posts"
            ], 422);
        }

        $category->delete();

        return response()->json([
            "data" => "ok"
        ], 200);
    }
}

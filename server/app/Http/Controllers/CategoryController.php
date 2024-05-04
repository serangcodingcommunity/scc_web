<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();

        return response()->json([
            "data" => $category
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
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


    /**
     * Display the specified resource.
     */
    public function show(Request $request, Category $category)
    {
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json([
                "error" => "Category not found"
            ], 422);
        }

        return response()->json([
            "data" => $category
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = Validator::make($request->all(), [
            "title" => ['required', 'unique:categories,title'],
        ]);

        $category = Category::find($request->id);
        if (!$category) {
            return response()->json([
                "error" => "Category not found"
            ], 422);
        }

        if ($validatedData->fails()) {
            return response()->json([
                "message" => "Validation error",
                "errors" => $validatedData->errors()
            ], 422);
        }

        $slug = strtolower(slugify($request->input('title')));

        Category::where('id', $request->id)->update([
            'title' => $request->input('title'),
            'slug' => $slug
        ]);

        $category = Category::find($request->id);

        return response()->json([
            "message" => "Category updated successfully",
            "data" => $category
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json([
                "error" => "Category not found"
            ], 422);
        }

        Category::where('id', $request->id)->delete();

        return response()->json([
            "data" => "ok"
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{


    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        try {
            return response(['success' => true, 'data' => Category::all(), 'message' => 'Categories loaded']);
        } catch (\Throwable $exception) {
            return response(['success' => false, 'data' => null, 'message' => $exception]);
        }
    }


    /**
     * Store a newly created category in db.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), ['name' => 'required|string|max:255']);
            if ($validator->fails()) {
                return response(['success' => false, 'data' => null, 'message' => $validator->errors()]);
            }
            $category = Category::create(['name' => $request->input('name')]);
            return response(['success' => true, 'data' => $category, 'message' => 'Category created']);
        } catch (\Exception $exception) {
            return response(['success' => false, 'data' => null, 'message' => $exception]);
        }
    }

    /**
     * Display the specified category.
     */
    public function show(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            return response(['success' => true, 'data' => $category, 'message' => 'Category loaded']);
        } catch (\Throwable $exception) {
            return response(['success' => false, 'data' => null, 'message' => $exception]);
        }
    }

    /**
     * Update the specified category in db.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), ['name' => 'required|max:255']);
            if ($validator->fails()) {
                return response(['success' => false, 'data' => null, 'message' => $validator->errors()]);
            }
            Category::findOrFail($id)->update(['name' => $request->input('name')]);
            return response(['success' => true, 'data' => Category::findOrFail($id), 'message' => 'Category updated']);
        } catch (\Exception $exception) {
            return response(['success' => false, 'data' => null, 'message' => $exception]);
        }
    }

    /**
     * Remove the specified category from db.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
//            Deletes old products
            Product::where('category_id', $id)->delete();
            return response(['success' => true, 'data' => null, 'message' => 'Category deleted']);
        } catch (\Throwable $exception) {
            return response(['success' => false, 'data' => null, 'message' => $exception]);
        }
    }
}

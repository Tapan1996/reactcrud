<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    /**
     * Display a listing of the products.
     */
    public function index()
    {
        try {
            return response(['success' => true, 'data' => Product::with('category')->get(), 'message' => null]);
        } catch (\Throwable $exception) {
            return response(['success' => false, 'data' => null, 'message' => $exception]);
        }
    }

    /**
     * Store a newly created product in db.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'price' => 'required|decimal:0,2|max:9999999',
                'category_id' => 'required|int']);
            if ($validator->fails()) {
                return response(['success' => false, 'data' => null, 'message' => $validator->errors()]);
            }
            $product = Product::create($request->toArray());
            return response(['success' => true, 'data' => $product, 'message' => 'Product created']);
        } catch (\Throwable $exception) {
            return response(['success' => false, 'data' => null, 'message' => $exception]);
        }
    }

    /**
     * Display the specified product.
     */
    public function show(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            return response(['success' => true, 'data' => $product, 'message' => null]);
        } catch (\Throwable $exception) {
            return response(['success' => false, 'data' => null, 'message' => $exception]);
        }
    }


    /**
     * Update the specified product in db.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'price' => 'required|decimal:0,2|max:9999999',
                'category_id' => 'required|int',
            ]);
            if ($validator->fails()) {
                return response(['success' => false, 'data' => null, 'message' => $validator->errors()]);
            }
            $product = Product::findOrFail($id)->update($request->toArray());
            return response(['success' => true, 'data' => Product::findOrFail($id), 'message' => 'Product updated']);

        } catch (\Throwable $exception) {
            return response(['success' => false, 'data' => null, 'message' => $exception]);

        }
    }

    /**
     * Remove the specified product from db.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return response(['success' => true, 'data' => null, 'message' => 'Product deleted']);
        } catch (\Throwable $exception) {
            return response(['success' => false, 'data' => null, 'message' => $exception]);
        }
    }
}

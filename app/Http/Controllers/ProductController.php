<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Only return non-deleted products
        $products = Product::whereNull('deleted_at')
            ->select('id', 'name', 'img', 'price')
            ->get();

        return response()->json($products);
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::whereNull('deleted_at')->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        return response()->json($product);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    /**
     * Get the authenticated user's library.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $library = $user->products()
            ->whereNull('products.deleted_at')
            ->select('products.id', 'products.name', 'products.img', 'products.price')
            ->get();

        return response()->json($library);
    }

    /**
     * Add a free product to the user's library.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $user = $request->user();
        $product = Product::find($request->product_id);

        // Check if the product is free
        if ($product->price > 0) {
            return response()->json(['message' => 'Product is not free.'], 400);
        }

        // Check if already in library
        if ($user->products()->where('product_id', $product->id)->exists()) {
            return response()->json(['message' => 'Product is already in your library.'], 200);
        }

        // Add to library
        $user->products()->attach($product->id);

        return response()->json(['message' => 'Product added to library.']);
    }
}
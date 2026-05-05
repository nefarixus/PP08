<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LibraryController extends Controller
{
    /**
     * Get the authenticated user's library.
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                Log::warning('[Library] index called but user is null — auth middleware may have failed');
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            Log::info('[Library] Fetching library for user ID: ' . $user->id . ' login: ' . $user->login);

            $library = $user->products()
                ->select('products.id', 'products.name', 'products.img', 'products.price')
                ->get();

            Log::info('[Library] Found ' . $library->count() . ' items for user ' . $user->id);

            return response()->json($library);
        } catch (\Throwable $e) {
            Log::error('[Library] index error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            Log::error('[Library] Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'message' => 'Ошибка сервера при загрузке библиотеки: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add a free product to the user's library.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
            ]);

            $user = $request->user();
            $product = Product::find($request->product_id);

            if ($product->price > 0) {
                return response()->json(['message' => 'Product is not free.'], 400);
            }

            if ($user->products()->where('product_id', $product->id)->exists()) {
                return response()->json(['message' => 'Product is already in your library.'], 200);
            }

            $user->products()->attach($product->id);

            Log::info('[Library] Product ' . $product->id . ' added for user ' . $user->id);

            return response()->json(['message' => 'Product added to library.']);
        } catch (\Throwable $e) {
            Log::error('[Library] store error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Ошибка при добавлении в библиотеку: ' . $e->getMessage()
            ], 500);
        }
    }
}

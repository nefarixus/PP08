<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Process a test payment: create order, mark paid, add to library.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $user = $request->user();
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['message' => 'Товар не найден.'], 404);
        }

        if ((float) $product->price <= 0) {
            return response()->json(['message' => 'Этот товар бесплатный.'], 400);
        }

        // Already in library
        if ($user->products()->where('product_id', $product->id)->exists()) {
            return response()->json(['message' => 'Товар уже в вашей библиотеке.'], 400);
        }

        try {
            DB::beginTransaction();

            // Create order (paid_test immediately — test payment)
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => $user->id,
                'status'  => 'paid_test',
                'total'   => $product->price,
            ]);

            // Create order item
            DB::table('order_items')->insert([
                'order_id'          => $orderId,
                'product_id'        => $product->id,
                'price_at_purchase' => $product->price,
            ]);

            // Add to user library
            DB::table('user_products')->insert([
                'user_id'    => $user->id,
                'product_id' => $product->id,
            ]);

            DB::commit();

            return response()->json(['message' => 'Покупка успешно завершена! Игра добавлена в библиотеку.']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ошибка при обработке платежа: ' . $e->getMessage()], 500);
        }
    }
}

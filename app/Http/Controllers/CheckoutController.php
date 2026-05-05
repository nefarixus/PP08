<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        if ($user->products()->where('product_id', $product->id)->exists()) {
            return response()->json(['message' => 'Товар уже в вашей библиотеке.'], 400);
        }

        try {
            DB::beginTransaction();

            $now = now();

            $orderId = DB::table('orders')->insertGetId([
                'user_id'    => $user->id,
                'status'     => 'paid_test',
                'total'      => $product->price,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('order_items')->insert([
                'order_id'          => $orderId,
                'product_id'        => $product->id,
                'price_at_purchase' => $product->price,
                'created_at'        => $now,
                'updated_at'        => $now,
            ]);

            // Используем Eloquent-связь чтобы правильно заполнить created_at/updated_at
            $user->products()->attach($product->id, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::commit();

            Log::info('[Checkout] User ' . $user->id . ' purchased product ' . $product->id . ' order #' . $orderId);

            return response()->json(['message' => 'Покупка успешно завершена! Игра добавлена в библиотеку.']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('[Checkout] Error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            return response()->json(['message' => 'Ошибка при обработке платежа: ' . $e->getMessage()], 500);
        }
    }
}

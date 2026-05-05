<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private function requireAdmin(Request $request)
    {
        $user = $request->user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Доступ запрещён. Требуются права администратора.');
        }
        return $user;
    }

    /**
     * List all products (including soft-deleted).
     */
    public function products(Request $request)
    {
        $this->requireAdmin($request);

        $products = Product::withTrashed()
            ->select('id', 'name', 'img', 'price', 'rating', 'deleted_at', 'created_at')
            ->orderByDesc('id')
            ->get();

        return response()->json($products);
    }

    /**
     * Create a new product with file upload.
     */
    public function storeProduct(Request $request)
    {
        $this->requireAdmin($request);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'img_file'    => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:10240',
        ], [
            'name.required'     => 'Укажите название товара.',
            'price.required'    => 'Укажите цену.',
            'price.numeric'     => 'Цена должна быть числом.',
            'price.min'         => 'Цена не может быть отрицательной.',
            'img_file.required' => 'Выберите файл обложки.',
            'img_file.image'    => 'Файл должен быть изображением.',
            'img_file.mimes'    => 'Допустимые форматы: jpg, jpeg, png, webp, gif.',
            'img_file.max'      => 'Максимальный размер файла — 10 МБ.',
        ]);

        $file = $request->file('img_file');
        $origName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safe = preg_replace('/[^a-z0-9._-]+/i', '_', $origName);
        $safe = trim($safe, '._-') ?: 'cover';
        $ext = strtolower($file->getClientOriginalExtension());
        $filename = $safe . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(3)) . '.' . $ext;

        $destDir = public_path('images');
        if (!is_dir($destDir)) {
            mkdir($destDir, 0777, true);
        }

        $file->move($destDir, $filename);

        $product = Product::create([
            'name'        => $request->input('name'),
            'description' => $request->input('description') ?: null,
            'price'       => round((float) $request->input('price'), 2),
            'img'         => $filename,
            'rating'      => 0.00,
        ]);

        Log::info('[Admin] Product created: id=' . $product->id . ' name=' . $product->name);

        return response()->json([
            'message' => 'Товар добавлен (id ' . $product->id . ').',
            'product' => $product,
        ], 201);
    }

    /**
     * Soft-delete a product.
     */
    public function destroyProduct(Request $request, $id)
    {
        $this->requireAdmin($request);

        $product = Product::withTrashed()->find($id);
        if (!$product) {
            return response()->json(['message' => 'Продукт не найден.'], 404);
        }

        $product->delete();
        Log::info('[Admin] Product soft-deleted: id=' . $id);

        return response()->json(['message' => 'Продукт удалён.']);
    }

    /**
     * Restore a soft-deleted product.
     */
    public function restoreProduct(Request $request, $id)
    {
        $this->requireAdmin($request);

        $product = Product::withTrashed()->find($id);
        if (!$product) {
            return response()->json(['message' => 'Продукт не найден.'], 404);
        }

        $product->restore();
        Log::info('[Admin] Product restored: id=' . $id);

        return response()->json(['message' => 'Продукт восстановлен.']);
    }

    /**
     * Total count of products (for profile stats).
     */
    public function productsCount()
    {
        $count = Product::count();
        return response()->json(['total' => $count]);
    }
}

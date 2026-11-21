<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => Category::withCount('medicines')->get(),
        ], 200);
    }

    public function show(string $id): JsonResponse
    {
        $category = Category::with('medicines:id,category_id,name,price')
            ->findOrFail((int) $id);

        return response()->json([
            'status' => 'success',
            'data' => $category,
        ], 200);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    private array $items = [
        [
            'id' => 1,
            'name' => 'Амоксиклав',
            'active_substance' => 'Амоксицилін + Клавуланова кислота',
            'dosage' => '625 мг',
            'price' => 345.50,
            'stock_quantity' => 42,
            'is_prescription' => true,
        ],
        [
            'id' => 2,
            'name' => 'Нурофєн Експрес',
            'active_substance' => 'Ібупрофен',
            'dosage' => '400 мг',
            'price' => 165.00,
            'stock_quantity' => 85,
            'is_prescription' => false,
        ],
        [
            'id' => 3,
            'name' => 'Азитроміцин',
            'active_substance' => 'Азитроміцин',
            'dosage' => '500 мг',
            'price' => 210.00,
            'stock_quantity' => 19,
            'is_prescription' => true,
        ],
    ];

    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'count' => count($this->items),
            'data' => $this->items,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'active_substance' => ['required', 'string', 'min:2', 'max:255'],
            'dosage' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'is_prescription' => ['required', 'boolean'],
            'stock_quantity' => ['sometimes', 'integer', 'min:0'],
        ]);

        $newItem = [
            'id' => count($this->items) + 1,
            'name' => $validated['name'],
            'active_substance' => $validated['active_substance'],
            'dosage' => $validated['dosage'],
            'price' => (float) $validated['price'],
            'stock_quantity' => (int) ($validated['stock_quantity'] ?? 10),
            'is_prescription' => (bool) $validated['is_prescription'],
        ];

        $this->items[] = $newItem;

        return response()->json([
            'status' => 'created',
            'data' => $newItem,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $itemId = (int) $id;

        foreach ($this->items as $item) {
            if ($item['id'] === $itemId) {
                return response()->json([
                    'status' => 'success',
                    'data' => $item,
                ], 200);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Лікарський засіб із зазначеним ідентифікатором не знайдено.',
        ], 404);
    }
}

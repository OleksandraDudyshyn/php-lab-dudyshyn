<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $medicines = Medicine::query()
            ->with([
                'category:id,name',
                'manufacturer:id,name,country',
                'activeSubstances:id,name,atc_code',
            ])
            ->paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => $medicines,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'manufacturer_id' => ['required', 'integer', 'exists:manufacturers,id'],
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'dosage' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'is_prescription' => ['required', 'boolean'],
            'active_substances' => ['nullable', 'array'],
            'active_substances.*' => ['integer', 'exists:active_substances,id'],
        ]);

        $medicine = Medicine::create([
            'category_id' => $validated['category_id'],
            'manufacturer_id' => $validated['manufacturer_id'],
            'name' => $validated['name'],
            'dosage' => $validated['dosage'],
            'price' => (float) $validated['price'],
            'stock_quantity' => (int) ($validated['stock_quantity'] ?? 0),
            'is_prescription' => (bool) $validated['is_prescription'],
        ]);

        if (! empty($validated['active_substances'])) {
            $medicine->activeSubstances()->sync($validated['active_substances']);
        }

        $medicine->load([
            'category:id,name',
            'manufacturer:id,name,country',
            'activeSubstances:id,name,atc_code',
        ]);

        return response()->json([
            'status' => 'created',
            'data' => $medicine,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $medicine = Medicine::with(['category', 'manufacturer', 'activeSubstances'])
            ->findOrFail((int) $id);

        return response()->json([
            'status' => 'success',
            'data' => $medicine,
        ], 200);
    }
}

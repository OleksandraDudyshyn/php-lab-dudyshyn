<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Order::with(['user:id,name,email', 'medicines:id,name,price', 'payment'])
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $orders,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.medicine_id' => ['required', 'integer', 'exists:medicines,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $order = Order::create([
            'user_id' => $validated['user_id'],
            'order_number' => 'ORD-'.now()->format('YmdHis'),
            'total_amount' => 0,
            'status' => 'pending',
        ]);

        $syncData = [];
        $total = 0.0;

        foreach ($validated['items'] as $item) {
            $medicine = Medicine::findOrFail((int) $item['medicine_id']);
            $qty = (int) $item['quantity'];
            $syncData[$medicine->id] = [
                'quantity' => $qty,
                'unit_price' => $medicine->price,
            ];
            $total += $medicine->price * $qty;
        }

        $order->medicines()->sync($syncData);
        $order->update(['total_amount' => round($total, 2)]);
        $order->load(['user:id,name,email', 'medicines:id,name,price', 'payment']);

        return response()->json([
            'status' => 'created',
            'data' => $order,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $order = Order::with(['user:id,name,email', 'medicines', 'payment'])
            ->findOrFail((int) $id);

        return response()->json([
            'status' => 'success',
            'data' => $order,
        ], 200);
    }
}

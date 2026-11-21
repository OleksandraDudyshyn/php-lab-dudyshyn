<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => Prescription::with(['user:id,name', 'medicine:id,name,dosage'])->get(),
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'medicine_id' => ['required', 'integer', 'exists:medicines,id'],
            'prescription_code' => ['required', 'string', 'unique:prescriptions,prescription_code'],
            'doctor_name' => ['required', 'string', 'max:255'],
            'issue_date' => ['required', 'date'],
            'expiry_date' => ['required', 'date', 'after:issue_date'],
        ]);

        $prescription = Prescription::create($validated);
        $prescription->load(['user:id,name', 'medicine:id,name,dosage']);

        return response()->json([
            'status' => 'created',
            'data' => $prescription,
        ], 201);
    }
}

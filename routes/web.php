<?php

declare(strict_types=1);

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PharmacyReportController;
use App\Http\Controllers\PrescriptionController;
use App\Models\ActiveSubstance;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', fn () => response()->json([
    'status' => 'OK',
    'service' => 'Electronic Pharmacy Sales System',
    'timestamp' => now(),
]))->name('health');

Route::get('/system-info', [PharmacyReportController::class, 'systemInfo'])
    ->name('system.info');

Route::prefix('medicines')->name('medicines.')->group(function () {
    Route::get('/', [MedicineController::class, 'index'])->name('index');
    Route::post('/', [MedicineController::class, 'store'])
        ->middleware('medicine.license')
        ->name('store');
    Route::get('/{id}', [MedicineController::class, 'show'])
        ->whereNumber('id')
        ->name('show');
});

Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/{id}', [CategoryController::class, 'show'])
        ->whereNumber('id')
        ->name('show');
});

Route::get('/active-substances', fn () => response()->json([
    'status' => 'success',
    'data' => ActiveSubstance::withCount('medicines')->get(),
]))->name('active-substances.index');

Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::post('/', [OrderController::class, 'store'])->name('store');
    Route::get('/{id}', [OrderController::class, 'show'])
        ->whereNumber('id')
        ->name('show');
});

Route::prefix('prescriptions')->name('prescriptions.')->group(function () {
    Route::get('/', [PrescriptionController::class, 'index'])->name('index');
    Route::post('/', [PrescriptionController::class, 'store'])->name('store');
});

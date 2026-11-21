<?php

declare(strict_types=1);

use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyReportController;
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

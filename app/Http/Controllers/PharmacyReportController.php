<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class PharmacyReportController extends Controller
{
    public function systemInfo(): JsonResponse
    {
        return response()->json([
            'system' => 'Електронна система продажу ліків в аптеці',
            'variant' => 16,
            'framework' => 'Laravel '.app()->version(),
            'php_version' => PHP_VERSION,
            'modules' => ['Catalog (/medicines)', 'Prescription Guard (Middleware)', 'Health Check'],
        ], 200);
    }
}

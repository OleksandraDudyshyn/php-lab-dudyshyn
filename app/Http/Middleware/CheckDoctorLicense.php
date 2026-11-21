<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDoctorLicense
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->isMethod('post')
            && $request->boolean('is_prescription')
            && ! $request->hasHeader('X-Doctor-License')
        ) {
            return response()->json([
                'status' => 'access_denied',
                'message' => 'Відхилено: для додавання рецептурного препарату потрібен заголовок X-Doctor-License.',
            ], 403);
        }

        $response = $next($request);

        $response->headers->set('X-Security-Policy', 'Enforced');

        return $response;
    }
}

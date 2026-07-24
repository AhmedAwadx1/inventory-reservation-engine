<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IdempotencyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            $key = $request->header('X-Idempotency-Key');

            if (!$key) {
                return response()->json([
                    'message' => __('errors.idempotency_key_required'),
                ], 422);
            }

            $request->merge(['idempotency_key' => $key]);
        }

        return $next($request);
    }
}

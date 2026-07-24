<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sets the application locale based on the request.
 *
 * Priority:
 *   1. Accept-Language header (e.g., "ar", "en")
 *   2. ?lang= query parameter
 *   3. APP_LOCALE from .env
 */
class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('Accept-Language')
            ?? $request->query('lang')
            ?? config('app.locale');

        // Take only the first 2 characters (e.g., "ar-EG,ar;q=0.9" → "ar")
        $locale = substr($locale, 0, 2);

        $available = config('app.available_locales', ['en', 'ar']);

        if (in_array($locale, $available)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}

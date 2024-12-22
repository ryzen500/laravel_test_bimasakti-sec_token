<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secToken = $request->header('Sec-Token');
        $currentDate = now()->format('Ymd');

        if ($secToken !== $currentDate) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

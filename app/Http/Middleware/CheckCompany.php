<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Kullanıcı auth kontrolü ve Company mi kontrolü
         if (!$request->user() || !$request->user() instanceof \App\Models\Company) {
            return response()->json([
                'succeeded' => false,
                'message' => 'Unauthorized - Access allowed only for companies',
                'errors' => null,
                'data' => null
            ], 403); // 403 Forbidden
        }
        return $next($request);
    }
}

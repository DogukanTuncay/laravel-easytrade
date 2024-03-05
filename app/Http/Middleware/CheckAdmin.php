<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Kullanıcının isAdmin değerini kontrol et
        if ($request->user() && $request->user()->isAdmin == 1) {
            return $next($request);
        }

        // isAdmin 1 değilse, kullanıcıyı anasayfaya yönlendir
        return redirect()->route('index');
    }
}

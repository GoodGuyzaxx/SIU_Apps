<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $dataRole = ['admin', 'akademik', 'dekan', 'kaprodi'];

        if (!auth()->check() || !in_array(auth()->user()->role, $dataRole)) {
            abort(403, 'Anda tidak memiliki hak akses!');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Pages\Dashboard;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'admin' ) {
            return redirect()->to(Dashboard::getUrl(panel: 'admin'));
        }
        return $next($request);
    }
}

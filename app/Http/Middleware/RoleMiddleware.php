<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect('/login')->with('error', '請先登入系統');
        }

        if (auth()->user()->role !== $role && auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', '權限不足，無法存取此功能');
        }

        return $next($request);
    }
}

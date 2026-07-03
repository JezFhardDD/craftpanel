<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
     public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Check if user has the required role
        if (auth()->user()->role !== $role) {
            abort(403, 'Access denied. Required role: ' . $role);
        }

        return $next($request);
    }
}
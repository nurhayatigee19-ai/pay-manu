<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            abort(403, 'Anda belum login');
        }

        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses');
        }

        return $next($request);
    }
}
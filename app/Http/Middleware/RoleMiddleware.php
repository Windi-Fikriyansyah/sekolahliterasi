<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        \Log::info('Role middleware check', [
            'auth_check' => auth()->check(),
            'user' => auth()->user(),
            'roles' => $roles,
        ]);
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}

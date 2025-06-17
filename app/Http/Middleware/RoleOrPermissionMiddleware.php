<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleOrPermissionMiddleware
{
    public function handle(Request $request, Closure $next, string ...$rolesOrPermissions)
    {
        if (Auth::guest()) {
            abort(403);
        }

        foreach ($rolesOrPermissions as $roleOrPermission) {
            if (Auth::user()->hasRole($roleOrPermission) || Auth::user()->hasPermissionTo($roleOrPermission)) {
                return $next($request);
            }
        }

        abort(403);
    }
}

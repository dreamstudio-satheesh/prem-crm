<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!auth()->user()->permissions->contains('name', $permission)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}

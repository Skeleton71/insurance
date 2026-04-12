<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        foreach ($roles as $role) {
            if ($role === 'admin' && $user->isAdmin()) {
                return $next($request);
            }
            if ($role === 'editor' && $user->isEditor()) {
                return $next($request);
            }
            if ($role === 'visitor' && $user->isVisitor()) {
                return $next($request);
            }
        }

        abort(403, 'Access denied. You do not have permission to perform this action.');
    }
}
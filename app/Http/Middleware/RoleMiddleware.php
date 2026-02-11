<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware{
    
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = strtolower(Auth::user()->role->role_name ?? '');
        $allowed  = array_map('strtolower', $roles);

        if ($userRole === '' || !in_array($userRole, $allowed, true)) {
             return redirect()->route('dashboard.index')
                ->with('error', 'You are not authorized to access that page.');
        }

        return $next($request);
    }
}

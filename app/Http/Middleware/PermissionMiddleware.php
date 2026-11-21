<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * The legacy CMS has one trusted admin guard. Fine-grained Spatie roles
     * are not installed in this Laravel project, so every authenticated,
     * active admin account is treated as an administrator.
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || (int) $admin->status !== 1) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}

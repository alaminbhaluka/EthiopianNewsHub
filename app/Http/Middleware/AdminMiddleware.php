<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || (int) $admin->status !== 1) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}

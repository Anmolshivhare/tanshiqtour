<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();
        if (!$user->hasAnyRole([
            config('constants.super_admin_role_name'),
            config('constants.admin_role_name'),
        ])) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Admin access only.');
        }

        return $next($request);
    }
}

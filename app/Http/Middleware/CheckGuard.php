<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            $request->merge(['login_source' => 'users']); // เพิ่มข้อมูลใน Request
        } elseif (Auth::guard('staff')->check()) {
            $request->merge(['login_source' => 'staff_users']); // เพิ่มข้อมูลใน Request
        }

        return $next($request);
    }
}
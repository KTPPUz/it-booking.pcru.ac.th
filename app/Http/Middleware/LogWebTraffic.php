<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogWebTraffic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next)
    {
        Log::info('Web Access Log', [
            'ip'       => $request->ip(),
            'url'      => $request->fullUrl(),
            'method'   => $request->method(),
            'user_id'  => auth()->id(), // ถ้า login จะมี user_id
            'user_agent' => $request->header('User-Agent'),
            'timestamp' => now(),
        ]);

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
//        if ($request->server() && strpos($request->server()["HTTP_ORIGIN"], 'footpaper.info') !== false) {
//            return $next($request);
//        }
//        return response('Unauthorized',401);
    }
}

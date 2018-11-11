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
        if ($request->server() && $request->server()["HTTP_ORIGIN"] == 'http://www.footpaper.info') {
            return $next($request);
        }
        return response('Unauthorized',401);
    }
}

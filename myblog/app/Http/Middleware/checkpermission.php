<?php

namespace App\Http\Middleware;

use Closure;

class checkpermission
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
        echo 'hhh';
        return $next($request);
    }
}

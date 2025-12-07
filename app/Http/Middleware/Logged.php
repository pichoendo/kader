<?php

namespace App\Http\Middleware;

use Closure;

class Logged
{
    public function handle($request, Closure $next)
    {
        if (!is_null(request()->user())) {
            return redirect()->route('login');
        } else {
            return $next($request);
        }
    }
}
